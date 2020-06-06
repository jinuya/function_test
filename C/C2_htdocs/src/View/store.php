<script src="resources/js/app.js"></script>
<div id="content">
            <div id="store" class="content_box">
                <h2>Store</h2>
                <div class="content_word">
                    <div id="search">
                        <input type="text" name="search_form" id="search_form" placeholder="검색어를 입력하세요.">
                        <button id="search_btn"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </div>
            <div class="content_box" id="itemList">
                <div id="drop_box">
                    <h2 id="drop_title"><i class="fa fa-shopping-cart"></i></h2>
                    <div id="item_drop">이곳에 상품을 넣어주세요.</div>
                </div>
                <div class="content_word">
                    <div id="item_list">
                        <div class="item">
                            <div class="item_img">
                                <img src="resources/images/product_1.jpg" alt="item_img">
                            </div>
                            <div class="item_info">
                                <p class="item_name">이름</p>
                                <p class="item_brand">브랜드</p>
                                <p class="item_price">가격</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="item_box" class="content_box">
                <h2>장바구니</h2>
                <div class="content_word">
                    <div id="item_box_list">
                        <div class="item">
                            <button class="item_box_del"><i class="fa fa-close"></i></button>
                            <div class="item_img">
                                <img src="resources/images/product_1.jpg" alt="item_img">
                            </div>
                            <div class="item_info">
                                <p class="item_number_box">수량 : <span class="item_number">0</span></p>
                                <p class="item_name">이름</p>
                                <p class="item_brand">브랜드</p>
                                <p class="item_price">가격</p>
                            </div>
                        </div>
                    </div>
                    <p id="item_allprice_box">총합계 : <span id="item_allprice">0</span>원<button id="item_allprice_btn" class="btn btn-light" data-toggle="modal" data-target="#buyer_popup">구매하기</button></p>
                </div>
            </div>
        </div>

        <div class="modal fade" id="buyer_popup">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title">구매하기</h2>
                        <button class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form id="buyer_form">
                            <div class="form-group">
                                <label for="buyer_name">이름</label>
                                <input type="text" class="form-control" id="buyer_name" placeholder="이름을 입력해주세요.">
                            </div>
                            <div class="form-group">
                                <label for="buyer_address">주소</label>
                                <input type="text" class="form-control" id="buyer_address" placeholder="주소를 입력해주세요.">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" id="buy_close" data-dismiss="modal">취소</button>
                        <button class="btn btn-primary" id="buy_btn">구매완료</button>
                    </div>
                </div>
            </div>
        </div>