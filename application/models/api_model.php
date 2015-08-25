<?php
    class Api_model extends  CI_Model {

        function __construct()
        {
            parent::__construct();
            $this->load->database();
        }

        public function add_report($insert_data)
        {
            return $this->db->insert('report',$insert_data);
        }

}