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

    function loadEmail(){
        $this->output->unset_template();
        $data = array('InspectionID' => '1234',
            'InspectionType'=>'3456',
            'HazardID'=>'4567',
            'DateIdentified' => '12/12/2015',
            'InspectorName' => 'John Smith',
            'AoA' => 'Area',
            'Issue' => 'Electrical cables need to be inspected and tagged by a qualified technician',
            'Location' => 'Location',
            'Deficiencies'=>'20',
            'TotalItems'=>'25'
            );
        $this->load->view('emails/item_assigned', $data);
    }

    function index(){

        $data = array('outstanding'=>$this->task_model->getForUser($this->ion_auth->get_user_id(), 'Open'),
            'completed'=>$this->task_model->getForUser($this->ion_auth->get_user_id(), 'Closed'));

        $this->load->view('dashboard/index_view', $data);


    }


}