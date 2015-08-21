<?php
class Debug extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->library('session');
    }

    function checksession(){
        print_r($this->session->all_userdata());
    }

    function setsession($value){
        $this->session->set_userdata($value);
    }
}
