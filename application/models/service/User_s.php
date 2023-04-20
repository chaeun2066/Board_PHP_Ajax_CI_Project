<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_s extends CI_Model {

    function __construct() 
    {
        parent::__construct();
     
        $this->load->model('/dao/User_m');
    }

    public function checkUser($user)
    {
        $result = $this->User_m->checkUser($user);

        if(!$result){
            return false;
        }

        // == 1일 때, $result->row(0)로 넘어와 패스워드 검색 진행
        // password hash 말고 다른 방법 찾아보기 SHA-256
        $password_hash = $result->password;

        // if(!password_verify($user['password'], $password_hash)){ 
        //     return false;
        // }

        if((hash("SHA256",$user['password']) !== $password_hash)){ 
            return false;
        }

        $session_data = array( 
            'userid' => $result->userid,
            'email' => $result->email
        );

        $this->session->set_userdata($session_data);
 
        return $result;
    }

    public function insert($user) : Bool
    {
        $password_hash = hash("SHA256", $user['password']); 
        
        $result   = $this->User_m->checkUser($user);
        
        if($result){
            return false;
        }
        
        $row = array( 
            "userid" => $user['userid'],
            "password" => $password_hash,
            "email" => $user['email'],
        );
        
        $result = $this->User_m->insert($row);
       
        return $result;
    }
}