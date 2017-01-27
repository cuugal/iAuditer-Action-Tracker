<?php

class Media_model extends CI_Model
{

    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->database();
    }

    public function getForAR($ar_id){
        $this->db->where('ar_id', $ar_id);

        $query = $this->db->get('media');
        $results = $query->result_array();

        $images = array();
        foreach ($results as $result) {

            if(file_exists(APPPATH.'../tmp/'.$result['label'])){
                $images[] = $result['label'];
            }
            else{
                $url = $result['href'];
                echo json_encode($url);
                $client = new Guzzle\Http\Client();
                $client->setDefaultOption('headers', array(
                    'Authorization' => $this->config->item('authorisation'),
                ));
                $request = $client->get($url);

                $request->setResponseBody(APPPATH.'../tmp/'.$result['label']);
                $res = $request->send();
                $images[] = $result['label'];
            }
        }

        return $images;
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
        $query = $this->db->get('media');
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
                $this->db->insert('media', $ins);
            }
            $ret['inserts'] = count($inserts);
        }
        if (count($updates) > 0) {
            //$ret['updates'] = $this->db->update_batch('action_register', $updates, 'key');
            foreach($updates as $upd){
                $errors[] = $this->db->update('media', $upd, array('key' => $upd['key']));

            }
            //echo "ERRORS:".json_encode($errors);
            //echo json_encode($updates);
            $ret['updates'] = count($updates);
        }

        return $ret;
    }
}
