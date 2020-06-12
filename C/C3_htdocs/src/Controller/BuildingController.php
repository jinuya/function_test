<?php

namespace Base\Controller;

use Base\App\{DB,Lib};

class BuildingController{
    function buildingPost(){
        extract($_POST);
        $sql = "INSERT INTO building_post(`writer_id`,`day`,`content`,`status`) VALUES(?,?,?,?)";
        DB::query($sql,[$_SESSION['user']->id,$day,$content,"requesting"]);
        Lib::msg("견적이 정상적으로 요청되었습니다.","/building");
    }

    function buildingRequest(){
        extract($_POST);
        $sql = "INSERT INTO building_request(`writer_id`,`post_id`,`price`,`status`) VALUES(?,?,?,?)";
        DB::query($sql,[$_SESSION['user']->id,$post_id,$price,"requesting"]);
        Lib::msg("견적이 정상적으로 보내졌습니다.","/building");
    }

    function buildingAccept(){
        header("Content-Type","application/json");
        extract($_POST);
        $sql = "UPDATE  building_post SET `status` = ? WHERE id = ?";
        DB::query($sql,["success",$post_id]);
        $sql = "UPDATE building_request SET `status` = ? WHERE id = ?";
        DB::query($sql,["accept",$request_id]);
        $sql = "SELECT * FROM building_request WHERE post_id = ? AND NOT id = ?";
        $list = DB::fetchAll($sql,[$post_id,$request_id]);
        $sql = "UPDATE building_request SET `status` = ? WHERE id = ?";
        foreach($list as $request) DB::query($sql,["notaccept",$request->id]);
        echo json_encode(true);
    }

    function buildingWatch(){
        header("Content-Type","application/json");
        extract($_POST);
        $sql = "SELECT U.user_name, U.user_id , BR.* FROM users AS U , building_request AS BR WHERE U.id = BR.writer_id AND BR.post_id = ?";
        $list = DB::fetchAll($sql,[$post_id]);
        echo json_encode($list);   
    }
}