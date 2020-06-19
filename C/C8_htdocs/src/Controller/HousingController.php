<?php

namespace Base\Controller;

use Base\App\{DB,Lib};

class HousingController{
    function housing_write(){
        extract($_POST);
        $be_img = Lib::imgUpload($_FILES['before_img']);
        $af_img = Lib::imgUpload($_FILES['after_img']);
        $sql = "INSERT INTO housing(`writer_id`,`content`,`before_img`,`after_img`,`day`) VALUES(?,?,?,?,?)";
        DB::query($sql,[$_SESSION['user']->id,$content,$be_img,$af_img,date("Y-m-d")]);
        return Lib::msg("글이 정상적으로 작성되었습니다.","/housing");
    }

    function housing_score(){
        header("Content-Type","applicaton/json");
        extract($_POST);
        $sql = "INSERT INTO score(`writer_id`,`post_id`,`val`) VALUES(?,?,?)";
        DB::query($sql,[$_SESSION['user']->id,$post_id,$val]);
        $sql = "SELECT AVG(val) as score FROM score WHERE post_id = ?";
        $data = DB::fetch($sql,[$post_id])->score;
        $data = floor((float)$data);
        $sql = "UPDATE housing SET score = ? WHERE id = ?";
        DB::query($sql,[$data,$post_id]);
        echo json_encode(true);
    }

    function review_write(){
        extract($_POST);
        $sql = "INSERT INTO review(`writer_id`,`content`,`price`,`score`,`specialist_id`) VALUES(?,?,?,?,?)";
        DB::query($sql,[$_SESSION['user']->id,$content,$price,$score,$specialist_id]);
        return Lib::msg("시공 후기 작성이 완료되었습니다.","/specialist");
    }
}