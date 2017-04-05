<?php

class Actionregister_model extends CI_Model
{

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->database();
        $this->load->model('Mail_model');
        $this->load->model('Areaofaccountability_model');
    }

    public function getAR($userId=false){
        $result = array();
        if($userId){
            //Fetch AOA first where accountable
            $this->db->where('accountable_person', $userId);
            $this->db->select('area_of_accountability.*, area_of_accountability.id as aoa_id');

            //Some people may be accountable and responsible.
            //Store the areas in a map to prevent fetching twice
            $accountableMap = array();
            $query = $this->db->get('area_of_accountability');
            $results = $query->result_array();
            foreach($results as $i){
                $tmp = $this->getARByArea($i['name']);
                if(count($tmp)> 0){
                    $accountableMap[$i['name']] = true;
                    $result[] = $tmp;
                }
            }

            //Then, where we are listed as RP
            $this->db->where('rp', $userId);
            $this->db->join('area_of_accountability', 'area_of_accountability.id = aoa_rp.aoa');
            $this->db->select('aoa_rp.*, area_of_accountability.*, area_of_accountability.id as aoa_id');

            $query = $this->db->get('aoa_rp');
            $results = $query->result_array();
            foreach($results as $i) {
                //only add if we haven't added them already as accountable person
                if (!isset($accountableMap[$i['name']])){

                    $tmp = $this->getARByArea($i['name']);
                    if (count($tmp) > 0) {
                        $result[] = $tmp;
                    }
                }
            }
        }
        else{

            $this->db->group_by('area_of_accountability');
            $this->db->where('response', 'No');
            $this->db->where('area_of_accountability !=', '');
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
        foreach($result as &$res) {
            foreach($res as &$r) {
                if (isset($r['area_of_accountability'])) {
                    $tmp = explode('.', $r['area_of_accountability']);
                    $r['OrgUnit'] = $tmp[0];
                } else {
                    $r['OrgUnit'] = '';
                }
                //echo "ARRAY";
                //echo json_encode($r);
            }
        }


        return $result;
    }

    private function getARByArea($area){
        $this->db->like('area_of_accountability', $area);
        $this->db->where('response', 'No');
        $this->db->join('audits', 'audits.audit_id = action_register.audit_id');
        $this->db->select('action_register.*, action_register.id as ar_id, audits.*, audits.id as au_id');

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
            $results = $query->result_array();
            $results = $results[0];
            return $results['first_name'] . " " . $results['last_name'];
        }
        //no accountable person
        else return "--Not Set In Action Tracker--";
    }

    public function isAccountableUser($area, $userId){
        $this->db->like('name', $area);
        $this->db->join('users', 'users.id = area_of_accountability.accountable_person');
        $this->db->select('users.id as userId, users.*');
        $query = $this->db->get('area_of_accountability');
        $allresults = $query->result_array();
        if(count($allresults) > 0) {
            $results = $query->result_array();
            $results = $results[0];
            if($userId == $results['userId']){
                return true;
            }

        }
        //no accountable person
        else return false;
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
        $this->db->select('audits.*, action_register.*, audits.id as audit_pk');
        $this->db->join('audits', 'audits.audit_id = action_register.audit_id');
        $query = $this->db->get('action_register');
        $results = $query->result_array();
        $results = $results[0];
        if (isset($results['area_of_accountability'])) {
            $tmp = explode('.', $results['area_of_accountability']);
            $results['OrgUnit'] = $tmp[0];
        } else {
            $results['OrgUnit'] = '';
        }
        return $results;
    }

    public function update($record){

        if(isset($record['completion_date'])){
            //Have to remove the slashes, otherwise PHP thinks its an american date.
            $record['completion_date'] = str_replace('/', '-', $record['completion_date']);
            $record['completion_date'] = date("Y-m-d", strtotime($record['completion_date']));
        }
        if(isset($record['action_closed_date'])){
            $record['action_closed_date'] = str_replace('/', '-', $record['action_closed_date']);
            $record['action_closed_date'] = date("Y-m-d", strtotime($record['action_closed_date']));
        }

        if(isset($record['reviewed_action']) && strlen($record['reviewed_action']) > 0 && $record['action_status'] == 'Open'){
            $record['action_status'] = 'In Progress';

        }

        if($record['action_status'] == 'Closed' && isset($record['completion_date'])){
            //set the date
            //$record['action_closed_date'] = $record['completion_date'];
            $record['action_closed_date'] = date("Y-m-d");

            //$record['action_closed_date'] = date("Y-m-d");
            //close tasks
            $this->load->model('task_model');
            $this->task_model->closeTasks($record['id']);
        }

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
        //$this->db->where_in('key', $itemIds);


        $item_ids_chunk = array_chunk($itemIds ,25);
        if(count($item_ids_chunk) > 0) {
            $this->db->group_start();

            foreach ($item_ids_chunk as $item_ids) {
                $this->db->or_where_in('key', $item_ids);
            }
            $this->db->group_end();

        }
        $query = $this->db->get('action_register');
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
                $this->db->insert('action_register', $ins);


            }
            $ret['inserts'] = count($inserts);
        }
        if (count($updates) > 0) {
            //$ret['updates'] = $this->db->update_batch('action_register', $updates, 'key');
            foreach($updates as $upd){
                $errors[] = $this->db->update('action_register', $upd, array('key' => $upd['key']));

            }
            //echo "ERRORS:".json_encode($errors);
            //echo json_encode($updates);
            $ret['updates'] = count($updates);
        }



        return $ret;
    }

    public function sendMailForNew(){
        $this->db->where('mail_sent', false);
        $this->db->select('audits.*, action_register.*, audits.id as audit_pk');
        $this->db->join('audits', 'audits.audit_id = action_register.audit_id');
        $query = $this->db->get('action_register');
        $results = $query->result_array();
        $updates = array();
        $info = array();
        foreach($results as $res) {
            $ap = $this->Areaofaccountability_model->getUserforAoa($res['area_of_accountability']);
            if($ap) {
               $info['ap_mail'][] = $this->Mail_model->item_assigned($ap, $res, 'ap');
            }
            $inspector = $this->Areaofaccountability_model->getInspector($res['inspector_name']);
            if($inspector && $inspector != $ap) {
                $info['inspector_mail'][] = $this->Mail_model->item_assigned($inspector, $res, 'ins');
            }
            if($inspector || $ap){
                $update['key'] = $res['key'];
                $update['mail_sent'] = true;
                $updates[] = $update;
            }
        }
        $info['ar_updates'] = $this->upsertBatch($updates);
        return $info;
    }

    public function getTotalMap(){
        $this->db->select('audit_id as audit_id, COUNT(*) as total');
        $this->db->where('response', 'No');
        $this->db->group_by("audit_id");
        $query = $this->db->get('action_register');

        $results = $query->result_array();
        $map = array();
        foreach ($results as $r) {
            $map[$r['audit_id']] = $r['total'];
        }
        return $map;
    }

    public function getOutstandingMap(){
        $this->db->select('audit_id as audit_id, COUNT(*) as total');
        $this->db->where('action_status =', 'Open');
        $this->db->where('response', 'No');
        $this->db->group_by("audit_id");
        $query = $this->db->get('action_register');


        $results = $query->result_array();


        $map = array();
        foreach ($results as $r) {
            $map[$r['audit_id']] = $r['total'];
        }
        return $map;
    }

    public function getInProgressMap(){
        $this->db->select('audit_id as audit_id, COUNT(*) as total');
        $this->db->where('action_status', 'In Progress');
        $this->db->where('response', 'No');
        $this->db->group_by("audit_id");
        $query = $this->db->get('action_register');


        $results = $query->result_array();


        $map = array();
        foreach ($results as $r) {
            $map[$r['audit_id']] = $r['total'];
        }
        return $map;
    }
}