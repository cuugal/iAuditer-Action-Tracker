<?php

class Areaofaccountability_model extends CI_Model
{
    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->database();

    }

    public function getAllAOA(){
        $this->db->join('users', 'users.id = area_of_accountability.accountable_person');
        $query = $this->db->get('area_of_accountability');
        $results = $query->result_array();
        return $results;
    }

    public function getUsers(){
        //$this->db->join('users', 'users.id = area_of_accountability.accountable_person');
        $query = $this->db->get('users');
        $results = $query->result_array();
        $ret = array();
        foreach($results as $res){
            $ret[$res['id']] = $res['first_name']." ".$res['last_name'];
        }
        return $ret;
    }

    public function getRecord($id){
        $this->db->where('id',$id);
        $query = $this->db->get('area_of_accountability');
        $results = $query->result_array();
        return $results[0];
    }

    public function insert($data){
        return $this->db->insert('area_of_accountability', $data, true);
    }

}