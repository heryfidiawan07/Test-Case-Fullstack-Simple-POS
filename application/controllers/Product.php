<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Product extends CI_Controller
{
    private $auth;

    public function __construct()
    {
        parent::__construct();

        $this->load->model(['AuthModel', 'ProductModel']);
        $this->auth = $this->AuthModel->auth();
        $this->load->library('form_validation');
        // echo json_encode($this->auth);die;
    }

    public function index()
    {
        if(! can('product-index')) {
            show_404();
        }

        $data['auth'] = $this->auth;
        $data['title'] = 'Product';

        $this->load->view('product/index', $data);
    }

    public function create()
    {
        if(! can('product-store')) {
            show_404();
        }

        $data['auth'] = $this->auth;
        $data['title'] = 'Create Product';
        $data['categories'] = $this->db->get('categories')->result();
        $data['supplier'] = $this->db->get('supplier')->result();

        $this->load->view('product/create', $data);
    }

    public function store()
    {
        $this->db->trans_begin();
        try {
            if(! can('product-store')) {
                throw new Exception("Permission denied !");
            }

            $this->form_validation->set_rules('name', 'name', 'required');
            $this->form_validation->set_rules('detail', 'detail', 'required');
            $this->form_validation->set_rules('price', 'price', 'required');
            $this->form_validation->set_rules('qty_stock', 'qty_stock', 'required');
            $this->form_validation->set_rules('supplier_id', 'supplier_id', 'required');
            $this->form_validation->set_rules('description', 'description', 'required');
            $this->form_validation->set_rules('categories[]', 'categories', 'required');
            
            if (empty($_FILES['photo']['name'])){
                $this->form_validation->set_rules('photo', 'photo', 'required');
            }

            if (! $this->form_validation->run()) {
                throw new Exception(validation_errors());
            }

            $name = $this->input->post('name', true);
            if ($this->uniqueName($name) == false) {
                throw new Exception('Sorry, Product name already exist !');
            }
            
            // $photo = $this->uploadFile(me);
            $token = $this->session->userdata('token');
            $temporary = $this->db->get_where('temporary', ['token'=>$token])->row();

            $product_id = uuid();
            $this->db->insert('products', [
                'id' => $product_id,
                'name' => htmlspecialchars($name),
                'detail' => htmlspecialchars($this->input->post('detail', true)),
                'price' => preg_replace('/[^A-Za-z0-9\-]/', '', $this->input->post('price', true)),
                'qty_stock' => preg_replace('/[^A-Za-z0-9\-]/', '', $this->input->post('qty_stock', true)),
                'supplier_id' => htmlspecialchars($this->input->post('supplier_id', true)),
                'description' => $this->input->post('description', true),
                // 'photo' => $photo,
                'photo' => $temporary->photo,
                'created_by' => $this->auth->user->id,
            ]);

            $productCategory = [];
            foreach($this->input->post('categories') as $row) {
                $productCategory[] = ['product_id'=>$product_id, 'category_id'=>$row];
            }
            $this->db->insert_batch('product_category', $productCategory);
            
            if ($this->db->trans_status() === FALSE) {
                throw new Exception('Transaction Failed !');
            }else {
                $this->db->trans_commit();
                $this->db->delete('temporary', ['token'=>$token]);
                echo json_encode(['status'=>true, 'message'=>'Success']);
            }
        } catch (\Throwable $th) {
            $this->db->trans_rollback();
            echo json_encode(['status'=>false, 'message'=>$th->getMessage()]);
        }
    }

    public function edit($product_id)
    {
        if(! can('product-update')) {
            show_404();
        }

        $product = $this->db->get_where('products', ['id'=>$product_id])->row();
        if(!$product) {
            show_404();
        }
        $product_category = $this->db->get_where('product_category', ['product_id'=>$product->id])->result();

        $data['auth'] = $this->auth;
        $data['title'] = 'Edit Product';
        $data['product'] = $product;
        $data['categories'] = $this->db->get('categories')->result();
        $data['supplier'] = $this->db->get('supplier')->result();
        $data['product_category'] = array_column($product_category, 'category_id');

        $this->load->view('product/edit', $data);
    }

    public function update($product_id)
    {
        $this->db->trans_begin();
        try {
            if(! can('product-update')) {
                throw new Exception("Permission denied !");
            }

            $this->form_validation->set_rules('name', 'name', 'required');
            $this->form_validation->set_rules('detail', 'detail', 'required');
            $this->form_validation->set_rules('price', 'price', 'required');
            $this->form_validation->set_rules('qty_stock', 'qty_stock', 'required');
            $this->form_validation->set_rules('supplier_id', 'supplier_id', 'required');
            $this->form_validation->set_rules('description', 'description', 'required');
            $this->form_validation->set_rules('categories[]', 'categories', 'required');

            $product = $this->db->get_where('products', ['id'=>$product_id])->row();
            if(!$product) {
                throw new Exception("Data not found !");
            }
            
            if (empty($_FILES['photo']['name'])){
                $this->form_validation->set_rules('photo', 'photo', 'required');
            }

            if (! $this->form_validation->run()) {
                throw new Exception(validation_errors());
            }

            $name = $this->input->post('name', true);
            if ($this->uniqueName($name, $product->id) == false) {
                throw new Exception('Sorry, Product name already exist !');
            }
            
            // $photo = $this->uploadFile(me);
            $token = $this->session->userdata('token');
            $temporary = $this->db->get_where('temporary', ['token'=>$token])->row();

            $this->db->update('products', [
                'name' => htmlspecialchars($name),
                'detail' => htmlspecialchars($this->input->post('detail', true)),
                'price' => preg_replace('/[^A-Za-z0-9\-]/', '', $this->input->post('price', true)),
                'qty_stock' => preg_replace('/[^A-Za-z0-9\-]/', '', $this->input->post('qty_stock', true)),
                'supplier_id' => htmlspecialchars($this->input->post('supplier_id', true)),
                'description' => $this->input->post('description', true),
                // 'photo' => $photo,
                'photo' => $temporary->photo,
            ], ['id'=>$product->id]);

            $this->db->delete('product_category', ['product_id'=>$product->id]);
            $productCategory = [];
            foreach($this->input->post('categories') as $row) {
                $productCategory[] = ['product_id'=>$product->id, 'category_id'=>$row];
            }
            $this->db->insert_batch('product_category', $productCategory);
            
            if ($this->db->trans_status() === FALSE) {
                throw new Exception('Transaction Failed !');
            }else {
                $this->db->trans_commit();
                $this->db->delete('temporary', ['token'=>$token]);
                unlink('storage/products/'.$product->photo);
                echo json_encode(['status'=>true, 'message'=>'Success']);
            }
        } catch (\Throwable $th) {
            $this->db->trans_rollback();
            echo json_encode(['status'=>false, 'message'=>$th->getMessage()]);
        }
    }

    public function detail($product_id)
    {
        if(! can('product-detail')) {
            show_404();
        }

        $product = $this->db->get_where('products', ['id'=>$product_id])->row();
        if(!$product) {
            show_404();
        }

        $data['auth'] = $this->auth;
        $data['title'] = 'Detail Product';
        $data['product'] = $product;
        $data['category'] = $this->ProductModel->categories($product->id);
        $data['supplier'] = $this->db->get_where('supplier', ['id'=>$product->supplier_id])->row();

        $this->load->view('product/detail', $data);
    }

    public function destroy($product_id)
    {
        $this->db->trans_begin();
        try {
            if(! can('product-destroy')) {
                throw new Exception("Permission denied !");
            }

            $product = $this->db->get_where('products', ['id'=>$product_id])->row();
            if(!$product) {
                throw new Exception("Data not found !");
            }

            $this->db->delete('products', ['id'=>$product->id]);
            
            if ($this->db->trans_status() === FALSE) {
                throw new Exception('Transaction Failed !');
            }else {
                $this->db->trans_commit();
                echo json_encode(['status'=>true, 'message'=>'Success']);
            }
        } catch (\Throwable $th) {
            $this->db->trans_rollback();
            echo json_encode(['status'=>false, 'message'=>$th->getMessage()]);
        }
    }

    public function list()
    {
        if(! can('product-list')) {
            show_404();
        }

        $data['auth'] = $this->auth;
        $data['title'] = 'Products';
        $data['products'] = $this->db->get('products')->result();

        // $this->load->view('product/list', $data);
        $this->twig->display('product/list', $data);
    }

    public function datatable() {
        try {
			if(! can('product-index')) {
				throw new Exception("Permission denied !");
			}

            $model = $this->ProductModel->datatable();
            // var_dump($this->db->last_query());die;

            $data = [];
            $i    = $_POST['start']+1;
            foreach($model as $row) {
                $sub    = [];
                $sub[]  = $i++;
                $sub[]  = '<div style="height: 50px; overflow: hidden;"><img src="'.base_url('storage/products/'.$row->photo).'" width="50"></div>';
                $sub[]  = '<a href="'.base_url('product/detail/'.$row->id).'">'.$row->name.'</a>';
                $sub[]  = 'Rp '.number_format($row->price);
                $sub[]  = $this->setCategories($row->id);
                $sub[]  = $row->supplier_name;
                $sub[]  = $row->created_at;
                $sub[]  = '<a href="'.base_url('product/edit/'.$row->id).'" class="btn btn-primary btn-sm edit" data-id="'.$row->id.'"><i class="fas fa-edit"></i></a>';
                $sub[]  = '<button class="btn btn-danger btn-sm delete" data-id="'.$row->id.'"><i class="fas fa-trash"></i></button>';
                $data[] = $sub;
            }

            $output = [
                'draw'            => intval($_POST['draw']),
                'recordsTotal'    => $this->ProductModel->all(),
                'recordsFiltered' => $this->ProductModel->filtered(),
                'data'            => $data
            ];
            
            echo json_encode($output);
        } catch (\Throwable $th) {
			$output['message'] = $th->getMessage();
			echo json_encode($output);
		}
    }

    public function temporary()
    {
        $this->db->trans_begin();
        try {
            if(! can('product-store')) {
                throw new Exception("Permission denied !");
            }

            $token = $this->session->userdata('token');
            $temp = $this->db->get_where('temporary', ['token'=>$token])->row();
            $photo = $this->uploadFile();
            if($temp) {
                unlink('storage/products/'.$temp->photo);
                $this->db->update('temporary', ['photo'=>$photo], ['token'=>$token]);
            }else {
                $this->db->insert('temporary', [
                    'token' => $token,
                    'photo' => $photo,
                ]);
            }
            
            if ($this->db->trans_status() === FALSE) {
                throw new Exception('Transaction Failed !');
            }else {
                $this->db->trans_commit();
                echo json_encode(['status'=>true, 'message'=>'Success']);
            }
        } catch (\Throwable $th) {
            $this->db->trans_rollback();
            echo json_encode(['status'=>false, 'message'=>$th->getMessage()]);
        }
    }

    private function setCategories($product_id)
    {
        $data = $this->ProductModel->categories($product_id);
        $result = '';
        foreach($data as $row) {
            $result .= '<span class="bg-success text-white mx-1 px-2 py-1 rounded">'.$row->name.'</span>';
        }
        return $result;
    }

    private function uniqueName($name, $id=false) {
        $result = $this->ProductModel->uniqueName($name, $id);
        return $result == 0 ? true : false;
    }

    private function uploadFile()
    {
        $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        $filename = uuid().'.'.$ext;

        $config['upload_path']   = 'storage/products/';
        $config['allowed_types'] = 'jpg|png';
        $config['max_size']      = '5120';//5mb
        $config['file_name']     = $filename;

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (!$this->upload->do_upload('photo', FALSE)) {
            throw new Exception($this->upload->display_errors());
        }

        return $filename;
    }
}