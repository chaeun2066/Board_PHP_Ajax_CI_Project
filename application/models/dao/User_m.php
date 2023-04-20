<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_m extends CI_Model{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    public function checkUser($user)
    { 
        $result = $this->db->get_where('user', array('userid'=>$user['userid']));
     
        $result = ($result->num_rows())? $result->row() : false ;

        return $result;
    }

    public function insert($row) : Bool
    {
        $result = $this->db->insert('user', $row);

        return $result;
    }
}