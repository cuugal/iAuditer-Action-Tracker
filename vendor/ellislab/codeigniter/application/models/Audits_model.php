<?php

class Audits_model extends CI_Model {

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function loadAudits($map, $date){


        if(isset($date)) {
            $url = 'https://api.safetyculture.io/audits/search?field=audit_id&field=modified_at&field=template_id&modified_after=' . $date;
        }
        else{
            $url = 'https://api.safetyculture.io/audits/search?field=audit_id&field=modified_at&field=template_id';
        }

        $client = new Guzzle\Http\Client();
        $client->setDefaultOption('headers', [
            'Authorization' => 'Bearer d00508d44e39a51fcefa604b9540d03f02f9b9fef8a25ca84f782f61956b96f5',
        ]);
        $request = $client->get($url);
        $res = $request->send();

        $data = json_decode($res->getBody(), true);

        foreach($data['audits'] as &$audit){

            //initialise values because insert_batch hates it when you don't initialise values.
            $audit['inspection_type'] = '';
            $audit['location'] = '';
            $audit['modified_at'] = '';
            $audit['created_at'] = '';
            $audit['description'] = '';
            $audit['location'] = '';
            $audit['inspector_name'] = '';
            $audit['area_of_accountability'] = '';

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
                $url = 'https://api.safetyculture.io/audits/' . $audit['audit_id'];
                $client = new Guzzle\Http\Client();
                $client->setDefaultOption('headers', [
                    'Authorization' => 'Bearer d00508d44e39a51fcefa604b9540d03f02f9b9fef8a25ca84f782f61956b96f5',
                ]);
                $request = $client->get($url);
                $res = $request->send();

                //created at
                $audit_data = json_decode($res->getBody(), true);

                //Get rid of this blasted ISO8601 format
                $d = new DateTime($audit_data['created_at']);
                $audit['created_at'] = $d->format('Y-m-d H:i:s');

                $d = new DateTime($audit_data['modified_at']);
                $audit['modified_at'] = $d->format('Y-m-d H:i:s');

                $audit['description'] = $audit_data['template_data']['metadata']['description'];
                //Location
                foreach ($audit_data['header_items'] as $header_item) {
                    if (strpos($header_item['label'], 'Location') !== false) {
                        if (isset($header_item['responses']['text'])) {
                            $audit['location'] = $header_item['responses']['text'];
                        }
                    }

                    if (strpos($header_item['label'], 'Area to be Inspected') !== false) {
                        $area = '';
                        if (isset($header_item['responses']['selected'])) {
                            foreach ($header_item['responses']['selected'] as $item) {
                                $area .= $item['label'] . " ";
                            }
                        }
                        $audit['area_of_accountability'] = $area;
                    }

                }

                //Inspector
                if (isset($audit_data['audit_data']['authorship']['author'])) {
                    $audit['inspector_name'] = $audit_data['audit_data']['authorship']['author'];
                }


            }

        }

        $result['audits'] = $this->upsertBatch($data['audits']);

        return $result;
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