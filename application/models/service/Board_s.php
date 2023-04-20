<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Board_s extends CI_Model{
    public function __construct()
    {
        parent::__construct();
        $this->load->database(); 
        $this->load->model('dao/Board_m');
    }

    public function search($page, $search_word) : Array
    {
        //현재 페이지
        if(isset($page) || !empty($page)){ 
            $page = (int)$page;  
        }else{
            $page = 1;
        }

        $limit = 10;

        $page_block = 3;

        $total_record = $this->Board_m->search_count($search_word);

        $total_page = ceil($total_record / $limit);

        $total_block = ceil($total_page / $page_block);

	    $now_block = ceil($page / $page_block);

	    $block_start_page = ($now_block - 1) * $page_block;

        if($block_start_page <= 0){
            $block_start_page = 1;
        }

        $block_end_page = $now_block * $page_block;

        if($block_end_page > $total_page){
            $block_end_page = $total_page;
        }

        $start = ($page - 1) * $limit;

        $number = $total_record - $start;

        $pager = array(
            'page' => $page, 
            'start' =>$start, 
            'limit' => $limit, 
            'number' => $number, 
            'block_start_page' => $block_start_page,  
            'block_end_page' => $block_end_page,  
            'total_page' => $total_page, 
            'total_record' => $total_record
        );

        $types = array("userid", "subject", "registday");

        if(!in_array($search_word['search_type'], $types)){
            $search_word['search_type'] = "userid";
        }

        $result = $this->Board_m->search($pager['start'], $pager['limit'], $search_word);

        return array("list" => $result, "number" => $number, "pager" => $pager);
    }

    public function view($num){
        $result = $this->Board_m->view($num);

        $data['view'] = $result; 

        return $data;
    }

    public function insert($write) : Bool
    {
        $row = array(
            "userid" => $write['userid'],
            "subject" => $write['subject'],
            "content" => $write['content'],
            "registday" => date("Y-m-d H:i:s") 
        );

        $result = $this->Board_m->insert($row);

        return $result;
    }

    public function update($write) : Bool
    {
        $data = array(
            "subject" => $write['subject'],
            "content" => $write['content']
        );

        $where = array(
            "num" => $write['num']
        );

        $result = $this->Board_m->update($data, $where);

        return $result;
    }

    public function delete($num) : Bool
    {
        $where = array("num"=> $num);
        $result = $this->Board_m->delete($where);

        return $result;
    }
}

