<?php

namespace Base\Controller;

use Base\App\{Lib,DB};

class HousingController{
    function addhousing(){
        extract($_POST);
        $result = "글쓰는 도중 문제가 발생했습니다.";
        $before_img = $_FILES['before_img'];
        $after_img = $_FILES['after_img'];
        if(!($before_img['name'] == "" || $after_img['name'] == "" || $content == "")){
            $before_img_name = Lib::ImgUpload($before_img);
            $after_img_name = Lib::ImgUpload($after_img);
            $sql = "INSERT INTO housing(`writer_id`,`content`,`after_img`,`before_img`,`day`) VALUES(?,?,?,?,?)";
            DB::query($sql,[$_SESSION['user']->id,$content,$after_img_name,$before_img_name,date("Y-m-d H:i:s")]);
            $result = "성공적으로 글이 등록되었습니다.";
        }
        Lib::msg($result,"/housing");
    }

    function addHousingScore(){
        extract($_POST);
        $result = "평점등록중 문제가 발생했습니다.";
        if($val !== "" && $post_id !== ""){
            $avg = Lib::AddScore($val,$post_id,"housing");
            $sql = "UPDATE housing SET score = ? WHERE id = ?";
            DB::query($sql,[floor((float)$avg),$post_id]);
            $result = "평점이 정상적으로 등록되었습니다.";
        }
        Lib::msg($result,"/housing");
    }

    function addreview(){
        extract($_POST);
        $result = "리뷰 등록 중 문제가 발생했습니다.";
        $sql = "INSERT INTO review(`writer_id`,`specialist_id`,`content`,`score`,`price`) VALUES(?,?,?,?,?)";
        DB::query($sql,[$_SESSION['user']->id,$specialist_id,$review_content,$review_score,$review_price]);
        $result = "리뷰가 정상적으로 등록되었습니다.";
        Lib::AddScore($review_score,$specialist_id,"review");
        Lib::msg($result,"/specialist");
    }
}