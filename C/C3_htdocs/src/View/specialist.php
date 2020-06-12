<!-- 콘텐츠 -->
<div id="content">
    <div class="content_wrap">
        <div class="content_title">
            <div class="content_title_line"></div>
            <h2>전문가</h2>
        </div>

        <div class="content_box" id="specialist_list">
            <?php foreach($data[0] as $item):?>
                <div class="card">
                    <img src="resources/user_img/<?=$item->img?>" alt="specialist_img" title="specialist_img" class="card-img specialist_img">
                    <div class="card-img-overlay text-center specialist_info">
                        <h4 class="card-title text-white mt-2"><?=$item->user_name?></h4>
                        <p class="card-text text-white"><?=$item->user_id?></p>
                        <div class="score border-top border-white pt-4 mb-5">
                            <?php for($i=1;$i<=5;$i++):?>
                            <i class="fa fa-star star <?php if($item->score >= $i) echo "blink"; ?>"></i>
                            <?php endfor;?>
                        </div>
                        <button data-toggle="modal" data-target="#review_popup" class="review_add_btn rounded" data-id="<?=$item->id?>">시공 후기작성</button>
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
            <?php foreach($data[1] as $review): ?>
                <?php foreach ($data[0] as $item){if($review->specialist_id == $item->id) $specialist_name = [$item->user_name,$item->user_id];}?>
                <div class="card m-2">
                    <div class="card-body">
                        <h4 class="card-title"><?=$review->user_name?>(<?=$review->user_id?>)</h4>
                        <h6 class="card-sub-title"><?=$specialist_name[0]?>(<?=$specialist_name[1]?>)</h6>
                        <hr>
                        <p class="card-text"><?=nl2br(htmlentities($review->content));?></p>
                        <hr>
                        <p class="score">평점 : <?php for($i = 1; $i <= 5; $i++):?><i class="fa fa-star star <?php if($i <= $review->val) echo "blink"; ?>"></i><?php endfor;?>(<?=$review->val?>)</p>
                    </div>
                </div>
            <?php endforeach;?>
        </div>
    </div>
</div>

<div id="review_popup" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content border-0">
            <div class="modal-header bg-dark">
                <h2 class="modal-title text-white">시공 후기작성</h2>
                <button class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="/writeSpecialist" name="review_form" method="post" id="review_form">
                    <div class="form-group">
                        <label for="price">비용</label>
                        <input type="number" id="price" name="price" min="1" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="content">내용</label>
                        <textarea id="content" name="content" class="form-control" cols="30" rows="5"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="val">평점</label>
                        <input type="number" min="1" max="5" id="val" name="val" placeholder="1~5점" class="form-control">
                    </div>
                    <input hidden type="number" name="specialist_id" id="specialist_id">
                    <button id="writeSpecialist_send" class="close"></button>
                </form>
            </div>
            <div class="modal-footer bg-light">
                <button class="btn btn-secondary" data-dismiss="modal">취소</button>
                <button class="btn btn-primary" id="writeSpecialist_btn">작성 완료</button>
            </div>
        </div>
    </div>
</div>