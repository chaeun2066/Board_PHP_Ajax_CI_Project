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
            <div class="text-lg-end">
<?php
            if(isset($this->session->userdata['userid'])){ 
?>
                <div class="top d-flex justify-content-end align-content-center">
                    <p class="text-align-right mb-0 me-3"><?= $this->session->userdata['userid']?><span>님 어서오세요.</span></p>
                    <input type="button" class="btn btn-info mt-1 mb-1" onclick="location.href='/user/logout'" value="로그아웃">
                </div>
<?php
            }else{
?>
                <input type="button" class="btn btn-info mt-1 mb-1" onclick="location.href='/user/login'" value="로그인">
                <input type="button" class="btn btn-warning mt-1 mb-1" onclick="location.href='/user/regist'" value="회원가입">
<?php
    }
?>
            </div>
            <h3 class="pb-4 mb-4 border-bottom" style="text-align: center;"> - 게시판 보기 - </h3>
            <form class="col-12 d-inline-flex justify-content-end" name="search_form">
                <select name="search_type" id="search_type" class="col-1 mt-1 mb-3 me-2">
                    <option>전체</option>
                    <option value="userid">글쓴이</option>
                    <option value="subject">제목</option>
                    <option value="registday">등록일</option>
                </select>
                <input id="search_word" name="search_word" class="col-3 mb-3 ml-2" 
                    type="text" placeholder="검색 대상을 입력하세요." style="float:right;">
                <button type="submit" class="ml-2 mb-3" id="search_button" style="border: 1px solid blue;">
                    <img src="/assets/img/search.png" alt="search" style="width: 20px; height: 20px;">
                </button>
            </form>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col" class="w-15 text-center">번호</th>
                        <th scope="col" class="text-center">글쓴이</th>
                        <th scope="col-2" class="w-50 text-center">제목</th>
                        <th scope="col" class="text-center">등록일</th>
                    </tr>
                </thead>
                <tbody id="board_list">

                </tbody>
            </table>
            <div class="fw-normal text-center" id="pagination">

            </div>
            <div class="text-lg-end">
                <input type="button" class="btn btn-primary mt-2" onclick="location.href='/board/write'" value="글쓰기">
            </div>
        </div>
    </div>
</body>
</html>
<!-- Ajax -->
<script>
    $(document).ready(function(){
        search_list(1);
    });

    let page = "";

    function search_list(page){
        let search_type = document.querySelector('#search_type').value;
        let search_word = document.querySelector('#search_word').value;

        let search = {'search_type' : search_type, 'search_word' : search_word, 'page' : page}; 
        let list_html = "";
        
        $.ajax({
            url : '/board/search',
            type : "GET",
            data : search,
            dataType : "JSON",
            success : function(data){
                for(i = 0 ; i < data.list.length ; i++){ 
                    list_html += "<tr>";
                    list_html += "<th scope=\"row\" class=\"text-center\">" +  data.number + "</th>";
                    list_html += "<td class=\"text-center\">" + data.list[i].userid + "</td>";
                    list_html += "<td><a href=\"/board/view/" + data.list[i].num + "\">" + data.list[i].subject + "</a></td>";
                    list_html += "<td class=\"text-center\">" + data.list[i].registday + "</td>";
                    list_html += "</tr>"; 
                    data.number--;
                }

                $("#board_list").html(list_html);

                let pagination = {
                    'page' : data.pager['page'],
                    'block_start_page' : data.pager['block_start_page'],
                    'block_end_page' : data.pager['block_end_page'],
                    'total_page' : data.pager['total_page']
                };

                paging(pagination, "search_list");
            },
            error : function() {
                alert("데이터 가져오기 실패");
            }
        });
    }
    
    function paging(pagination, func){
        let page_html = "";
        let block_start_page = pagination.block_start_page;
        let block_end_page = pagination.block_end_page;
        let total_page = pagination.total_page;
        page = pagination.page;

        if(page <= 1){
            page_html += "<a href=\"javascript:" + func + "(1);\">◀ 이전</a>&nbsp;&nbsp;";
        }else{
            page_html += "<a href=\"javascript:" + func + "('" + (page - 1) + "')\">◀ 이전</a>&nbsp;&nbsp;";
        }

        for(print_page = block_start_page; print_page <= block_end_page; print_page++){
            page_html += "<a href=\"javascript:" + func + "('" + print_page + "')\">" + print_page + "&nbsp;</a>";
        } 

        if(page >= total_page){
            page_html += "<a href=\"javascript:" + func + "('" + total_page + "')\">&nbsp;&nbsp;다음 ▶</a>";
        }else{
            page_html += "<a href=\"javascript:" + func + "('" + (page + 1) + "')\">&nbsp;&nbsp;다음 ▶</a>";
        }

        // document ready 함수 안에 있을 시 서로 참조 못하는 이유는 이미 DOM을 읽은 상태에서 Script를 실행했기 때문에 page에서의 HTML 코드가
        // 또 새로운 DOM 이 생성이 된 개념이라 적용이 되지 않는다. 

        $('#pagination').html(page_html);
    }
</script>