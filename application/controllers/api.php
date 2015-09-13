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
        die("No access right");
    }

    public function repairer_login()
    {
        $result = array('status' => "0");
        if ($this->input->post('username') && $this->input->post('password')) {
            $username = $this->input->post('username');
            $passwd = $this->input->post('password');
            $this->auth_lib->init_lib('repairer', 'repairer_login', 'repairer_passwd', 'repairer');
            if ($info = $this->auth_lib->login($username, $passwd)) {
                $result['status'] = "1";
                $result['info'] = $info;
            }
        } else {
            $result['error'] = "username or password incorrect";
        }
        $this->output->set_output(json_encode($result));
    }


    public function user_login()
    {

        $result = array('status' => "0");
        if ($this->input->post('username') && $this->input->post('password')) {
            $username = $this->input->post('username');
            $passwd = $this->input->post('password');
            $this->auth_lib->init_lib('users', 'user_login', 'user_passwd', 'user');
            if ($info = $this->auth_lib->login($username, $passwd)) {
                $result['status'] = "1";
                $result['info'] = $info;
            } else {
                $result['error'] = "username or password incorrect";
            }
        }
        $this->output->set_output(json_encode($result));
    }


    public function logoff()
    {
//        if($this->auth_lib->logoff()){
//            $this->output->set_output(json_encode(array('status'=>'1')));
//        } else {
//            $this->error_message("You have not logged in");
//        }
        $this->auth_lib->logoff();
        $this->output->set_output(json_encode(array('status' => '1')));
    }

    public function user_register()
    {
        $result = array('status' => '0');
        $required = array(
            'user_login',
            'user_passwd',
            'user_nickname',
            'user_tel');
        $user_data = array();
        $flag = 1;
        foreach ($required as $key) {
            if (!$this->input->post($key)) {
                $flag = 0;
                break;
            } else {
                $user_data[$key] = $this->input->post($key);
            }
        }
        if (!$flag) {
            $this->error_message("Some argument is missed");
            return;
        }

        if (!preg_match('/^[A-za-z0-9]{5,31}/', $user_data['user_login'])) {
            $this->error_message("user name illegal");
            return;
        }
        if (!preg_match('/^[0-9]{11}/', $user_data['user_tel'])) {
            $this->error_message("user tel illegal");
            return;
        }

        $this->api_model->add_user($user_data);
        if ($this->db->_error_message()) {
            $result['status'] = 0;
            $result['error'] = $this->db->_error_message();
            $this->output->set_output(json_encode($result));
        } else {
            $result['status'] = 1;
            $this->output->set_output(json_encode($result));
        }

    }


    public function create_report()
    {
        $result = array('status' => "0");
        if (!$this->auth_lib->check_login()) {
            $this->error_message("You have to login");
            return;
        }

        $upload_config = array(
            'upload_path'   => 'picture',
            'encrypt_name'  => true,
            'allowed_types' => 'jpg|png',
        );

        $this->load->library('upload', $upload_config);

        $required = array(
            'report_pos'  => '',
            'report_info' => '',
            'report_type' => '',
        );

        $avaliable = True;

        foreach ($required as $key => $value) {
            if (!$this->input->post($key)) {
                $avaliable = False;
            } else {
                $required[$key] = $this->input->post($key);
            }
        }
        if (!$avaliable) {
            $this->error_message("You have missed some arguments");
            return;
        }

        if (!$this->upload->do_upload('picture')) {
            $this->error_message($this->upload->display_errors());
            return;

        }

        $file_data = $this->upload->data();
        $file_name = $file_data['file_name'];

        $required['report_picurl'] = $file_name;
        $required['report_reporter'] = $this->auth_lib->check_login();

        if ($this->api_model->add_report($required)) {
            $result['status'] = '1';
            $this->output->set_output(json_encode($result));
        } else {
            $this->error_message("databases error");
        }
    }

    public function list_report($page = 1)
    {
        if (isset($report_id) && !is_numeric($report_id)) {
            $this->error_message("You have no access right");
            return;
        }

        if (!is_numeric($page)) {
            $this->error_message("incorrect page number");
        } else {
            $report_list = ($this->api_model->list_report($page));
            $this->output->set_output(json_encode($report_list));
        }
    }


    public function list_my_report()
    {
        if (!$this->check_login()) {
            $this->error_message("You haven't logged in");
        } else {
            $suid = $this->check_login();
            $reports = $this->api_model->list_user_report($suid);
            $this->output->set_output(json_encode($reports));
        }
    }

    public function list_repairer_accept()
    {
        if (!$this->check_access('repairer')) {
            $this->output->set_output(json_encode(array('status' => '0', 'error' => 'You have not logged in')));
        } else {
            $suid = $this->check_login();
            $reports = $this->api_model->list_repairer_report($suid);
            $this->output->set_output(json_encode($reports));
        }
    }


    public function check_report($report_id)
    {
        if (isset($report_id) && !is_numeric($report_id)) {
            $this->error_message("incorrect page argument");
        } else {
            $report_info = $this->api_model->check_report($report_id);
            $this->output->set_output(json_encode($report_info));
        }
    }

    public function accept_report($report_id)
    {
        if (!isset($report_id) or !is_numeric($report_id)) {
            $this->error_message("argument error");
            return;
        }
        if (!$this->check_access('repairer')) {
            $this->error_message("You don't have access");
        }

        $repairer_id = $this->auth_lib->check_suid();
        $report_info = $this->api_model->check_report($report_id);
        if (!$report_info) {
            $this->error_message("report doesn't exist");
            return;
        }

        if ($report_info->report_status != 0) {
            $this->error_message("report can't be accepted");
            return;
        }

        if ($this->api_model->accept_report($repairer_id, $report_id)) {
            $this->output->set_output(json_encode(array('status' => '1')));
        } else {
            $this->error_message('Databases error');
        }
    }

    public function finish_report($report_id)
    {
        if (!$this->check_access('repairer')) {
            $this->error_message("You don't have access");
        }

        $repairer_id = $this->auth_lib->check_suid();
        $report_info = $this->api_model->check_report($report_id);

        if (!$report_info){
            $this->error_message('report not exist');
            return ;
        }

        if ($report_info->report_status != 1){
            $this->error_message("report can't be finished");
            return ;
        }

        if ($report_info->report_fixerid != $repairer_id ){
            $this->error_message("report do not belong to you");
            return ;
        }

        if ($this->api_model->finish_report($repairer_id, $report_id)) {
            $this->output->set_output(json_encode(array('status' => '1')));
        } else {
            $this->error_message("Databases error , please try later");
        }

    }


    public function add_comment()
    {
        if (!$this->check_access('user')) {
            $this->error_message("You don't have access");
            return;
        }

        $required = array('report_id' => '', 'comment_content' => '');
        $flag = 1;
        foreach ($required as $key => $value) {
            if ($this->input->post($key)) {
                $required[$key] = $this->input->post($key);
            } else {
                $flag = 0;
                break;
            }
        }
        if ($flag) {

            $report_info = $this->api_model->check_report($required['report_id']);

            if ($report_info->report_status != 2){
                $this->error_message("The report haven't been finished");
                return ;
            }

            if ($report_info->report_reporter != $this->check_login()){
                $this->error_message("You are not the submitter of the report");
                return ;
            }

            if ($report_info->report_comment != 0){
                $this->error_message("You have submitted a comment to this report");
                return ;
            }

            if ($this->api_model->add_comment($this->check_login(),
                $required['report_id'], $required['comment_content'])
            ) {
                $this->output->set_output(json_encode(array('status' => '1')));
            } else {
                $this->error_message("Databases Error");
            }
        }
    }

    public function debug()
    {
        //pass
    }


    private function check_login()
    {
        return $this->auth_lib->check_login();
    }

    /**
     *
     * Logged in and is $access : True
     *
     *
     * @return mixed
     */
    private function check_access($access)
    {
        $access_level = array('user', 'repairer');

        if (!in_array($access, $access_level)) {
            return False;
        }

        $session_check = $this->auth_lib->check_type();

        return ($session_check && $session_check == $access);

    }

    private function error_message($error)
    {
        $this->output->set_output(json_encode(array('status' => '0', 'error' => $error)));
    }
}