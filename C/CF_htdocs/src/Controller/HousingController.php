<?php

namespace Base\Controller;

use Base\App\{DB,Lib};

class HousingController{
    function housing_write(){
        extract($_POST);
        $before_img = Lib::imgUpload($_FILES['before_img']);
        $after_img  = Lib::imgUpload($_FILES['after_img']);
        $sql = "INSERT INTO housing(`writer_id`,`content`,`before_img`,`after_img`,`day`) VALUES(?,?,?,?,?)";
        DB::query($sql,[$_SESSION['user']->id,$content,$before_img,$after_img,date("Y-m-d")]);
        return Lib::msg("글쓰기가 완료되었습니다.","/housing");
    }

    function housing_score(){
        header("Content-Type","application/json");
        extract($_POST);
        $sql = "INSERT INTO score(`writer_id`,`post_id`,`val`) VALUES(?,?,?)";
        DB::query($sql,[$_SESSION['user']->id,$post_id,$val]);
        $sql = "SELECT AVG(val) as score FROM score WHERE post_id = ?";
        $data = DB::fetch($sql,[$post_id])->score;
        $data = floor((float)$data);
        $sql = "UPDATE housing SET `score` = ? WHERE id = ?";
        DB::query($sql,[$data,$post_id]);
        echo json_encode(true);
    }

    function review_write(){
        extract($_POST);
        $sql = "INSERT INTO review(`writer_id`,`content`,`specialist_id`,`score`,`price`) VALUES(?,?,?,?,?)";
        DB::query($sql,[$_SESSION['user']->id,$content,$specialist_id,$score,$price]);
        return Lib::msg("시공 후기가 작성되었습니다.","/specialist");
    }
}