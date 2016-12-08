<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProposedAction extends Auth_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->output->set_template('default');
        $this->load->model('proposed_action_model');
        $this->load->model('issues_model');
    }

    public function index()
    {
        $data = array('dataSet' => $this->proposed_action_model->getAll());
        $this->load->view('proposed_action/index_view', $data);
    }

    public function newAction(){
        $this->load->library('form_builder');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('proposed_action', 'Proposed Action','trim|required|is_unique[proposed_action.proposed_action]');



        if($this->form_validation->run()===FALSE)
        {

            $this->load->view('proposed_action/new_view');
        }
        else
        {
            $record = array(
                'proposed_action' => $this->input->post('proposed_action'),
            );
            $this->proposed_action_model->insert($record);
            $_SESSION['pa_message'] = 'The Proposed Action has been created';
            $this->session->mark_as_flash('pa_message');


            $this->load->view('proposed_action/new_view');
        }

    }

    public function editAction($id){
        $this->load->library('form_builder');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('proposed_action', 'Proposed Action','trim|required');

        if($this->form_validation->run()===FALSE)
        {

            $data = Array('pa'=>$this->proposed_action_model->getRecord($id),'issues'=>$this->issues_model->getForProposedAction($id));
            $this->load->view('proposed_action/edit_view', $data);
        }
        else
        {
            $record = array(
                'id' =>$this->input->post('id'),
                'proposed_action' => $this->input->post('proposed_action'),
            );
            $this->proposed_action_model->update($record);
            $_SESSION['pa_message'] = 'The Location has been updated';
            $this->session->mark_as_flash('pa_message');

            $data = Array('pa'=>$this->proposed_action_model->getRecord($id),'issues'=>$this->issues_model->getForProposedAction($id));
            $this->load->view('proposed_action/edit_view', $data);
        }

    }



}