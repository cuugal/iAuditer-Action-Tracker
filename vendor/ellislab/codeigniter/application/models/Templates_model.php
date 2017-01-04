<?php
class Templates_model extends CI_Model
{

    public function __construct()
    {
// Call the CI_Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function getTemplates(){
        $query = $this->db->get('templates');
        $results = $query->result_array();
        return $results;
    }


//Upsert script.
    public function upsertBatch($batch)
    {

//Obtain audit ids from the batch
        $auditIds = array();
        foreach ($batch as $b) {
            $auditIds[] = $b['template_id'];
        }
//check if they are in the db
        $this->db->where_in('template_id', $auditIds);
        $query = $this->db->get('templates');
        $results = $query->result_array();

//if they are, grab their keys
        $keys = array();
        foreach ($results as $r) {
            $keys[] = $r['template_id'];
        }

//separate into inserts and updates
        $inserts = array();
        $updates = array();
        foreach ($batch as $b) {
            if (in_array($b['template_id'], $keys)) {
                $updates[] = $b;
            } else {
                $inserts[] = $b;
            }
        }
        //echo json_encode($inserts);
//insert/update as applicable
        $ret = array();
        if (count($inserts) > 0) {
            //$ret['inserts'] = $this->db->insert_batch('templates', $inserts);
            foreach($inserts as $ins){
                $this->db->insert('templates', $ins);
            }
            $ret['inserts'] = count($inserts);
        }
        if (count($updates) > 0) {
            //php 5.3 and SQLite3 can't do multiple inserts.  Woot.
            //$ret['updates'] = $this->db->update_batch('templates', $updates, 'template_id');
            foreach($updates as $upd){
                $this->db->update('templates', $upd, 'template_id');
            }
            $ret['updates'] = count($updates);
        }

        return $ret;
    }
}