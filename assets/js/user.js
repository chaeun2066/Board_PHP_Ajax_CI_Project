$(document).ready(function(){
    $('#login').click(function() {
        let userid = document.querySelector('#userid').value;
        let password = document.querySelector('#password').value;
        let form = document.login_form;

        if(userid == ""){
            alert("아이디를 입력해주세요.");
            form.userid.focus();
        }

        if(password == ""){
            alert("비밀번호를 입력해주세요.");
            form.password.focus();
        }
    })

    $('#regist').click(function() {
        let userid = document.querySelector('#userid').value;
        let password = document.querySelector('#password').value;
        let password_check = document.querySelector('#password_check').value;
        let email = document.querySelector('#email').value;
        let form = document.regist_form;

        if(userid == ""){
            alert("아이디를 입력해주세요.");
            form.userid.focus();
        }

        if(password == ""){
            alert("비밀번호를 입력해주세요.");
            form.password.focus();
        }

        if(password_check == ""){
            alert("비밀번호를 확인해주세요.");
            form.password_check.focus();
        }

        if(email == ""){
            alert("이메일을 입력해주세요.");
            form.email.focus();
        }
    })
});