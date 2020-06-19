<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>내집꾸미기</title>
    <!-- 링크설정 -->
    <link rel="stylesheet" href="resources/bootstrap-4.3.1-dist/css/bootstrap.css">
    <link rel="stylesheet" href="resources/fontawesome/css/font-awesome.css">
    <link rel="stylesheet" href="resources/css/style.css">
    <script src="resources/js/jquery-3.4.1.min.js"></script>
    <script src="resources/bootstrap-4.3.1-dist/js/bootstrap.js"></script>
    <script src="resources/js/app.js"></script>
</head>
<body>
    <!-- 시작 -->
    <div id="wrap">
        <!-- 헤더 -->
        <header>
            <div id="user_area">
                <?php if(!isset($_SESSION['user'])):?>
                    <a href="#" data-target="#join_popup" data-toggle="modal" id="join_open" class="main_user">회원가입</a>
                    <a href="#" data-target="#login_popup" data-toggle="modal" id="login_open" class="main_user">로그인</a>

                    <div id="join_popup" class="modal fade">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-line"><div></div></div>
                                <div class="modal-header">
                                    <h3 class="modal-title d-block text-center">회원가입</h3>
                                </div>
                                <div class="modal-body">
                                    <form action="/join" method="post" name="join_form" id="join_form" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="user_id">아이디</label>
                                            <input type="text" id="user_id" name="user_id" placeholder="아이디를 입력해주세요." class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="password">비밀번호</label>
                                            <input type="password" id="password" name="password" placeholder="비밀번호를 입력해주세요." class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="user_name">이름</label>
                                            <input type="text" id="user_name" name="user_name" placeholder="이름을 입력해주세요." class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="img">사진</label>
                                            <input type="file" id="img" name="img" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <canvas id="captcha" class="border"></canvas>
                                            <input type="text" id="captcha_word" name="captcha_word" placeholder="자동입력방지 문자를 입력해주세요." class="form-control">
                                        </div>
                                        <button class="close" id="join_send" type="button"></button>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button class="footer_btn" id="join_btn">가입 완료</button>
                                    <button class="footer_btn" data-dismiss="modal">닫기</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="login_popup" class="modal fade">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-line"><div></div></div>
                                <div class="modal-header">
                                    <h3 class="text-center modal-title d-block">로그인</h3>
                                </div>
                                <div class="modal-body">
                                    <form action="/login" name="login_form" method="post" id="login_form">
                                        <div class="form-group">
                                            <label for="user_id">아이디</label>
                                            <input type="text" id="user_id" name="user_id" placeholder="아이디를 입력해주세요." class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="password">비밀번호</label>
                                            <input type="password" id="password" name="password" placeholder='비밀번호를 입력해주세요.' class="form-control">
                                        </div>
                                        <button class="close" id="login_send" type="button"></button>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button class="footer_button" id="login_btn">로그인</button>
                                    <button class="footer_button" data-dismiss="modal">닫기</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php else:?>
                    <p class="main_user">&lt;<?=$_SESSION['user']->user_name?>&gt;(&lt;<?=$_SESSION['user']->user_id?>&gt;)</p>
                    <a href="/logout" class="main_user">로그아웃</a>
                <?php endif;?>
            </div>
            <i class="fa fa-reorder main_480" id="menu_open"></i>
            <div id="logo">
                <img src="resources/images/logo.png" title="logo" alt="logo">
            </div>
            <nav>
                <ul>
                    <li><a href="/">홈</a></li>
                    <li><a href="/housing">온라인 집들이</a></li>
                    <li><a href="/store">스토어</a></li>
                    <li><a href="/specialist">전문가</a></li>
                    <li><a href="/building">시공 견적</a></li>
                </ul>
            </nav>
        </header>
        <!-- 비쥬얼 -->
        <div id="visual">
            <div id="visual_back">
                <div id="visual_back_left"></div>
                <div id="visual_word">
                    <div></div>
                    <p>Every Design</p>
                    <h2 id="vw_h1">Decorating</h2>
                    <h2 id="vw_h2">House</h2>
                    <h5>당신이 원하는 모든 인테리어가<br>있는곳</h5>
                </div>
            </div>
            <div id="slide">
                <img src="resources/images/slide1.jpg" title="slide_img" alt="slide_img">
                <img src="resources/images/slide2.jpg" title="slide_img" alt="slide_img">
                <img src="resources/images/slide3.jpg" title="slide_img" alt="slide_img">
            </div>
            <div id="slide_button">
                <button class="slide_btn" id="left_btn"><i class="fa fa-angle-left text-white"></i></button>
                <button class="slide_btn" id="right_btn"><i class="fa fa-angle-right text-white"></i></button>
            </div>
        </div>

        <div id="content">