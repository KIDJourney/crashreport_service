<?php

class Manage extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->library('auth_lib');
        $this->load->library('session');
        $this->load->model('manage_model');
        $this->load->helper('url');

        $this->auth_lib->init_lib('manager','manager_login','manager_login','manager');

        if (!$this->check_access()){
            if (current_url() != base_url('manage/login')){
                redirect(base_url('manage/login'));
            }
        }

    }

    public function index()
    {


    }

    public function login()
    {

    }


    private function check_access()
    {
        $session_type = $this->auth_lib->check_type();
        if ($session_type && $session_type == 'manager'){
            return True;
        } else {
            return False;
        }
    }


}