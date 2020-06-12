<!-- 콘텐츠 -->
<div id="content">

    <div class="content_wrap">
        <div class="content_title">
            <div class="content_title_line"></div>
            <h2>시공 견적 요청</h2>
        </div>
        <button class="btn btn-primary float-right" data-target="#building_post_popup" data-toggle="modal">견적 요청</button>
        <div class="content_box" id="bp_list">
            <?php foreach($data[0] as $item):?>
                <?php $flag = true; ?>
                <div class="card mt-4 rounded-0">
                    <div class="card-body">
                        <?php if($item->status == "requesting"): ?>
                            <span class="badge badge-success float-right p-2">진행중</span>
                        <?php else:?>
                            <span class="badge badge-secondary float-right p-2">완료</span>
                        <?php endif;?>
                        <h4 class="card-title"><?=$item->user_name?>(<?=$item->user_id?>)</h4>
                        <p class="card-sub-title text-muted">시공일 : <?=$item->day?></p>
                        <hr>
                        <p class="card-text"><?=nl2br(htmlentities($item->content)) ?></p>
                        <hr>
                        <?php if($item->writer_id == $_SESSION['user']->id):?>
                            <button data-target="#building_watch_popup" data-toggle="modal" class="btn btn-dark building_watch_btn float-right" data-id="<?=$item->id?>">견적 보기</button>
                        <?php endif;?>
                        <?php foreach($data[1] as $id) if($id->post_id == $item->id) $flag = false;?>
                        <?php if($_SESSION['user']->specialist == 1 && $item->status == "requesting" && $flag):?>
                            <button data-target="#building_request_popup" data-toggle="modal" class="btn btn-primary building_request_btn float-right" data-id="<?=$item->id?>">견적 보내기</button>
                        <?php endif;?>
                    </div>
                </div>
            <?php endforeach;?>
        </div>
    </div>

    <?php if($_SESSION['user']->specialist == 1): ?>
    <div class="content_wrap">
        <div class="content_title">
            <div class="content_title_line"></div>
            <h2>보낸 견적</h2>
        </div>

        <div class="content_box" id="br_list">
            <?php foreach($data[1] as $item):?>
                <div class="card mt-4 rounded-0">
                    <div class="card-body">
                        <?php if($item->status == "requesting"):?>
                            <span class="badge badge-success float-right p-2">진행 중</span>
                        <?php elseif($item->status == "accept"):?>
                            <span class="badge badge-primary float-right p-2">선택</span>
                        <?php else:?>
                            <span class="badge badge-secondary float-right p-2">미선택</span>
                        <?php endif;?>
                        <h4 class="card-title"><?=$item->user_name?>(<?=$item->user_id?>)</h4>
                        <p class="card-sub-title text-muted">시공일 : <?=$item->day?></p>
                        <hr>
                        <p class="card-text"><?= nl2br(htmlentities($item->content))?></p>
                        <hr>
                        <h6 class="card-sub-title">비용 : <?=$item->price?>원</h6>
                    </div>
                </div>
            <?php endforeach;?>
        </div>
    </div>
    <?php endif;?>
</div>

<div id="building_watch_popup" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content border-0">
            <div class="modal-header bg-dark">
                <h2 class="modal-title text-white">받은 견적</h2>
                <button class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="building_request_watch_list">
                
            </div>
            <div class="modal-footer bg-light">
                <div class="button btn btn-secondary" data-dismiss="modal">닫기</div>
            </div>
        </div>
    </div>
</div>

<div id="building_request_popup" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content border-0">
            <div class="modal-header bg-dark">
                <h2 class="modal-title text-white">견적 보내기</h2>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="/buildingRequest" method="post" id="building_request_form" name="building_request_form">
                    <div class="form-group">
                        <label for="price">비용</label>
                        <input type="number" name="price" id="price" class="form-control">
                    </div>
                    <input type="number" name="post_id" id="post_id" hidden>
                    <button class="close" id="building_request_send"></button>
                </form>
            </div>
            <div class="modal-footer bg-light">
                <button class="btn btn-secondary" data-dismiss="modal">취소</button>
                <button class="btn btn-primary" id="building_request_btn">입력 완료</button>
            </div>
        </div>
    </div>
</div>

<div id="building_post_popup" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content border-0">
            <div class="modal-header bg-dark">
                <h2 class="modal-title text-white">견적 요청</h2>
                <button class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="/buildingPost" method="post" id="building_post_form" name="building_post_form">
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
            <div class="modal-footer bg-light">
                <button class="btn btn-secondary" data-dismiss="modal">취소</button>
                <button class="btn btn-primary" id="building_post_btn">작성 완료</button>
            </div>
        </div>
    </div>
</div>