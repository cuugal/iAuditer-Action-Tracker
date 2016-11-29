<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Location extends Auth_Controller
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

    public function newLoc(){
        $this->load->library('form_builder');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('name', 'Name','trim|required|is_unique[area_of_accountability.name]');
        $this->form_validation->set_rules('area_of_accountability', 'Area of Accountability','trim|required');


        if($this->form_validation->run()===FALSE)
        {
            $data = Array('aoa'=>$this->location_model->getAoa());
            $this->load->view('location/new_view', $data);
        }
        else
        {
            $record = array(
                'name' => $this->input->post('name'),
                'area_of_accountability' => $this->input->post('area_of_accountability'),
            );
            $this->location_model->insert($record);
            $_SESSION['ln_message'] = 'The Location has been created';
            $this->session->mark_as_flash('ln_message');

            $data = Array('aoa'=>$this->location_model->getAoa());
            $this->load->view('location/new_view', $data);
        }

    }
    public function editLoc($id){
        $this->load->library('form_builder');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('name', 'Name','trim|required|is_unique[area_of_accountability.name]');
        $this->form_validation->set_rules('area_of_accountability', 'Area of Accountability','trim|required');


        if($this->form_validation->run()===FALSE)
        {

            $data = Array('aoa'=>$this->location_model->getAoa(),'i'=>$this->location_model->getRecord($id));
            $this->load->view('location/edit_view', $data);
        }
        else
        {
            $record = array(
                'id' =>$this->input->post('id'),
                'name' => $this->input->post('name'),
                'area_of_accountability' => $this->input->post('area_of_accountability'),
            );
            $this->location_model->update($record);
            $_SESSION['ln_message'] = 'The Location has been updated';
            $this->session->mark_as_flash('ln_message');

            $data = Array('aoa'=>$this->location_model->getAoa(),'i'=>$this->location_model->getRecord($id));
            $this->load->view('location/edit_view', $data);
        }

    }

}
