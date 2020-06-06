        <footer>
            Copyright (C) 2020 by MyHome Inc All Rights Reserved.
        </footer>
        <div class="modal fade" id="join_popup">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title">회원가입</h2>
                        <button class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form id="join_form" name="joinfrm" action="/join" method="post" enctype ="multipart/form-data">
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
                                <canvas id="captcha" style="width:100%;height:100px;"></canvas>
                                <input type="text" id="captcha" name="captcha" class="form-control">
                            </div>
                            <button id="join_submit" class="d-none"></button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-dismiss="modal">취소</button>
                        <button class="btn btn-primary" id="join_btn">회원가입</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="login_popup">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title">로그인</h2>
                        <button class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form action="/login" method="post">
                            <div class="form-group">
                                <label for="user_id">아이디</label>
                                <input type="text" class="form-control" id="user_id" name="user_id">
                            </div>
                            <div class="form-group">
                                <label for="password">비밀번호</label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-secondary" data-dismiss="modal">취소</button>
                                <button class="btn btn-primary">로그인</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</body>
</html>