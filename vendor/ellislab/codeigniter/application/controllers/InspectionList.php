<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class InspectionList extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->output->set_template('default');
        $this->load->model('audits_model');
    }

    public function index()
    {
        //$this->load->section('sidebar', 'ci_simplicity/sidebar');
        $data = array('dataSet'=>json_encode($this->audits_model->getAudits()));
        $this->load->view('inspectionlist/index_view', $data);
    }
}