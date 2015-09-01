<?php
class Api extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->library('auth_lib');
        $this->load->library('session');
        $this->load->model('api_model');
        $this->output->set_content_type('application/json');
    }

    public function index()
    {
        die("No access right");
    }

    public function repairer_login()
    {
        $result = array('status'=>"0");
        if ($this->input->post('username') && $this->input->post('password')){
            $username = $this->input->post('username');
            $passwd = $this->input->post('password');
            $this->auth_lib->init_lib('repairer','repairer_login','repairer_passwd','repairer');
            if ($this->auth_lib->login($username, $passwd)) {
                $result['status'] = "1";
            }
        }
        $this->output->set_output(json_encode($result));
    }


    public function user_login()
    {

        $result = array('status'=>"0");
        if ($this->input->post('username') && $this->input->post('password')) {
            $username = $this->input->post('username');
            $passwd = $this->input->post('password');
            $this->auth_lib->init_lib('users', 'user_login', 'user_passwd', 'user');
            if ($this->auth_lib->login($username, $passwd)) {
                $result['status'] = "1" ;
            }
        }  else {
            $result['error'] = "username or password incorrect";
//            echo <<<EOF
//<html>
//<head>
//<title>Upload Form</title>
//</head>
//<body>
//<form action="http://crashreport.sinaapp.com/api/user_login" method="post">
//    <input type="text" name="username" >
//    <input type="text" name="password" >
//    <input type="submit">
//</form>
//</body>
//</html>
//EOF;
        }
        $this->output->set_output(json_encode($result));
    }


    public function user_register()
    {
        $result = array('status'=>'0');
        $required = array(
            'user_login',
            'user_passwd',
            'user_nickname',
            'user_tel');
        $user_data = array();
        $flag = 1;
        foreach ($required as $key){
            if (!$this->input->post($key)){
                $flag = 0;
                break;
            } else {
                $user_data[$key] = $this->input->post($key);
            }
        }
        if (!$flag){
            $result['error'] = "Some argument is missed";
            $this->output->set_output(json_encode($result));
        } else {
            if (!preg_match('/^[A-Za-z][A-za-z0-9]{5,31}&/' , $user_data['user_login'])){
                $result['status'] = 0;
                $result['error'] = "user name illegal";
                $this->output->set_output(json_encode($result));
            } else {
                $this->api_model->add_user($user_data);
                if ($this->db->_error_message()){
                    $result['status'] = 0 ;
                    $result['error'] = $this->db->_error_message();
                    $this->output->set_output(json_encode($result));
                } else {
                    $result['status'] = 1;
                    $this->output->set_output(json_encode($result));
                }
            }
        }
    }


    public function create_report()
    {
        $result = array('status' => "0");
        if (!$this->auth_lib->check_login()) {
            $result['status'] = "0";
            $result['error'] = "You have to login";
            $this->output->set_output(json_encode($result));
        } else {
            $upload_config = array(
                'upload_path' => 'picture',
                'encrypt_name' => true,
                'allowed_types' => 'jpg',
            );

            $this->load->library('upload', $upload_config);

            $required = array(
                'report_pos' => '',
                'report_info' => '',
                'report_type' => '',
            );
            $avaliable = True;
            foreach ($required as $key => $value) {
                if (!$this->input->post($key)) {
                    $avaliable = False;
                } else {
                    $required[$key] = $this->input->post($key);
                }
            }
            if (!$avaliable) {
                $result['status'] = "0";
                $result['error'] = "You have missed some arguments";
                $this->output->set_output(json_encode($result));
//                echo <<<EOF
//                <html>
//                <body>
//                    <form action="http://crashreport.sinaapp.com/api/create_report" method="post" accept-charset="utf-8" enctype="multipart/form-data">
//                        <input type="file" name="picture" size="20"><br>
//                        <input type="text" name="report_pos"><br>
//                        <input type="text" name="report_info"><br>
//                        <input type="text" name="report_type"><br>
//                        <input type="submit" value="upload">
//                    </form>
//                </body>
//                </form>
//EOF;
            } else {

                $file_name = "";

                if (!$this->upload->do_upload('picture')) {
                    $result['status'] = "0";
                    $result['error'] = $this->upload->display_errors();
                    echo $this->upload->display_errors();
                    $this->output->set_output(json_encode($result));
                } else {
                    $file_data = $this->upload->data();
                    $file_name = $file_data['file_name'];

                    $required['report_picurl'] = $file_name;
                    $required['report_reporter'] = $this->auth_lib->check_login();

                    if ($this->api_model->add_report($required)){
                        $result['status'] = 'success';
                        $this->output->set_output(json_encode($result));
                    } else {
                        $result['status'] = '0';
                        $result['error'] = "databases error";
                        $this->output->set_output(json_encode($result));
                    }


                }

            }
        }
    }

    public function list_report($page)
    {
        $session_check = $this->auth_lib->check_type();
        if (!($session_check && $session_check != 'user')) {
            $this->output->set_output(json_encode(array('status' => '0', 'error' => 'You have no access right')));
        } else {
            if (!is_numeric($page)) {
                $this->output->set_output(json_encode(array('status' => '0', 'error' => 'incorrect page argument')));
            } else {
                $report_list = ($this->api_model->list_report($page)->result());
                $this->output->set_output(json_encode($report_list));
            }
        }

    }

    public function check_report($report_id)
    {
        if (isset($report_id) && !is_numeric($report_id)){
            $this->output->set_output(json_encode(array('status'=>'0','error'=>'incorrect page argument')));
        } else {
            $report_info = $this->api_model->check_report($report_id)
            $this->output->set_output(json_encode($report_info));
        }       
    }
}