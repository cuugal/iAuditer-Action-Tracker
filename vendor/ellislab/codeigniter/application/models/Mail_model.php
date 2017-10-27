<?php

class Mail_model extends CI_Model


		/*  edit defaultFromMail with default email address e.g. void@uts.edu.au */ 

{
    private $defaultFromMail = '';
    private $defaultFromName = 'iAuditor Action Tracker';
    private $defaultCompletionSubject = 'iAuditor Action Tracker - Past Completion Date';
    private $defaultAssignedSubject = 'iAuditor Action Tracker - Assigned Item';
	private $defaultNotifySubject = 'iAuditor Action Tracker - Inspection Receipt';


    function __construct() {
        parent::__construct();
        $this->load->model('Actionregister_model');
        $this->load->model('Ion_auth_model');

        $this->load->library('email');

    }

    public function passed_completion($id, $key){

        $ar = $this->Actionregister_model->getRequest($key);
        //echo json_encode($ar);
        $data['TaskDueDate'] = $ar['completion_date'];
        $data['InspectionID'] = $ar['audit_pk'];
        $data['HazardID'] = $ar['id'];
        $data['DateIdentified'] = $ar['created_at'];
        $data['InspectorName'] = $ar['inspector_name'];
        $data['Issue'] = $ar['issue'];
        $data['ProposedAction'] = $ar['proposed_action'];

        $this->email->clear();

        $this->email->set_newline("\r\n");
        $this->email->set_mailtype("html");
        $this->email->from($this->defaultFromMail, $this->defaultFromName);

        $user = $this->ion_auth_model->getUser($id);

        $to = $user['email'];
        $this->email->to($to);  // replace it with receiver mail id
        //$this->email->to('alger.andrew@gmail.com');
        $this->email->subject($this->defaultCompletionSubject); // replace it with relevant subject

        $body = $this->load->view('emails/passed_completion',$data, TRUE);
        $this->email->message($body);

        $sent = $this->email->send();
        if($sent) {
            $r = array('id' => $id, 'to' => $to, 'key' => $key, 'inspection' => $ar['audit_pk'], 'Hazard' => $ar['id'], 'sent' => $sent);
        }
        else{
            $r = array('id' => $id, 'to' => $to, 'key' => $key, 'inspection' => $ar['audit_pk'], 'Hazard' => $ar['id'], 'error' =>  $this->email->print_debugger());

        }

        return $r;
    }



    public function item_assigned($id, $ar, $type, $email=null){

        //$ar = $this->Actionregister_model->getRequest($key);
        //echo json_encode($ar);
        $data['InspectionType'] = $ar['name'];
        $data['InspectionID'] = $ar['id'];

        $data['DateIdentified']     = $ar['created_at'];
        $data['AoA']                = $ar['area_of_accountability'];
        $data['InspectorName']      = $ar['inspector_name'];
        $data['Location']           = $ar['location'];
        $data['Deficiencies']       = $ar['deficiencies'];
        $data['TotalItems']         = $ar['totalitems'];
        $this->email->clear();

        $this->email->set_newline("\r\n");
        $this->email->set_mailtype("html");
        $this->email->from($this->defaultFromMail, $this->defaultFromName);

        if(isset($id)) {
            $user = $this->ion_auth_model->getUser($id);

            $to = $user['email'];
        }
        else{
            $to = $email;
        }

        $this->email->to($to);  // replace it with receiver mail id

        if($type == 'ins') {
			$this->email->subject($this->defaultNotifySubject); // replace it with relevant subject
            $body = $this->load->view('emails/item_assigned_ins', $data, TRUE);
        }
        else if($type == 'ap'){
			$this->email->subject($this->defaultAssignedSubject); // replace it with relevant subject
            $body = $this->load->view('emails/item_assigned_ap', $data, TRUE);
        }
        $this->email->message($body);

        $sent = $this->email->send();
        if($sent) {
            $r = array('to' => $to, 'inspection' => $ar['id'], 'sent' => $sent);
        }
        else{
            $r = array('to' => $to, 'inspection' => $ar['id'], 'error' =>  $this->email->print_debugger());

        }
        return $r;
    }
}