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
        $result = array('status'=>"failed");
        if ($this->input->post('username') && $this->input->post('password')) {
            $username = $this->input->post('username');
            $passwd = $this->input->post('password');
            $this->auth_lib->init_lib('users', 'user_login', 'user_passwd', 'user');
            if ($this->auth_lib->login($username, $passwd)) {
                $result['status'] = "succeed" ;
            }
        }  else {
            $result['error'] = "username or password incorrect";
        }
        $this->output->set_output(json_encode($result));
    }

    public function create_report()
    {
        $result = array('status'=>"failed");
        if (!$this->auth_lib->check_login()){
            $result['status'] = "failed";
            $result['error'] = "You have to login";
            $this->output->set_output(json_encode($result));
            die();
        }

        $upload_config = array(
            'upload_path' => 'picture' ,
            'encrypt_name' => true ,
            'allowed_type' => 'jpg|png'
        );

        $this->load->library('upload' , $upload_config);

        $required = array(
            'report_pos'=>'',
            'report_info'=>'',
            'report_type'=>'',
        );
        $avaliable = True;
        foreach ($required as $key){
            if (!$this->input->post($key)){
                $avaliable = False;
            } else {
                $required[$key] = $this->input->post($key);
            }
        }
        if (!$avaliable){
            $result['status'] = "failed";
            $result['error'] = "You have miss some arguments";
            $this->output->set_output(json_encode($result));
            die();
        }

        $file_name = "";

        if (!$this->upload->do_upload('picture')){
            $result['status'] = "failed";
            $result['error'] = $this->upload->display_errors();
            $this->set_output(json_encode($result));
            die();
        } else {
            $file_data = $this->upload->data();
            $file_name = $file_data['file_name'];
        }

        $required['report_picurl'] = $file_name;
        $required['report_reporter'] = $this->auth_lib->check_login();

        $this->ouput->set_output(json_encode($required));

    }

    public function repairer_login()
    {
        $result = array('status'=>"failed");
        if ($this->input->post('username') && $this->input->post('password')){
            $username = $this->input->post('username');
            $passwd = $this->input->post('password');
            $this->auth_lib->init_lib('repairer','repairer_login','repairer_passwd','repairer');
            if ($this->auth_lib->login($username, $passwd)) {
                $result['status'] = "succeed";
            }
        }
        $this->output->set_output(json_encode($result));
    }

}