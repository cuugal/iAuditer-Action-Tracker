<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Issue extends Auth_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->output->set_template('default');
        $this->load->model('issue_model');
        $this->load->model('proposed_action_model');
    }

    public function index()
    {
        $data = array('dataSet' => $this->issue_model->getAll());
        $this->load->view('issue/index_view', $data);
    }

    public function editIssue($id){
        $this->load->library('form_builder');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('proposed_action', 'Proposed Action','trim|required');

        if($this->form_validation->run()===FALSE)
        {

            $data = Array('issue'=>$this->issue_model->getRecord($id),'actions'=>$this->proposed_action_model->getAllActions());
            $this->load->view('issue/edit_view', $data);
        }
        else
        {
            $record = array(
                'id' =>$this->input->post('id'),

                'proposed_action' => $this->input->post('proposed_action'),
            );
            $this->issue_model->update($record);
            $_SESSION['is_message'] = 'The Issue has been updated';
            $this->session->mark_as_flash('is_message');

            $data = Array('issue'=>$this->issue_model->getRecord($id),'actions'=>$this->proposed_action_model->getAllActions());
            $this->load->view('issue/edit_view', $data);
        }
    }
}