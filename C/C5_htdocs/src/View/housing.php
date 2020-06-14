<div class="content_wrap">
    <div class="content_title">
        <div class="content_title_line"></div>
        <h2>온라인 집들이</h2>
    </div>
    <button id="housing_btn" class="btn btn-primary float-right" data-target="#housing_popup" data-toggle="modal">글쓰기</button>
    <div class="content_box" id="housing_list">
        <?php foreach($data[0] as $post):?>
            <?php $flag = true; foreach($data[1] as $s){if($s->post_id == $post->id) $flag = false;}?>
            <div class="card rounded-0 housing_card">
                <div class="img-box">
                    <div>
                        <p class="bg-white text-dark m-0 p-2 text-center">Before</p>
                        <img src="resources/user_img/<?=$post->before_img?>" title="before_img" alt="before_img">
                    </div>
                    <div>
                        <p class="bg-dark text-white  m-0 p-2 text-center">After</p>
                        <img src="resources/user_img/<?=$post->after_img?>" title="afters_img" alt="after_img">
                    </div>
                </div>
                <div class="card-body">
                    <h5 class="card-title"><?=$post->user_name?>(<?=$post->user_id?>)</h5>
                    <p class="card-subtitle text-muted"><?=$post->day?></p>
                    <hr>
                    <p class="card-text"><?=nl2br(htmlentities($post->content))?></p>
                    <hr>
                    <p class="card-text d-inline-block">평점 : <i class="fa fa-star text-warning"></i>(<?=$post->score?>)</p>
                    <?php if($_SESSION['user']->id !== $post->writer_id && $flag):?>
                        <button class="btn btn-primary float-right housing_score_btn" data-target="#housing_score_popup" data-toggle="modal" data-id="<?=$post->id?>">평점주기</button>
                    <?php endif;?>
                </div>
            </div>
        <?php endforeach;?>
    </div>
</div>

<div id="housing_score_popup" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h3 class="modal-title text-white">평점주기</h3>
                <button class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body housing_score_box">
                <i class="fa fa-star text-warning housing_score_value" data-value="1"></i>
                <i class="fa fa-star text-warning housing_score_value" data-value="2"></i>
                <i class="fa fa-star text-warning housing_score_value" data-value="3"></i>
                <i class="fa fa-star text-warning housing_score_value" data-value="4"></i>
                <i class="fa fa-star text-warning housing_score_value" data-value="5"></i>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" id="housing_score_close" data-dismiss="modal">닫기</button>
            </div>
        </div>
    </div>
</div>

<div id="housing_popup" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h3 class="modal-title text-white">글쓰기</h3>
                <button class="close text-white" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="/housingwrite" method="post" name="housing_form" id="housing_form" enctype="multipart/form-data">
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
                    <button class="close" id="housing_write_send" type="button"></button>
                </form>
            </div>
            <div class="modal-footer bg-light">
                <button class="btn btn-secondary" data-dismiss='modal'>닫기</button>
                <button class="btn btn-primary" id="housing_write_btn">작성 완료</button>
            </div>
        </div>
    </div>
</div>