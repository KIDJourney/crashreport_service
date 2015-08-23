<?php
    class Api_model extends  CI_Model {

        function __construct()
        {
            parent::__construct();
            $this->load->database();
        }

        public function add_report($insert_data)
        {
            $this->db->insert('report',$insert_data);
        }

}