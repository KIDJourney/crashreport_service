<?php

class Api_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function add_report($insert_data)
    {
        return $this->db->insert('report', $insert_data);
    }

    public function list_report($page = 1)
    {
        if ($page <= 0)
            $page = 1;
        return $this->db->get('report', $page * 10, ($page - 1) * 10)->result();
    }

    public function add_user($user_data)
    {
        return $this->db->insert('users', $user_data);
    }

    public function check_report($report_id)
    {
        $query_result = $this->db->get_where('report', array('id' => $report_id))->result();
        return $query_result[0];

    }

    public function accept_report($repairer_id, $report_id)
    {
        $report_info = $this->check_report($report_id);
        if ($report_info->report_status != 0) {
            return false;
        } else {
            $timestamp = new DateTime();
            $data = array(
                'report_status'   => '1',
                'report_fixerid'  => $repairer_id,
                'report_acceptat' => $timestamp->format('Y-m-d H:i:s')
            );
            $this->db->where('id', $report_id);
            return $this->db->updata($data);
        }
    }

    public function finish_report($repairer_id , $report_id)
    {
        $report_info = $this->check_report($report_id);
        if ($report_info->report_status != 1 or $report_info->fixerid != $repairer_id) {
            return false;
        } else {
            $timestamp = new DateTime();
            $data = array(
                'report_status' => '2',
                'report_endat' => $timestamp->format('Y-m-d H:i:s')
            );
            $this->db->where('id',$report_id);
            $this->db->updata($data);
        }
    }
}