<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Board_m extends CI_Model{
    public function __construct()
    {
        parent::__construct();
        $this->load->database(); 
    }

    public function search_count($search_word) : int
    {
        if(isset($search_word) && isset($search_word['search_word']) && !empty($search_word['search_word'])){
            $this->db->like(array($search_word['search_type'] => $search_word['search_word']));
        }
        
        $this->db->from('board');
        $result = $this->db->count_all_results();

        return $result;
    }
    
    public function search($offset = "1", $limit, $search_word) : array
    { 
        $this->db->select('num, userid, subject, registday');
        $this->db->from('board');

        if(isset($search_word) && isset($search_word['search_word']) && !empty($search_word['search_word'])){
            $this->db->like(array($search_word['search_type'] => $search_word['search_word']));
        }

        $this->db->order_by('num', 'DESC');
        $this->db->limit($limit, $offset);

        $result = $this->db->get()->result();

        return $result;
    }

    public function view($num)
    {
        $result = $this->db->get_where('board', array('num' => $num));

        $result = ($result->num_rows())? $result->row() : false ;

        return $result;
    }

    public function insert($row) : Bool
    {
        $result = $this->db->insert('board', $row);

        return $result;
    }

    public function update($data, $where) : Bool
    {
        $result = $this->db->update('board', $data, $where);

        return $result;
    }

    public function delete($where) : Bool
    {
        $result = $this->db->delete('board', $where);
// echo $this->db->last_query();
        return $result;
    }
}