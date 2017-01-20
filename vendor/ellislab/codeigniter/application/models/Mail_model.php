<?php

class Mail_model extends CI_Model
{
    private $defaultFromMail = 'safetyandwellbeing@uts.edu.au';
    private $defaultFromName = 'iAuditor Action Tracker';
    private $defaultSubject = 'iAuditor Action Tracker - Past Completion Date';

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
        $this->load->library('email', $config);
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
        $this->email->subject($this->defaultSubject); // replace it with relevant subject

        $body = $this->load->view('emails/passed_completion',$data, TRUE);
        $this->email->message($body);
        $r = array('id'=>$id, 'to'=>$to, 'key'=>$key, 'inspection'=>$ar['audit_pk'],'Hazard'=>$ar['id']);
        echo json_encode($r);
        echo json_encode($this->email->send());
        echo $this->email->print_debugger();
        return $r;
    }
}