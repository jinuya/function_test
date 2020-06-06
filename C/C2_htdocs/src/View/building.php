<div id="content">
    <div class="content_box" id="building">
        <h2>시공 견적</h2>
        <div class="content_word position-relative">
            <button class="btn btn-primary position-absolute" id="building_btn" data-target="#building_popup" data-toggle="modal">견적 요청</button>
            <?php foreach($data[0] as $list):?>
                <?php $flag = true;?>
                <?php foreach($data[1] as $requesting){if($requesting->id == $list->id){$flag = false;}}?>
                <div class="card m-2">
                    <div class="card-body">
                        <?php if($list->status == "requesting"):?>
                            <span class="badge badge-success float-right p-2">진행 중</span>
                        <?php else:?>
                            <span class="badge badge-secondary float-right p-2">완료</span>
                        <?php endif;?>
                        <h4 class="card-title"><?= $list->user_name?>(<?=$list->user_id?>)</h4>
                        <p class="card-subtitle text-muted">시공일 : <?=$list->day?></p>
                        <hr>
                        <p class="card-text">
                            <?=$list->content?>
                        </p>
                    </div>
                    <div class="card-footer">
                        <p class="card-text d-inline-block">견적 : <?=$list->number?>개</p>
                        <?php if($_SESSION['user']->specialist == 1 && $list->status == "requesting" && $flag):?>
                            <button class="btn btn-primary building_btn float-right" data-toggle="modal" data-target="#buildingRequesting_popup" data-id="<?=$list->id?>">견적 보내기</button>
                        <?php endif;?>
                        <?php if($_SESSION['user']->id == $list->writer_id):?>
                        <button class="btn btn-dark building_watching float-right" data-target="#buildingReauesting_watch_popup" data-toggle="modal" data-id="<?=$list->id?>">견적 보기</button>
                        <?php endif;?>
                    </div>
                </div>
            <?php endforeach;?>
        </div>
    </div>
    <?php if($_SESSION['user']->specialist == 1):?>
        <div class="content_box" id="requesting">
            <h2>보낸 견적</h2>
            <div class="content_word">
                <?php foreach($data[1] as $requset):?>
                    <div class="card m-2">
                        <div class="card-body">
                            <?php if($requset->status == "requesting"):?>
                                <span class="badge badge-success float-right p-2">진행 중</span>
                            <?php elseif($requset->status == "choose"):?>
                                <span class="badge badge-info float-right p-2">선택</span>
                            <?php else:?>
                                <span class="badge badge-secondary float-right p-2">미선택</span>
                            <?php endif;?>
                            <h4 class="card-title"><?= $requset->user_name?>(<?=$requset->user_id?>)</h4>
                            <p class="card-subtitle text-muted">시공일 : <?=$requset->day?></p>
                            <hr>
                            <p class="card-text">
                                <?=$requset->content?>
                            </p>
                        </div>
                        <div class="card-footer">
                            <p class="card-text d-inline-block">비용 : <?=$requset->price?>원</p>
                        </div>
                    </div>
                <?php endforeach;?>
            </div>
        </div>
    <?php endif;?>
</div>

<div id="building_popup" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content overflow-hidden border-0 rounded">
            <div class="modal-header bg-dark rounded-0">
                <h4 class="modal-title text-white">견적 요청</h4>
                <button class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="/BuildingSend" method="post" name="building_send_form" id="building_send_form">
                    <div class="form-group">
                        <label for="building_day">시공일</label>
                        <input type="date" class="form-control" id="building_day" name="building_day">
                    </div>
                    <div class="form-group">
                        <label for="building_content">내용</label>
                        <textarea cols="20" rows="5" class="form-control" id="building_content" name="building_content"></textarea>
                    </div>
                    <button class="close" id="building_send"></button>
                </form>
            </div>
            <div class="modal-footer bg-light">
                <button class="btn btn-secondary" data-dismiss="modal">취소</button>
                <button class="btn btn-primary" id="building_send_btn">작성 완료</button>
            </div>
        </div>
    </div>
</div>

<div id="buildingRequesting_popup" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content overflow-hidden border-0 rounded">
            <div class="modal-header bg-dark rounded-0">
                <h4 class="modal-title text-white">견적 보내기</h4>
                <button class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="/BuildingRequestingSend" method="post" name="building_requesting_form" id="building_requesting_form">
                    <div class="form-group">
                        <label for="requesting_price">비용</label>
                        <input type="number" class="form-control" name="requesting_price" id="requesting_price" min="0">
                    </div>
                    <input type="number" name="post_id" id="post_id" hidden>
                    <button id="building_requesting_send" class="close"></button>
                </form>
            </div>
            <div class="modal-footer bg-light">
                <button class="btn btn-secondary" data-dismiss="modal">취소</button>
                <button class="btn btn-primary" id="building_requesting_send_btn">입력 완료</button>
            </div>
        </div>
    </div>
</div>

<div id="buildingReauesting_watch_popup" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content border-0">
            <div class="modal-header bg-dark rounded-0">
                <h4 class="modal-title text-white">견적 보기</h4>
                <button class="close text-white" id="buildingReauesting_watch_popup_close" data-dismiss = "modal">&times;</button>
            </div>
            <div class="modal-body" id="building_list"></div>
        </div>
    </div>
</div>