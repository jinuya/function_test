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
    <script src="resources/bootstrap-4.3.1-dist/js/bootstrap.js"></script>
    <script src="resources/js/script.js"></script>
</head>
<body>
    <div id="wrap">
        <!-- 헤더 -->
        <header>
            <div class="main_480" id="menu_bar"><i class="fa fa-bars"></i></div>
            <div id="user_area">
                <?php if(isset($_SESSION['user'])):?>
                    <a href="/logout" class="main_user main_not480">로그아웃</a>
                    <a href="/logout" class="main_user main_480"><i class="fa fa-sign-out"></i></a>
                    <span>&lt;<?=$_SESSION['user']->user_name?>&gt;(&lt;<?=$_SESSION['user']->user_id?>&gt;)</span>
                <?php else:?>
                    <a href="#" data-target="#login_popup" data-toggle="modal" class="login main_user main_not480">로그인</a>
                    <a href="#" data-target="#login_popup" data-toggle="modal" class="login main_user main_480"><i class="fa fa-sign-in"></i></a>
                    <a href="#" data-target="#join_popup" data-toggle="modal" class="join main_user main_not480">회원가입</a>
                    <a href="#" data-target="#join_popup" data-toggle="modal" class="join main_user main_480"><i class="fa fa-user-plus"></i></a>
                <?php endif;?>
            </div>
            <div id="logo"><img src="resources/images/logo.png" title="logo" alt="logo"></div>
            <!-- 네비게이션 -->
            <nav>
                <ul>
                    <li><a href="/">Home</a></li>
                    <li><a href="/housing">온라인 집들이</a></li>
                    <li><a href="/store">스토어</a></li>
                    <li><a href="/specialist">전문가</a></li>
                    <li><a href="/building">시공 견적</a></li>
                </ul>
            </nav>
        </header>
        <!-- 비쥬얼(슬라이드) -->
        <div id="visual">
            <div id="visual_back">
                <div class="visual_line position-absolute"><div class="visual_line2"></div></div>
                <p>당신이 원하는 모든 인테리어</p>
                <h2>Decorating House</h2>
                <div class="visual_line v2 position-absolute"><div class="visual_line2"></div></div>
            </div>

            <input type="radio" id="slide_1" data-id="1" checked hidden >
            <input type="radio" id="slide_2" data-id="2" hidden >
            <input type="radio" id="slide_3" data-id="3" hidden >
            <input type="radio" id="slide_4" data-id="4" hidden >

            <label class="slide_btn slide_left"><i class="fa fa-angle-left"></i></label>
            <label class="slide_btn slide_right"><i class="fa fa-angle-right"></i></label>

            <div id="slide">
                <img src="resources/images/slide_1.jpg" title="slide_img" alt="slide_img">
                <img src="resources/images/slide_2.jpg" title="slide_img" alt="slide_img">
                <img src="resources/images/slide_3.jpg" title="slide_img" alt="slide_img">
            </div>
        </div>

        <div id="join_popup" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content border-0">
                    <div class="modal-header bg-dark text-white">
                        <h2 class="modal-title text-white">회원가입</h2>
                        <button class="close text-white" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form action="/join" method="post" id="join_form" name="join_form" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="user_id">아이디</label>
                                <input type="text" id="user_id" name="user_id" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="password">비밀번호</label>
                                <input type="password" id="password" name="password" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="user_name">이름</label>
                                <input type="text" id="user_name" name="user_name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="img">사진</label>
                                <input type="file" id="img" name="img" class="form-control">
                            </div>
                            <div class="form-group">
                                <canvas id="captcha" style="width:100%; height:100px;" class="border border-dark"></canvas>
                                <input type="text" id="captcha_word" name="captcha_word" class="form-control">
                            </div>
                            <button class="close" id="join_send"></button>
                        </form>
                    </div>
                    <div class="modal-footer bg-light">
                        <button class="btn btn-secondary" data-dismiss="modal">취소</button>
                        <button class="btn btn-primary" id="join_btn">가입 완료</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="login_popup" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content border-0">
                    <div class="modal-header bg-dark text-white">
                        <h2 class="modal-title text-white">로그인</h2>
                        <button class="close text-white" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form action="/login" method="post" name="login_form" id="login_form">
                            <div class="form-group">
                                <label for="user_id">아이디</label>
                                <input type="text" id="user_id" name="user_id" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="password">비밀번호</label>
                                <input type="password" id="password" name="password" class="form-control">
                            </div>
                            <button class="close" id="login_send"></button>
                        </form>
                    </div>
                    <div class="modal-footer bg-light">
                        <button class="btn btn-secondary" data-dismiss="modal">취소</button>
                        <button class="btn btn-primary" id="login_btn">로그인</button>
                    </div>
                </div>
            </div>
        </div>