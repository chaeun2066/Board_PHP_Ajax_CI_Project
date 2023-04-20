<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include_once('application/views/head.php'); ?>
    <title>Board</title>
</head>
<body>
    <div class="col-md-8 mt-2" style="margin:auto;padding:20px;">
        <div class="wrap">
            <h3 class="pb-4 mb-4 border-bottom" style="text-align: center;"> - 게시글 보기 - </h3>
            <article class="blog-post">
                <h2 class="blog-post-title"><?= $view->subject ?></h2>
                <p class="blog-post-meta text-lg-end"><?= $view->registday ?> by <a href="#"><?= $view->userid ?></a></p>

                <hr>

                <div class="col-12" style="word-break:break-all;">
                    <?= $view->content ?>
                </div>

                <hr>
                <p style="text-align:right;">
            <?php
                $userid = isset($this->session->userdata['userid']) ? $this->session->userdata['userid'] : '' ;
                if(isset($userid)){
                    if($userid == $view->userid || $userid == 'admin'){
            ?>        
            <!-- GET으로 받아오는 방식 택하기 / 로그인하고 돌아올 때 이 화면으로 그대로 돌아오기 힘듦 -->
                        <!-- <a href="/board/modify/< ?= $view->num;?>"><button type="button" class="btn btn-success">수정</button><a>
                        <a href="/board/delete/< ?= $view->num;?>"><button type="button" class="btn btn-danger">삭제</button><a> -->
                        <button type="button" id="modify" class="btn btn-success" onclick="modify_board(<?= $view->num ?>)">수정</button>
                        <button type="button" id="delete" class="btn btn-danger" onclick="delete_board(<?= $view->num ?>)">삭제</button>
            <?php
                    }
                }
            ?>
                    <a href="/board"><button type="button" class="btn btn-primary">목록</button><a>
                </p>
            </article>
        </div>
    </div>
</body>
</html>
<script>
    function modify_board(num){
        let ajaxData = {'num' : num };

        $.ajax({
                url : "/board/modify",
                type : "POST",
                data : ajaxData,
                success : function(data){
                    if(!data){
                        alert('게시글 처리가 실패 되었습니다.');
                        history.back();
                    }
        
                    alert('게시글이 성공적으로 처리 되었습니다.');
                    location.href="/board";
                },
                error : function(request, error){
                    alert("code: " + request.status + "\n" + "message: " + request.reponseText + "\n" + "error: " + error);
                    alert('알 수 없는 오류입니다.'); 
                }
            });
    }

    function delete_board(num){
        let ajaxData = {'num' : num };

        if (confirm("정말로 삭제하시겠습니까?")) {
            $.ajax({
                url : "/board/ax_delete",
                type : "POST",
                data : ajaxData,
                success : function(data){
                    if(!data){
                        alert('게시글 처리가 실패 되었습니다.');
                        history.back();
                    }
        
                    alert('게시글이 성공적으로 처리 되었습니다.');
                    location.href="/board";
                },
                error : function(request, error){
                    alert("code: " + request.status + "\n" + "message: " + request.reponseText + "\n" + "error: " + error);
                    alert('알 수 없는 오류입니다.'); 
                }
            });
        }
    }
</script>