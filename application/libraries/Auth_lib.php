<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 *  Class for authentication
 *
 * */
class Auth_lib {
    private $ci ;
    private $session_name;
    private $passwd_key;
    function __construct()
    {
        $this->ci = & get_instance();
        $this->ci->load->library('session');
        $this->ci->load->model('auth_model');
    }

    function init_lib($db_name,$login_key,$passwd_key,$session_name)
    {
        $this->ci->auth_model->init_model($db_name,$login_key);
        $this->session_name = $session_name;
        $this->passwd_key = $passwd_key;
    }

    /*
     * check if the account in database and set session
     *
     * @param string string
     * @return boolean
     * */
    public function login($username , $passwd)
    {
        if ($this->check_login()){
            $this->logoff();
        }
        $user_data = $this->ci->auth_model->get_user($username);
        $passwd_key = $this->passwd_key;
        if ($user_data && $user_data->$passwd_key == $passwd){
            $this->set_session($user_data);
            return $user_data;
        } else {
            return false;
        }
    }
    /*
     * set session function
     *
     * @param string
     * @return NULL
     * */
    private function set_session($user_data)
    {
        $passwd2type = array('user_passwd'=>'user','repairer_passwd'=>'repairer','manager_passwd'=>'manager');
        $session_data = array('suid'=>$user_data->id,'type'=>$passwd2type[$this->passwd_key]);
        return $this->ci->session->set_userdata($session_data);
    }

    /*
     * return the login status
     *
     * @param NULL
     * @return Boolean
     * */
    public function check_login()
    {
        return $this->ci->session->userdata('suid');
    }

    public function check_type()
    {
        return $this->ci->session->userdata('type');
    }

    public function check_suid()
    {
        return $this->ci->session->userdata('suid');
    }

    /*
     * destroy the session
     *
     * @param NULL
     * @return NULL
     * */
    public function logoff()
    {
        return $this->ci->session->sess_destroy();
    }

    public function debug()
    {
        return $this->session_name;
    }
}