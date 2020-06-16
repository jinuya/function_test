<?php

namespace Base\Controller;

use Base\App\{DB,Lib};

class HousingController{
    function housingwrite(){
        extract($_POST);
        $be_img = Lib::imgUpload($_FILES['before_img']);
        $af_img = Lib::imgUpload($_FILES['after_img']);
        $sql = "INSERT INTO housing(`writer_id`,`before_img`,`after_img`,`day`,`content`) VALUES (?,?,?,?,?)";
        DB::query($sql,[$_SESSION['user']->id,$be_img,$af_img,date("Y-m-d"),$content]);
        return Lib::msg("글작성이 완료되었습니다.","/housing");
    }

    function housingscore(){
        header("Content-Type","application/json");
        extract($_POST);
        $sql = "INSERT INTO score(`writer_id`,`post_id`,`val`) VALUES (?,?,?)";
        DB::query($sql,[$_SESSION['user']->id,$post_id,$val]);
        $sql = "SELECT AVG(val) AS s FROM score WHERE `post_id` = ?";
        $data = DB::fetch($sql,[$post_id])->s;
        $data = floor((float)$data);
        $sql = "UPDATE housing SET score = ? WHERE id = ?";
        DB::query($sql,[$data,$post_id]);
        echo json_encode(true);
    }

    function reviewwrite(){
        extract($_POST);
        $sql = "INSERT INTO review(`writer_id`,`specialist_id`,`content`,`price`,`score`) VALUES(?,?,?,?,?)";
        DB::query($sql,[$_SESSION['user']->id,$specialist_id,$content,$price,$score]);
        return Lib::msg("시공후기 작성이 완료되었습니다.","/specialist");
    }
}