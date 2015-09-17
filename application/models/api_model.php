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

    public function list_report()
    {
        $sql = <<<SQL
                select r.id , p.pos_name as report_pos , r.report_status ,
        t.type_name as report_type , r.report_info , re.repairer_name as report_fixerid,
        r.report_picurl , u.user_nickname as report_reporter , r.report_createat ,
        r.report_acceptat , r.report_endat , c.comment_content
        FROM report r
        LEFT JOIN position p
        ON r.report_pos = p.id
        LEFT JOIN report_type t
        ON r.report_type = t.id
        LEFT JOIN users u
        ON r.report_reporter = u.id
        LEFT JOIN repairer re
        ON r.report_fixerid = re.id
        LEFT JOIN comment c
        ON r.id = c.comment_report_id
SQL;
        $query_result = $this->report_url_fixer($this->db->query($sql)->result());
        return $query_result;
    }

    public function add_user($user_data)
    {
        return $this->db->insert('users', $user_data);
    }

    public function check_report($report_id)
    {
        $sql = <<<SQL
        select r.id , p.pos_name as report_pos , r.report_status ,  t.type_name as report_type ,
        r.report_info , r.report_picurl , u.user_nickname as report_reporter , c.comment_content
        FROM report r
        LEFT JOIN position p
        ON r.report_pos = p.id
        LEFT JOIN report_type t
        ON r.report_type = t.id
        LEFT JOIN users u
        ON r.report_reporter = u.id
        LEFT JOIN comment c
        ON r.id = c.comment_report_id
SQL;

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

        $sql = <<<SQL
                select r.id , p.pos_name as report_pos , r.report_status ,
        t.type_name as report_type , r.report_info , re.repairer_name as report_fixerid,
        r.report_picurl , u.user_nickname as report_reporter , r.report_createat ,
        r.report_acceptat , r.report_endat , c.comment_content
        FROM report r
        LEFT JOIN position p
        ON r.report_pos = p.id
        LEFT JOIN report_type t
        ON r.report_type = t.id
        LEFT JOIN users u
        ON r.report_reporter = u.id
        LEFT JOIN repairer re
        ON r.report_fixerid = re.id
        LEFT JOIN comment c
        ON r.id = c.comment_report_id
        where r.id = $user_id
SQL;
        $query_result = $this->report_url_fixer($this->db->query($sql)->result());
        return $query_result;
    }

    public function list_repairer_report($repairer_id)
    {
        $sql = <<<SQL
        select r.id , p.pos_name as report_pos , r.report_status ,
        t.type_name as report_type , r.report_info , re.repairer_name as report_fixerid,
        r.report_picurl , u.user_nickname as report_reporter , r.report_createat ,
        r.report_acceptat , r.report_endat , c.comment_content
        FROM report r
        LEFT JOIN position p
        ON r.report_pos = p.id
        LEFT JOIN report_type t
        ON r.report_type = t.id
        LEFT JOIN users u
        ON r.report_reporter = u.id
        LEFT JOIN repairer re
        ON r.report_fixerid = re.id
        LEFT JOIN comment c
        ON r.id = c.comment_report_id
        where r.report_fixerid = $repairer_id
SQL;
        $query_result = $this->report_url_fixer($this->db->query($sql)->result());
        return $query_result;
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
        $sql = <<<SQL
                select r.id , p.pos_name as report_pos , r.report_status ,
        t.type_name as report_type , r.report_info , re.repairer_name as report_fixerid,
        r.report_picurl , u.user_nickname as report_reporter , r.report_createat ,
        r.report_acceptat , r.report_endat , c.comment_content
        FROM report r
        LEFT JOIN position p
        ON r.report_pos = p.id
        LEFT JOIN report_type t
        ON r.report_type = t.id
        LEFT JOIN users u
        ON r.report_reporter = u.id
        LEFT JOIN repairer re
        ON r.report_fixerid = re.id
        LEFT JOIN comment c
        ON r.id = c.comment_report_id
        where r.report_status = '0'
SQL;
        $query_result = $this->report_url_fixer($this->db->query($sql)->result());
        return $query_result;
    }

    public function check_user($id)
    {
        return $this->db->get_where('users',array('id'=>$id))->result();
    }

    public function check_repairer($id)
    {
        return $this->db->get_where('repairer',array('id'=>$id))->result();
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