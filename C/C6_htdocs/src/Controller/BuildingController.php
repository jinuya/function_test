<?php

namespace Base\Controller;

use Base\App\{DB,Lib};

class BuildingController{
    function building_post(){
        extract($_POST);
        $sql = "INSERT INTO building_post(`writer_id`,`day`,`content`,`status`) VALUES(?,?,?,?)";
        DB::query($sql,[$_SESSION['user']->id,$day,$content,"requesting"]);
        return Lib::msg("견적이 정상적으로 요청되었습니다.","/building");
    }

    function building_request(){
        extract($_POST);
        $sql = "INSERT INTO building_request(`writer_id`,`post_id`,`price`,`status`) VALUES(?,?,?,?)";
        DB::query($sql,[$_SESSION['user']->id,$post_id,$price,"requesting"]);
        $sql = "SELECT COUNT(*) AS cnt FROM building_request WHERE post_id = ?";
        $cnt = DB::fetch($sql,[$post_id])->cnt;
        $sql = "UPDATE building_post SET num = ? WHERE id = ?";
        DB::query($sql,[$cnt,$post_id]);
        return Lib::msg("견적이 정상적으로 보내졌습니다.","/building");
    }

    function building_update(){
        header("Content-Type","application/json");
        extract($_POST);
        $sql = "UPDATE building_post SET `status` = ? WHERE id = ?";
        DB::query($sql,["end",$post_id]);
        $sql = "UPDATE building_request SET `status` = ? WHERE id = ?";
        DB::query($sql,["choose",$request_id]);
        $sql = "UPDATE building_request SET `status` = ? WHERE post_id = ? AND NOT id = ?";
        DB::query($sql,["notchoose",$post_id,$request_id]);
        echo json_encode(true);
    }

    function building_load(){
        header("Content-Type","application/json");
        extract($_POST);
        $sql = "SELECT U.user_name,U.user_id,BR.* FROM building_request AS BR, users AS U WHERE U.id = BR.writer_id AND BR.post_id = ?";
        $list = DB::fetchAll($sql,[$post_id]);
        echo json_encode($list);
    }
}