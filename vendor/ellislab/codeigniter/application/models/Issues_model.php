<?php

class Issues_model extends CI_Model
{
    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->database();

    }

    public function getAll()
    {

        $query = $this->db->get('issues');
        $results = $query->result_array();
        return $results;
    }

    public function getForProposedAction($actionId){
        $this->db->where('proposed_action', $actionId);
        $query = $this->db->get('issues');
        $results = $query->result_array();
        return $results;
    }
}