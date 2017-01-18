<?php

class Task_model extends CI_Model
{
    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->database();

    }

    public function getForUser($user){

        $this->db->where('user',$user);
        $query = $this->db->get('tasks');
        $results = $query->result_array();
        foreach ($results as &$res){
            $now = time(); // or your date as well
            $your_date = strtotime($res['completion_date']);
            $datediff = $now - $your_date;
            $res['diff']=  floor($datediff / (60 * 60 * 24));
        }
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
        $query = $this->db->get('tasks');
        $results = $query->result_array();

        //if they are, grab their keys
        $keys = array();
        foreach ($results as $r) {
            $keys[] = $r['key'];
        }

        //Possibliity that an action item can be added
        //to the incoming array twice, due to the
        //complexity of the unstructured document.
        //Remove duplicates by only processing once per key
        $uniqueKeys = array();

        //separate into inserts and updates
        $inserts = array();
        $updates = array();
        foreach ($batch as $b) {
            if(!in_array($b['key'],$uniqueKeys )) {
                //echo "NOT IN ARRAY".$b['key'];
                if (in_array($b['key'], $keys)) {
                    $updates[] = $b;
                } else {
                    $inserts[] = $b;
                }
                $uniqueKeys[] = $b['key'];
            }
        }

        //insert/update as applicable
        $ret = array();
        if (count($inserts) > 0) {
            //$ret['inserts'] = $this->db->insert_batch('action_register', $inserts, true);
            foreach($inserts as $ins){
                $this->db->insert('tasks', $ins);
            }
            $ret['inserts'] = count($inserts);
        }
        if (count($updates) > 0) {
            //$ret['updates'] = $this->db->update_batch('action_register', $updates, 'key');
            foreach($updates as $upd){
                $errors[] = $this->db->update('tasks', $upd, array('key' => $upd['key']));

            }
            //echo "ERRORS:".json_encode($errors);
            //echo json_encode($updates);
            $ret['updates'] = count($updates);
        }

        return $ret;
    }

    public function CreateTasks(){
        $this->load->model('audits_model');
        $this->load->model('areaofaccountability_model');

        /*$query = $this->db->query("select id, audit_id, key, item_id, CURRENT_DATE, completion_date, action_status
          from action_register
          where action_register.id not in (select action_register from tasks)
          and CURRENT_DATE > completion_date and action_register.action_status != 'Closed'" );
    */
        $query = $this->db->query("select id, audit_id, key, item_id, CURRENT_DATE, completion_date, action_status 
          from action_register
          Where CURRENT_DATE > completion_date and action_register.action_status != 'Closed'" );
        $results = $query->result_array();

        $tasks = array();
        foreach($results as $result){
            $audit = $this->audits_model->getRecord($result['audit_id']);
            $ap = $this->areaofaccountability_model->getUserforAoa($audit['area_of_accountability']);
            if($ap) {
                $task['user'] = $ap;
                $task['key'] = $result['item_id']."_".$ap;
                $task['status'] = 'Open';
                $task['action_register'] = $result['id'];
                $task['audit'] = $result['audit_id'];
                $task['completion_date'] = $result['completion_date'];
                $tasks[] = $task;
            }
            $inspector = $this->areaofaccountability_model->getInspector($audit['inspector_name']);
            if($inspector) {
                $task['user'] = $inspector;
                $task['key'] = $result['item_id']."_".$inspector;
                $task['status'] = 'Open';
                $task['action_register'] = $result['id'];
                $task['audit'] = $result['audit_id'];
                $task['completion_date'] = $result['completion_date'];
                $tasks[] = $task;
            }
        }
        $d = array();
        if(isset($tasks) && count($tasks) > 0){
            $d['result'] = $this->upsertBatch($tasks);
        }
        else{
            $d['result'] = 'nothing to do';
        }

        return $d;

    }
}