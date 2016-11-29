<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aoa_rp extends Auth_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->output->set_template('default');
        $this->load->model('aoa_rp_model');
    }

    function index()
    {
        $data = array('dataSet' => $this->aoa_rp_model->getRlns());
        $this->load->view('aoa_rp/index_view', $data);
    }

    public function newAoa(){
        $this->load->library('form_builder');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('aoa', 'Area of Accountability','trim|required|is_unique[area_of_accountability.name]');
        $this->form_validation->set_rules('rp', 'Responsible Person','trim|required');


        if($this->form_validation->run()===FALSE)
        {
            $data = Array('users'=>$this->aoa_rp_model->getUsers(),
                'aoaunallocated'=>$this->aoa_rp_model->getAoa());
            $this->load->view('aoa_rp/new_view', $data);
        }
        else
        {
            $record = array(
                'rp' => $this->input->post('rp'),
                'aoa' => $this->input->post('aoa'),
            );
            $this->aoa_rp_model->insert($record);
            $_SESSION['ar_message'] = 'The Area of Accountability has been created';
            $this->session->mark_as_flash('ar_message');

            $data = Array('users'=>$this->aoa_rp_model->getUsers(),
                'aoaunallocated'=>$this->aoa_rp_model->getAoa());
            $this->load->view('aoa_rp/new_view', $data);
        }

    }

}