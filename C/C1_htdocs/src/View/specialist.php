<div id="content">
    <div class="content_box" id="speicalist">
        <h2>전문가</h2>
        <div class="content_word">
            <div id="specialist_list">
            <?php foreach($data[0] as $item): ?>
                <?php foreach($data[1] as $score){if($score[1] == $item->id){$value = $score[0];}}?>
                <div class="specialist_card border-0 card bg-dark text-white">
                    <img src="resources/user_img/<?=$item->img?>" title="specialist_img" alt="specialist_img" class="card-img">
                    <div class="card-img-overlay cardlap">
                        <h5 class="card-title specialist_name"><?=$item->user_name?>(<?=$item->user_id?>)</h5>
                        <div class="score">
                            <?php for($i = 1; $i<=5; $i++):?>
                                <i class="fa fa-star star <?php if($i <= $value){echo "blink";}?>"></i>
                            <?php endfor; ?>
                        </div>
                        <button class="specialist_review_add" data-toggle="modal" data-target="#review_popup" data-id="<?=$item->id?>">평점 주기</button>
                    </div>
                </div>
            <?php endforeach;?>
            </div>
        </div>
    </div>

    <div class="content_box" id="specialist_review">
        <h2>시공 후기</h2>
        <div class="content_word">
            <div id="after_review_list">
                <?php foreach($data[2] as $review):?>
                    <?php foreach ($data[0] as $people){if($people->id == $review->specialist_id){$specialist = $people;}}?>
                    <div class="card m-2">
                        <div class="card-body">
                            <h5 class="card-title"><?=$review->user_name?>(<?=$review->user_id?>)</h5>
                            <p class="card-subtitle text-muted"><?=$specialist->user_name?>(<?=$specialist->user_id?>)</p>
                            <hr>
                            <?=$review->content?>
                            <hr>
                            <p class="card-subtitle text-muted d-inline-block"><?=$review->price?>원</p>
                            <p class="card-text d-inline-block float-right">
                                <?php for($i=1;$i<=5;$i++):?>
                                    <i class="fa fa-star star <?php if($review->score >= $i){echo "blink";}?>"></i>
                                <?php endfor;?>
                            </p>
                        </div>
                    </div>
                <?php endforeach;?>
            </div>
        </div>
    </div>
</div>

<div id="review_popup" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content border-0">
            <div class="modal-header bg-dark rounded-0">
                <h2 class="modal-title text-white">시공 후기 작성</h2>
                <button class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="/addreview" method="post" name="reivew_form" id="review_form">
                    <div class="form-group">
                        <label for="review_price">비용</label>
                        <input type="number" class="form-control" name="review_price" id="review_price" min="0">
                    </div>
                    <div class="form-group">
                        <label for="review_content">내용</label>
                        <textarea name="review_content" id="review_content" class="form-control" cols="30" rows="5"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="review_score">평점</label>
                        <input type="number" class="form-control w-25" name="review_score" id="review_score" value="1" min="1" max="5" placeholder="(1~5)">
                    </div>
                    <input type="number" name="specialist_id" id="specialist_id" hidden>
                    <button id="review_send" class="close"></button>
                </form>
            </div>
            <div class="modal-footer bg-light">
                <button class="btn btn-secondary" data-dismiss="modal">취소</button>
                <button class="btn btn-primary" id="review_send_btn">작성 완료</button>
            </div>
        </div>
    </div>
</div>