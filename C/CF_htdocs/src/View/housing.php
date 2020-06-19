<div class="content_wrap">
    <div class="content_title">
        <div class="content_title_circle"></div>
        <h3>온라인 집들이</h3>
    </div>
    <div class="content_box" id="housing_list">
        <button class="read_more" data-target='#housing_popup' data-toggle='modal'>글쓰기</button>
        <?php foreach($data[0] as $post):?>
        <?php $flag = true; foreach($data[1] as $src) if($src->post_id == $post->id) $flag = false;?>
        <div class="main_housing_card">
            <div class="img_box">
                <img src="resources/user_img/<?=$post->before_img?>" title="housing_img" alt="housing_img">
                <img src="resources/user_img/<?=$post->after_img?>" title="housing_img" alt="housing_img">
            </div>

            <div class="housing_card_body card border-0 bg-white">
                <div class="card-body">
                    <h5 class="card-title"><?=$post->user_id?>(<?=$post->user_name?>)</h5>
                    <p class="card-subtitle text-muted">작성일 : <?=$post->day?></p>
                    <hr>
                    <p class="card-text p-2"><?=nl2br(htmlentities($post->content))?></p>
                </div>
            </div>
            
            <div class="housing_card_info">
                <p><i class="fa fa-star text-warning"></i>(<?=$post->score?>)</p>
                <?php if($_SESSION['user']->id !== $post->writer_id && $flag):?>
                    <button class="btn btn-dark housing_score_btn" data-id="<?=$post->id?>" data-target="#housing_score_popup" data-toggle="modal">평점 주기</button>
                <?php endif;?>
            </div>
        </div>
        <?php endforeach;?>
    </div>
</div>

<div id="housing_score_popup" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-line"><div></div></div>
            <div class="modal-header">
                <h3 class="modal-title w-100 text-center d-block">평점 주기</h3>
            </div>
            <div class="modal-body">
                <div id="housing_score_button_box">
                    <button class="housing_score_add bg-white border-warning rounded p-1" data-id="1"><i class="housing_score_add fa fa-star text-warning mr-2" data-id="1"></i>1</button>
                    <button class="housing_score_add bg-white border-warning rounded p-1" data-id="2"><i class="housing_score_add fa fa-star text-warning mr-2" data-id="2"></i>2</button>
                    <button class="housing_score_add bg-white border-warning rounded p-1" data-id="3"><i class="housing_score_add fa fa-star text-warning mr-2" data-id="3"></i>3</button>
                    <button class="housing_score_add bg-white border-warning rounded p-1" data-id="4"><i class="housing_score_add fa fa-star text-warning mr-2" data-id="4"></i>4</button>
                    <button class="housing_score_add bg-white border-warning rounded p-1" data-id="5"><i class="housing_score_add fa fa-star text-warning mr-2" data-id="5"></i>5</button>
                </div>
            </div>
            <div class="modal-footer">
                <button class="footer_btn one_button" id="housing_score_close" data-dismiss="modal">닫기</button>
            </div>
        </div>
    </div>
</div>

<div id="housing_popup" class="modal fade">
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
                        <input type="file" id="before_img" name="before_img" placeholder="Before 사진을 넣어주세요." class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="after_img">After 사진</label>
                        <input type="file" id="after_img" name="after_img" placeholder="After 사진을 넣어주세요." class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="content">노하우</label>
                        <textarea name="content" id="content" cols="30" rows="5" placeholder="노하우를 입력해주세요." class="form-control"></textarea>
                    </div>
                    <button class="close" id="housing_write_send" type="button"></button>
                </form>
            </div>
            <div class="modal-footer">
                <button class="footer_btn m-0" id="housing_btn">작성 완료</button>
                <button class="footer_btn m-0" data-dismiss="modal">닫기</button>
            </div>
        </div>
    </div>
</div>