<?php

class Manage extends CI_Controller {

    private $username ;
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
        } else {
            $this->username = $this->session->userdata('username');
        }
    }

    public function index()
    {
        $username = $this->username;
        $recent_report = $this->manage_model->get_recent_report();
        $report_count = $this->manage_model->get_report_count();

        $this->load->view('manage/dashboard', array('username'     => $username,
                                                    "reports"      => $recent_report,
                                                    "report_count" => $report_count));
    }

    public function report()
    {
        $reports = $this->manage_model->get_report();
        $this->load->view('manage/report',array('username'=>$this->username,
                                                'reports'=>$reports));
    }

    public function repairer()
    {
        $repairers = $this->manage_model->get_repairer();
        $this->load->view('manage/repairer',array('username'=>$this->username,'repairers'=>$repairers));
    }

    public function user()
    {
        $users = $this->manage_model->get_user();
        $this->load->view('manage/user',array('username'=>$this->username , 'users' => $users));
    }

    public function position()
    {
        $positions = $this->manage_model->get_position();
        $this->load->view('manage/position',array('username'=>$this->username,'positions'=>$positions));
    }

    public function type()
    {
        $types = $this->manage_model->get_type();
        $this->load->view('manage/type',array('username'=>$this->username,'types'=>$types));
    }

    public function analyze()
    {
        $this->load->view('manage/analyze',array('username'=>$this->username));
    }

    public function predict()
    {
        $this->load->view('manage/predict',array('username'=>$this->username));
    }

    public function summary()
    {
        $this->load->view('manage/summary',array('username'=>$this->username));
    }

    public function login()
    {
        if (!($this->input->post('username') && $this->input->post('password'))) {
            $this->load->view('manage/login');
            return;
        }

        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $this->auth_lib->init_lib('manager', 'manager_login', 'manager_passwd', 'manager');
        if ($this->auth_lib->login($username, $password)) {
            $this->session->set_userdata(array('username' => $username));
            redirect(base_url('manage'));
        } else {
            $this->load->view('manage/login', array('error' => 'true'));
        }
    }

    public function edit($type,$id)
    {
        $accept_type = array('report','repairer','user');

        if(!isset($type) or !isset($id) or !is_numeric($id)
                         or !in_array($type,$accept_type)){
            $this->jump_back();
            return;
        }

        print_r($this->manage_model->get_field_data($type));


    }


    public function logoff()
    {
        $this->auth_lib->logoff();
        redirect('manage/login');
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

    public function debug()
    {
        print_r($this->manage_model->get_report_count());
    }

    private function jump_back()
    {
        echo <<<JS
        <script language="javascript" type="text/javascript">
            window.history.back(-1);
        </script>
JS;
    }

}