<div class="content_wrap">
    <div class="content_title">
        <div class="content_title_circle"></div>
        <h3>전문가</h3>
    </div>
    <div class="content_box" id="specialist_list">
        <?php foreach($data[0] as $post):?>
        <?php $value = "0"; foreach($data[1] as $val) if($val->specialist_id == $post->id) $value = $val->score?>
        <div class="specialist_card">
            <div class="specialist_card_img"><img src="resources/user_img/<?=$post->img?>" title="specialist_img" alt="specialist_img"></div>
            <div class="specialist_card_back">
                <h5><?=$post->user_name?></h5>
                <p><?=$post->user_id?></p>
                <span><i class="fa fa-star text-warning pr-2"></i>(<?=$value?>)<span></span></span>
                <button data-target="#review_popup" class="review_btn" data-toggle='modal' data-id="<?=$post->id?>">시공 후기작성</button>
                <div class="specialist_border"><div></div></div>
            </div>
        </div>
        <?php endforeach?>
    </div>
</div>

<div class="content_wrap">
    <div class="content_title">
        <div class="content_title_circle"></div>
        <h3>시공 후기</h3>
    </div>
    <div class="content_box" id="review_list">
        <?php foreach($data[2] as $review):?>
        <?php foreach($data[0] as $info){if($info->id == $review->specialist_id) $specialist = $info;}?>
            <div class="review_card">
                <div class="review_card_info">
                    <h5 class="review_title"><?=$specialist->user_name?>(<?=$specialist->user_id?>)</h5>
                    <p class="pl-2 text-muted">비용 : <?=$review->price?>원</p>
                    <div class="score"><i class="fa fa-star text-warning"></i>(<?=$review->score?>)</div>
                </div>
                <div class="review_card_body">
                    <p class="p-2">" <?=nl2br(htmlentities($review->content))?> "</p>
                    <p class="text-muted text-right">- <?=$review->user_name?>(<?=$review->user_id?>)</p>
                </div>
                <div class="review_card_top"></div>
            </div>
        <?php endforeach;?>
    </div>
</div>

<div id="review_popup" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h3 class="modal-title text-white">시공 후기 작성</h3>
                <button class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="/reviewwrite" method="post" name="review_form" id="review_form">
                    <div class="form-group">
                        <label for="price">비용</label>
                        <input type="number" min="1" id="price" name="price" class="form-control review_form_price">
                    </div>
                    <div class="form-group">
                        <label for="content">내용</label>
                        <textarea name="content" id="content" cols="30" rows="5" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="val">평점</label>
                        <select name="val" id="val" class="form-control">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                    <input type="number" name="specialist_id" hidden id="specialist_id">
                    <button id="review_send" class='close' type="button"></button>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" id="review_write_btn">작성 완료</button>
                <button class="btn btn-secondary" data-dismiss="modal">닫기</button>
            </div>
        </div>
    </div>
</div>