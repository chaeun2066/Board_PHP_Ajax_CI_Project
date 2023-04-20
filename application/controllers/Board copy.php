<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Board extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('/servie/Board');
    }

	public function index()
	{
        $this->load->library('pagination');

        $config = array(
            'base_url' => "http://localhost:8000/board/index/",
            'total_rows' => $this->BoardModel->total_rows(),
            'per_page' => 10,
            'uri_segment' => 3,
            'num_links' => 2,
            'use_page_numbers' => TRUE,
            'full_tag_open' => '<div class="paging text-center">',
            'full_tag_close' => '</div>',
            'first_link' => '[처음]',
            'first_tag_open' => '<span class="first" title="처음">',
            'first_tag_close' => '</span>',
            'last_link' => '[끝]',
            'last_tag_open' => '<span class="last" title="끝">',
            'last_tag_close' => '</span>',
            'prev_link' => '< 이전',
            'prev_tag_open' => '<span class="prev" title="이전" style="color:black;">',
            'prev_tag_close' => '</span>',
            'next_link' => '다음 >',
            'next_tag_open' => '<span class="next" title="다음" style="color:black;">',
            'next_tag_close' => '</span>',
            'cur_tag_open' => '<a href="#" class="on" style="text-decoration: none; color:black;"> ',
            'cur_tag_close' => ' </a>',
            'num_tag_open' => '<a href="#" style="text-decoration: none; color:black;"> ',
            'num_tag_close' => ' </a>'
        );      
 
        $this->pagination->initialize($config);
      
        $data = array();
        $data['pagination'] = $this->pagination->create_links();

        $page = $this->uri->segment(3,1); // 보통 GET 방식으로 얻어오는 것이 더 좋다.

        $start = ($page - 1) * $config['per_page'];

        $limit = $config['per_page'];

        $number = $config['total_rows'] - $start; 

        $data['list'] = array($this->BoardModel->getBoard($start, $limit), $number);
        $this->load->view('board/list', $data);
	}

    public function write(){
        if(!isset($this->session->userdata['userid'])){ 
            echo "<script>
                    alert('로그인 후 이용가능합니다.'); 
                    location.href='/user/login';
                  </script>";
        }

        $this->load->view('board/write');
    }

    public function view($num){
        $result = $this->BoardModel->getView($num);

        if($result == false){
            echo "<script>
                    alert('해당 게시글이 없습니다.'); 
                    location.href='/board';
                  </script>";
        }

        $data['view'] = $result;
        $this->load->view('board/view', $data);
    }

    public function save(){
        $userid  = $this->session->userdata['userid'];

        if(!isset($userid)){
            echo "<script>
                    alert('권한이 없습니다.'); 
                    location.href='/user/login';
                  </script>";
        }
        
        $mode    = $this->input->post('mode', TRUE);
        $subject = $this->input->post('subject', TRUE);
        $content = $this->input->post('content', TRUE);
        $registday = date("Y-m-d H:i:s");

        if($mode == "insert"){
            $result = $this->BoardModel->saveBoard($userid, $subject, $content, $registday); // 그리고 배열로 넘기는 식으로 바꿔보기
        }elseif($mode == "modify"){
            $num    = $this->input->post('num', TRUE);
            $result = $this->BoardModel->updateBoard($num, $subject, $content);
        }else{
            echo "<script>alert('잘못된 방식입니다.');</script>";
            exit;
        }

        if($result){
            echo "<script>
                    alert('게시글이 성공적으로 처리 되었습니다.'); 
                    location.href='/board';
                  </script>";
        }else{
            echo "<script>
                    alert('게시글 처리가 실패 되었습니다.');    
                    history.back;
                  </script>";
        }
    }

    public function modify($num){
        if(!isset($this->session->userdata['userid'])){
            echo "<script>
                    alert('로그인 후 이용가능합니다.'); 
                    location.href='/user/login';
                  </script>";
        }

        $data['view'] = $this->BoardModel->getView($num);
        $this->load->view('board/modify', $data);
    }

    public function delete($num){
        if(!isset($this->session->userdata['userid'])){
            echo "<script>
                    alert('권한이 없습니다.'); 
                    location.href='/user/login';
                  </script>";
        }

        $result = $this->BoardModel->deleteBoard($num);

        if($result){
            echo "<script>
                    alert('게시글 삭제가 되었습니다.'); 
                    location.href='/board';
                  </script>";
        }else{
            echo "<script>
                    alert('삭제 실패'); 
                    history.back;
                  </script>";
        }
    }
}  