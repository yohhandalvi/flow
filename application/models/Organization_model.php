<?php

class Organization_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_organization_sizes()
    {
        return $this->db->get('organization_sizes')->result_array();
    }

    public function get_all_organization_types()
    {
        return $this->db->get('organization_types')->result_array();
    }

    public function add($data)
    {
        $this->db->insert('organizations', $data);
        return $this->db->insert_id();
    }

}
