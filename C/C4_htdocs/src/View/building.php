<div id="content">
    <div class="content_wrap">
        <div class="content_title">
            <div class="content_title_line"></div>
            <h2>시공 견적</h2>
        </div>
        <button class="btn btn-primary" data-target="#building_post_popup" id="building_post_btn" data-toggle="modal">견적 요청</button>
        <div class="content_box" id="building_list">
            <?php foreach($data[0] as $item):?>
                <div class="card m-2">
                    <div class="card-body">
                        <?php if($item->status == "requesting"):?>
                            <span class="badge badge-success">진행중</span>
                        <?php else:?>
                            <span class="badge badge-secondary">완료</span>
                        <?php endif;?>
                        <h5 class="card-title"><?=$item->user_name?>(<?=$item->user_id?>)</h5>
                        <p class="card-subtitle text-muted">시공일 : <?=$item->day?></p>
                        <hr>
                        <p class="card-text"><?=nl2br(htmlentities($item->content))?></p>
                        <hr>
                        <?php if($item->status == "requesting" && $_SESSION['user']->id == $item->writer_id):?>
                            <button class="btn btn-dark building_see_btn" data-id="<?=$item->id?>" data-target="#building_see_popup" data-toggle="modal">견적 보기</button>
                        <?php endif;?>
                        <?php if($item->status == "requesting" && $_SESSION['user']->specialist == 1):?>
                            <button class="btn btn-primary building_request_btn" data-id = "<?=$item->id?>" data-target="#building_request_popup" data-toggle="modal">견적 보내기</button>
                        <?php endif;?>
                    </div>
                </div>
            <?php endforeach;?>
        </div>
    </div>
</div>

<div id="building_post_popup" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title text-white">견적 요청</h5>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="/building_post" method="post" id="building_post_form" name="building_post_form">
                    <div class="form-group">
                        <label for="day">시공일</label>
                        <input type="date" id="day" name="day" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="content">내용</label>
                        <textarea name="content" id="content" class="form-control" cols="30" rows="5"></textarea>
                    </div>
                    <button class="close" id="building_post_send"></button>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">닫기</button>
                <button class="btn btn-primary" id="building_post_send_btn">작성 완료</button>
            </div>
        </div>
    </div>
</div>

<div id="building_request_popup" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title text-white">견적 보내기</h5>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="/building_request" name="building_request_form" id="building_request_form" method="post">
                    <div class="form-group">
                        <label for="price">비용</label>
                        <input type="number" name="price" id="price" class="form-control">
                        <input type="number" name="post_id" id="post_id" hidden>
                        <button class="close" id="building_request_send"></button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">닫기</button>
                <button class="btn btn-primary" id="building_request_btn">입력 완료</button>
            </div>
        </div>
    </div>
</div>

<div id="building_see_popup" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h4 class="modal-title text-white">받은 견적</h4>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="building_request_list">
                
            </div>
            <div class="modal-footer bg-light">
                <button class="btn btn-secondary" data-dismiss="modal">닫기</button>
            </div>
        </div>
    </div>
</div>