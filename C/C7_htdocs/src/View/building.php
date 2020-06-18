<div class="content_wrap">
    <div class="content_title">
        <div class="content_title_circle"></div>
        <h3>시공 견적 요청</h3>
    </div>
    <div class="content_box" id="post_list">
        <button class="read_more" data-target="#building_write_popup" data-toggle="modal">견적 요청</button>
        <?php foreach($data[0] as $post):?>
        <?php $flag = true; foreach($data[1] as $request){if($request->post_id == $post->id) $flag =false;}?>
        <div class="review_card">
            <div class="review_card_info">
                <?php if($post->status == "requesting"):?>
                    <span class="badge badge-success p-2 float-right">진행 중</span>
                <?php else:?>
                    <span class="badge badge-secondary p-2 float-right">완료</span>
                <?php endif;?>
                <h5 class="review_title"><?=$post->user_name?>(<?=$post->user_id?>)</h5>
                <p class="pl-2 text-muted">시공일 : <?=$post->day?></p>
                <p class="score">견적 개수 : <?=$post->num?>개</p>
            </div>
            <div class="review_card_body">
                <p class="p-4">" <?=nl2br(htmlentities($post->content))?> "</p>
                <?php if($_SESSION['user']->id == $post->writer_id):?>
                    <button class="float-right btn btn-dark building_see_btn" data-target="#building_see_popup" data-toggle='modal' data-id="<?=$post->id?>">견적 보기</button>
                <?php endif;?>
                <?php if($_SESSION['user']->specialist == 1 && $_SESSION['user']->id !== $post->writer_id && $flag && $post->status == "requesting"):?>
                    <button class="btn btn-primary building_request_open_btn float-right" data-target="#building_request_popup" data-toggle="modal" data-id="<?=$post->id?>">견적 보내기</button>
                <?php endif;?>
            </div>
            <div class="review_card_top"></div>
        </div>
        <?php endforeach;?>
    </div>
</div>

<?php if($_SESSION['user']->specialist == 1):?>
<div class="content_wrap">
    <div class="content_title">
        <div class="content_title_circle"></div>
        <h3>보낸 견적</h3>
    </div>
    <div class="content_box" id="request_list">
        <?php foreach($data[1] as $request):?>
        <div class="review_card">
            <div class="review_card_info">
                <?php if($request->status == "requesting"):?>
                    <span class="badge badge-success p-2 float-right">진행 중</span>
                <?php elseif($request->status == "choose"):?>
                    <span class="badge badge-primary p-2 float-right">선택</span>
                <?php else:?>
                    <span class="badge badge-secondary p-2 float-right">미선택</span>
                <?php endif;?>
                <h5 class="review_title"><?=$request->user_name?>(<?=$request->user_id?>)</h5>
                <p class="pl-2 text-muted">시공일 : <?=$request->day?></p>
                <p class="pl-2 pt-1">입력한 비용 : <?=$request->price?>원</p>
            </div>
            <div class="review_card_body">
                <p class="p-2">" <?=nl2br(htmlentities($request->content))?> "</p>
            </div>
            <div class="review_card_top"></div>
        </div>
        <?php endforeach;?>
    </div>
</div>
<?php endif;?>

<div id="building_write_popup" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h3 class="modal-title text-white">견적 요청</h3>
                <button class="close text-white" data-dismiss='modal'>&times;</button>
            </div>
            <div class="modal-body">
                <form action="/building_post" method="post" name="building_write_form" id="building_write_form">
                    <div class="form-group">
                        <label for="day">시공일</label>
                        <input type="date" id="day" name="day" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="content">내용</label>
                        <textarea name="content" id="content" cols="30" rows="5" class="form-control"></textarea>
                    </div>
                    <button class="close" id="building_write_send" type="button"></button>
                </form>
            </div>
            <div class="modal-footer bg-light">
                <button class="btn btn-primary" id="building_write_btn">작성 완료</button>
                <button class="btn btn-secondary" data-dismiss="modal">닫기</button>
            </div>
        </div>
    </div>
</div>

<div id="building_request_popup" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h3 class="modal-title text-white">견적 보내기</h3>
                <button class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="/building_request" method="post" name="building_request_form" id="building_request_form">
                    <div class="form-group">
                        <label for="price">비용</label>
                        <input type="number" id="price" name="price" class="form-control">
                    </div>
                    <input type="number" name="post_id" id="post_id" hidden>
                    <button class="close" id="building_request_send" type="button"></button>
                </form>
            </div>
            <div class="modal-footer bg-light">
                <button class="btn btn-primary" id="building_request_btn">입력 완료</button>
                <button class="btn btn-secondary" data-dismiss="modal">닫기</button>
            </div>
        </div>
    </div>
</div>

<div id="building_see_popup" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h3 class="modal-title text-white">받은 견적</h3>
                <button class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="building_request_list">
                
            </div>
            <div class="modal-footer bg-light">
                <button class="btn btn-secondary" data-dismiss='modal'>닫기</button>
            </div>
        </div>
    </div>
</div>