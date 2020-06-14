<!-- 콘텐츠 -->
<div id="content">

    <div class="content_wrap">
        <div class="content_title">
            <div class="content_title_line"></div>
            <h2>전문가</h2>
        </div>
        
        <div class="content_box" id="specialist_list">
            <?php foreach($data[0] as $item):?>
                <?php foreach($data[1] as $score){if($score[1] == $item->id) $scores = $score[0];}?>
                <div class="main_specialist_card">
                        <div class="img_box"><img src="resources/user_img/<?=$item->img?>" title="specialist_img" alt="specialist_img"></div>
                        <div class="main_specialist_back">
                            <h2><?=$item->user_name?></h2>
                            <p><?=$item->user_id?></p>
                            <span><i class="fa fa-star blink text-warning"></i>(<?=$scores?>)</span>
                            <button class="specialist_more review_add_btn" data-target="#review_popup" data-toggle="modal" data-id="<?=$item->id?>" >시공후기작성</button>
                        </div>
                    </div>
            <?php endforeach;?>
        </div>
    </div>

    <div class="content_wrap">
        <div class="content_title">
            <div class="content_title_line"></div>
            <h2>시공 후기</h2>
        </div>
        <div class="content_box" id="review_list">
            <?php foreach($data[2] as $review):?>
                <?php foreach($data[0] as $info){if($info ->id == $review->specialist_id) $specialist = $info;}?>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?=$review->user_name?>(<?=$review->user_id?>)</h5>
                        <p class="card-subtitle text-muted"><?=$specialist->user_name?>(<?=$specialist->user_id?>)</p>
                        <hr>
                        <p class="card-text"><?=nl2br(htmlentities($review->content))?></p>
                        <hr>
                        <p class="card-text d-inline-block">비용:<?=$review->price?>원</p>
                        <p class="float-right"><i class="fa fa-star text-warning"></i>(<?=$review->score?>)</p>
                    </div>
                </div>
            <?php endforeach;?>
        </div>
    </div>
</div>

<div id="review_popup" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title text-white">시공후기작성</h5>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="/reviewWrite" method="post" name="review_form" id="review_form">
                    <div class="form-group">
                        <label for="price">비용</label>
                        <input type="number" id="price" name="price" class="form-control" min="1">
                    </div>
                    <div class="form-group">
                        <label for="content">내용</label>
                        <textarea cols="30" rows="5" id="content" name="content" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="score">평점</label>
                        <input type="number" id="score" name="score" min="1" max="5" class="form-control">
                    </div>
                    <input type="text" hidden name="specialist_id" id="specialist_id">
                    <button class="close" id="review_send"></button>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">닫기</button>
                <button class="btn btn-primary" id="review_btn">작성 완료</button>
            </div>
        </div>
    </div>
</div>