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
            <h3 class="pb-4 mb-4 font-weight-bold border-bottom" style="text-align: center;"> - 게시판 작성 - </h3>
            <form name="write_form" id="write_form">
            <?php 
                if(validation_errors()){
                    echo '<div id = "error"><h1>'.validation_errors().'</h1></div>';
                } 
            ?>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">아이디</label>
                    <input type="text" name="userid" class="form-control" id="userid" value="<?= $this->session->userdata['userid'] ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="exampleFormControllInput1" class="form-label">제목</label>
                    <input type="text" name="subject" class="form-control" id="subject" placeholder="제목을 입력하세요.">
                </div>
                <div class="mb-3">
                    <label for="exampleFormControllTextarea1" class="form-label">내용</label>
                    <textarea type="text" name="content" class="form-control" id="content" rows="10"></textarea>
                </div>
                <div class="text-lg-end">
                    <button type="button" id="write" class="btn btn-primary mt-2" style="">등록</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
<script>
    $(document).ready(function(){
        $('#write').click(function(){
            let formData = new FormData($('#write_form')[0]);

            $.ajax({
                url : '/board/ax_insert',
                type : "POST",
                data : formData,
                dataType : "JSON",
                contentType: false,
                processData : false,
                success : function(data){
                    if(!data){
                        alert('게시글 처리가 실패 되었습니다.');
                        history.back();
                    }
    
                    alert('게시글이 성공적으로 처리 되었습니다.'); 
                    location.href="/board";
                },
                error : function(){
                    alert('알 수 없는 오류입니다.'); 
                }
            });
        })
    })
</script>