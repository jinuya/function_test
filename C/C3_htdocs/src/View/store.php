
<script src="resources/js/app.js"></script>
<!-- 콘텐츠 -->
<div id="content">
            
            <div class="content_wrap">
                
                <div class="content_title">
                    <div class="content_title_line"></div>
                    <h2>Store</h2>
                </div>

                <div class="content_box position-relative" id="store">
                    
                    <div id="search">
                        <input type="text" id="search_form" placeholder="검색할 단어를 입력해주세요.">
                        <button id="search_btn"><i class="fa fa-search text-white"></i></button>
                    </div>

                    <div id="drop_box">
                        <div id="drop_title"><i class="fa fa-shopping-cart"></i></div>
                        <div id="drop_area">이곳에 상품을 넣어주세요</div>
                    </div>

                    <div id="item_list">
                        
                    </div>
                </div>

            </div>

            <div class="content_wrap bg-light" id="store_page">

                <div class="content_title">
                    <div class="content_title_line"></div>
                    <h2 class="bg-light">장바구니</h2>
                </div>

                <div class="content_box" id="basket">
                    <div id="basket_list">
                        <table class="table bg-white m-0">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th></th>
                                    <th scope="col">상품명</th>
                                    <th scope="col">브랜드</th>
                                    <th scope="col">가격</th>
                                    <th scope="col">수량</th>
                                    <th scope="col">합계</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="basket_list_area">
                            </tbody>
                        </table>
                    </div>
                    <div id="basket_price_box" class="bg-secondary text-white p-3 rounded-bottom">총 금액 : <span id="basket_price" class="text-white">0</span>원<button class="btn btn-primary float-right line" id="basket_sell_btn" data-target="#basket_popup" data-toggle="modal">구매하기</button></div>
                </div>
            </div>
        </div>
        <div id="basket_popup" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content border-0">
                    <div class="modal-header bg-dark">
                        <h2 class="modal-title text-white">구매하기</h2>
                        <button class="close text-white" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form name="basket_form" id="basket_form">
                            <div class="form-group">
                                <label for="basket_name">이름</label>
                                <input type="text" id="basket_name" name="basket_name" placeholder="이름을 입력해 주세요." class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="basket_port">주소</label>
                                <input type="text" id="basket_port" name="basket_port" placeholder="주소를 입력해 주세요." class="form-control">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer bg-light">
                        <button class="btn btn-secondary" id="basket_sell_close" data-dismiss="modal">취소</button>
                        <button class="btn btn-primary" id="basket_sell">구매 완료</button>
                    </div>
                </div>
            </div>
        </div>
        <button class="close" id="receipt_open" data-target="#receipt_modal" data-toggle="modal"></button>
        <div class="modal fade" id="receipt_modal">
            <div class="modal-dialog">
                <div class="modal-content border-0">
                    <div class="modal-header bg-dark">
                        <h2 class="modal-title text-white">영수증</h2>
                        <button class="close text-white" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <canvas id="receipt" class="border border-dark"></canvas>
                    </div>
                    <div class="modal-footer bg-light">
                        <button class="btn btn-secondary" data-dismiss="modal">확인</button>
                    </div>
                </div>
            </div>
        </div>