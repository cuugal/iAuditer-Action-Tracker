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
        if($this->ion_auth->is_admin()){
            $data = array('dataSet'=>$this->actionregister_model->getAR());
        }
        else {
            $data = array('dataSet'=>$this->actionregister_model->getAR($this->ion_auth->get_user_id()));
        }
        $this->load->view('actionregister/index_view', $data);
    }

    function request($key){
        $this->load->library('form_builder');
        $this->load->library('form_validation');

        $dataSet = $this->actionregister_model->getRequest($key);
        $isAccountable = $this->actionregister_model->isAccountableUser($dataSet['area_of_accountability'],
            $this->ion_auth->get_user_id());

        //$this->form_validation->set_rules('proposed_action', 'Proposed Action','trim|required');
        $this->form_validation->set_rules('action_required', 'Action Required','trim|required');
        $this->form_validation->set_rules('reviewed_action', 'Reviewed Action','trim|required');
        $this->form_validation->set_rules('residual_risk', 'Residual Risk', 'trim|required');
        if($isAccountable) {
            $this->form_validation->set_rules('action_status', 'Action Status', 'trim|required');
            $this->form_validation->set_rules('completion_date', 'Completion Date', 'trim|required');
        }

        if($this->form_validation->run()===FALSE)
        {

            $data = array('dataSet'=>$dataSet, 'isAccountable'=>$isAccountable);
            $this->load->view('actionregister/actionregister_view', $data);
        }
        else
        {
            $record = array(
                'proposed_action' => $this->input->post('proposed_action'),
                'action_required' => $this->input->post('action_required'),
                'reviewed_action' => $this->input->post('reviewed_action'),
                'residual_risk' => $this->input->post('residual_risk'),
                'action_status' => $this->input->post('action_status'),
                'completion_date' => $this->input->post('completion_date'),
                'key'=>$this->input->post('key'),
            );
            $this->actionregister_model->update($record);
            $_SESSION['ar_message'] = 'The Action Register has been updated';
            $this->session->mark_as_flash('ar_message');

            $dataSet = $this->actionregister_model->getRequest($key);
            $data = array('dataSet'=>$dataSet, 'isAccountable'=>$isAccountable);
            $this->load->view('actionregister/actionregister_view', $data);
        }
    }
}