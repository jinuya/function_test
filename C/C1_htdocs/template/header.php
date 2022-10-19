<?php

require_once 'DB.php';

class Session
{
    public function has($type)
    {
        return isset($_SESSION[$type]);
    }
}

class UserController 
{
    // 회원가입
    public function register()
    {
        $_POST = ajaxValidation($_POST);
        extract($_POST);
        
        if(session()->get("captcha", true) != $captcha){
            returnJSON(["msg" => "자동입력방지 문자를 잘못 입력하였습니다.", "result" => false]);
        }

        $user = DB::fetch("SELECT * FROM users WHERE id = ?", array($id));
        if($user){
            returnJSON(["msg" => "중복되는 아이디입니다. 다른 아이디를 사용해주세요.", "result" => false]);
        }

        $img = upload($_FILES['img']);
        DB::execute("INSERT INTO users (id, password, name, img) VALUE (?, ?, ?, ?)", array($id, $password, $name, $img));
        returnJSON(["msg" => "회원가입 하셨습니다.", "result" => true]);
    }
}

function session()
{
    return new session();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http_equiv="X_UA_Compatible" content="IE=edge">
    <meta name="viewport" content="width=device_width, initial_scale=1.0">
    <link rel="stylesheet" href="resources/css/style.css">
    <link rel="stylesheet" href="resources/css/bootstrap.css">
    <link rel="stylesheet" href="resources/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="resources/css/jquery-ui.min.css">
    <link rel="stylesheet" href="resources/css/common.css">
    <script src="resources/js/jquery-3.4.1.min.js"></script>
    <script src="resources/js/jquery-ui.min.js"></script>
    <script src="resources/js/bootstrap.js"></script>
    <title>두근두근 인테리어, 내 집 꾸미기</title>
</head>

<body>
    <?php if (session()->has("msg")) { ?>
        <script>
            alert('<?= session()->get("msg") ?>');
        </script>
    <?php } else if (session()->has("error")) { ?>
        <script>
            alert('<?= session()->get("error") ?>');
        </script>
    <?php } ?>
    <header>
        <nav class="main_nav navbar">
            <a class="navbar_brand px" href="#"><img class="header_logo" src="resources/images/logo.png" alt="logo" title="logo"></a>
            <div class="navbar_collapse">
                <ul class="navbar_nav">
                    <li class="nav_item"><a class="nav_link" href="index.php">홈</a></li>
                    <li class="nav_item"><a class="nav_link" href="#">온라인 집들이</a></li>
                    <li class="nav_item"><a class="nav_link" href="store.php">스토어</a></li>
                    <li class="nav_item"><a class="nav_link" href="#">전문가</a></li>
                    <li class="nav_item"><a class="nav_link" href="#">시공견적</a></li>
                </ul>
                <ul class="login_section">
                        <a href="logout" class="main_user">로그아웃</a>
                    <li class="nav_item login">
                        <a class="nav_link" href="#">로그인</a>
                    </li>
                    <li class="nav_item account">
                        <a href="#" data-toggle="modal" data-target="#register" class="nav_link account_btn">회원가입</a>
                    </li>
                </ul>
            </div>
            
        </nav>
        
    </header>

    <div id="register" class="modal fade">
        <div class="modal-dialog">
            <form id="registerForm" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <span class="fs-3">회원가입</span>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="id">아이디</label>
                            <input type="text" name="id" id="id" placeholder="아이디를 입력해주세요." class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="password">비밀번호</label>
                            <input type="password" name="password" id="password" placeholder="비밀번호를 입력해주세요." class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="name">이름</label>
                            <input type="text" name="name" id="name" placeholder="이름을 입력해주세요." class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="img">사진</label>
                            <input type="file" name="img" id="img" class="form-control">
                        </div>
                        <div class="form-group">
                            <img src="" alt="captcha" title="captcha">
                            <input type="text" name="captcha" id="captcha" class="form-control mt-3" placeholder="캡차를 입력해주세요.">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="text-right">
                            <input type="button" value="회원가입" class="btn border-white color-white bg-purple" onclick="register();">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function ajax(url, type, data, successFn) {
            $.ajax({
                url: url,
                type: type,
                data: data,
                contentType: false,
                processData: false,
                success: successFn
            });
        }

        function register() {
            let form = document.querySelector('#registerForm');
            let data = new FormData(form);
            $.ajax({
                enctype: 'multipart/form-data',
                url: '/user/register',
                type: 'post',
                data: data,
                contentType: false,
                processData: false,
                success: data => {
                    data = JSON.parse(data);
                    alert(data.msg);
                    if (data.result) {
                        location.reload();
                    }
                }
            });
        }
    </script>