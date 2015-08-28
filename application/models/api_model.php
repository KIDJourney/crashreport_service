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

        public function list_report($page)
        {
            if ($page <= 0)
                $page = 1;
            return $this->db->get('report',$page*10 , ($page - 1) * 10);
        }

}