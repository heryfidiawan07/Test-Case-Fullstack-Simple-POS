<?php

class RoleModel extends CI_Model {

    private $select  = ['id', 'name', 'description', 'created_at'];
    private $order   = [null, 'name', 'description', 'created_at'];
    private $search  = ['name', 'description'];
    private $ordered = ['created_at' => 'desc'];

    private function query()
    {
        $this->db->select($this->select);
        $this->db->from('roles');
    }

    public function datatable()
    {
        $this->query();
        $this->searchOrder();
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function filtered()
    {
        $this->query();
        $this->searchOrder();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function all()
    {
        $this->query();
        return $this->db->count_all_results();
    }

    private function searchOrder()
    {
        $i = 0;
        foreach ($this->search as $item) {
            if($_POST['search']['value']) {
                if($i===0) {
                    $this->db->group_start();
                    $this->db->like("lower(".$item.")", strtolower($_POST['search']['value']));
                }else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if(count($this->search) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } elseif (isset($this->ordered)) {
            $ordered = $this->ordered;
            $this->db->order_by(key($ordered), $ordered[key($ordered)]);
        }
    }

    public function uniqueName($name, $id=false) {
        $this->db->where('name', $name);
        if($id) {
            $this->db->where_not_in('id', $id);
        }
        return $this->db->get('roles')->num_rows();
    }

    public function permissions($role_id)
    {
        $this->db->select('permissions.*');
        $this->db->from('permissions');
        $this->db->join('role_permission', 'permissions.id = role_permission.permission_id');
        $this->db->where('role_permission.role_id', $role_id);
        $query = $this->db->get();
        return $query->result();
    }
}