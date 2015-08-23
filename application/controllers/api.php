<?php
class Api extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->library('auth_lib');
        $this->load->library('session');
        $this->load->model('api_model');
        $this->output->set_content_type('application/json');
    }

    public function index()
    {
        print_r(array('a'=>array('b'=>'c','c'=>'d')));
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
        }  else {
            $result['error'] =
        }
        $this->output->set_output(json_encode($result));
    }

    public function create_report()
    {
        $result = array('status'=>0);
        if (!$this->auth_lib->check_login()){
            $result['status'] = 0;
            $result['error'] = "You have to login";
            $this->output->set_output(json_encode($result));
        } else {
            $required = array('report_post',
                'report_info',
                'report_type',
                'report_status');
            $avaliable = True;
            foreach ($required as $key){
                if (!$this->input->post($key)){
                    $avaliable = False;
                } else {
                    $required[$key] = $this-input->post($key);
                }
            }
            if ($avaliable){
                $required['report_reporter'] = $this->auth_lib->check_login();
                
            }

        }
    }

    public function repairer_login()
    {
        $result = array('status'=>0);
        if ($this->input->post('username') && $this->input->post('password')){
            $username = $this->input->post('username');
            $passwd = $this->input->post('password');
            $this->auth_lib->init_lib('repairer','repairer_login','repairer_passwd','repairer');
            if ($this->auth_lib->login($username, $passwd)) {
                $result['status'] = 1;
            }
        }
        $this->output->set_output(json_encode($result));
    }

}