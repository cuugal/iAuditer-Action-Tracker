<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller  {

    function __construct()
    {
        parent::__construct();
        $this->output->set_template('default');
        $this->load->model('areaofaccountability_model');
        $this->load->model('aoa_rp_model');
    }

    public function index()
    {
        if($this->ion_auth->is_admin()===FALSE)
        {
            redirect('/');
        }

        $data = array('dataSet'=>$this->ion_auth->getUsers());
        //echo json_encode($data);
        foreach($data['dataSet'] as &$d){
            $aoa = $this->areaofaccountability_model->getAOAforUser($d['user_id']);
            $concat = implode($aoa,'; ');
            $d['aoa'] = $concat;
        }
        foreach($data['dataSet'] as &$d){
            $aoa = $this->aoa_rp_model->getRPforUser($d['user_id']);
            $concat = implode($aoa,'; ');
            $d['rp'] = $concat;
        }
        $this->load->view('user/index_view', $data);
    }

    public function profile(){

        $data['aoa'] = $this->areaofaccountability_model->getAOAforUser($this->ion_auth->get_user_id());
        $data['rp'] =  $this->aoa_rp_model->getRPforUser($this->ion_auth->get_user_id());

        $this->load->view('user/profile_view', $data);
    }

    public function changepassword($userid){
        if($this->ion_auth->is_admin()===FALSE)
        {
            redirect('/');
        }

        $this->load->library('form_builder');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('password','Password','trim|min_length[8]|max_length[20]|required');
        $this->form_validation->set_rules('confirm_password','Confirm password','trim|matches[password]|required');
        if($this->form_validation->run()===FALSE)
        {
            unset($_SESSION['edit_message']);
            $groups = $this->ion_auth->listGroups();
            $data = array('dataSet'=>$this->ion_auth->getUser($userid),
                'groups'=>$groups);
            $this->load->view('user/edit_view', $data);
        }
        else
        {
            unset($_SESSION['edit_message']);
            $id = $this->input->post('id');

            $dataSet['password'] = $this->input->post('password');

            $this->load->library('ion_auth');
            if($this->ion_auth->update($id,$dataSet))
            {
                $_SESSION['edit_message'] = 'Password has been updated.';
            }
            else
            {
                $_SESSION['edit_message'] = $this->ion_auth->errors();
            }

            $groups = $this->ion_auth->listGroups();

            $dataSet['user_id'] = $id;
            $data = array('dataSet'=>$this->ion_auth->getUser($id),
                'groups'=>$groups);
            $this->load->view('user/edit_view', $data);
        }
    }

    public function edit($userid)
    {
        if($this->ion_auth->is_admin()===FALSE)
        {
            redirect('/');
        }

        $this->load->library('form_builder');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('first_name', 'First name','trim|required');
        $this->form_validation->set_rules('last_name', 'Last name','trim|required');
        $this->form_validation->set_rules('iAuditor_Name','iAuditor Name','trim|required');
        $this->form_validation->set_rules('email','Email','trim|valid_email|required');
        $this->form_validation->set_rules('group', 'Group','trim|required');

        if($this->form_validation->run()===FALSE)
        {
            unset($_SESSION['edit_message']);
            $this->load->helper('form');
            $data = array('dataSet'=>$this->ion_auth->getUser($userid),
                'groups'=>$this->ion_auth->listGroups());
            $this->load->view('user/edit_view', $data);
        }
        else
        {
            unset($_SESSION['edit_message']);
            $id = $this->input->post('id');

            $dataSet['first_name'] = $this->input->post('first_name');
            $dataSet['last_name'] = $this->input->post('last_name');
            $dataSet['iAuditor_Name'] = $this->input->post('iAuditor_Name');
            $dataSet['email'] = $this->input->post('email');
            $dataSet['group'] = $this->input->post('group');

            $this->load->library('ion_auth');
            if($this->ion_auth->update($id,$dataSet))
            {
                $_SESSION['edit_message'] = 'User has been updated.';
            }
            else
            {
                $_SESSION['edit_message'] = $this->ion_auth->errors();
            }
            //fix up groups
            $groups = $this->ion_auth->listGroups();

            $ids = array_keys($groups);


            $this->ion_auth->remove_from_group(false, $id);
            $this->ion_auth->add_to_group($this->input->post('group'), $id);

            $dataSet['user_id'] = $id;
            $data = array('dataSet'=>$this->ion_auth->getUser($userid),
                'groups'=>$groups);
            $this->load->view('user/edit_view', $data);
        }


    }

    public function delete_user($userid){
            $this->ion_auth->delete_user($userid);
            $_SESSION['ar_message'] = 'User has been deleted';
            $this->session->mark_as_flash('ar_message');
            redirect('User');

    }

    public function register()
    {
        if($this->ion_auth->is_admin()===FALSE)
        {
            redirect('/');
        }
        $this->load->library('form_builder');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('first_name', 'First name','trim|required');
        $this->form_validation->set_rules('last_name', 'Last name','trim|required');
        $this->form_validation->set_rules('iAuditor_Name','iAuditor Name','trim|required');
        $this->form_validation->set_rules('email','Email','trim|valid_email|required|is_unique[users.email]');
        $this->form_validation->set_rules('password','Password','trim|min_length[8]|max_length[20]|required');
        $this->form_validation->set_rules('confirm_password','Confirm password','trim|matches[password]|required');

        if($this->form_validation->run()===FALSE)
        {
            $this->load->helper('form');
            $this->load->view('user/register_view');
        }
        else
        {
            $first_name = $this->input->post('first_name');
            $last_name = $this->input->post('last_name');
            $iAuditor_Name = $this->input->post('iAuditor_Name');
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            $additional_data = array(
                'first_name' => $first_name,
                'last_name' => $last_name,
                'active'=>true,
                'iAuditor_Name' => $iAuditor_Name
            );

            $this->load->library('ion_auth');
            $group = array('2');
            $userid = $this->ion_auth->register($email,$password,$email,$additional_data, $group);
            if($userid)
            {


                $_SESSION['register_message'] = 'The user: '.$first_name.' '.$last_name .' has been created.';
                $this->session->mark_as_flash('register_message');

                //redirect('user/edit/'.$userid);
                $this->load->view('user/register_view');
            }
            else
            {
                $_SESSION['register_message'] = $this->ion_auth->errors();
                $this->session->mark_as_flash('register_message');
                redirect('user/register');
            }
        }
    }



    public function login()
    {
        $this->load->library('form_builder');
        $this->data['title'] = "Login";

        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        if ($this->form_validation->run() === FALSE)
        {
            $this->load->helper('form');
            $this->load->view('user/login_view');
            //$this->render('user/login_view');
        }
        else
        {
            $remember = (bool) $this->input->post('remember');
            if ($this->ion_auth->login($this->input->post('email'), $this->input->post('password'), $remember))
            {
                redirect('dashboard');
            }
            else
            {
                $_SESSION['auth_message'] = $this->ion_auth->errors();
                $this->session->mark_as_flash('auth_message');
                redirect('user/login');
            }
        }
    }

    public function logout()
    {
        $this->ion_auth->logout();
        redirect('user/login');
    }
}