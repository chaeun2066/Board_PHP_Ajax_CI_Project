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
            <form name="login_form" id="login_form">
            <?php 
                if(validation_errors()){
                    echo '<div id = "error"><h1>'.validation_errors().'</h1></div>';
                } 
            ?>
                <div class="col-12">
                    <label for="validationCustom02" class="form-label">아이디</label>
                    <input type="text" class="form-control" name="userid" id="userid">
                </div>
                <div class="col-12">
                    <label for="validationCustom02" class="form-label">비밀번호</label>
                    <input type="password" class="form-control" name="password" id="password">
                </div>
                <div class="col-12">
                    <button class="btn btn-primary" id="login">로그인</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
<script>
    $(document).ready(function(){
        $('#login').click(function(){
            let formData = new FormData($('#login_form')[0]);

            $.ajax({
                url : "/user/login_correct",
                data : formData,
                dataType : "JSON",
                type : "POST",
                contentType: false,
                processData : false,
                success : function(data){
                    if(data){
                        alert('로그인되었습니다.');
                        location.href='/board';
                    }else{
                        alert('아이디나 비밀번호를 확인해주세요.');
                        location.href='/user/login';
                    }
                },
                error : function(){
                    alert('알 수 없는 오류입니다.');
                }
            });
        });
    });
</script>