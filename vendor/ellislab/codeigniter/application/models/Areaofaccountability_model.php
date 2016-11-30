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
        $this->db->select('area_of_accountability.*, users.*, area_of_accountability.id as aoa_id');
        $query = $this->db->get('area_of_accountability');
        $results = $query->result_array();
        return $results;
    }

    public function getUsers(){
        //$this->db->join('users', 'users.id = area_of_accountability.accountable_person');
        $query = $this->db->get('users');
        $results = $query->result_array();
        $ret = array();
        $ret[''] = '--';
        foreach($results as $res){
            $ret[$res['id']] = $res['first_name']." ".$res['last_name'];
        }
        return $ret;
    }

    public function unallocatedAOA(){

        $query = $this->db->get('area_of_accountability');
        $results = $query->result_array();
        $aoa_allocated = array();
        foreach($results as $aoa){
            $aoa_allocated[] = $aoa['name'];
        }
        print json_encode($aoa_allocated);
        $this->db->where_not_in('area_of_accountability', $aoa_allocated);
        $this->db->distinct('area_of_accountability');
        $query = $this->db->get('audits');
        $results = $query->result_array();

        $aoa_unallocated = array();
        $aoa_unallocated[''] = '--';
        foreach($results as $aoa){
            $aoa_unallocated[$aoa['area_of_accountability']] = $aoa['area_of_accountability'];
        }
        return $aoa_unallocated;


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
    public function update($data)
    {
        $this->db->where('id', $data['id']);
        $this->db->update('area_of_accountability', $data);
    }

}