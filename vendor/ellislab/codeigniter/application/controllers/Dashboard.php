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
        if($this->ion_auth->is_admin()){
            $data = array('dataSet'=>$this->task_model->getForUser($this->ion_auth->get_user_id()));
        }
        else {
            $data = array('dataSet'=>$this->task_model->getForUser($this->ion_auth->get_user_id()));
        }
        $this->load->view('dashboard/index_view', $data);
    }


}