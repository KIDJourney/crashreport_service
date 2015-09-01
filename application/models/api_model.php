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

        public function list_report($page=1)
        {
            if ($page <= 0)
                $page = 1;
            return $this->db->get('report',$page*10 , ($page - 1) * 10);
        }

        public function add_user($user_data)
        {
            return $this->db->insert('users',$user_data);
        }

        public function check_report($report_id)
        {
            return $this->db->get_where('report',array('id'=>$report_id));            
        }

}