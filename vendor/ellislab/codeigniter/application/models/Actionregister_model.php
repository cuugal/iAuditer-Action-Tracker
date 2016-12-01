<?php

class Actionregister_model extends CI_Model
{

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function getAR($userId=false){
        $result = [];
        if($userId){
            //Fetch AOA first where accountable
            $this->db->where('accountable_person', $userId);
            $this->db->select('area_of_accountability.*, area_of_accountability.id as aoa_id');

            $query = $this->db->get('area_of_accountability');
            $results = $query->result_array();
            foreach($results as $i){

                $tmp = $this->getARByArea($i['name']);
                if(count($tmp)> 0){
                    $result[] = $tmp;
                }
            }

            //Then, where we are listed as RP
            $this->db->where('rp', $userId);
            $this->db->join('area_of_accountability', 'area_of_accountability.id = aoa_rp.aoa');
            $this->db->select('aoa_rp.*, area_of_accountability.*, area_of_accountability.id as aoa_id');

            $query = $this->db->get('aoa_rp');
            $results = $query->result_array();
            foreach($results as $i){
                $tmp = $this->getARByArea($i['name']);
                if(count($tmp)> 0){
                    $result[] = $tmp;
                }
            }

        }
        else{

            $this->db->group_by('area_of_accountability');
            $this->db->where('response', 'No');
            $this->db->join('audits', 'audits.audit_id = action_register.audit_id');
            $query = $this->db->get('action_register');
            $results = $query->result_array();
            foreach($results as $i){

                $tmp = $this->getARByArea($i['area_of_accountability']);
                if(count($tmp)> 0){
                    $result[] = $tmp;
                }
            }
        }

        return $result;
    }

    private function getARByArea($area){
        $this->db->like('area_of_accountability', $area);
        $this->db->where('response', 'No');
        $this->db->join('audits', 'audits.audit_id = action_register.audit_id');

        $query = $this->db->get('action_register');
        $results = $query->result_array();
        $accountable =  $this->getAccountable($area);
        $responsible = $this->getResponsible($area);
        foreach($results as &$res){
            $res['accountable'] = $accountable;
            $res['responsible'] = implode($responsible,', ');
        }
        //$results['accountable'] = $this->getAccountable($area);
        return $results;
    }

    private function getAccountable($area){
        $this->db->like('name', $area);
        $this->db->join('users', 'users.id = area_of_accountability.accountable_person');
        $query = $this->db->get('area_of_accountability');
        $allresults = $query->result_array();
        if(count($allresults) > 0) {
            $results = $query->result_array()[0];
            return $results['first_name'] . " " . $results['last_name'];
        }
        //no accountable person
        else return "--Not Set In Action Tracker--";
    }

    private function getResponsible($area){
        //get RP by area
        $this->db->where('name', $area);
        $this->db->join('area_of_accountability', 'area_of_accountability.id = aoa_rp.aoa');
        $this->db->join('users', 'users.id = aoa_rp.rp');
        $this->db->select('users.*, aoa_rp.*, area_of_accountability.*, area_of_accountability.id as aoa_id');

        $query = $this->db->get('aoa_rp');
        $results = $query->result_array();
        $ret = array();
        foreach($results as $result){
            $ret[] = $result['first_name']." ".$result['last_name'];
        }
        if(count($ret)== 0){
            $ret[] = "--Not Set In Action Tracker--";
        }
        return $ret;
    }

    public function getRequest($key){
        $this->db->where('key', $key);
        $this->db->join('audits', 'audits.audit_id = action_register.audit_id');
        $query = $this->db->get('action_register');
        $results = $query->result_array()[0];
        return $results;
    }

    public function update($record){
        $this->db->where('key', $record['key']);
        $this->db->update('action_register', $record);
    }

//Upsert script.
    public function upsertBatch($batch)
    {

        //Obtain audit ids from the batch
        $itemIds = array();
        foreach ($batch as $b) {
            $itemIds[] = $b['key'];
        }
        //check if they are in the db
        $this->db->where_in('key', $itemIds);
        $query = $this->db->get('action_register');
        $results = $query->result_array();

        //if they are, grab their keys
        $keys = array();
        foreach ($results as $r) {
            $keys[] = $r['key'];
        }

        //separate into inserts and updates
        $inserts = array();
        $updates = array();
        foreach ($batch as $b) {
            if (in_array($b['key'], $keys)) {
                $updates[] = $b;
            } else {
                $inserts[] = $b;
            }
        }

        //insert/update as applicable
        $ret = array();
        if (count($inserts) > 0) {
            $ret['inserts'] = $this->db->insert_batch('action_register', $inserts, true);
        }
        if (count($updates) > 0) {
            $ret['updates'] = $this->db->update_batch('action_register', $updates, 'key');
        }

        return $ret;
    }

}