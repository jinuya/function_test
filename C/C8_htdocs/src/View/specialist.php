<div class="content_wrap">
    <div class="content_title">
        <div class="content_title_circle"></div>
        <h3>전문가</h3>
    </div>
    <div class="content_box" id="speicalist_list">
    <?php foreach ($data[0] as $info):?>
    <?php foreach ($data[1] as $score){if($score->specialist_id == $info->id) $src = $score->score;}?>
    <div class="specialist_card">
        <div class="specialist_card_img"><img src="resources/user_img/<?=$info->img?>" title="specialist_img" alt="specialist_img"></div>
        <div class="specialist_card_back">
            <h5><?=$info->user_name?></h5>
            <p><?=$info->user_id?></p>
            <span><i class="fa fa-star text-warning"></i>(<?=$src?>)<span></span></span>
            <button data-target="#review_popup" data-toggle="modal" class="review_add_btn" data-id="<?=$info->id?>">시공 후기 작성</button>
            <div class="specialist_border"><div></div></div>
        </div>
    </div>
    <?php endforeach;?>
    </div>
</div>

<div id="review_popup" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-line"><div></div></div>
            <div class="modal-header">
                <h3 class="modal-title text-center d-block">시공 후기 작성</h3>
            </div>
            <div class="modal-body">
                <form action="/review_write" method="post" name="review_form" id="review_form">
                    <div class="form-group">
                        <label for="price">비용</label>
                        <input type="number" id="price" name="price" placeholder='비용을 입력해주세요.' require class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="content">내용</label>
                        <textarea name="content" id="content" cols="30" rows="5" placeholder="내용을 입력해주세요." class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="score">평점</label>
                        <select name="score" id="score" class="form-control">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                    <input type="number" name="specialist_id" hidden id="specialist_id">
                    <button class="close" id="review_send" type="button"></button>
                </form>
            </div>
            <div class="modal-footer">
                <button class="footer_btn" id="review_btn">작성 완료</button>
                <button class="footer_btn" data-dismiss="modal">닫기</button>
            </div>
        </div>
    </div>
</div>

<div class="content_wrap">
    <div class="content_title">
        <div class="content_title_circle"></div>
        <h3>시공 후기</h3>
    </div>
    <div class="content_box" id="review_list">
    <?php foreach($data[2] as $review):?>
    <?php foreach($data[0] as $info){if($info->id == $review->specialist_id) $speicalist = $info;}?>
    <div class="review_card">
        <div class="review_card_info">
            <h5 class="review_title"><?=$speicalist->user_name?>(<?=$speicalist->user_id?>)</h5>
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