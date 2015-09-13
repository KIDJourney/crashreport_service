<?php
class Debug extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->library('session');
        $this->load->helper(array('url','form'));
    }

    function index()
    {
        print_r($this->session->all_userdata());
    }

    function checksession()
    {
        echo json_encode($this->session->userdata);
    }

    function setsession($value)
    {
        $this->session->set_userdata($value);
    }

    function save_file()
    {
        $config['upload_path'] = 'picture';
        $config['encrypt_name'] = true;
        $config['allowed_types'] = 'jpg';

        $this->load->library('upload' , $config);

        if (!$this->upload->do_upload()){
            print_r($this->upload->display_errors());
            echo <<<EOF
<html>
<head>
<title>Upload Form</title>
</head>
<body>
EOF;
            echo form_open_multipart('debug/save_file');
            echo <<<EOF
<input type="file" name="userfile" size="20" />
<br /><br />
<input type="submit" value="upload" />
</form>
</body>
</html>
EOF;
        } else {
            print_r($this->upload->data());

            echo "Upload Success";
        }

    }
}
