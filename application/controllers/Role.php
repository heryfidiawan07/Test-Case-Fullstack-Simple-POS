<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Role extends CI_Controller
{
    private $auth;

    public function __construct()
    {
        parent::__construct();

        $this->load->model(['AuthModel', 'RoleModel']);
        $this->auth = $this->AuthModel->auth();
        $this->load->library('form_validation');
        // echo json_encode($this->auth);die;
    }

    public function index()
    {
        if(! can('role-index')) {
            show_404();
        }

        $data['auth'] = $this->auth;
        $data['title'] = 'Role';
        $data['permissions'] = $this->db->get('permissions')->result();

        $this->load->view('role/index', $data);
    }

    public function store()
    {
        $this->db->trans_begin();
        try {
            if(! can('role-store')) {
                throw new Exception("Permission denied !");
            }

            $this->form_validation->set_rules('name', 'name', 'required');
            $this->form_validation->set_rules('description', 'description', 'required');
            $this->form_validation->set_rules('permissions[]', 'permissions', 'required');

            if (! $this->form_validation->run()) {
                throw new Exception(validation_errors());
            }

            $name = $this->input->post('name', true);
            if ($this->uniqueName($name) == false) {
                throw new Exception('Sorry, Role name already exist !');
            }

            $role_id = uuid();
            $this->db->insert('roles', [
                'id' => $role_id,
                'name' => htmlspecialchars($this->input->post('name', true)),
                'description' => $this->input->post('description',true),
            ]);

            $permissions = $this->input->post('permissions', true);
            $rolePermission = [];
            foreach($permissions as $row) {
                $rolePermission[] = ['role_id'=>$role_id, 'permission_id'=>$row];
            }
            $this->db->insert_batch('role_permission', $rolePermission);
            
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

    public function update($role_id)
    {
        $this->db->trans_begin();
        try {
            if(! can('role-update')) {
                throw new Exception("Permission denied !");
            }

            $this->form_validation->set_rules('name', 'name', 'required');
            $this->form_validation->set_rules('description', 'description', 'required');
            $this->form_validation->set_rules('permissions[]', 'permissions', 'required');

            if (! $this->form_validation->run()) {
                throw new Exception(validation_errors());
            }

            $role = $this->db->get_where('roles', ['id'=>$role_id])->row();
            if(!$role) {
                throw new Exception("Data not found !");
            }

            $name = $this->input->post('name', true);
            if ($this->uniqueName($name, $role->id) == false) {
                throw new Exception('Sorry, Role name already exist !');
            }

            $this->db->update('roles', [
                'name' => htmlspecialchars($name),
                'description' => $this->input->post('description',true),
            ], ['id'=>$role->id]);

            $this->db->delete('role_permission', ['role_id'=>$role->id]);
            
            $permissions = $this->input->post('permissions', true);
            $rolePermission = [];
            foreach($permissions as $row) {
                $rolePermission[] = ['role_id'=>$role->id, 'permission_id'=>$row];
            }
            $this->db->insert_batch('role_permission', $rolePermission);
            
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

    public function show($role_id)
    {
        try {
            if(! can('role-index')) {
                throw new Exception("Permission denied !");
            }

            $role = $this->db->get_where('roles', ['id'=>$role_id])->row();
            if(!$role) {
                throw new Exception("Data not found !");
            }

            $permissions = $this->RoleModel->permissions($role->id);

            echo json_encode(['status'=>true, 'data'=>['role'=>$role, 'permissions'=>$permissions]]);
        } catch (\Throwable $th) {
            echo json_encode(['status'=>false, 'message'=>$th->getMessage()]);
        }
    }

    public function destroy($role_id)
    {
        $this->db->trans_begin();
        try {
            if(! can('role-destroy')) {
                throw new Exception("Permission denied !");
            }

            $role = $this->db->get_where('roles', ['id'=>$role_id])->row();
            if(!$role) {
                throw new Exception("Data not found !");
            }

            $this->db->delete('roles', ['id'=>$role->id]);
            
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
			if(! can('role-index')) {
				throw new Exception("Permission denied !");
			}

            $model = $this->RoleModel->datatable();
            // var_dump($this->db->last_query());die;

            $data = [];
            $i    = $_POST['start']+1;
            foreach($model as $row) {
                $sub    = [];
                $sub[]  = $i++;
                $sub[]  = $row->name;
                $sub[]  = $row->description;
                $sub[]  = $this->setPermissions($row->id);
                $sub[]  = $row->created_at;
                $sub[]  = '<button class="btn btn-primary btn-sm edit" data-id="'.$row->id.'"><i class="fas fa-edit"></i></button>';
                $sub[]  = '<button class="btn btn-danger btn-sm delete" data-id="'.$row->id.'"><i class="fas fa-trash"></i></button>';
                $data[] = $sub;
            }

            $output = [
                'draw'            => intval($_POST['draw']),
                'recordsTotal'    => $this->RoleModel->all(),
                'recordsFiltered' => $this->RoleModel->filtered(),
                'data'            => $data
            ];
            
            echo json_encode($output);
        } catch (\Throwable $th) {
			$output['message'] = $th->getMessage();
			echo json_encode($output);
		}
    }

    private function setPermissions($role_id)
    {
        $data = $this->RoleModel->permissions($role_id);
        $result = '';
        foreach($data as $key => $row) {
            if($key == 0) {
                $result .= $row->name;
            }else {
                $result .= ', '.$row->name;
            }
        }
        return $result;
    }

    private function uniqueName($name, $id=false) {
        $result = $this->RoleModel->uniqueName($name, $id);
        return $result == 0 ? true : false;
    }
}