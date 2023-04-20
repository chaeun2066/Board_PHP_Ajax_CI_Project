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
            <form name="regist_form" id="regist_form">
            <?php 
                if(validation_errors()){
                    echo '<div id = "error"><h1>'.validation_errors().'</h1></div>';
                } 
            ?>
                <div class="col-12">
                    <label for="validationCustom02" class="form-label">아이디</label>
                    <input type="text" class="form-control" name="userid" id="userid" placeholde="아이디 입력" required>
                </div>
                <div class="col-12">
                    <label for="validationCustom02" class="form-label">비밀번호</label>
                    <input type="password" class="form-control" name="password" id="password" placeholde="비밀번호 입력" required>
                </div>
                <div class="col-12">
                    <label for="validationCustom02" class="form-label">비밀번호 확인</label>
                    <input type="password" class="form-control" name="password_check" id="password_check" placeholde="비밀번호 확인" required>
                </div>
                <div class="col-12">
                    <label for="validationCustom03" class="form-label">이메일</label>
                    <input type="email" class="form-control" name="email" placeholde="이메일 입력" id="email">
                </div>
                <div class="col-12 text-lg-end">
                    <button class="btn btn-primary mt-1" id="regist">회원가입</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
<script>
     $(document).ready(function(){
        $('#regist').click(function(){
            let formData = new FormData($('#regist_form')[0]);

            $.ajax({
                url : "/user/ax_insert",
                data : formData,
                dataType : "JSON",
                type : "POST",
                contentType: false,
                processData : false,
                success : function(data){
                    if(data){
                        alert('가입이 성공적으로 되었습니다.');
                        location.href='/board';
                    }else{
                        alert('가입 실패');
                        history.back();
                    }
                },
                error : function(){
                    alert('알 수 없는 오류입니다.');
                }
            });
        });
    });
</script>