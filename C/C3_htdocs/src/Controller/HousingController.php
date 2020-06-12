<?php

namespace Base\Controller;

use Base\App\{DB,Lib};

class HousingController{
    function writeHousing(){
        extract($_POST);
        $before_img = Lib::imgUpload($_FILES['before_img']);
        $after_img = Lib::imgUpload($_FILES['after_img']);
        $sql = "INSERT INTO housing(`writer_id`,`content`,`before_img`,`after_img`,`score`,`day`) VALUES(?,?,?,?,?,?)";
        DB::query($sql,[$_SESSION['user']->id,$content,$before_img,$after_img,0,date("Y-m-d H:i:s")]);
        Lib::msg("성공적으로 글이 작성되었습니다.","/housing");
    }

    function housingScore(){
        header("Content-type","application/json");
        extract($_POST);
        $sql = "INSERT INTO score(`writer_id`,`post_id`,`val`,`type`) VALUES(?,?,?,?)";
        DB::query($sql,[$_SESSION['user']->id,$post_id,$value,"housing"]);
        $sql = "SELECT AVG(val) as `avg` FROM score WHERE id = ?";
        $result = DB::fetch($sql,[$post_id])->avg;
        $result = floor($result);
        $sql = "UPDATE SET housing VALUES `score` = ? WHERE id = ?";
        DB::query($sql,[$result,$post_id]);
        echo json_encode();
    }

    function writeSpecialist(){
        extract($_POST);
        $sql = "INSERT INTO specialist(`writer_id`,`price`,`val`,`content`,`specialist_id`) VALUES(?,?,?,?,?)";
        DB::query($sql,[$_SESSION['user']->id,$price,$val,$content,$specialist_id]);
        $sql = "SELECT MAX(id) AS id FROM specialist";
        $post_id = DB::fetch($sql)->id;
        $sql = "INSERT INTO score(`writer_id`,`give_id`,`post_id`,`val`,`type`) VALUES(?,?,?,?,?)";
        DB::query($sql,[$_SESSION['user']->id,$specialist_id,$post_id,$val,"review"]);
        Lib::msg('성공적으로 시공후기가 작성되었습니다.',"/specialist");
    }
}