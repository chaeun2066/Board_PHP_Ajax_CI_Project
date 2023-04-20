<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BoardModel extends CI_Model{
    public function __construct()
    {
        parent::__construct();
        $this->load->database(); 
    }

    public function total_rows(){
        $result = $this->db->count_all('board');
        return $result;
    }
    
    public function getBoard($offset, $limit) : array
    { 
        $test =  $this->db->select('num, userid, subject, registday')
                          ->from('board')
                          ->order_by('num', 'DESC')
                          ->limit($limit, $offset);

        $result = $this->db->get()->result();

        return $result;
    }

    public function getView($num){
        

        $result = $this->db->get_where('board', array('num' => $num));

        if($result->num_rows() <= 0){
            return false;
        }

        return $result->row();
    }

    public function saveBoard($userid, $subject, $content){
        $row = array(
            "userid"    => $userid,
            "subject"   => $subject,
            "content"   => $content,
            "registday" => date("Y-m-d H:i:s") 
        );

        $result = $this->db->insert('board', $row);

        return $result;
    }

    public function updateBoard($num, $subject, $content){
        $data = array(
            "subject" => $subject,
            "content" => $content
        );

        $where = array(
            "num" => $num
        );

        $result = $this->db->update('board', $data, $where);
        return $result;
    }

    public function deleteBoard($num){
        $where = array("num"=> $num);
        $result = $this->db->delete('board', $where);
        return $result;
    }
}

