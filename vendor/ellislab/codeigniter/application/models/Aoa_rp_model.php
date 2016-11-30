<?php

class Aoa_rp_model extends CI_Model
{
    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->database();

    }

    public function getRlns()
    {

        $this->db->join('area_of_accountability', 'area_of_accountability.id = aoa_rp.aoa');
        $this->db->join('users', 'users.id = aoa_rp.rp');
        $this->db->select("area_of_accountability.*, aoa_rp.id AS aoa_rp_id, users.*");
        $query = $this->db->get('aoa_rp');
        $results = $query->result_array();
        return $results;
    }

    public function getAoa(){

        $this->db->join('users', 'users.id = area_of_accountability.accountable_person');
        $this->db->select("area_of_accountability.*, area_of_accountability.id AS aoa_id, users.*");
        $query = $this->db->get('area_of_accountability');
        $results = $query->result_array();
        $ret = array();

        $ret[''] = '--';
        foreach($results as $res){

            $ret[$res['aoa_id']] = $res['name'].": (".$res['first_name']." ".$res['last_name'].")";
        }
        return $ret;
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


    public function getRecord($id){
        $this->db->where('id',$id);
        $query = $this->db->get('location');
        $results = $query->result_array();
        return $results[0];
    }

    public function insert($data){
        return $this->db->insert('aoa_rp', $data);
    }

    public function update($data)
    {
        $this->db->where('id', $data['id']);
        $this->db->update('location', $data);
    }

    public function remove($id){
        $this->db->where('id', $id);
        $this->db->delete('aoa_rp');
    }
}