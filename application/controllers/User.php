<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    private $auth;

    public function __construct()
    {
        parent::__construct();

        $this->load->model(['AuthModel', 'UserModel']);
        $this->auth = $this->AuthModel->auth();
        $this->load->library('form_validation');
        // echo json_encode($this->auth);die;
    }

    public function index()
    {
        if(! can('user-index')) {
            show_404();
        }

        $data['auth'] = $this->auth;
        $data['title'] = 'User';
        $data['roles'] = $this->db->get('roles')->result();

        $this->load->view('user/index', $data);
    }

    public function store()
    {
        $this->db->trans_begin();
        try {
            if(! can('user-store')) {
                throw new Exception("Permission denied !");
            }

            $this->form_validation->set_rules('name', 'name', 'required');
            $this->form_validation->set_rules('username', 'username', 'required');
            $this->form_validation->set_rules('email', 'email', 'required');
            $this->form_validation->set_rules('password', 'password', 'required');
            $this->form_validation->set_rules('role_id', 'role_id', 'required');

            if (! $this->form_validation->run()) {
                throw new Exception(validation_errors());
            }

            $username = $this->input->post('username', true);
            if ($this->uniqueUsername($username) == false) {
                throw new Exception('Sorry, Username already exist !');
            }

            $email = $this->input->post('email', true);
            if ($this->uniqueEmail($email) == false) {
                throw new Exception('Sorry, Email already exist !');
            }

            $user_id = uuid();
            $this->db->insert('users', [
                'id' => $user_id,
                'name' => htmlspecialchars($this->input->post('name', true)),
                'username' => htmlspecialchars($this->input->post('username', true)),
                'email' => htmlspecialchars($this->input->post('email', true)),
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'role_id' => $this->input->post('role_id', true),
                'token' => uuid(),
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

    public function update($user_id)
    {
        $this->db->trans_begin();
        try {
            if(! can('user-update')) {
                throw new Exception("Permission denied !");
            }

            $this->form_validation->set_rules('name', 'name', 'required');

            if (! $this->form_validation->run()) {
                throw new Exception(validation_errors());
            }

            $user = $this->db->get_where('users', ['id'=>$user_id])->row();
            if(!$user) {
                throw new Exception("Data not found !");
            }

            $username = $this->input->post('username', true);
            if ($this->uniqueUsername($username, $user->id) == false) {
                throw new Exception('Sorry, User name already exist !');
            }

            $email = $this->input->post('email', true);
            if ($this->uniqueEmail($email, $user->id) == false) {
                throw new Exception('Sorry, User name already exist !');
            }

            $this->db->update('users', [
                'name' => htmlspecialchars($this->input->post('name', true)),
                'username' => htmlspecialchars($this->input->post('username', true)),
                'email' => htmlspecialchars($this->input->post('email', true)),
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'role_id' => $this->input->post('role_id', true),
            ], ['id'=>$user->id]);
            
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

    public function show($user_id)
    {
        try {
            if(! can('user-index')) {
                throw new Exception("Permission denied !");
            }

            $user = $this->db->get_where('users', ['id'=>$user_id])->row();
            if(!$user) {
                throw new Exception("Data not found !");
            }

            echo json_encode(['status'=>true, 'data'=>$user]);
        } catch (\Throwable $th) {
            echo json_encode(['status'=>false, 'message'=>$th->getMessage()]);
        }
    }

    public function destroy($user_id)
    {
        $this->db->trans_begin();
        try {
            if(! can('user-destroy')) {
                throw new Exception("Permission denied !");
            }

            $user = $this->db->get_where('users', ['id'=>$user_id])->row();
            if(!$user) {
                throw new Exception("Data not found !");
            }

            $this->db->delete('users', ['id'=>$user->id]);
            
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
			if(! can('user-index')) {
				throw new Exception("Permission denied !");
			}

            $model = $this->UserModel->datatable();
            // var_dump($this->db->last_query());die;

            $data = [];
            $i    = $_POST['start']+1;
            foreach($model as $row) {
                $sub    = [];
                $sub[]  = $i++;
                $sub[]  = $row->name;
                $sub[]  = $row->username;
                $sub[]  = $row->email;
                $sub[]  = $row->role_name;
                $sub[]  = $row->created_at;
                $sub[]  = '<button class="btn btn-primary btn-sm edit" data-id="'.$row->id.'"><i class="fas fa-edit"></i></button>';
                $sub[]  = '<button class="btn btn-danger btn-sm delete" data-id="'.$row->id.'"><i class="fas fa-trash"></i></button>';
                $data[] = $sub;
            }

            $output = [
                'draw'            => intval($_POST['draw']),
                'recordsTotal'    => $this->UserModel->all(),
                'recordsFiltered' => $this->UserModel->filtered(),
                'data'            => $data
            ];
            
            echo json_encode($output);
        } catch (\Throwable $th) {
			$output['message'] = $th->getMessage();
			echo json_encode($output);
		}
    }

    private function uniqueUsername($username, $id=false) {
        $result = $this->UserModel->uniqueUsername($username, $id);
        return $result == 0 ? true : false;
    }

    private function uniqueEmail($email, $id=false) {
        $result = $this->UserModel->uniqueEmail($email, $id);
        return $result == 0 ? true : false;
    }
}