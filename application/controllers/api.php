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

    public function user_login()
    {

        $result = array('status'=>"failed");
        if ($this->input->post('username') && $this->input->post('password')) {
            $username = $this->input->post('username');
            $passwd = $this->input->post('password');
            $this->auth_lib->init_lib('users', 'user_login', 'user_passwd', 'user');
            if ($this->auth_lib->login($username, $passwd)) {
                $result['status'] = "succeed" ;
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

    public function create_report()
    {
        $result = array('status' => "failed");
        if (!$this->auth_lib->check_login()) {
            $result['status'] = "failed";
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
                    echo "$key not found";
                    $avaliable = False;
                } else {
                    $required[$key] = $this->input->post($key);
                }
            }
            if (!$avaliable) {
                $result['status'] = "failed";
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
                    $result['status'] = "failed";
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
                        $result['status'] = 'failed';
                        $result['error'] = "databases error";
                        $this->output->set_output(json_encode($result));
                    }


                }

            }
        }
    }

    public function repairer_login()
    {
        $result = array('status'=>"failed");
        if ($this->input->post('username') && $this->input->post('password')){
            $username = $this->input->post('username');
            $passwd = $this->input->post('password');
            $this->auth_lib->init_lib('repairer','repairer_login','repairer_passwd','repairer');
            if ($this->auth_lib->login($username, $passwd)) {
                $result['status'] = "succeed";
            }
        }
        $this->output->set_output(json_encode($result));
    }

}