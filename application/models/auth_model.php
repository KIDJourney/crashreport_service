<?php
    class Auth_model extends CI_Model {

        private $db_name;
        private $login_key;
        private $passwd_key;

        function __construct()
        {
            parent::__construct();
            $this->load->database();
        }

        function init_model($db_name , $login_key , $passwd_key)
        {
            $this->db_name = $db_name;
            $this->login_key = $login_key;
            $this->passwd_key = $passwd_key;
        }

        function get_passwd($login_name)
        {
            $result = $this->db->get_where($this->db_name,
                array("$this->login_key"=>$login_name))->result();
            $passwd_key = $this->passwd_key;
            return $result?$result[0]->$passwd_key:false;
        }


    }