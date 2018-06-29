<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends Auth_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->output->set_template('default');
        $this->load->model('actionregister_model');
        $this->load->model('templates_model');
        $this->load->model('reports_model');
    }

    function index($from=null, $to=null)
    {
        if($from == null && $to == null){
            $dates = $this->reports_model->getMinMaxDates();
            $from = $dates['start'];
            $to = $dates['end'];
        }
        $results['data'] = $this->reports_model->getManagerReportData($from, $to);
        $results['start'] = $from;
        $results['end'] = $to;
        $this->load->view('reports/management_view', $results);

    }
}