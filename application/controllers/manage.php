<?php

class Manage extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->library('auth_lib');
        $this->load->library('session');
        $this->load->model('manage_model');
        $this->load->helper('url');

        if (!$this->check_access()) {
            if (current_url() != base_url('manage/login')) {
                redirect(base_url('manage/login'));
            }
        }

    }

    public function index()
    {
        echo "This is index";
    }

    public function login()
    {
        if (!($this->input->post('username') && $this->input->post('password'))) {
            $this->load->view('manage/login');
        }

        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $this->auth_lib->init_lib('manager', 'manager_login', 'manager_passwd', 'manager');
        if ($this->auth_lib->login($username, $password)){
            redirect(base_url('manage'));
        } else {
            $this->load->view('manage/login',array('error'=>'true'));
        }

    }


    private function check_access()
    {
        $session_type = $this->auth_lib->check_type();
        if ($session_type && $session_type == 'manager') {
            return True;
        } else {
            return False;
        }
    }


}