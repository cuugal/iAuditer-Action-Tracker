<?php

class Issue_model extends CI_Model
{
    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->database();

    }

    public function getAll()
    {
        $this->db->join('proposed_action', 'issues.proposed_action = proposed_action.id', 'left outer');
        $this->db->select("issues.*, issues.id AS issue_id, proposed_action.*");
        $query = $this->db->get('issues');
        $results = $query->result_array();
        return $results;
    }

    public function getForProposedAction($actionId){
        $this->db->where('proposed_action', $actionId);
        $query = $this->db->get('issues');
        $results = $query->result_array();
        return $results;
    }

    public function getRecord($id){
        $this->db->where('id',$id);
        $query = $this->db->get('issues');
        $results = $query->result_array();
        return $results[0];
    }

    public function update($data)
    {
        $this->db->where('id', $data['id']);
        $this->db->update('issues', $data);
    }

    public function getIssueActionMap(){
        $this->db->join('proposed_action', 'issues.proposed_action = proposed_action.id');
        $this->db->select("issues.*, issues.id AS issue_id, proposed_action.proposed_action as pa");
        $query = $this->db->get('issues');
        $results = $query->result_array();

        $map = array();
        foreach($results as $a){
            $map[$a['issue']] = $a['pa'];
        }

        return $map;


    }

}