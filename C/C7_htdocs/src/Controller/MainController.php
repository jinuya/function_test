<?php

namespace Base\Controller;

use Base\App\{DB,Lib};

class MainController{
    function indexpage(){
        Lib::view("index");
    }

    function storepage(){
        Lib::view("store");
    }

    function housingpage(){
        if(!isset($_SESSION['user'])) return Lib::msg("로그인해 주세요.","/");
        $sql = "SELECT U.user_name,U.user_id,H.* FROM users AS U,housing AS H WHERE H.writer_id = U.id";
        $housing = DB::fetchAll($sql);
        $sql = "SELECT post_id FROM score WHERE writer_id = ?";
        $score = DB::fetchAll($sql,[$_SESSION['user']->id]);
        $data = [$housing,$score];
        return Lib::view("housing",$data);
    }

    function specialistpage(){
        if(!isset($_SESSION['user'])) return Lib::msg("로그인해 주세요.","/");
        $sql = "SELECT * FROM users WHERE specialist = ?";
        $specialist = DB::fetchAll($sql,[1]);
        $score = [];
        $sql = "SELECT AVG(score) as score,specialist_id FROM review WHERE specialist_id = ?";
        foreach($specialist as $id){
            $data = DB::fetch($sql,[$id->id]);
            $data->specialist_id = $id->id;
            $data->score = floor((float)$data->score);
            $score[]=$data;
        }
        $sql = "SELECT U.user_name,U.user_id,R.* FROM users AS U,review AS R WHERE U.id = R.writer_id";
        $review = DB::fetchAll($sql);
        $data = [$specialist,$score,$review];
        return Lib::view("specialist",$data);
    }

    function buildingpage(){
        if(!isset($_SESSION['user'])) return Lib::msg("로그인해 주세요.","/");
        $sql = "SELECT U.user_name,U.user_id,BP.* FROM users AS U , building_post AS BP WHERE BP.writer_id = U.id";
        $bp_list = DB::fetchAll($sql);
        $br_list = [];
        $sql = "SELECT U.user_name,U.user_id,BP.content,BP.day,BR.* FROM users AS U , building_post AS BP, building_request AS BR WHERE BR.post_id = BP.id AND BP.writer_id = U.id AND BR.writer_id = ?";
        if(isset($_SESSION['user'])) $br_list = DB::fetchAll($sql,[$_SESSION['user']->id]);
        $data = [$bp_list,$br_list];
        return Lib::view("building",$data);
    }
}