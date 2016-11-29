<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Location extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->output->set_template('default');
        $this->load->model('location_model');

    }

    public function index()
    {
        $data = array('dataSet' => $this->location_model->getAllLocation());
        $this->load->view('location/index_view', $data);
    }
}
