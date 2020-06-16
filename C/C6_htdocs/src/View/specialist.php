<div class="content_wrap">
    <div class="content_title">
        <div class="content_title_line"></div>
        <h2>전문가</h2>
    </div>

    <div class="content_box" id="specialist_list">
        <?php foreach($data[0] as $item):?>
            <?php foreach($data[1] as $s){if($s->id == $item->id) $score = $s->score;}?>
            <div class="main_specialist_card">
                <div class="img_box"><img src="resources/user_img/<?=$item->img?>" title="specialist_img" alt="specialist_img"></div>
                <div class="main_specialist_back">
                    <h2><?=$item->user_name?></h2>
                    <p><?=$item->user_id?></p>
                    <span><i class="fa fa-star text-warning"></i>(<?=$score?>)</span>
                    <button class="specialist_more specialist_more_btn" data-id="<?=$item->id?>" data-target="#specialist_popup" data-toggle="modal">시공후기작성</button>
                </div>
            </div>
        <?php endforeach;?>
    </div>
</div>

<div class="content_wrap">
    <div class="content_title">
        <div class="content_title_line"></div>
        <h2>시공후기</h2>
    </div>

    <div class="content_box" id="review_list">
        <?php foreach($data[2] as $review):?>
            <div class="card m-2 review_card">
                <?php foreach($data[0] as $item){if($item->id == $review->specialist_id) $specialist = $item;}?>
                <div class="card-body">
                    <h4 class="card-title"><?=$review->user_name?>(<?=$review->user_id?>)</h4>
                    <p class="card-subtitle text-muted"><?=$specialist->user_name?>(<?=$specialist->user_id?>)</p>
                    <hr>
                    <p class="card-text"><?=nl2br(htmlentities($review->content))?></p>
                    <hr>
                    <p class="card-text d-inline-block">비용 : <?=$review->price?>원</p>
                    <p class="card-text float-right"><i class="fa fa-star text-warning"></i>(<?=$review->score?>)</p>
                </div>
            </div>
        <?php endforeach;?>
    </div>
</div>

<div id="specialist_popup" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h3 class="modal-title text-white">시공후기작성</h3>
                <button class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="/reviewwrite" method="post" name="review_form" id="review_form">
                    <div class="form-group">
                        <label for="price">비용</label>
                        <input type="number" id="price" name="price" class="form-control" min="1">
                    </div>
                    <div class="form-group">
                        <label for="content">내용</label>
                        <textarea name="content" class="form-control" id="content" cols="30" rows="5"></textarea>
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
                <button class="btn btn-secondary" data-dismiss="modal">닫기</button>
                <button class="btn btn-primary" id="review_write_btn">작성 완료</button>
            </div>
        </div>
    </div>
</div>