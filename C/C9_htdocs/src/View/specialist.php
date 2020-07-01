<div class="content_wrap">
    <div class="content_title">
        <div class="content_title_circle"></div>
        <h3>전문가</h3>
    </div>
    <div class="content_box" id="specialist_list">
    <?php foreach($data[0] as $item):?>
    <?php foreach($data[1] as $src) if($src->specialist_id == $item->id) $score = $src->avg;?>
    <div class="specialist_card">
        <div class="specialist_img">
            <img src="resources/user_img/<?=$item->img?>" alt="specialist_img" title="specialist_img">
        </div>
        <div class="specialist_back">
            <h5><?=$item->user_id?></h5>
            <p><?=$item->user_name?></p>
            <span class="specialist_score"><i class="fa fa-star text-warning specialist_score"></i> (<?=$score?>)<span></span> </span>
            <button class="specialist_button review_open" data-target="#review_popup" data-toggle="modal" data-id="<?=$item->id?>">시공 후기 작성</button>
            <div class="specialist_card_line"><div></div></div>
        </div>
    </div>
    <?php endforeach;?>
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
            <div class="review_card_header">
                <h5><?=$specialist->user_name?>(<?=$specialist->user_id?>)</h5>
                <p class="text-muted">비용 : <?=$review->price?> 원</p>
                <p><i class="fa fa-star text-warning mr-1"></i>(<?=$review->val?>)</p>
            </div>
            <div class="review_card_body">
                <p class="p-2">" <?=nl2br(htmlentities($review->content))?> "</p>
                <p class="text-right">- <?=$review->user_name?>(<?=$review->user_id?>)</p>
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
                <h3 class="modal-title text-center w-100 d-block">시공 후기 작성</h3>
            </div>
            <div class="modal-body">
                <form action="/review_write" method="post" name="review_form" id="review_form">
                    <div class="form-group">
                        <label for="price">비용</label>
                        <input type="number" id="price" name="price" class="form-control input_number" require min="1" placeholder="비용을 입력해주세요.">
                    </div>
                    <div class="form-group">
                        <label for="content">내용</label>
                        <textarea name="content" id="content" cols="30" rows="5" class="form-control" placeholder="내용을 입력해주세요."></textarea>
                    </div>
                    <div class="form-group">
                        <label for="val">평점</label>
                        <select name="val" id="val" class="form-control w-25">
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