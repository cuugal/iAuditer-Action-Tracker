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
        $this->load->model('media_model');
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

        //Let Admin always edit, otherwise check user to see if they are accountable for this area
        $isAccountable = $this->ion_auth->is_admin();
        if(!$isAccountable) {
            $isAccountable = $this->actionregister_model->isAccountableUser($dataSet['area_of_accountability'],
                $this->ion_auth->get_user_id());
        }

        $isOpen = true;
        if($dataSet['action_status'] == 'Closed'){
            $isOpen = false;
        }


        if($isOpen) {

            $this->form_validation->set_rules('action_required', 'Action Required', 'trim|required');
            $this->form_validation->set_rules('reviewed_action', 'Reviewed Action', 'trim|required');
            $this->form_validation->set_rules('residual_risk', 'Residual Risk', 'trim|required');
            if ($isAccountable) {
                $this->form_validation->set_rules('action_status', 'Action Status', 'trim|required');
                $this->form_validation->set_rules('completion_date', 'Completion Date', 'trim|required');
            }
        }
        else{
            if ($isAccountable) {
                $this->form_validation->set_rules('action_status', 'Action Status', 'trim|required');
            }
        }

        if($this->form_validation->run()===FALSE)
        {
            $media = $this->media_model->getForAR($key);

            $data = array('dataSet'=>$dataSet, 'isAccountable'=>$isAccountable, 'isOpen'=>$isOpen, 'media'=>$media);
            $this->load->view('actionregister/actionregister_view', $data);
        }
        else
        {

            $record = $this->input->post();
            unset($record['submit']);


            $this->actionregister_model->update($record);
            $_SESSION['ar_message'] = 'The Action Register has been updated';
            $this->session->mark_as_flash('ar_message');

            $dataSet = $this->actionregister_model->getRequest($key);
            $isOpen = true;
            if($dataSet['action_status'] == 'Closed'){
                $isOpen = false;
            }

            $media = $this->media_model->getForAR($key);
            $data = array('dataSet'=>$dataSet, 'isAccountable'=>$isAccountable, 'isOpen'=>$isOpen, 'media'=>$media);
            $this->load->view('actionregister/actionregister_view', $data);
        }
    }
}