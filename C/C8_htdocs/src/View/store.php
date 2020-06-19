<!-- Store -->
<div class="content_wrap" id="store_wrap">
                <div class="content_title">
                    <div class="content_title_circle"></div>
                    <h3>스토어</h3>
                </div>
                <div class="content_box" id="store_area">
                    <div id="store_header">
                        <div id="search">
                            <input type="search" placeholder="검색어를 입력해주세요." id="search_form">
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

            <!-- 장바구니 -->
            <div class="content_wrap" id="basket_wrap">
                <div class="content_title">
                    <div class="content_title_circle"></div>
                    <h3>장바구니</h3>
                </div>
                <div class="content_box" id="basket_area">
                    <table class="table bg-white m-0 rounded-top">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th></th>
                                <th>상품명</th>
                                <th>브랜드명</th>
                                <th>가격</th>
                                <th>수량</th>
                                <th>합계</th>
                                <th><i class="fa fa-plus text-secondary float-right mr-2"></i></th>
                            </tr>
                        </thead>
                        <tbody id="basket_list">
                            
                        </tbody>
                    </table>
                    <div id="basket_box" class="bg-light p-2 border-top rounded-bottom">
                        <p>총합계 : <span id="basket_price">0</span>원</p>
                        <button id="basket_sell" data-toggle='modal' data-target="#basket_popup">구매하기</button>
                    </div>

                    <div id="basket_popup" class="modal fade">
                        <div class="modal-dialog">
                            <div class="modal-content border-0 rounded">
                                <div class="modal-line"><div></div></div>
                                <div class="modal-header border-bottom m-2">
                                    <h3 class="modal-title text-center">장바구니</h3>
                                </div>
                                <div class="modal-content p-4">
                                    <form name='basket_form' id="basket_form">
                                        <div class="form-group">
                                            <label for="name">이름</label>
                                            <input type="text" id="name" name='name' class="form-control" placeholder="이름을 입력해주세요.">
                                        </div>
                                        <div class="form-group">
                                            <label for="port">주소</label>
                                            <input type="text" id="port" name='port' class="form-control" placeholder="주소를 입력해주세요.">
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button class="m-0 footer_btn" id="basket_sell_btn">구매 완료</button>
                                    <button class="m-0 footer_btn" id="basket_close" data-dismiss="modal">닫기</button>
                                    <button class="close" id="recepit_open" data-target="#recepit_popup" data-toggle="modal"></button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="recepit_popup" class="modal fade">
                        <div class="modal-dialog">
                            <div class="modal-content border-0 rounded">
                                <div class="modal-line"><div></div></div>
                                <div class="modal-body">
                                    <canvas id="recepit"></canvas>
                                </div>
                                <div class="modal-footer">
                                    <button class="footer_btn one_button" data-dismiss="modal">닫기</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <script src="resources/js/store.js"></script>