<?php

class Reports_model extends CI_Model
{
    public function __construct()
    {
        // Call the CI_Model constructor
        parent::__construct();
        $this->load->database();

    }

    public function getMinMaxDates(){

        $SQL = "select min(created_at) as start, max(created_at) as end from audits where template_archived = 0 and OrgUnit != ''";
        $query = $this->db->query($SQL);
        $results = $query->result_array();

        return $results[0];

    }

    public function getManagerReportData($from, $to){


        $SQL = "select OrgUnit, count(distinct(location)) as Locations,
count(distinct(audits.id)) as Inspections,
  sum(case action_register.action_status when 'Open' then 1 else 0 end) as OutstandingActions,
  count(distinct(action_register.id)) as TotalActions
from audits
  left outer join action_register on action_register.audit_id = audits.audit_id and action_register.response = 'No'
where template_archived = 0 and OrgUnit != '' 
  and date(created_at) >= date('$from') and date(created_at) <= date('$to')
group by OrgUnit";

        //echo $SQL;

        $query = $this->db->query($SQL);
        $results = $query->result_array();

        return $results;
    }
}
