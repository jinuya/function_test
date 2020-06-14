<script src="resources/js/store.js"></script>
<!-- 콘텐츠 -->
<div id="content">
            
            <div class="content_wrap">
                
                <div class="content_title">
                    <div class="content_title_line"></div>
                    <h2>Store</h2>
                </div>

                <div class="content_box" id="store_area">
                    <div id="store_header">
                        <div id="search">
                            <input type="text" id="search_form" placeholder="검색어를 입력해주세요.">
                            <button id="search_btn"><i class="fa fa-search"></i></button>
                        </div>

                        <div id="drop_box">
                            <div id="drop_title"><i class="fa fa-shopping-cart"></i></div>
                            <div id="drop_area" class="text-center">
                                이곳에 상품을 넣어주세요.
                            </div>
                        </div>
                    </div>
                    <div id="store_list">
                        
                    </div>
                </div>
            </div>

            <div class="content_wrap">
                <div class="content_title">
                    <div class="content_title_line"></div>
                    <h2>장바구니</h2>
                </div>

                <div class="content_box" id="basket_area">
                    <table class="table m-0">
                        <thead class="bg-light">
                            <tr>
                                <th>#</th>
                                <th></th>
                                <th>상품</th>
                                <th>브랜드</th>
                                <th>가격</th>
                                <th>수량</th>
                                <th>합계</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white" id="basket_list">
                        </tbody>
                    </table>

                    <div id="sell_box" class="bg-light border-top rounded-bottom"> 총 합계 : <span id="sell_price">0</span>원 <button class="btn btn-dark" id="basket_btn" data-target="#basket_popup" data-toggle="modal">구매하기</button> </div>
                </div>
            </div>

        </div>

        <div id="basket_popup" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <h2 class="modal-title text-white">구매하기</h2>
                        <button class="close text-white" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form id="basket_form" name="basket_form">
                            <div class="form-group">
                                <label for="name">이름</label>
                                <input type="text" id="name" class="form-control" placeholder="이름을 입력해주세요.">
                            </div>
                            <div class="form-group">
                                <label for="port">주소</label>
                                <input type="text" id="port" class="form-control" placeholder="주소를 입력해주세요.">
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
        <button class="close" data-target="#recepit_popup" data-toggle="modal" id="recepit_btn"></button>
        <div id="recepit_popup" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-info">
                        <h2 class="modal-title text-white">영수증</h2>
                        <button class="close text-white" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <canvas id="recepit"></canvas>
                    </div>
                    <div class="modal-footer bg-light">
                        <button class="btn btn-secondary" data-dismiss="modal">닫기</button>
                    </div>
                </div>
            </div>
        </div>