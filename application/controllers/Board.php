<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Board extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('service/Board_s');
    }

	public function index() : void
    {
        $this->load->view('board/list');
	}

    public function search()
    {
        $search_word = $this->input->get(array('search_type', 'search_word'), TRUE);

        $page = $this->input->get('page', TRUE); 

        $data = $this->Board_s->search($page, $search_word);

        echo json_encode($data);
    }

    public function write() : void
    {
        if(!isset($this->session->userdata['userid'])){  
            echo "<script> 
                    alert('로그인 후 이용가능합니다.'); 
                    location.href='/user/login';
                  </script>";
            exit;      
        }

        $this->load->view('board/write');
    }

    public function view($num){
        $data = $this->Board_s->view($num);

        if(!$data){
            echo "<script>
                    alert('해당 게시글이 없습니다.'); 
                    location.href='/board';
                  </script>";
            exit;      
        }

        $this->load->view('board/view', $data);
    }

    public function ax_insert(){ 
        $userid = isset($this->session->userdata['userid']) ? $this->session->userdata['userid'] : '' ;

        if(!isset($userid)){
            echo "<script>
                    alert('글쓰기 권한이 없습니다.'); 
                    location.href='/user/login';
                  </script>";
            exit;
        }
        
        $this->form_validation->set_rules('userid', '아이디', array('trim','htmlspecialchars', 'required', 
                                                                    array('isset_userid', function(){
                                                                        if(isset($this->session->userdata['userid'])){
                                                                            return true;
                                                                        }else{
                                                                            return false;
                                                                        }
                                                                    })),array('isset_userid' => "isset_userid 오류"));
   
        $this->form_validation->set_rules('subject', '제목', 'trim|htmlspecialchars|required');
        $this->form_validation->set_rules('content', '내용', 'trim|htmlspecialchars|required');

        if($this->form_validation->run() == FALSE){
            $msg = validation_errors();
            echo "<script>
                    alert('".$msg."');
                    history.back();
                  </script>";
            exit;
        }

        $write = $this->input->post(array('subject', 'content'),TRUE);
        $write['userid'] = $userid;

        $result = $this->Board_s->insert($write); 
           
        echo json_encode($result);
    }

    public function modify(){ 
        $num = $this->input->post('num', TRUE);

        if(!isset($this->session->userdata['userid']) ){
            echo "<script>
                    alert('해당 권한이 없습니다.'); 
                    location.href='/user/login';
                  </script>";
            exit;      
        }    
        
        $data = $this->Board_s->view($num);

        if(!$data){
            echo "<script>
                    alert('해당 게시글 정보가 없습니다.'); 
                    location.href='/board';
                  </script>";
            exit; 
        }

        if($this->session->userdata['userid'] !== $data['view']->userid){
            echo "<script>
                    alert('해당 수정 권한이 없습니다.'); 
                    location.href='/board';
                  </script>";
            exit;
        }

        $this->load->view('board/modify', $data); 
    }

    public function ax_update(){ 
        $userid = isset($this->session->userdata['userid']) ? $this->session->userdata['userid'] : '' ;

        if(!isset($userid)){
            echo "<script>
                    alert('글쓰기 권한이 없습니다.'); 
                    location.href='/user/login';
                  </script>";
            exit;    
        }
        
        $this->form_validation->set_rules('num', '번호', 'trim|htmlspecialchars|required');
        $this->form_validation->set_rules('userid', '아이디', 'trim|htmlspecialchars|required');
        $this->form_validation->set_rules('subject', '제목', 'trim|htmlspecialchars|required');
        $this->form_validation->set_rules('content', '내용', 'trim|htmlspecialchars|required');

        if($this->form_validation->run() == FALSE){
            echo "<script>
                    alert('작성 실패');
                    history.back();
                  </script>";
            exit;
        }

        $num = $this->input->post('num', TRUE);
        $write = $this->input->post(array('subject', 'content'),TRUE);

        $data = $this->Board_s->view($num);

        if(!$data){
            echo "<script>
                    alert('해당 게시글 정보가 없습니다.'); 
                    location.href='/board';
                  </script>";
            exit; 
        }

        if($this->session->userdata['userid'] !== $data['view']->userid){
            echo "<script>
                    alert('해당 수정 권한이 없습니다.'); 
                    location.href='/board';
                  </script>";
            exit;
        }

        $write['num'] = $num;
        $result = $this->Board_s->update($write);

        echo json_encode($result);
    }

    public function ax_delete(){
        $num = $this->input->post('num', TRUE);
       
        if(!isset($this->session->userdata['userid'])){ 
            echo "<script>
                    alert('해당 권한이 없습니다.'); 
                    location.href='/user/login';
                  </script>";
            exit;      
        }

        $data = $this->Board_s->view($num);

        if(!$data){
            echo "<script>
                    alert('해당 게시글 정보가 없습니다.'); 
                    location.href='/board';
                  </script>";
            exit; 
        }

        if($this->session->userdata['userid'] !== $data['view']->userid){
            echo "<script>
                    alert('해당 삭제 권한이 없습니다.'); 
                    location.href='/board';
                  </script>";
            exit;
        }

        $result = $this->Board_s->delete($num);

        echo json_encode($result);
    }
}  