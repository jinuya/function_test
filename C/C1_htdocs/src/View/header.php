<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>내집꾸미기</title>
    <link rel="stylesheet" href="resources/bootstrap-4.3.1-dist/css/bootstrap.css">
    <link rel="stylesheet" href="resources/fontawesome/css/font-awesome.css">
    <link rel="stylesheet" href="resources/css/style.css">
    <script src="resources/js/jquery-3.4.1.min.js"></script>
    <script src="resources/bootstrap-4.3.1-dist/js/bootstrap.bundle.js"></script>
    <script src="resources/js/script.js"></script>
</head>
<body>
    <div id="wrap">
        <header>
            <i id="menu_open" class="fa fa-reorder main_480"></i>
            <div id="user_box">
                <?php if(isset($_SESSION['user'])):?>
                    <a href="/logout" class="main_480"><i class="fa fa-sign-out"></i></a>
                    <a href="/logout" class="main_not480">로그아웃</a>
                    <p><?='&lt;'.$_SESSION['user']->user_name.'>(&lt;'.$_SESSION['user']->user_id.'&gt;)'?></p>
                <?php else:?>
                    <a href="#" data-target="#join_popup" data-toggle="modal" class="join_open_btn main_480"><i class="fa fa-user-plus"></i></a>
                    <a href="#" data-target="#join_popup" data-toggle="modal" class="join_open_btn main_not480">회원가입</a>
                    <a href="#" data-target="#login_popup" data-toggle="modal" class="login_open_btn main_480"><i class="fa fa-sign-in"></i></a>
                    <a href="#" data-target="#login_popup" data-toggle="modal" class="login_open_btn main_not480">로그인</a>
                <?php endif;?>
            </div>
            <a href="#"><img id="logo" src="resources/images/logo.png" alt="Logo" title="Logo"></a>
            <nav>
                <ul>
                    <li><a href="/">HOME</a></li>
                    <li><a href="/housing">온라인 집들이</a></li>
                    <li><a href="/store">스토어</a></li>
                    <li><a href="/specialist">전문가</a></li>
                    <li><a href="/building">시공 견적</a></li>
                </ul>
            </nav>
        </header>
        <div id="visual">
            <div id="slide_back">
                <div id="slide_word">
                    <p>당신을 위한 인테리어</p>
                    <h2>Modern Housing</h2>
                </div>
            </div>
            <input type="radio" name="slidebtn" id="slide-1" hidden checked="">
            <input type="radio" name="slidebtn" id="slide-2" hidden >
            <input type="radio" name="slidebtn" id="slide-3" hidden >
            <input type="radio" name="slidebtn" id="slide-4" hidden >
            
            <label class="slide_controller slide_left" for="slide-2" data-idx="1"><i class="fa fa-chevron-left"></i></label>
            <label class="slide_controller slide_left" for="slide-3" data-idx="2"><i class="fa fa-chevron-left"></i></label>
            <label class="slide_controller slide_left" for="slide-4" data-idx="3"><i class="fa fa-chevron-left"></i></label>
            <label class="slide_controller slide_left" for="slide-1" data-idx="4"><i class="fa fa-chevron-left"></i></label>
                
            <label class="slide_controller slide_right" for="slide-2" data-idx="1"><i class="fa fa-chevron-right"></i></label>
            <label class="slide_controller slide_right" for="slide-3" data-idx="2"><i class="fa fa-chevron-right"></i></label>
            <label class="slide_controller slide_right" for="slide-4" data-idx="3"><i class="fa fa-chevron-right"></i></label>
            <label class="slide_controller slide_right" for="slide-1" data-idx="4"><i class="fa fa-chevron-right"></i></label>
            <div class="slide">
                <img src="resources/images/main_slide1.jpg" class="slide_img" title="slide img1" alt="slide img1">
                <img src="resources/images/main_slide2.jpg" class="slide_img" title="slide img2" alt="slide img2">
                <img src="resources/images/main_slide3.jpg" class="slide_img" title="slide img3" alt="slide img3">
            </div>
        </div>