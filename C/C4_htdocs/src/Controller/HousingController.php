<?php

namespace Base\Controller;

use Base\App\{Lib,DB};

class HousingController{
    function housingWrite(){
        extract($_POST);
        $be_img = Lib::imgUpload($_FILES['before_img']);
        $af_img = Lib::imgUpload($_FILES['after_img']);
        $sql = "INSERT INTO housing(`writer_id`,`content`,`before_img`,`after_img`,`day`) VALUES(?,?,?,?,?)";
        DB::query($sql,[$_SESSION['user']->id,$content,$be_img,$af_img,date("Y-m-d H:i:s")]);
        return Lib::msg("글이 정상적으로 등록되었습니다."," /housing");
    }

    function housingAddScore(){
        header("Content-Type","application/json");
        extract($_POST);
        $sql = "INSERT INTO score(`writer_id`,`post_id`,`val`) VALUES(?,?,?)";
        DB::query($sql,[$_SESSION['user']->id,$post_id,$val]);
        $sql = "SELECT AVG(val) AS score FROM score WHERE post_id = ?";
        $data = DB::fetch($sql,[$post_id])->score;
        $data = floor((float)$data);
        $sql = "UPDATE housing SET score = ? WHERE id = ?";
        DB::query($sql,[$data,$post_id]);
        echo json_encode(true);
    }

    function reviewWrite(){
        extract($_POST);
        $sql = "INSERT INTO review(`writer_id`,`specialist_id`,`score`,`content`,`price`) VALUES(?,?,?,?,?)";
        DB::query($sql,[$_SESSION['user']->id,$specialist_id,$score,$content,$price]);
        return Lib::msg("시공후기등록이 완료되었습니다.","/specialist");
    }
}