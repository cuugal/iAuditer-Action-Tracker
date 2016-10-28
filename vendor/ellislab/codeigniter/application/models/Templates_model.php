<?php
class Templates_model extends CI_Model
{

    public function __construct()
    {
// Call the CI_Model constructor
        parent::__construct();
        $this->load->database();
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

//insert/update as applicable
        $ret = array();
        if (count($inserts) > 0) {
            $ret['inserts'] = $this->db->insert_batch('templates', $inserts);
        }
        if (count($updates) > 0) {
            $ret['updates'] = $this->db->update_batch('templates', $updates, 'template_id');
        }

        return $ret;
    }
}