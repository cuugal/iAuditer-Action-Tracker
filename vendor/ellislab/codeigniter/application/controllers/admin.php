<?php
class Admin extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->library(array('ion_auth'));

        if (!$this->ion_auth->logged_in()) {
            redirect('/auth', 'refresh');
        }
    }

    public function index()
    {
        echo 'Hello World!';
    }
}

