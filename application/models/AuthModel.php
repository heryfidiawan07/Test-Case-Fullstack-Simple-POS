<?php

class AuthModel extends CI_model {

    private $result;

    public function auth() {
        $online = $this->user();
        $guest = ['login'];
        
        if(!in_array($this->uri->segment(1), $guest) && !$online) {
            if ($this->input->is_ajax_request()) {
                echo json_encode([
                    'status'=>false, 
                    'message'=>'Unauthorized', 
                    'code'=>401
                ]);
                die;
            }
            redirect('login');
        }

        $this->result = new stdClass();
        $this->result->check = $online ? true : false;
        
        if($online) {
            $this->result->user = $online;
            $this->result->role = $this->role();
            $this->result->permissions = $this->permissions();
            $this->result->menus = $this->menus($this->parentMenuId($this->result->user));
        }

        return $this->result;
    }

    private function user() {
        $data = $this->db->get_where('users', ['token'=>$this->session->userdata('token')])->row();
        unset($data->password);
        return $data;
    }

    private function role() {
        return $this->db->get_where('roles', ['id'=>$this->result->user->role_id])->row();
    }

    private function permissions()
    {
        $this->db->select('permissions.name');
        $this->db->from('role_permission');
        $this->db->join('permissions', 'permissions.id = role_permission.permission_id');
        $this->db->where(['role_permission.role_id'=>$this->result->user->role_id]);
        $query = $this->db->get();
        return array_column($query->result(), 'name');
    }

    private function parentMenuId($online)
    {
        $this->db->select('permission_id');
        $this->db->from('role_permission');
        $this->db->where(['role_permission.role_id'=>$online->role_id]);
        $query = $this->db->get();
        return array_column($query->result(), 'permission_id');
    }

    private function menus($parent=[])
    {
        if(count($parent) == 0) {
            return [];
        }

        $this->db->select('parent_menu as parent');
        $this->db->from('permissions');
        $this->db->where_in('id', $parent);
        $this->db->group_by('parent_menu');
        $query = $this->db->get();
        $parents = $query->result();
        // echo json_encode($parents);die;

        foreach($parents as $row) {
            $this->db->select('permissions.*');
            $this->db->from('permissions');
            $this->db->join('role_permission', 'permissions.id = role_permission.permission_id');
            $this->db->where([
                'role_permission.role_id'=>$this->result->user->role_id, 
                'parent_menu'=>$row->parent, 
                'parent_id'=>null
            ]);
            $children = $this->db->get()->result();
            // echo json_encode($children);die;
            
            $row->icon = $children[0]->parent_icon;
            $row->url = array_column($children, 'url');
            $row->children = $children;
        }

        return $query->result();
    }

    public function can($action) {
        if(in_array($action, $this->result->permissions)) {
            return true;
        }
        return false;
    }
}