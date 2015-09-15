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
        return $this->report_url_fixer($this->db->get('report', $page * 10, ($page - 1) * 10)->result());
    }

    public function add_user($user_data)
    {
        return $this->db->insert('users', $user_data);
    }

    public function check_report($report_id)
    {
        $query_result = $this->report_url_fixer($this->db->get_where('report', array('id' => $report_id))->result());
        return $query_result ? $query_result[0] : false;
    }

    public function list_position()
    {
        return $this->db->get('position')->result();
    }

    public function list_type()
    {
        return $this->db->get('report_type')->result();
    }


    public function accept_report($repairer_id, $report_id)
    {
        $timestamp = new DateTime();
        $data = array(
            'report_status'   => '1',
            'report_fixerid'  => $repairer_id,
            'report_acceptat' => $timestamp->format('Y-m-d H:i:s')
        );

        $this->db->where('id', $report_id);
        return $this->db->update('report', $data);
    }

    public function finish_report($repairer_id, $report_id)
    {
        $timestamp = new DateTime();
        $data = array(
            'report_status' => '2',
            'report_endat'  => $timestamp->format('Y-m-d H:i:s')
        );
        $this->db->where('id', $report_id);
        return $this->db->update('report', $data);
    }

    public function list_user_report($user_id)
    {
        return $this->report_url_fixer($this->db->get_where('report', array('report_reporter' => $user_id))->result());
    }

    public function list_repairer_report($repairer_id)
    {
        return $this->report_url_fixer($this->db->get_where('report', array('repairer_fixerid' => $repairer_id))->result());
    }

    public function add_comment($reporter_id, $report_id, $comment_content)
    {
        $insert_body = array('comment_report_id'   => $report_id,
                             'comment_reporter_id' => $reporter_id,
                             'comment_content'     => $comment_content);
        return $this->db->insert('comment', $insert_body);
    }

    public function list_unaccpet()
    {
        return $this->report_url_fixer($this->db->get_where('report',array('report_status'=>'0'))->result());
    }

    private function report_url_fixer($report_list)
    {
        $url_prefix = "http://crashreport-picture.stor.sinaapp.com/";
        foreach ($report_list as $report) {
            $report->report_picurl = $url_prefix . $report->report_picurl;
        }
        return $report_list;
    }

}