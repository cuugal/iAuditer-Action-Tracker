<?php

class Areaofaccountability_model extends CI_Model
{
    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->database();

    }

    public function getAllLocation()
    {
        $this->db->join('area_of_accountability', 'area_of_accountability.id = location.area_of_accountability');
        $query = $this->db->get('location');
        $results = $query->result_array();
        return $results;
    }
}