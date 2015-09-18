<?php

class Manage_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function  get_recent_report()
    {
        $sql = <<<SQL
    select r.id , p.pos_name as report_pos , t.type_name as report_type , r.report_info , r.report_picurl , u.user_nickname as report_reporter
    FROM report r
    LEFT JOIN position p
    ON r.report_pos = p.id
    LEFT JOIN report_type t
    ON r.report_type = t.id
    LEFT JOIN users u
    ON r.report_reporter = u.id
    where r.report_status = 0
SQL;
        $query = $this->db->query($sql);
        return $query ? $query->result() : false;
    }

    public function get_report_count()
    {
        $time = 24 * 60 * 60;

        $report        = $this->db->query("SELECT COUNT(*) as num FROM report where
            (report.report_status = 0 and (current_timestamp() - report.report_createat < $time))")->result();
        $report_accept = $this->db->query("SELECT COUNT(*) as num FROM report where
            (report.report_status = 1 and (current_timestamp() - report.report_createat < $time))")->result();
        $report_finish = $this->db->query("SELECT COUNT(*) as num FROM report where
            (report.report_status = 2 and (current_timestamp() - report.report_createat < $time))")->result();
        $report_all    = $this->db->count_all('report');
        return array("report"=>$report[0]->num , "report_accept" =>$report_accept[0]->num , "report_finish" => $report_finish[0]->num , "report_all"=>$report_all);
    }

    public function get_report()
    {
        $sql = <<<SQL
        select r.id , p.pos_name as report_pos , r.report_status ,  t.type_name as report_type , r.report_info , r.report_picurl , u.user_nickname as report_reporter
        FROM report r
        LEFT JOIN position p
        ON r.report_pos = p.id
        LEFT JOIN report_type t
        ON r.report_type = t.id
        LEFT JOIN users u
        ON r.report_reporter = u.id
SQL;
        $query = $this->db->query($sql);
        return $query?$query->result():false;
    }

    public function get_repairer()
    {
        return $this->db->get('repairer')->result();
    }

    public function get_user()
    {
        return $this->db->get('users')->result();
    }

    public function get_position()
    {
        return $this->db->get('position')->result();
    }

    public function get_type()
    {
        return $this->db->get('report_type')->result();
    }

    public function check_report($id)
    {
        return $this->db->get_where('report', array('id'=>$id))->result();
    }

    public function check_user($id)
    {
        return $this->db->get_where('user', array('id'=>$id))->result();
    }

    public function check_repairer($id)
    {
        return $this->db->get_where('repairer', array('id'=>$id))->result();
    }

    public function get_field_data($table_name)
    {
        return $this->db->list_fields($table_name);
    }
}