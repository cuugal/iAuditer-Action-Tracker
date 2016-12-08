<?php

class Proposed_action_model extends CI_Model
{
    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->database();

    }

    public function getAll()
    {

        $query = $this->db->get('proposed_action');
        $results = $query->result_array();
        return $results;
    }

    public function getRecord($id){
        $this->db->where('id',$id);
        $query = $this->db->get('proposed_action');
        $results = $query->result_array();
        return $results[0];
    }


    public function insert($data){
        return $this->db->insert('proposed_action', $data);
    }
    public function update($data)
    {
        $this->db->where('id', $data['id']);
        $this->db->update('proposed_action', $data);
    }
}