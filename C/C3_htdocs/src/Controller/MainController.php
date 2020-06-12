<?php

namespace Base\Controller;

use Base\App\{DB,Lib};

class MainController{
    function indexpage(){Lib::view("index");}
    function storepage(){Lib::view("store");}
    function buildingpage(){
        if(!isset($_SESSION['user'])) return Lib::msg("로그인해 주세요.","/");
        $sql = "SELECT U.user_name , U.user_id , BP.* FROM users AS U , building_post AS BP WHERE BP.writer_id = U.id";
        $bplist = DB::fetchAll($sql);
        $brlist = [];
        if($_SESSION['user']->specialist == 1){
            $sql = "SELECT U.user_name , U.user_id , BP.*, BR.* FROM users AS U, building_post AS BP , building_request AS BR WHERE BP.writer_id = U.id AND BP.id = BR.post_id AND BR.writer_id = ?";
            $brlist = DB::fetchAll($sql,[$_SESSION['user']->id]);
        }
        $data =[$bplist,$brlist];
        Lib::view("building",$data);
    }
    function specialistpage(){
        if(!isset($_SESSION['user'])) return Lib::msg("로그인해 주세요.","/");
        $sql = "SELECT * FROM users WHERE specialist = ?";
        $specialist = DB::fetchAll($sql,[1]);
        foreach($specialist as $person){
            $sql = "SELECT AVG(val) AS `avg` FROM score WHERE `type` = ? AND give_id = ?";
            $result = DB::fetch($sql,["review",$person->id]);
            $person->score = floor((float)$result->avg);
            $list[] = $person;
        }
        $sql = "SELECT U.user_name,U.user_id,R.* FROM users AS U, specialist AS R WHERE U.id = writer_id";
        $review = DB::fetchAll($sql);
        $data =[$list,$review];
        Lib::view("specialist",$data);
    }
    function housingpage(){
        if(!isset($_SESSION['user'])) return Lib::msg("로그인해 주세요.","/");
        $post = [];
        $score = [];
        $sql = "SELECT U.user_name,U.user_id,H.* FROM users AS U, housing AS H WHERE H.writer_id = U.id";
        $post = DB::fetchAll($sql);
        $sql = "SELECT S.post_id FROM users AS U , score AS S WHERE S.type = ? AND S.writer_id = ?";
        $score = DB::fetchAll($sql,["housing",$_SESSION['user']->id]);
        $data = [$post,$score];
        Lib::view("housing",$data);
    }
}