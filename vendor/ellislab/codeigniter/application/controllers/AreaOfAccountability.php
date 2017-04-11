<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AreaOfAccountability extends Auth_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->output->set_template('default');
        $this->load->model('areaofaccountability_model');

    }
    public function index()
    {
        $data = array('dataSet'=>$this->areaofaccountability_model->getAllAOA());
        $this->load->view('areaofaccountability/index_view', $data);
    }

    public function newAoa()
    {
        $this->load->library('form_builder');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('name', 'Name','trim|required|is_unique[area_of_accountability.name]');
        $this->form_validation->set_rules('accountable_person', 'Accountable Person','trim|required');

        if($this->form_validation->run()===FALSE)
        {
            $data = Array('users'=>$this->areaofaccountability_model->getUsers());
            $this->load->view('areaofaccountability/new_view', $data);
        }
        else
        {
            $record = array(
                'name' => $this->input->post('name'),
                'accountable_person' => $this->input->post('accountable_person'),
            );
            $this->areaofaccountability_model->insert($record);
            $_SESSION['aa_message'] = 'The Area of Accountability has been created';
            $this->session->mark_as_flash('aa_message');

            $data = Array('users'=>$this->areaofaccountability_model->getUsers());
            $this->load->view('areaofaccountability/new_view', $data);
        }

    }

    public function assignAoa(){
        $this->load->library('form_builder');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('name', 'Name','trim|required|is_unique[area_of_accountability.name]');
        $this->form_validation->set_rules('accountable_person', 'Accountable Person','trim|required');


        if($this->form_validation->run()===FALSE)
        {
            $data = Array('users'=>$this->areaofaccountability_model->getUsers(),
                'aoaunallocated'=>$this->areaofaccountability_model->unallocatedAOA());
            $this->load->view('areaofaccountability/new_assign_view', $data);
        }
        else
        {
            $record = array(
                'name' => $this->input->post('name'),
                'accountable_person' => $this->input->post('accountable_person'),
            );
            $this->areaofaccountability_model->insert($record);
            $_SESSION['aa_message'] = 'The Area of Accountability has been created';
            $this->session->mark_as_flash('aa_message');

            $data = Array('users'=>$this->areaofaccountability_model->getUsers(),
                'aoaunallocated'=>$this->areaofaccountability_model->unallocatedAOA());
            $this->load->view('areaofaccountability/new_assign_view', $data);
        }

    }

    public function editAssignAoa($id){
        $this->load->library('form_builder');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('name', 'Name','trim|required');
        $this->form_validation->set_rules('accountable_person', 'Accountable Person','trim|required');


        if($this->form_validation->run()===FALSE)
        {

            $data = Array('users'=>$this->areaofaccountability_model->getUsers(),
                'i'=>$this->areaofaccountability_model->getRecord($id));
            $this->load->view('areaofaccountability/edit_assign_view', $data);
        }
        else
        {
            $record = array(
                'id'=> $this->input->post('id'),
                'name' => $this->input->post('name'),
                'accountable_person' => $this->input->post('accountable_person'),
            );
            $this->areaofaccountability_model->update($record);
            $_SESSION['aa_message'] = 'The Area of Accountability has been updated';
            $this->session->mark_as_flash('aa_message');

            $data = Array('users'=>$this->areaofaccountability_model->getUsers(),'i'=>$this->areaofaccountability_model->getRecord($id));

            $this->load->view('areaofaccountability/edit_assign_view', $data);
        }

    }
}