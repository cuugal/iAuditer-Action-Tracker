<?php

class Audits_model extends CI_Model {

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->database();
        $this->load->model('actionregister_model');
        $this->load->model('issue_model');
        $this->load->model('media_model');
    }

    
    public function loadAudits($map, $date){


        if(isset($date)) {
            $url = 'https://api.safetyculture.io/audits/search?field=audit_id&field=modified_at&field=template_id&modified_after=' . $date;
        }
        else{
            $url = 'https://api.safetyculture.io/audits/search?field=audit_id&field=modified_at&field=template_id';
        }

        $client = new Guzzle\Http\Client();
        $client->setDefaultOption('headers', array(
            'Authorization' => $this->config->item('authorisation'),
        ));
        $request = $client->get($url);
        $res = $request->send();

        $data = json_decode($res->getBody(), true);

        $action_registers = array();

        $issueActionMap = $this->issue_model->getIssueActionMap();

        foreach($data['audits'] as &$audit){

//            if($audit['audit_id'] != 'audit_0be59d80f91349b88fa3669b6cc32b02'){
//                continue;
//            }

            //initialise values because insert_batch hates it when you don't initialise values.
            $audit['inspection_type'] = '';
            $audit['location'] = '';
            $audit['modified_at'] = '';
            $audit['created_at'] = '';
            $audit['description'] = '';
            $audit['inspector_name'] = '';
            $audit['area_of_accountability'] = '';
            $audit['OrgUnit'] = '';
            $audit['last_fetched_api'] =  time();
            $audit['email'] = '';

            if(isset($map[$audit['template_id']])) {
                $audit['inspection_type'] = $map[$audit['template_id']];
                $audit['template_archived'] = false;
            }
            else{
                $audit['inspection_type'] = '';
                $audit['template_archived'] = true;
            }

            //backfill with data from individual calls, as required
            // (at this stage, only where the template isn't archived
            if(isset($map[$audit['template_id']])) {


                $url = $this->config->item('audit_url') . $audit['audit_id'];
                $client = new Guzzle\Http\Client();
                $client->setDefaultOption('headers', array(
                    'Authorization' => $this->config->item('authorisation'),
                ));
                $request = $client->get($url);
                $res = $request->send();

                //created at
                $audit_data = json_decode($res->getBody(), true);


                //Inspector
                if (isset($audit_data['audit_data']['authorship']['author'])) {
                    $audit['inspector_name'] = trim($audit_data['audit_data']['authorship']['author']);
                }


                //Get rid of this blasted ISO8601 format
                //$d = new DateTime($audit_data['created_at']);
                $d = new DateTime($audit_data['created_at']);
                $audit['created_at'] = $d->format('Y-m-d H:i:s');

                $d = new DateTime($audit_data['modified_at']);
                $audit['modified_at'] = $d->format('Y-m-d H:i:s');

                $audit['description'] = $audit_data['template_data']['metadata']['description'];
                $audit['name'] = $audit_data['template_data']['metadata']['name'];

                //Location
                foreach ($audit_data['header_items'] as $header_item) {
                    if (strpos($header_item['label'], 'Location') !== false) {
                        if (isset($header_item['responses']['text'])) {
                            $audit['location'] = trim($header_item['responses']['text']);
                        }
                    }

                    if (strpos($header_item['label'], 'Area to be Inspected') !== false) {
                        $area = '';
                        if (isset($header_item['responses']['selected'])) {
                            foreach ($header_item['responses']['selected'] as $item) {
                                $area .= $item['label'] . " ";
                            }
                        }
                        $audit['area_of_accountability'] = trim($area);

                        $tmp = explode('.', $audit['area_of_accountability']);
                        $audit['OrgUnit'] = $tmp[0];
                    }

                    if(isset($header_item['label'])){
                        if (strpos($header_item['label'], 'Name of person completing the checklist') !== false) {
                            if(isset($header_item['responses']['text'])) {
                                $audit['inspector_name'] = trim($header_item['responses']['text']);
                            }
                        }
                        if (strpos($header_item['label'], 'Email of person submitting checklist') !== false) {
                            if(isset($header_item['responses']['text'])) {
                                $audit['email'] = trim($header_item['responses']['text']);
                            }
                        }
                    }


                }


                //SMartfieldmap
                unset($smartfield_map);

                //Retrieve smartfields
                unset($smartfields);
                //Retrieve categories
                unset($categories);
                //retrieve checkboxes
                unset($checkboxes);
                //retrieve sections
                unset($sections);
                //retrieve proposed actions
                unset($proposed_actions);
                unset($proposed_actions_map);

                foreach ($audit_data['items'] as $item) {
                    if($item['type'] == 'smartfield'){
                        $smartfield_map[$item['item_id']] = $item['parent_id'];
                        $smartfields[$item['item_id']] = $item;
                    }
                    if($item['type'] == 'checkbox'){
                        $checkboxes[$item['item_id']] = $item['parent_id'];
                    }
                    if($item['type']== 'category'){
                        $categories[$item['item_id']] = $item['label'];
                    }
                    if($item['type'] == 'section'){
                        $sections[$item['item_id']] = $item;
                    }
                    if($item['type'] == 'information'){
                        $proposed_action_map[$item['parent_id']] = $item['item_id'];
                        $proposed_actions[$item['item_id']] = $item;
                    }
                }


                //Action_Register
                foreach ($audit_data['items'] as $item) {
                    if (strpos($item['type'], 'question') !== false) {
                        // no 'inactive' flag means its active
                        if(!isset($item['inactive'])) {
                            $action_register = array();
                            $action_register['item_id'] = trim($item['item_id']);
                            $action_register['audit_id'] = trim($audit['audit_id']);
                            $action_register['issue'] = trim($item['label']);
                            $action_register['proposed_action'] = "";
                            $action_register['notes'] = "";


                            //fetch proposed actions
                            if(isset($action_register['issue']) && isset($issueActionMap[$action_register['issue']])){
                                $action_register['proposed_action'] = $issueActionMap[$action_register['issue']];
                            }

                            //override with the action in the audit if available
                            //echo $item['item_id']."<br/>".json_encode($proposed_action_map);
                            if(isset($proposed_actions) && isset($proposed_action_map[$item['item_id']])) {
                                $proposed_action_id = $proposed_action_map[$item['item_id']];
                                $proposed_action = $proposed_actions[$proposed_action_id];
                                $action_register['proposed_action'] = $proposed_action['label'];
                            }
                            else if(isset($smartfields) && isset($smartfields[$item['parent_id']])) {
                                $smrt = $smartfields[$item['parent_id']];
                                //echo json_encode($checkboxId);
                                //$smrt is the smartfield, need to find the item+1 child to get the action
                                $index = array_search( $item['item_id'],$smrt['children']);

                                if(isset( $smrt['children'][$index+1])) {
                                    $proposed_action_id = $smrt['children'][$index + 1];
                                    if (isset($proposed_actions[$proposed_action_id])) {
                                        $proposed_action = $proposed_actions[$proposed_action_id];
                                        $action_register['proposed_action'] = $proposed_action['label'];
                                    }
                                }
                            }


                            $action_register['type_of_hazard'] = '';
                            $action_register['initial_risk'] = '';
                            $action_register['source'] = trim($audit['description']);

                            //if there is a response noted on the page
                            if(isset($item['responses']['selected'])){
                                //Item-->smartfield-->checkbox-->section
                                unset($sectionId);
                                //locate topmost section
                                if(isset($smartfield_map) && isset($checkboxes) && isset($smartfield_map[$item['parent_id']])) {
                                    $checkboxId = $smartfield_map[$item['parent_id']];
                                    //$action_register['source'] = $checkboxId;
                                    $sectionId = $checkboxes[$checkboxId];
                                    $action_register['type_of_hazard'] = trim($sectionId);
                                    //$action_register['source'] = $item['parent_id'];
                                    unset($section);

                                    if (isset($sectionId) && isset($sections[$sectionId])){
                                        $section = $sections[$sectionId];
                                    }
                                    //Now we can start populating some items.
                                    if (isset($section)) {
                                        //$action_register['source'] = $section['label'];

                                        $index = array_search($checkboxId, $section['children']);
                                        if ($index !== false) {
                                            //children are in order: get the previous to get parent
                                            while ($index > 0 and !isset($categories[$section['children'][$index - 1]])){
                                                $index--;
                                            }
                                            $action_register['type_of_hazard'] = trim($categories[$section['children'][$index - 1]]);
                                        }
                                    }

                                }
                                //other case where there are no smartfields or checkboxes
                                else if (isset($sections[$item['parent_id']])) {
                                    $section = $sections[$item['parent_id']];
                                    $index = array_search($item['item_id'], $section['children']);
                                    if ($index !== false) {
                                        //children are in order: get the previous to get parent
                                        while ($index >= 0 and !isset($categories[$section['children'][$index]])) {
                                            $index--;
                                        }
                                        if ($index >= 0) {
                                            $action_register['type_of_hazard'] = trim($categories[$section['children'][$index]]);
                                        }
                                    }
                                }
                                if(isset($item['children'])){
                                    foreach($item['children'] as $child) {
                                        //$action_register['initial_risk'] = $child;

                                        //locate priority
                                        foreach ($audit_data['items'] as $source) {
                                            //if the item is a list item and not inactive, and is label 'Rate priority'
                                            if(strpos($source['type'], 'list') !== false && !isset($source['inactive'])
                                                 && strpos($source['label'], 'priority') !== false ) {
                                                #//if the list item's parent matches this items' child
                                                if ($source['parent_id'] == $child) {

                                                    if(isset($source['responses']['selected'])) {
                                                        //take the response and add to DB
                                                        foreach($source['responses']['selected'] as $i)
                                                            $action_register['initial_risk'] = trim($i['label']);
                                                    }

                                                }
                                            }
                                        }

                                    }
                                }

                                foreach($item['responses']['selected'] as $rp){
                                    if(strpos($rp['type'], 'text') !== false){
                                        $action_register['response'] = $rp['label'];
                                    }
                                }

                            }
                            //Add media items to media table
                            if(isset($item['media'])){
                                foreach($item['media'] as $m) {
                                    $media['ar_id'] = $action_register['item_id'] . $action_register['audit_id'];
                                    //media ID looks to be unique against audit, hence cn use item id/media ID as key
                                    $media['key'] = $action_register['item_id'] . $m['media_id'];
                                    $media['label'] = $m['label'];
                                    $media['media_id'] = $m['media_id'];
                                    $media['href'] = $m['href'];
                                    $media_items[] = $media;
                                }

                            }
                            //if there is a note on the page
                            if(isset($item['responses']['text'])){
                                //echo json_encode($item['responses']['text']);
                                $action_register['notes'] = $item['responses']['text'];
                            }

                            //only add/update if the type matters
                            if(isset($action_register['response'])){
                                $action_register['key'] = $action_register['item_id'].$action_register['audit_id'];
                                //echo json_encode($action_register);
                                $action_registers[] = $action_register;
                            }

                        }


                    }

                }




            }

        }

        $result['audits'] = $this->upsertBatch($data['audits']);
        //echo json_encode($action_registers);

        $result['action_registers'] = $this->actionregister_model->upsertBatch($action_registers);

        //upload media
        if(isset($media_items) && count($media_items) > 0){
            $result['media_items'] = $this->media_model->upsertBatch($media_items);
        }

        $result['new issues'] = $this->loadIssues();
        return $result;
    }

    public function loadIssues(){
        //pull out the existing issues from table
        $this->db->distinct();
        $this->db->select('issue');
        $query = $this->db->get('action_register');
        $results = $query->result_array();

        $ar_issues = array();
        foreach ($results as $b) {
            $ar_issues[] = $b['issue'];
        }

        //pull out existing issues from issues table
        $this->db->select('issue');
        $query = $this->db->get('issues');
        $results = $query->result_array();

        $issues = array();
        foreach ($results as $b) {
            $issues[] = $b['issue'];
        }

        $difference = array_diff($ar_issues, $issues);
        //return $difference;

        $inserts = array();
        foreach($difference as $a){
            if(trim($a) != '') {
                $n = array();
                $n['issue'] = $a;
                $inserts[] = $n;
            }
        }
        //return $inserts;
        if(count($inserts) > 0) {
            //return $this->db->insert_batch('issues', $inserts);
            foreach($inserts as $ins){
                $this->db->insert('issues', $ins);
            }
            return count($inserts);
        }
        return 0;
    }

    //Finish this after lunch

    public function getAudits($userId=false){

        if($userId){
            $orgunits = array();
            //Get AOA
            $this->db->where('accountable_person', $userId);
            $query = $this->db->get('area_of_accountability');
            $results = $query->result_array();
            foreach($results as $res){
                $orgunits[] = $res['OrgUnit'];
            }
            //echo json_encode($orgunits);


            //Get RP
            $this->db->join('area_of_accountability', 'area_of_accountability.id = aoa_rp.aoa');
            $this->db->where('rp', $userId);
            $query = $this->db->get('aoa_rp');
            $results = $query->result_array();
            foreach($results as $res){
                $orgunits[] = $res['OrgUnit'];
            }

            //Add to query
            $orgunits = array_unique ($orgunits);
            echo json_encode($orgunits);

            $this->db->where_in('OrgUnit', $orgunits);
        }
        $this->db->where('template_archived', false);
        $query = $this->db->get('audits');
        $results = $query->result_array();

        $total = $this->actionregister_model->getTotalMap();
        $outstanding = $this->actionregister_model->getOutstandingMap();
        $inprogress = $this->actionregister_model->getInProgressMap();

        foreach ($results as &$r) {
            if (isset($outstanding[$r['audit_id']])){
                $r['number_of_outstanding_actions'] = $outstanding[$r['audit_id']]."/".$total[$r['audit_id']];
            }
            else if (isset($total[$r['audit_id']])){
                $r['number_of_outstanding_actions'] = "0/".$total[$r['audit_id']];
            }
            else{
                $r['number_of_outstanding_actions'] = "0/0";
            }

            if (isset($inprogress[$r['audit_id']])){
                $r['number_of_actions_in_progress'] = $inprogress[$r['audit_id']]."/".$total[$r['audit_id']];
            }
            else if (isset($total[$r['audit_id']])){
                $r['number_of_actions_in_progress'] = "0/".$total[$r['audit_id']];
            }
            else{
                $r['number_of_actions_in_progress'] = "0/0";
            }
        }


        return $results;
    }

    public function getRecord($id){
        $this->db->where('audit_id',$id);
        $query = $this->db->get('audits');
        $results = $query->result_array();
        return $results[0];
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

    public function getMostRecentTime(){
        $this->db->order_by('last_fetched_api', 'desc');
        $this->db->limit(1);
        $this->db->select('last_fetched_api');
        $query = $this->db->get('audits');
        $results = $query->result_array();
        if (count($results) > 0) {
            return $results[0]['last_fetched_api'];
        }
        else return false;
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
            //php 5.3 and mysqlite can't do batch insert
            //$ret['inserts'] = $this->db->insert_batch('audits', $inserts, true);
            foreach($inserts as $ins){
                $this->db->insert('audits', $ins, true);
            }
            $ret['inserts'] = count($inserts);
        }
        if(count($updates)> 0) {
            //$ret['updates'] = $this->db->update_batch('audits', $updates, 'audit_id');
            foreach($updates as $upd){
                $this->db->update('audits', $upd, array('audit_id' => $upd['audit_id']));
            }
            $ret['updates'] = count($updates);
        }

        return $ret;
    }


    public function sendMailForNew(){
        $this->db->where('mail_sent', false);
        $query = $this->db->get('audits');

        $results = $query->result_array();
        $total = $this->actionregister_model->getTotalMap();
        $outstanding = $this->actionregister_model->getOutstandingMap();

        foreach($results as &$res_lk) {
            if (isset($outstanding[$res_lk['audit_id']])){
                $res_lk['deficiencies'] = $outstanding[$res_lk['audit_id']];
            }
            else{
                $res_lk['deficiencies'] = 0;
            }
            if (isset($total[$res_lk['audit_id']])){
                $res_lk['totalitems']   = $total[$res_lk['audit_id']];
            }
            else{
                $res_lk['totalitems'] = 0;
            }

        }

        $updates = array();
        $info = array();
        foreach($results as $res) {
            //send email to creator first
            if(isset($res['email'])){
                $info['audit_detail_mail'][] = $this->Mail_model->item_assigned(null, $res, 'ins',$res['email'] );
            }

            $ap = $this->Areaofaccountability_model->getUserforAoa($res['area_of_accountability']);
            if($ap) {
                $info['ap_mail'][] = $this->Mail_model->item_assigned($ap, $res, 'ap');
            }
            $inspector = $this->Areaofaccountability_model->getInspector($res['inspector_name']);
            if($inspector && $inspector != $ap) {
                $info['inspector_mail'][] = $this->Mail_model->item_assigned($inspector, $res, 'ins');
            }
            if($inspector || $ap){
                $update['audit_id'] = $res['audit_id'];
                $update['mail_sent'] = true;
                $updates[] = $update;
            }
        }
        $info['ar_updates'] = $this->upsertBatch($updates);
        return $info;
    }

}