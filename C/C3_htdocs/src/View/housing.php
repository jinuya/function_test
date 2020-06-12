<!-- 콘텐츠 -->
<div id="content">

    <div class="content_wrap">
        <div class="content_title">
            <div class="content_title_line"></div>
            <h2>온라인 집들이</h2>
        </div>
        <button class="btn btn-primary float-right" style="margin-top:-20px;" data-target="#housing_write_popup" data-toggle="modal"><i class="fa fa-edit text-white"></i> 글쓰기</button>
        <div class="content_box" id="housing">
            <?php foreach($data[0] as $item):?>
                <?php $flag = true;?>
                <?php foreach($data[1] as $id){if($id->post_id == $item->id) $flag = false;}?>
                <div class="card">
                    <div class="card-img-box">
                        <div class="card-img">
                            <div class="alert alert-white text-center mb-0">Before</div>
                            <img src="resources/user_img/<?=$item->before_img?>" title="housing_img" alt="housing_img">
                        </div>
                        <div class="card-img">
                            <div class="alert alert-white text-center mb-0">After</div>
                            <img src="resources/user_img/<?=$item->after_img?>" title="housing_img" alt="housing_img">
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?=$item->user_name?>(<?=$item->user_id?>)</h5>
                        <p class="card-subtitle text-muted"><?=$item->day?></p>
                        <hr>
                        <p class="card-text"><?=nl2br(htmlentities($item->content))?></p>
                        <hr>
                        <div class="score d-inline-block">
                            <?php for($i = 1; $i<=5; $i++):?>
                                <i class="fa fa-star star <?php if($i <= $item->score){echo "blink";}?>"></i>
                            <?php endfor;?>
                        </div>
                        <?php if($flag && $item->writer_id !== $_SESSION['user']->id):?>
                            <button class="btn btn-primary float-right addhousingScore" data-target="#housing_star_popup" data-toggle="modal" data-id="<?=$item->id?>">평점주기</button>
                        <?php endif;?>
                    </div>
                </div>
            <?php endforeach?>
        </div>
    </div>
</div>

<div id="housing_star_popup" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content border-0">
            <div class="modal-header bg-dark">
                <h2 class="text-white modal-title">평점 주기</h2>
                <button class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="score_box">
                    <i class="fa fa-star star blink housing_score_send" data-value="1"></i>
                    <i class="fa fa-star star blink housing_score_send" data-value="2"></i>
                    <i class="fa fa-star star blink housing_score_send" data-value="3"></i>
                    <i class="fa fa-star star blink housing_score_send" data-value="4"></i>
                    <i class="fa fa-star star blink housing_score_send" data-value="5"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="housing_write_popup" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content border-0">
            <div class="modal-header bg-dark">
                <h2 class="text-white modal-title">글쓰기</h2>
                <button class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="/writeHousing" method="post" name="housing_write_form" id="housing_write_form" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="before_img">Before 이미지</label>
                        <input type="file" id="before_img" name="before_img" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="after_img">After 이미지</label>
                        <input type="file" id="after_img" name="after_img" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="content"></label>
                        <textarea name="content" id="content" cols="30" rows="5" class="form-control"></textarea>
                    </div>
                    <button id="housing_write_send" class="close"></button>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">취소</button>
                <button class="btn btn-primary" id="housing_write_btn">작성 완료</button>
            </div>
        </div>
    </div>
</div>