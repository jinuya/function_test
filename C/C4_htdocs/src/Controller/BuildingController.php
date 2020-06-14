<?php

namespace Base\Controller;

use Base\App\{DB,Lib};

class BuildingController{
    function building_post(){
        extract($_POST);
        $sql = "INSERT INTO building_post(`writer_id`,`content`,`day`,`status`) VALUES(?,?,?,?)";
        DB::query($sql,[$_SESSION['user']->id,$content,$day,"requesting"]);
        return Lib::msg("견적이 정상적으로 요청되었습니다.","/building");
    }

    function building_request(){
        extract($_POST);
        $sql = "INSERT INTO building_request(`writer_id`,`post_id`,`price`,`status`) VALUES(?,?,?,?)";
        DB::query($sql,[$_SESSION['user']->id,$post_id,$price,"requesting"]);
        return Lib::msg("견적이 정상적으로 보내졌습니다.");
    }

    function building_update(){
        extract($_POST);
        $sql = "UPDATE building_post SET `status` = ? WHERE id = ?";
        DB::query($sql,["clear",$post_id]);
        $sql = "UPDATE building_request SET `status` = ? WHERE id = ? AND post_id = ?";
        DB::query($sql,["choose",$request_id,$post_id]);
        $sql = "UPDATE building request SET `status` = ? WHERE post_id = ? AND NOT id = ?";
        DB::query($sql,["notchoose",$post_id,$request_id]);
        Lib::msg("견적이 정상적으로 선택되었습니다.","/building");
    }

    function building_load(){
        header("Content-Type","application/json");
        extract($_POST);
        $sql = "SELECT U.user_name , U.user_id ,BR.* FROM users AS U, building_request AS BR WHERE BR.post_id = ? AND writer_id = U.id";
        $list = DB::fetchAll($sql,[$post_id]);
        echo json_encode($list);
    }
}