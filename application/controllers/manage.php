<?php

class Manage extends CI_Controller {

    private $username;

    function __construct()
    {
        parent::__construct();
        $this->load->library('auth_lib');
        $this->load->library('session');
        $this->load->model('manage_model');
        $this->load->helper('url');

        if (!$this->check_access()) {
            if (current_url() != base_url('manage/login')) {
                redirect(base_url('manage/login'));
            }
        } else {
            $this->username = $this->session->userdata('username');
        }
    }

    public function index()
    {
        $username = $this->username;
        $recent_report = $this->manage_model->get_recent_report();
        $report_count = $this->manage_model->get_report_count();

        $this->load->view('manage/dashboard', array('username' => $username,
            "reports" => $recent_report,
            "report_count" => $report_count));
    }

    public function report()
    {
        $reports = $this->manage_model->get_report();
        $this->load->view('manage/report', array('username' => $this->username,
            'reports' => $reports));
    }

    public function repairer()
    {
        $repairers = $this->manage_model->get_repairer();
        $this->load->view('manage/repairer', array('username' => $this->username, 'repairers' => $repairers));
    }

    public function user()
    {
        $users = $this->manage_model->get_user();
        $this->load->view('manage/user', array('username' => $this->username, 'users' => $users));
    }

    public function position()
    {
        $positions = $this->manage_model->get_position();
        $this->load->view('manage/position', array('username' => $this->username, 'positions' => $positions));
    }

    public function type()
    {
        $types = $this->manage_model->get_type();
        $this->load->view('manage/type', array('username' => $this->username, 'types' => $types));
    }

    public function analyze()
    {
        $timechartdata = json_encode($this->manage_model->get_chart_time());
        $typechartdata = json_encode($this->manage_model->get_chart_type());
        $poschartdata = json_encode($this->manage_model->get_chart_pos());
        $this->load->view('manage/analyze', array('username' => $this->username,
            'timechartdata' => $timechartdata,
            'typechartdata' => $typechartdata,
            'poschartdata' => $poschartdata));
    }

    public function predict()
    {
        $this->load->view('manage/predict', array('username' => $this->username));
    }

    public function summary()
    {
        $this->load->view('manage/summary', array('username' => $this->username));
    }

    public function login()
    {
        if (!($this->input->post('username') && $this->input->post('password'))) {
            $this->load->view('manage/login');
            return;
        }

        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $this->auth_lib->init_lib('manager', 'manager_login', 'manager_passwd', 'manager');
        if ($this->auth_lib->login($username, $password)) {
            $this->session->set_userdata(array('username' => $username));
            redirect(base_url('manage'));
        } else {
            $this->load->view('manage/login', array('error' => 'true'));
        }
    }

    public function edit($type, $id)
    {
        $accept_type = array('report', 'repairer', 'user', 'position', 'type');
        $active_class = $this->active_list($type);
        if (!isset($type) or !isset($id) or !is_numeric($id)
            or !in_array($type, $accept_type)
        ) {
            $this->jump_back();
            return;
        }

        $active_class[$type] = 'class="active"';

        if ($post_data = $this->input->post()) {
            if ($type == 'report') {
                $result = $this->manage_model->update($type, $id, $post_data) ? '更新成功' : '更新失败，请检查你的输入';
                $report_type = $this->manage_model->get_type();
                $position = $this->manage_model->get_position();
                $data = $this->manage_model->check_type($type, $id);
                $data = $data[0];
                $this->load->view('manage/edit', array('username' => $this->username, 'active_class' => $active_class));
                $this->load->view('manage/form/report', array('types' => $report_type, 'positions' => $position, 'data' => $data,
                    'report_status' => array("$data->report_status" => 'checked'),
                    'info' => $result));
            } else {
                $this->edit_post_handler($type, $id, $post_data, $active_class);
                return;
            }
        }

        if ($type == 'report') {
            $report_type = $this->manage_model->get_type();
            $position = $this->manage_model->get_position();
            $data = $this->manage_model->check_report($id);
            $data = $data[0];
            $this->load->view('manage/edit', array('username' => $this->username, 'active_class' => $active_class));
            $this->load->view('manage/form/report', array('types' => $report_type, 'positions' => $position, 'data' => $data,
                'report_status' => array("$data->report_status" => 'checked')));
        } else {
            $this->edit_load_form($type, $id, $active_class);
        }
    }

    public function create($type)
    {
        $accept_type = array('position','repairer','type');
        if (!in_array($type,$accept_type)){
            $this->jump_back();
            return ;
        }
        $active_class = $this->active_list($type);
        if ($this->input->post()) {
            if ($this->manage_model->insert_type($type, $this->input->post())) {
                $this->load->view('manage/edit', array('username' => $this->username, 'active_class' => $active_class));
                $this->load->view('manage/create/' . $type, array('info' => "添加成功"));
            } else {
                $this->load->view('manage/edit', array('username' => $this->username, 'active_class' => $active_class));
                $this->load->view('manage/create/' . $type, array('info' => "添加失败"));
            }
            return;
        }

        $this->load->view('manage/edit', array('username' => $this->username, 'active_class' => $active_class));
        $this->load->view('manage/create/' . $type);
    }

    public function delete($type,$id)
    {
        $accept_type = array('user','repairer','report');
        if (!in_array($type,$accept_type)){
            $this->jump_back();
            return;
        }
        if ($this->manage_model->delete_type($type,$id)){
            redirect('manage/'.$type);
        }
    }

    public function logoff()
    {
        $this->auth_lib->logoff();
        redirect('manage/login');
    }

    private function check_access()
    {
        $session_type = $this->auth_lib->check_type();
        if ($session_type && $session_type == 'manager') {
            return True;
        } else {
            return False;
        }
    }

    public function debug()
    {
        $this->output->set_output(json_encode($this->manage_model->get_chart_time()));
    }

    private function edit_load_form($type, $id, $active_class)
    {
        $data = $this->manage_model->check_type($type, $id);
        $data = $data[0];
        $this->load->view('manage/edit', array('username' => $this->username, 'active_class' => $active_class));
        $this->load->view('manage/form/' . $type, array('data' => $data));
    }

    private function edit_post_handler($type, $id, $post_data, $active_class)
    {
        $result = $this->manage_model->update($type, $id, $post_data) ? '更新成功' : '更新失败，请检查你的输入';
        $data = $this->manage_model->check_type($type, $id);
        $data = $data[0];
        $this->load->view('manage/edit', array('username' => $this->username, 'active_class' => $active_class));
        $this->load->view('manage/form/' . $type, array('data' => $data, 'info' => $result));
    }


    private function jump_back()
    {
        echo <<<JS
        <script language="javascript" type="text/javascript">
            window.history.back(-1);
        </script>
JS;
    }

    /**
     * @param $type
     * @return array
     */
    private function active_list($type)
    {
        $all_type = array('report', 'repairer', 'user', 'position', 'type');
        $active_class = array();
        foreach ($all_type as $key)
            $active_class[$key] = "";
        $active_class[$type] = 'class="active"';
        return $active_class;
    }

}