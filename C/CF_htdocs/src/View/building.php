<div class="content_wrap">
    <div class="content_title">
        <div class="content_title_circle"></div>
        <h3>시공 견적 요청</h3>
    </div>
    <div class="content_box" id="building_post_list">
        <button class="read_more" data-target="#building_post_popup" data-toggle="modal">견적 요청</button>
        <?php foreach($data[0] as $post):?>
        <?php $flag=true; if($_SESSION['user']->specialist == 1) foreach($data[1] as $request){if($post->id == $request->post_id) $flag = false;}?>
        <div class="review_card">
            <div class="review_card_info">
                <?php if($post->status == "requesting"):?>
                    <span class="badge badge-success float-right p-2">진행 중</span>
                <?php else:?>
                    <span class="badge badge-secondary float-right p-2">완료</span>
                <?php endif;?>
                <h5 class="review_title"><?=$post->user_name?>(<?=$post->user_id?>)</h5>
                <p class="pl-2 text-muted">시공일 : <?=$post->day?></p>
                <p class="pl-2">견적 개수 : <?=$post->num?>개</p>
            </div>
            <div class="review_card_body">
                <p class="p-2">" <?=nl2br(htmlentities($post->content))?> "</p>
                <?php if($_SESSION['user']->id == $post->writer_id):?>
                    <button class="btn btn-dark float-right building_see_btn" data-target="#building_see_popup" data-toggle="modal" data-id="<?=$post->id?>">견적 보기</button>
                <?php endif;?>
                <?php if($_SESSION['user']->id !== $post->writer_id && $_SESSION['user']->specialist == 1 && $flag):?>
                    <button class="btn btn-primary float-right building_request_btn" data-target="#building_request_popup" data-toggle="modal" data-id="<?=$post->id?>">견적 보내기</button>
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
    <div class="content_box" id="building_request_list">
    <?php foreach($data[1] as $request):?>
    <?php foreach($data[0] as $post){if($post->id == $request->post_id) $posting = $post;}?>
    <div class="review_card">
        <div class="review_card_info">
            <?php if($request->status == "requesting"):?>
                <span class="badge badge-success float-right p-2">진행 중</span>
            <?php elseif($request->status == "choose"):?>
                <span class="badge badge-primary float-right p-2">선택</span>
            <?php else:?>
                <span class="badge badge-secondary float-right p-2">미선택</span>
            <?php endif;?>
            <h5 class="review_title"><?=$posting->user_name?>(<?=$posting->user_id?>)</h5>
            <p class="pl-2 text-muted">시공일 : <?=$posting->day?></p>
            <p class="pl-2">입력한 비용 : <?=$request->price?>원</p>
        </div>
        <div class="review_card_body">
            <p class="p-2">" <?=nl2br(htmlentities($posting->content))?> "</p>
        </div>
        <div class="review_card_top"></div>
    </div>
    <?php endforeach;?>
    </div>
</div>
<?php endif;?>

<div id="building_see_popup" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-line"><div></div></div>
            <div class="modal-header">
                <h3 class="modal-title text-center w-100 d-block">견적 보기</h3>
            </div>
            <div class="modal-body" id="building_see_list">

            </div>
            <div class="modal-footer">
                <button class="footer_btn one_button" data-dismiss="modal">닫기</button>
            </div>
        </div>
    </div>
</div>

<div id="building_request_popup" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-line"><div></div></div>
            <div class="modal-header">
                <h3 class="modal-title text-center w-100 d-block">견적 보내기</h3>
            </div>
            <div class="modal-body">
                <form action="/building_request" method="post" name="building_request_form" id="building_request_form">
                    <div class="form-group">
                        <label for="price">비용</label>
                        <input type="number" name="price" class="form-control price_input" id="price" placeholder="비용을 입력해주세요.">
                    </div>
                    <input type="number" hidden name="post_id" id="post_id">
                    <button class="close" id="building_request_send"></button>
                </form>
            </div>
            <div class="modal-footer">
                <button class="footer_btn m-0" id="building_request_send_btn">입력 완료</button>
                <button class="footer_btn m-0" data-dismiss="modal">닫기</button>
            </div>
        </div>
    </div>
</div>

<div id="building_post_popup" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-line"><div></div></div>
            <div class="modal-header">
                <h3 class="modal-title text-center w-100 d-block">견적 요청</h3>
            </div>
            <div class="modal-body">
                <form action="/building_post" method="post" name="building_post_form" id="building_post_form">
                    <div class="form-group">
                        <label for="day">시공일</label>
                        <input type="date" name="day" id="day" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="content">내용</label>
                        <textarea name="content" id="content" cols="30" rows="5" placeholder="내용을 입력해주세요." class="form-control"></textarea>
                    </div>
                    <button class="close" id="building_post_send" type="button"></button>
                </form>
            </div>
            <div class="modal-footer">
                <button class="footer_btn m-0" id="building_post_btn">작성 완료</button>
                <button class="footer_btn m-0" data-dismiss='modal'>닫기</button>
            </div>
        </div>
    </div>
</div>
