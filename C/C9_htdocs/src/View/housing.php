<div class="content_wrap">
    <div class="content_title">
        <div class="content_title_circle"></div>
        <h3>온라인 집들이</h3>
    </div>
    <div class="content_box" id="housing_list">
    <button class="content_button" id="housing_write_open" data-target="#housing_write_popup" data-toggle="modal">글쓰기</button>
    <?php foreach($data[0] as $post):?>
    <?php $flag = true; foreach($data[1] as $id) if($id->post_id == $post->id) $flag = false;?>
    <div class="housing_card">
        <div class="img-box">
            <img src="resources/user_img/<?=$post->before_img?>" alt="housing_img" title="housing_img" class="left-img">
            <img src="resources/user_img/<?=$post->after_img?>" alt="housing_img" title="housing_img" class="right-img">
        </div>
        <div class="housing_card_body bg-white p-3 border-top">
            <h5 class="card-title"><?=$post->user_name?>(<?=$post->user_id?>)</h5>
            <p class="card-subtitle text-muted">작성일 : <?=$post->day?></p>
            <hr>
            <p class="card-text p-2"><?=nl2br(htmlentities($post->content))?></p>
        </div>
        <div class="housing_card_info">
            <p><i class="fa fa-star text-warning mr-1"></i>(<?=$post->score?>)</p>
            <?php if($_SESSION['user']->id !== $post->writer_id && $flag):?>
            <button class="housing_score_open" data-target="#housing_score_popup" data-id="<?=$post->id?>" data-toggle="modal">평점 주기</button>
            <?php endif;?>
        </div>
    </div>
    <?php endforeach;?>
    </div>
</div>

<div id="housing_write_popup" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-line"><div></div></div>
            <div class="modal-header">
                <h3 class="modal-title text-center w-100 d-block">글쓰기</h3>
            </div>
            <div class="modal-body">
                <form action="/housing_write" method="post" name="housing_form" id="housing_form" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="before_img">Before 사진</label>
                        <input type="file" name="before_img" id="before_img" class="form-control" >
                    </div>
                    <div class="form-group">
                        <label for="after_img">After 사진</label>
                        <input type="file" name="after_img" id="after_img" class="form-control" >
                    </div>
                    <div class="form-group">
                        <label for="content">노하우</label>
                        <textarea name="content" id="content" cols="30" rows="5" class="form-control" placeholder="노하우를 입력해주세요."></textarea>
                    </div>
                    <button class="close" id="housing_send" type="button"></button>
                </form>
            </div>
            <div class="modal-footer">
                <button class="footer_btn" id="housing_btn">작성 완료</button>
                <button class="footer_btn" data-dismiss="modal">닫기</button>
            </div>
        </div>
    </div>
</div>

<div id="housing_score_popup" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-line"><div></div></div>
            <div class="modal-header">
                <h3 class="modal-title text-center d-block w-100">평점 주기</h3>
            </div>
            <div class="modal-body">
                <div id="housing_score_box">
                    <button class="housing_score_send bg-white border-warning rounded" data-id="1"><i class="housing_score_send fa fa-star text-warning mr-1" data-id="1"></i> 1</button>
                    <button class="housing_score_send bg-white border-warning rounded" data-id="2"><i class="housing_score_send fa fa-star text-warning mr-1" data-id="2"></i> 2</button>
                    <button class="housing_score_send bg-white border-warning rounded" data-id="3"><i class="housing_score_send fa fa-star text-warning mr-1" data-id="3"></i> 3</button>
                    <button class="housing_score_send bg-white border-warning rounded" data-id="4"><i class="housing_score_send fa fa-star text-warning mr-1" data-id="4"></i> 4</button>
                    <button class="housing_score_send bg-white border-warning rounded" data-id="5"><i class="housing_score_send fa fa-star text-warning mr-1" data-id="5"></i> 5</button>
                </div>
            </div>
            <div class="modal-footer">
                <button class="footer_btn one_button" data-dismiss="modal" id="housing_score_close">닫기</button>
            </div>
        </div>
    </div>
</div>