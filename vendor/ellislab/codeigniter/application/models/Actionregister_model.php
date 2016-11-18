<?php

class Actionregister_model extends CI_Model
{

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function getAR(){
        $this->db->where('response', 'No');
        $this->db->join('audits', 'audits.audit_id = action_register.audit_id');
        $query = $this->db->get('action_register');
        $results = $query->result_array();
        return $results;
    }

    public function getRequest($key){
        $this->db->where('key', $key);
        $this->db->join('audits', 'audits.audit_id = action_register.audit_id');
        $query = $this->db->get('action_register');
        $results = $query->result_array()[0];
        return $results;
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