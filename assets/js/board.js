$(document).ready(function(){
    $('#write').click(function() {
        let subject = document.querySelector('#subject').value;
        let content = document.querySelector('#content').value;
        let form = document.write_form;

        if(subject == ""){
            alert("제목을 입력해주세요.");
            form.subject.focus();
        }

        if(content == ""){
            alert("내용을 입력해주세요.");
            form.content.focus();
        }
    })

    $('#update').click(function() {
        let subject = document.querySelector('#subject').value;
        let content = document.querySelector('#content').value;
        let form = document.update_form;

        if(subject == ""){
            alert("제목을 입력해주세요.");
            form.subject.focus();
        }

        if(content == ""){
            alert("내용을 입력해주세요.");
            form.content.focus();
        }
    })

    $('#search_button').click(function() {
        let input = document.querySelector('#search_word').value;
        let type = document.querySelector('#search_type').value;

        if(type !== "" && input == ""){
            alert("검색 내용을 입력해주세요.");
            input.focus();
            exit();
        }

        if(type == "" && input !== ""){
            alert("검색 타입을 선택해주세요.");
            type.focus();
            exit();
        }
    });

    
});