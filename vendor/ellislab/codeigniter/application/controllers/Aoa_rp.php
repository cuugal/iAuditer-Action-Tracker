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
        unset($_SESSION['ar_message']);
        $data = array('dataSet' => $this->aoa_rp_model->getRlns());
        $this->load->view('aoa_rp/index_view', $data);

    }

    public function newAoa(){
        $this->load->library('form_builder');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('aoa', 'Area of Accountability','trim|required|callback_check_exists');
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
            $_SESSION['ar_message'] = 'Responsible Person - Area of Accountability has been created';
            $this->session->mark_as_flash('ar_message');

            $data = Array('users'=>$this->aoa_rp_model->getUsers(),
                'aoaunallocated'=>$this->aoa_rp_model->getAoa());
            $this->load->view('aoa_rp/new_view', $data);
        }

    }

    function check_exists() {
        $aoa = $this->input->post('aoa');// get fiest name
        $rp = $this->input->post('rp');// get last name
        $this->db->select('id');
        $this->db->from('aoa_rp');
        $this->db->where('aoa', $aoa);
        $this->db->where('rp', $rp);
        $query = $this->db->get();
        $num = $query->num_rows();
        if ($num > 0) {
            $this->form_validation->set_message('check_exists', 'This Responsible Person already exists for this Area');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function remove($id){
        $this->aoa_rp_model->remove($id);
        $data = array('dataSet' => $this->aoa_rp_model->getRlns());
        $_SESSION['ar_message'] = 'Responsible Person has been removed from this Area';
        $this->session->mark_as_flash('ar_message');
        redirect('aoa_rp');
    }

}