<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Auth_Controller {

    function __construct()
    {
        parent::__construct();
        $this->output->set_template('default');

        $this->load->js('assets/themes/default/js/jquery-1.9.1.min.js');
        $this->load->js('assets/themes/default/hero_files/bootstrap-transition.js');
        $this->load->js('assets/themes/default/hero_files/bootstrap-collapse.js');
    }

    public function index()
    {
        //$this->load->section('sidebar', 'ci_simplicity/sidebar');
        $this->load->view('dashboard/index_view');
    }
}