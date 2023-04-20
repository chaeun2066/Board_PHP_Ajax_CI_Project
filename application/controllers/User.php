<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    function __construct() 
    {
        parent::__construct();
     
        $this->load->model('service/User_s');
    }

	public function login()
    {
        $this->load->view('/user/login');
	}   

	public function logout()
    {
        $this->session->sess_destroy();

        redirect('/board');
	}

    public function login_correct()
    {
        $this->form_validation->set_rules('userid', '아이디', 'trim|htmlspecialchars|required');
        $this->form_validation->set_rules('password', '비밀번호', 'trim|htmlspecialchars|required');

        if($this->form_validation->run() == FALSE){
            echo "<script>
                    alert('에러를 확인해주세요')
                  </script>";
            exit;
        }

        $user = $this->input->post(array('userid', 'password'), TRUE);
        
        $result = $this->User_s->checkUser($user);
        
        echo json_encode($result);
    }

    public function regist()
    {
        $this->load->view('/user/regist');
    }

    public function ax_insert()
    {
        $this->form_validation->set_rules('userid', '아이디', 'trim|htmlspecialchars|required');
        $this->form_validation->set_rules('password', '비밀번호', 'trim|htmlspecialchars|required');
        $this->form_validation->set_rules('password_check', '비밀번호 확인', 'trim|htmlspecialchars|required|matches[password]');
        $this->form_validation->set_rules('email', '이메일', 'trim|htmlspecialchars|required|valid_email');

        if($this->form_validation->run() == FALSE){
            echo "<script>
                    alert('가입 실패');
                    history.back();
                  </script>";
            exit;
        }

        $user = $this->input->post(array('userid', 'password','password_check', 'email'), TRUE);

        $result = $this->User_s->insert($user);
   
        echo json_encode($result);
    }
}