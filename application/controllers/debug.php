<?php
class Debug extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->library('session');
    }

    function index()
    {
        print_r($this->session->all_userdata());
    }

    function checksession()
    {
        echo $this->session->userdata('suid');
        echo "<br>";
        echo $this->session->userdata('type');
    }

    function setsession($value){
        $this->session->set_userdata($value);
    }

    function save_file(){


    }
}
