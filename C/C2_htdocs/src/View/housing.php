<div id="content">
    <div class="content_box" id="housing">
        <h2>온라인 집들이</h2>
        <div class="content_word">
            <button class="btn btn-primary postition-absolute" id="housing_write_btn" data-target="#housing_write_popup" data-toggle="modal"><i class="fa fa-edit"></i>글쓰기</button>

            <?php foreach($data[0] as $item):?>
            <div class="card housing_box m-2">
                <div class="housing_img">
                    <div class="housing_img_box">
                        <p class="housing_img_title alert alert-light">Before</p>
                        <img src="resources/user_img/<?=$item->before_img?>" title="housing_img" alt="housing_img">
                    </div>
                    <div class="housing_img_box">
                        <p class="housing_img_title alert alert-light">After</p>
                        <img src="resources/user_img/<?=$item->after_img?>" title="housing_img" alt="housing_img">
                    </div>
                </div>
                <div class="card-body">
                    <h5 class="card-title d-inline-block"><?=$item->user_name?>(<?=$item->user_id?>)</h5>
                    <p class="card-subtitle text-muted float-right"><?=$item->day?></p>
                    <hr>
                    <p class="card-text">
                        <?=$item->content?>
                    </p>
                </div>
                <div class="card-footer bg-dark">
                    <div class="score mt-2">
                        <?php for($i = 1; $i <= 5; $i++):?>
                            <i class="fa fa-star star <?php if($i <= $item->score){echo "blink";}?>"></i>
                        <?php endfor;?>
                    </div>
                    <?php if($_SESSION['user']->id): ?>
                        <button class="btn btn-light housing_addstar_btn float-right" data-id="<?= $item->id?>" data-target="#housing_add_star" data-toggle="modal">평점주기</button>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach;?>
        </div>
    </div>
</div>

<div id="housing_write_popup" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content border-0 overflow-hidden">
            <div class="modal-header bg-dark rounded-0">
                <h2 class="modal-title text-white">글쓰기</h2>
                <button class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="/addhousing" method="post" id="housing_form" name="housing_form" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="before_img">Before 이미지</label>
                        <input type="file" class="form-control" id="before_img" name="before_img">
                    </div>
                    <div class="form-group">
                        <label for="after_img">After 이미지</label>
                        <input type="file" class="form-control" id="after_img" name="after_img">
                    </div>
                    <div class="form-group">
                        <label for="content">노하우</label>
                        <textarea name="content" id="content" cols="30" rows="5" class="form-control"></textarea>
                    </div>
                    <input type="number" name="post_id" id="post_id" hidden>
                    <button class="close" id="housing_form_send"></button>
                </form>
            </div>
            <div class="modal-footer bg-light">
                <button class="btn btn-secondary" data-dismiss="modal">취소</button>
                <button class="btn btn-primary" id="housing_form_send_btn">작성 완료</button>
            </div>
        </div>
    </div> 
</div>

<div id="housing_add_star" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content border-0 overflow-hidden">
            <div class="modal-header bg-dark rounded-0">
                <h2 class="modal-title text-white">평점주기</h2>
                <button data-dismiss="modal" class="close text-white">&times;</button>
            </div>
            <div class="modal-body">
                <div class="housing_score_box">
                    <button class="housing_score_btn" data-id="1"><i class="fa fa-star star housing_score_btn" data-id="1"></i></button>
                    <button class="housing_score_btn" data-id="2"><i class="fa fa-star star housing_score_btn" data-id="2"></i></button>
                    <button class="housing_score_btn" data-id="3"><i class="fa fa-star star housing_score_btn" data-id="3"></i></button>
                    <button class="housing_score_btn" data-id="4"><i class="fa fa-star star housing_score_btn" data-id="4"></i></button>
                    <button class="housing_score_btn" data-id="5"><i class="fa fa-star star housing_score_btn" data-id="5"></i></button>
                </div>
                <form action="/addHousingScore" method="post" name="housing_add_star_form" id="housing_add_star_form" hidden>
                    <input type="number" name="val" id="val">
                    <input type="number" name="post_id" id="post_id">
                    <button id="housing_score_add_btn" class="close"></button>
                </form>
            </div>
        </div>
    </div>
</div>