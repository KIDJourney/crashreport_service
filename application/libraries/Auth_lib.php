<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 *  Class for authentication
 *
 * */
class Auth_lib {
    private $ci ;
    private $session_name;
    private $loaded_model;
    function __construct()
    {
        $this->ci = & get_instance();
        $this->ci->load->library('session');
        $this->ci->load->model('auth_model');
    }

    function init_lib($db_name,$login_key,$passwd_key,$session_name)
    {
        $this->ci->auth_model->init_model($db_name,$login_key,$passwd_key);
        $this->session_name = $session_name;
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
            return true;
        }
        $real_passwd = $this->ci->auth_model->get_passwd($username);
        if ($real_passwd && $real_passwd == $passwd ){
            $this->set_session($username);
            return true;
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
    private function set_session($username)
    {
        return $this->ci->session->set_userdata(array($this->session_name=>$username));
    }

    /*
     * return the login status
     *
     * @param NULL
     * @return Boolean
     * */
    public function check_login()
    {
        return $this->ci->session->userdata($this->session_name) or false;
    }

    public function get_username()
    {
        if (!$this->check_login()){
            return False;
        } else {
            return $this->ci->session->userdata($this->session_name);
        }
    }

    /*
     * destroy the session
     *
     * @param NULL
     * @return NULL
     * */
    public function logoff()
    {
        $this->ci->session->sess_destroy();
    }

    public function debug()
    {
        return $this->session_name;
    }
}