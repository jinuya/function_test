<script src="resources/js/store.js"></script>
<!-- store -->
<div class="content_wrap" id="store_wrap">
                <div class="content_title">
                    <div class="content_title_circle"></div>
                    <h3>스토어</h3>
                </div>
                <div class="content_box" id="store_area">
                    <div id="store_header">
                        <div id="search">
                            <input type="text" id="search_form" placeholder="검색어를 입력해주세요.">
                            <button id="search_btn"><i class="fa fa-search text-white"></i></button>
                        </div>

                        <div id="drop_box">
                            <div id="drop_title"><i class="fa fa-shopping-cart text-white"></i></div>
                            <div id="drop_area">이곳에 상품을 넣어주세요.</div>
                        </div>
                    </div>

                    <div id="store_body">
                        <div id="store_list">
                            
                        </div>
                    </div>

                </div>
            </div>

            <div class="content_wrap" id="basket_wrap">
                <div class="content_title">
                    <div class="content_title_circle"></div>
                    <h3>장바구니</h3>
                </div>
                <div class="content_box" id="basket_area">
                    <table class="table bg-white m-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th></th>
                                <th>상품명</th>
                                <th>브랜드명</th>
                                <th>가격</th>
                                <th>수량</th>
                                <th>합계</th>
                                <th><i class="fa fa-plus text-muted"></i></th>
                            </tr>
                        </thead>
                        <tbody id="basket_list">
                        </tbody>
                    </table>

                    <div id="basket_box" class="bg-light border-top">
                        <p>총합계 : <span id="basket_price">0</span>원</p>
                        <button class="btn btn-primary" data-target="#basket_popup" data-toggle="modal">구매하기</button>
                    </div>
                </div>
            </div>

            <div id="basket_popup" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-info">
                            <h4 class="modal-title text-white">구매하기</h4>
                            <button class="close text-white" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <form name="basket_form" id="basket_form">
                                <div class="form-group">
                                    <label for="name">이름</label>
                                    <input type="text" id="name" name="name" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="port">주소</label>
                                    <input type="text" id="port" name="port" class="form-control">
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer bg-light">
                            <button class="btn btn-primary" id="basket_sell_btn">구매 완료</button>
                            <button class="btn btn-secondary" id="basket_popup_close" data-dismiss="modal">닫기</button>
                        </div>
                    </div>
                </div>
            </div>

            <button class="close" id="recepit_open" data-target="#recepit_popup" data-toggle="modal"></button>

            <div id="recepit_popup" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <canvas id="recepit"></canvas>
                        </div>
                        <div class="modal-footer bg-light">
                            <button class="btn btn-primary pr-2 pl-2" data-dismiss="modal">닫기</button>
                        </div>
                    </div>
                </div>
            </div>