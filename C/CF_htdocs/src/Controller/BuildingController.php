<?php

namespace Base\Controller;

use Base\App\{DB,Lib};

class BuildingController{
    function building_post(){
        extract($_POST);
        $sql = "INSERT INTO building_post(`writer_id`,`content`,`day`,`status`) VALUES(?,?,?,?)";
        DB::query($sql,[$_SESSION['user']->id,$content,$day,"requesting"]);
        return Lib::msg("견적이 요청되었습니다.","/building");
    }

    function building_request(){
        extract($_POST);
        $sql = "INSERT INTO building_request(`writer_id`,`price`,`status`,`post_id`) VALUES(?,?,?,?)";
        DB::query($sql,[$_SESSION['user']->id,$price,"requesting",$post_id]);
        $sql = "SELECT COUNT(*) AS cnt FROM building_request WHERE post_id = ?";
        $data = DB::fetch($sql,[$post_id])->cnt;
        $sql = "UPDATE building_post SET `num` = ? WHERE id = ?";
        DB::query($sql,[$data,$post_id]);
        return Lib::msg("견적이 보내졌습니다.","/building");
    }

    function building_update(){
        header("Content-Type","application/json");
        extract($_POST);
        $sql = "UPDATE building_post SET `status` = ? WHERE id = ?";
        DB::query($sql,["fin",$post_id]);
        $sql = "UPDATE building_request SET `status` = ? WHERE id = ?";
        DB::query($sql,["choose",$request_id]);
        $sql = "UPDATE building_request SET `status` = ? WHERE post_id = ? AND NOT id = ?";
        DB::query($sql,["notchoose",$post_id,$request_id]);
        echo json_encode(true);
    }

    function building_load(){
        header("Content-Type","application/json");
        extract($_POST);
        $sql = "SELECT U.user_name,U.user_id,BR.* FROM users AS U,building_request AS BR WHERE BR.writer_id = U.id AND BR.post_id = ?";
        $list = DB::fetchAll($sql,[$post_id]);
        echo json_encode($list);
    }
}