<?php

class Audits_model extends CI_Model {

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function getAudits(){
        $this->db->where('template_archived', false);
        $query = $this->db->get('audits');
        $results = $query->result_array();
        return $results;
    }

    public function getMostRecentDate(){
        $this->db->order_by('modified_at', 'desc');
        $this->db->limit(1);
        $this->db->select('modified_at');
        $query = $this->db->get('audits');
        $results = $query->result_array();
        //convert to ISO8601 format for the API

        $time = date(DATE_ATOM, strtotime($results[0]['modified_at']));
        return urlencode($time);

    }

    //Upsert script.
    public function upsertBatch($batch){

        //Obtain audit ids from the batch
        $auditIds = array();
        foreach($batch as $b) {
            $auditIds[] = $b['audit_id'];
        }
        //check if they are in the db
        $this->db->where_in('audit_id', $auditIds);
        $query = $this->db->get('audits');
        $results = $query->result_array();

        //if they are, grab their keys
        $keys = array();
        foreach($results as $r){
            $keys[] = $r['audit_id'];
        }

        //separate into inserts and updates
        $inserts = array();
        $updates = array();
        foreach($batch as $b){
            if(in_array($b['audit_id'], $keys)){
                $updates[] = $b;
            }
            else{
                $inserts[] = $b;
            }
        }

        //insert/update as applicable
        $ret = array();
        if(count($inserts)>0) {
            $ret['inserts'] = $this->db->insert_batch('audits', $inserts, true);
        }
        if(count($updates)> 0) {
            $ret['updates'] = $this->db->update_batch('audits', $updates, 'audit_id');
        }

        return $ret;
    }


    public function tester($batch){
        $auditids = array();
        foreach($batch as $def) {
            $auditids[] = $def['audit_id'];
        }
        return $auditids;

        //$query = $this->db->get('audits');
        //return $query->result_array();
    }
}