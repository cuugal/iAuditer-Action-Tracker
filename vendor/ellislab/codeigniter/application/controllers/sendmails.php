<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sendmails extends CI_Controller {

    private $defaultFromMail = 'safetyandwellbeing@uts.edu.au';
    private $defaultFromName = 'iAuditor Action Tracker';
    private $defaultSubject = 'iAuditor Action Tracker - Past Completion Date';

    function __construct() {
        parent::__construct();
        $this->load->model('Actionregister_model');
        $this->load->model('Ion_auth_model');
        $this->load->model('Mail_model');

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

    public function index()
    {
        $this->load->view('emails/passed_completion');
    }

    public function passed_completion($id, $key){
        echo $this->Mail_model->passed_completion($id, $key);
    }


}
