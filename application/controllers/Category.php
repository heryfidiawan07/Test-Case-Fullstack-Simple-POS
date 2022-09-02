<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Category extends CI_Controller
{
    private $auth;

    public function __construct()
    {
        parent::__construct();

        $this->load->model(['AuthModel', 'CategoryModel']);
        $this->auth = $this->AuthModel->auth();
        $this->load->library('form_validation');
        // echo json_encode($this->auth);die;
    }

    public function index()
    {
        if(! can('category-index')) {
            show_404();
        }

        $data['auth'] = $this->auth;
        $data['title'] = 'Category';

        $this->load->view('category/index', $data);
    }

    public function store()
    {
        $this->db->trans_begin();
        try {
            if(! can('category-store')) {
                throw new Exception("Permission denied !");
            }

            $this->form_validation->set_rules('name', 'name', 'required');

            if (! $this->form_validation->run()) {
                throw new Exception(validation_errors());
            }

            $name = $this->input->post('name', true);
            if ($this->uniqueName($name) == false) {
                throw new Exception('Sorry, Category name already exist !');
            }

            $category_id = uuid();
            $this->db->insert('categories', [
                'id' => $category_id,
                'name' => $name,
            ]);
            
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

    public function update($category_id)
    {
        $this->db->trans_begin();
        try {
            if(! can('category-update')) {
                throw new Exception("Permission denied !");
            }

            $this->form_validation->set_rules('name', 'name', 'required');

            if (! $this->form_validation->run()) {
                throw new Exception(validation_errors());
            }

            $category = $this->db->get_where('categories', ['id'=>$category_id])->row();
            if(!$category) {
                throw new Exception("Data not found !");
            }

            $name = $this->input->post('name', true);
            if ($this->uniqueName($name, $category->id) == false) {
                throw new Exception('Sorry, Category name already exist !');
            }

            $this->db->update('categories', [
                'name' => $name,
            ], ['id'=>$category->id]);
            
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

    public function show($category_id)
    {
        try {
            if(! can('category-index')) {
                throw new Exception("Permission denied !");
            }

            $category = $this->db->get_where('categories', ['id'=>$category_id])->row();
            if(!$category) {
                throw new Exception("Data not found !");
            }

            echo json_encode(['status'=>true, 'data'=>$category]);
        } catch (\Throwable $th) {
            echo json_encode(['status'=>false, 'message'=>$th->getMessage()]);
        }
    }

    public function destroy($category_id)
    {
        $this->db->trans_begin();
        try {
            if(! can('category-destroy')) {
                throw new Exception("Permission denied !");
            }

            $category = $this->db->get_where('categories', ['id'=>$category_id])->row();
            if(!$category) {
                throw new Exception("Data not found !");
            }

            $this->db->delete('categories', ['id'=>$category->id]);
            
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

    public function datatable() {
        try {
			if(! can('category-index')) {
				throw new Exception("Permission denied !");
			}

            $model = $this->CategoryModel->datatable();
            // var_dump($this->db->last_query());die;

            $data = [];
            $i    = $_POST['start']+1;
            foreach($model as $row) {
                $sub    = [];
                $sub[]  = $i++;
                $sub[]  = $row->name;
                $sub[]  = $row->created_at;
                $sub[]  = '<button class="btn btn-primary btn-sm edit" data-id="'.$row->id.'"><i class="fas fa-edit"></i></button>';
                $sub[]  = '<button class="btn btn-danger btn-sm delete" data-id="'.$row->id.'"><i class="fas fa-trash"></i></button>';
                $data[] = $sub;
            }

            $output = [
                'draw'            => intval($_POST['draw']),
                'recordsTotal'    => $this->CategoryModel->all(),
                'recordsFiltered' => $this->CategoryModel->filtered(),
                'data'            => $data
            ];
            
            echo json_encode($output);
        } catch (\Throwable $th) {
			$output['message'] = $th->getMessage();
			echo json_encode($output);
		}
    }

    private function uniqueName($name, $id=false) {
        $result = $this->CategoryModel->uniqueName($name, $id);
        return $result == 0 ? true : false;
    }
}