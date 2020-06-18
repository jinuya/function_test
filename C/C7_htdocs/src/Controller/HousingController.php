<?php

namespace Base\Controller;

use Base\App\{DB,Lib};

class HousingController{
    function housingwrite(){
        extract($_POST);
        $be_img = Lib::imgUpload($_FILES['before_img']);
        $af_img = Lib::imgUpload($_FILES['after_img']);
        $sql = "INSERT INTO housing(`writer_id`,`before_img`,`after_img`,`content`,`day`) VALUES(?,?,?,?,?)";
        DB::query($sql,[$_SESSION['user']->id,$be_img,$af_img,$content,date("Y-m-d")]);
        return Lib::msg("글이 작성되었습니다.","/housing");
    }

    function housingscore(){
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

    function reviewwrite(){
        extract($_POST);
        $sql = "INSERT INTO review(`writer_id`,`content`,`price`,`specialist_id`,`score`) VALUES(?,?,?,?,?)";
        DB::query($sql,[$_SESSION['user']->id,$content,$price,$specialist_id,$val]);
        return Lib::msg("시공 후기작성이 완료되었습니다.","/specialist");
    }
}