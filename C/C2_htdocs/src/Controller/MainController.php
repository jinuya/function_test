<?php

namespace Base\Controller;

use Base\App\{DB,Lib};

class MainController{
    function indexpage(){Lib::view("index");}
    function storepage(){Lib::view("store");}
    function specialistpage(){
        if(!isset($_SESSION['user'])) Lib::msg("로그인해 주세요.","/");
        $specialist = [];
        $sql = "SELECT * FROM users WHERE specialist = ?";
        $data = DB::fetchAll($sql,[1]);
        $sql = "SELECT R.*, U.user_name,U.user_id FROM review AS R, users AS U WHERE R.writer_id = U.id ORDER BY R.id DESC";
        $review = DB::fetchAll($sql);
        foreach($data as $item){
            $sql = "SELECT AVG(`value`) AS `avg` FROM score WHERE `type` = ? AND post_id = ?";
            $score = DB::fetch($sql,["review",$item->id])->avg;
            $specialist[] = [floor((float)$score),$item->id];
        }
        $result = [$data,$specialist,$review];
        Lib::view("specialist",$result);
    }
    function housingpage(){
        if(!isset($_SESSION['user'])) Lib::msg("로그인해 주세요.","/");
        $sql = "SELECT H.*, U.user_name,U.user_id FROM housing AS H , users AS U WHERE H.writer_id = U.id";
        $data = DB::fetchAll($sql);
        $sql = "SELECT R.id , S.writer_id FROM review AS R, score AS S WHERE R.id = S.post_id";
        $score = DB::fetchAll($sql);
        $result = [$data,$score];
        Lib::view("housing",$result);
    }
    function buildingpage(){
        if(!isset($_SESSION['user'])) Lib::msg("로그인해 주세요.","/");
        $request_list = [];
        $sql = "SELECT BP.*, U.user_name,U.user_id FROM building_post AS BP , users AS U WHERE BP.writer_id = U.id";
        $post_list = DB::fetchAll($sql);
        if($_SESSION['user']->specialist == 1){
            $sql = "SELECT BP.*,U.user_name,U.user_id,BR.price,BR.status FROM building_post AS BP, users AS U,building_request AS BR WHERE BP.writer_id = U.id AND BR.post_id = BP.id AND BR.writer_id = ?";
            $request_list = DB::fetchAll($sql,[$_SESSION['user']->id]);
        }
        $result = [$post_list,$request_list];
        Lib::view("building",$result);
    }
}