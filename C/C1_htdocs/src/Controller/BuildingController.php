<?php

namespace Base\Controller;

use Base\App\{DB,Lib};

class BuildingController{
    function BuildingSend(){
        extract($_POST);
        $sql = "INSERT INTO building_post(`writer_id`,`day`,`status`,`content`) VALUES(?,?,?,?)";
        DB::query($sql,[$_SESSION['user']->id,$building_day,"requesting",$building_content]);
        Lib::msg("견적이 정상적으로 요청되었습니다.","/building");
    }

    function BuildingRequestingSend(){
        extract($_POST);
        $sql = "INSERT INTO building_request(`writer_id`,`post_id`,`price`,`status`) VALUES(?,?,?,?)";
        DB::query($sql,[$_SESSION['user']->id,$post_id,$requesting_price,"requesting"]);
        $sql = "SELECT `number` FROM building_post WHERE id = ?";
        $num = DB::fetch($sql,[$post_id])->number;
        $sql = "UPDATE building_post SET `number` = ? WHERE id = ?";
        DB::query($sql,[((int)$num)+1,$post_id]);
        Lib::msg("견적이 정상적으로 보내졌습니다.","/building");
    }

    function BuildingChoose(){
        header("Content-Type","application/json");
        extract($_POST);
        $sql = "UPDATE building_request SET `status` = ? WHERE id = ?";
        DB::query($sql,["choose",$requesting_id]);
        $sql = "UPDATE building_post SET `status` = ? WHERE id = ?";
        DB::query($sql,["complete",$post_id]);
        $sql = "SELECT * FROM building_request WHERE post_id = ? AND NOT id = ?";
        $list = DB::fetchAll($sql,[$post_id,$requesting_id]);
        foreach($list as $request){
            $sql = "UPDATE building_request SET `status` = ? WHERE id = ?";
            DB::query($sql,["notchoose",$request->id]);
        }
        echo json_encode(true);
    }

    function BuildingRequestWatch(){
        header("Content-Type","application/json");
        extract($_POST);
        $sql = "SELECT BR.*, U.user_name,U.user_id FROM building_request AS BR , users AS U WHERE BR.post_id = ? AND BR.writer_id = U.id";
        $list = DB::fetchAll($sql,[$building_post]);
        $result = $list;
        echo json_encode($list);
    }
}