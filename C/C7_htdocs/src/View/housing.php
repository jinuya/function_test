<div class="content_wrap">
    <div class="content_title">
        <div class="content_title_circle"></div>
        <h3>온라인 집들이</h3>
    </div>

    <div class="content_box" id="housing_list">
    <button class="read_more" data-target="#housing_popup" data-toggle="modal" id="write_btn">글쓰기</button>
        <?php foreach($data[0] as $post):?>
        <?php $flag = true; foreach($data[1] as $score){if($post->id == $score->post_id) $flag = false;}?>
            <div class="main_housing_card">
                <div class="img_box">
                    <img src="resources/user_img/<?=$post->before_img?>" title="housing_img" alt="housing_img">
                    <img src="resources/user_img/<?=$post->after_img?>" title="housing_img" alt="housing_img">
                </div>

                <div class="housing_card_body p-3">
                    <h5 class="card-title"><?=$post->user_name?>(<?=$post->user_id?>)</h5>
                    <p class="text-muted">작성일 : <?=$post->day?></p>
                    <hr>
                    <p class="card-text"><?=nl2br(htmlentities($post->content))?></p>
                </div>
                
                <div class="housing_card_info">
                    <span><i class="fa fa-star text-warning"></i>(<?=$post->score?>)</span>
                    <div>
                    <?php if($_SESSION['user']->id !== $post->writer_id && $flag):?>
                        <button class="btn btn-dark housing_score_btn h-100" data-id="<?=$post->id?>" data-target="#housing_score_popup" data-toggle="modal">평점 주기</button>
                    <?php endif;?>
                    </div>
                </div>
            </div>
        <?php endforeach;?>
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
                        <label for="before_img">Before 사진</label>
                        <input type="file" id="before_img" name="before_img" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="after_img">After 사진</label>
                        <input type="file" id="after_img" name="after_img" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="content">노하우</label>
                        <textarea name="content" id="content" cols="30" rows="5" class="form-control"></textarea>
                    </div>
                    <button class="close" id="housing_write_send" type="button"></button>
                </form>
            </div>
            <div class="modal-footer bg-light">
                <button class="btn btn-primary" id="housing_write_btn">작성 완료</button>
                <button class="btn btn-secondary" data-dismiss='modal'>닫기</button>
            </div>
        </div>
    </div>
</div>

<div id="housing_score_popup" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h3 class="modal-title text-white">평점 주기</h3>
                <button class="close text-white" id="housing_score_close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" id="housing_score_list">
                <button class="housing_score_add_btn pr-2 pl-2 bg-white mr-2 border border-warning rounded" data-id="1"><i class="fa fa-star text-warning housing_score_add_btn" data-id="1">1</i></button>
                <button class="housing_score_add_btn pr-2 pl-2 bg-white mr-2 border border-warning rounded" data-id="2"><i class="fa fa-star text-warning housing_score_add_btn" data-id="2">2</i></button>
                <button class="housing_score_add_btn pr-2 pl-2 bg-white mr-2 border border-warning rounded" data-id="3"><i class="fa fa-star text-warning housing_score_add_btn" data-id="3">3</i></button>
                <button class="housing_score_add_btn pr-2 pl-2 bg-white mr-2 border border-warning rounded" data-id="4"><i class="fa fa-star text-warning housing_score_add_btn" data-id="4">4</i></button>
                <button class="housing_score_add_btn pr-2 pl-2 bg-white mr-2 border border-warning rounded" data-id="5"><i class="fa fa-star text-warning housing_score_add_btn" data-id="5">5</i></button>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">닫기</button>
            </div>
        </div>
    </div>
</div>