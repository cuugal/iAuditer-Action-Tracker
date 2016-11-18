<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ActionRegister extends Auth_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->output->set_template('default');
        $this->load->model('actionregister_model');
        $this->load->model('templates_model');
    }

    function index(){
        $data = array('dataSet'=>json_encode($this->actionregister_model->getAR()));
        $this->load->view('actionregister/index_view', $data);
    }

    function request($key){
        $this->load->library('form_builder');
        $this->load->library('form_validation');
        if($this->form_validation->run()===FALSE)
        {
            $data = array('dataSet'=>$this->actionregister_model->getRequest($key));
            $this->load->view('actionregister/actionregister_view', $data);
        }
        else
        {

        }
    }
}