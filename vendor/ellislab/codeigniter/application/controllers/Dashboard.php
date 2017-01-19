<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Auth_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->output->set_template('default');
        $this->load->model('task_model');

    }

    function index(){

        $data = array('outstanding'=>$this->task_model->getForUser($this->ion_auth->get_user_id(), 'Open'),
            'completed'=>$this->task_model->getForUser($this->ion_auth->get_user_id(), 'Closed'));

        $this->load->view('dashboard/index_view', $data);
    }


}