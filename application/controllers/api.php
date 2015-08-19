<?php
class Api extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->library('auth_lib');
    }

    public function index()
    {
        echo 'Hello World!';
    }

    public function user_login()
    {
        $result = array('status'=>0);
        if ($this->input->post('username') && $this->input->post('password')) {
            $username = $this->input->post('username');
            $passwd = $this->input->post('password');
            $this->auth_lib->init_lib('users', 'user_login', 'user_passwd', 'user');
            if ($this->auth_lib->login($username, $passwd)) {
                $result['status'] = 1;
            }
        }
        echo json_encode($result);

    }

    public function repairer_login()
    {


    }
}