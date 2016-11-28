<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller  {

    function __construct()
    {
        parent::__construct();

        $this->output->set_template('default');

    }



    public function index()
    {
        $data = array('dataSet'=>$this->ion_auth->getUsers());
        $this->load->view('user/index_view', $data);
    }

    public function edit($userid)
    {
        $this->load->library('form_builder');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('first_name', 'First name','trim|required');
        $this->form_validation->set_rules('last_name', 'Last name','trim|required');
        $this->form_validation->set_rules('username','Username','trim|required');
        $this->form_validation->set_rules('email','Email','trim|valid_email|required');

        if($this->form_validation->run()===FALSE)
        {
            unset($_SESSION['edit_message']);
            $this->load->helper('form');
            $data = array('dataSet'=>$this->ion_auth->getUser($userid));
            $this->load->view('user/edit_view', $data);
        }
        else
        {
            $id = $this->input->post('id');

            $dataSet['first_name'] = $this->input->post('first_name');
            $dataSet['last_name'] = $this->input->post('last_name');
            $dataSet['username'] = $this->input->post('username');
            $dataSet['email'] = $this->input->post('email');




            $this->load->library('ion_auth');
            if($this->ion_auth->update($id,$dataSet))
            {
                $_SESSION['edit_message'] = 'User has been updated.';
            }
            else
            {
                $_SESSION['edit_message'] = $this->ion_auth->errors();
            }
            $dataSet['user_id'] = $id;
            $data = array('dataSet'=>$dataSet);
            $this->load->view('user/edit_view', $data);
        }


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
        $this->form_validation->set_rules('username','Username','trim|required|is_unique[users.username]');
        $this->form_validation->set_rules('email','Email','trim|valid_email|required');
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
            $username = $this->input->post('username');
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            $additional_data = array(
                'first_name' => $first_name,
                'last_name' => $last_name
            );

            $this->load->library('ion_auth');
            if($this->ion_auth->register($username,$password,$email,$additional_data))
            {
                $_SESSION['auth_message'] = 'The account has been created. You may now login.';
                $this->session->mark_as_flash('auth_message');
                //redirect('user/login');
            }
            else
            {
                $_SESSION['auth_message'] = $this->ion_auth->errors();
                $this->session->mark_as_flash('auth_message');
                redirect('user/register');
            }
        }
    }



    public function login()
    {
        $this->load->library('form_builder');
        $this->data['title'] = "Login";

        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
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
            if ($this->ion_auth->login($this->input->post('username'), $this->input->post('password'), $remember))
            {
                redirect('inspection');
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