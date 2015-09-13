<?php
class Manage_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function  get_recent_report()
    {
        $this->db->order_by("report_createat desc");
        $this->db->where('report_status',0);
        return $this->db->get('report',10,0)->result();
    }
    //SELECT report.id, report.report_pos, report.report_type, report.report_info, report.report_picurl, users.user_nickname AS report_reporter
    //FROM report
    //LEFT JOIN users
    //on report.report_reporter = users.id

}