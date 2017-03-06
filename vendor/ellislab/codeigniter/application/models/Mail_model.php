<?php

class Mail_model extends CI_Model
{
    private $defaultFromMail = 'safetyandwellbeing@uts.edu.au';
    private $defaultFromName = 'iAuditor Action Tracker';
    private $defaultCompletionSubject = 'iAuditor Action Tracker - Past Completion Date';
    private $defaultAssignedSubject = 'iAuditor Action Tracker - Assigned Item';

    function __construct() {
        parent::__construct();
        $this->load->model('Actionregister_model');
        $this->load->model('Ion_auth_model');

        $this->load->library('email');

        /* Alternate setup if default mail doesn't work
        $config = Array(
        'protocol' => 'smtp',
        'smtp_host' => 'ssl://smtp.googlemail.com',
        'smtp_port' => 465,
        'smtp_user' => 'my-email@gmail.com',
        'smtp_pass' => '***',
        'mailtype' => 'html',
        'charset' => 'iso-8859-1',
        'wordwrap' => TRUE
        );

        $this->email->initialize($config);
        */
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

    public function item_assigned($id, $ar){

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

        $user = $this->ion_auth_model->getUser($id);

        $to = $user['email'];
        $this->email->to($to);  // replace it with receiver mail id
        //$this->email->to('alger.andrew@gmail.com');
        $this->email->subject($this->defaultAssignedSubject); // replace it with relevant subject

        $body = $this->load->view('emails/item_assigned',$data, TRUE);
        $this->email->message($body);

        $sent = $this->email->send();
        if($sent) {
            $r = array('id' => $id, 'to' => $to, 'inspection' => $ar['id'], 'sent' => $sent);
        }
        else{
            $r = array('id' => $id, 'to' => $to, 'inspection' => $ar['id'], 'error' =>  $this->email->print_debugger());

        }
        return $r;
    }
}