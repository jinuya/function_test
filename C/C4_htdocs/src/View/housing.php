<!-- 콘텐츠 -->
<div id="content">

    <div class="content_wrap">

        <div class="content_title">
            <div class="content_title_line"></div>
            <h2>온라인 집들이</h2>
        </div>
        <button class="btn btn-primary" id="housing_write" data-toggle="modal" data-target="#housing_write_popup">글쓰기</button>
        <div class="content_box" id="housing_list">
            <?php foreach($data[0] as $post):?>
                <?php $flag = true;?>
                <?php foreach($data[1] as $score){if($score->post_id == $post->id) $flag = false;}?>
                <div class="card housing_card">
                    <div class="card-img-box">
                        <div>
                            <span class="alert alert-white">Before</span>
                            <img src="resources/user_img/<?=$post->before_img?>" title="housing_img" alt="housing_img">
                        </div>
                        <div>
                            <span class="alert alert-white">After</span>
                            <img src="resources/user_img/<?=$post->after_img?>" title="housing_img" alt="housing_img">
                        </div>
                    </div>
                    <div class="card-body">
                            <h5 class="card-title"><?=$post->user_name?>(<?=$post->user_id?>)</h5>
                            <p class="card-subtitle text-muted"><?=$post->day?></p>
                            <hr>
                            <p class="card-text"><?=nl2br(htmlentities($post->content))?></p>
                            <hr>
                            <p class="card-text d-inline-block"><i class="fa fa-star blink text-warning"></i> <?=$post->score?></p>
                            <?php if($_SESSION['user']->id !== $post->writer_id && $flag):?>
                                <button class="btn btn-primary float-right housing_score_btn" data-target="#housing_addScore_popup" data-id="<?=$post->id?>" data-toggle="modal">평점주기</button>
                            <?php endif;?>
                        </div>
                </div>
            <?php endforeach;?>
        </div>
    </div>
</div>

<div id="housing_write_popup" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h2 class="modal-title text-white">글쓰기</h2>
                <button class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="/housingWrite" method="post" name="housing_write_form" id="housing_write_form" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="before_img">Before 이미지</label>
                        <input type="file" id="before_img" name="before_img" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="after_img">After 이미지</label>
                        <input type="file" id="after_img" name="after_img" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="content">노하우</label>
                        <textarea name="content" id="content" class="form-control" cols="30" rows="5"></textarea>
                    </div>
                    <button class="close" id="housing_write_send"></button>
                </form>
            </div>
            <div class="modal-footer bg-light">
                <button class="btn btn-secondary" data-dismiss="modal">닫기</button>
                <button class="btn btn-primary" id="housing_write_btn">작성 완료</button>
            </div>
        </div>
    </div>
</div>

<div id="housing_addScore_popup" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h2 class="modal-title text-white">평점</h2>
                <button class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="housing_add_score_list">
                <button class="close housing_score" data-id="1"><i class="fa fa-star blink housing_score" data-id="1"></i></button>
                <button class="close housing_score" data-id="2"><i class="fa fa-star blink housing_score" data-id="2"></i></button>
                <button class="close housing_score" data-id="3"><i class="fa fa-star blink housing_score" data-id="3"></i></button>
                <button class="close housing_score" data-id="4"><i class="fa fa-star blink housing_score" data-id="4"></i></button>
                <button class="close housing_score" data-id="5"><i class="fa fa-star blink housing_score" data-id="5"></i></button>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" id="housing_addScore_close" data-dismiss="modal">닫기</button>
            </div>
        </div>
    </div>
</div>