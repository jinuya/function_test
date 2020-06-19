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
        $sql = "SELECT U.user_name,U.user_id,H.* FROM users AS U , housing AS H WHERE H.writer_id = U.id";
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
        foreach($specialist as $info){
            $data = DB::fetch($sql,[$info->id]);
            $data->score = floor((float)$data->score);
            $data->specialist_id = $info->id;
            $score[]=$data;
        }
        $sql = "SELECT U.user_name,U.user_id,R.* FROM users AS U , review AS R WHERE R.writer_id = U.id";
        $review = DB::fetchAll($sql);
        $data = [$specialist,$score,$review];
        return Lib::view("specialist",$data);
    }

    function buildingpage(){
        if(!isset($_SESSION['user'])) return Lib::msg("로그인해 주세요.","/");
        $sql = "SELECT U.user_name,U.user_id,BP.* FROM users AS U , building_post AS BP WHERE BP.writer_id = U.id";
        $bp_list = DB::fetchAll($sql);
        $br_list = [];
        $sql = "SELECT U.user_name,U.user_id,BR.* FROM users AS U,building_request AS BR, building_post AS BP WHERE BR.writer_id = ? AND U.id = BP.writer_id AND BP.id = BR.post_id";
        if($_SESSION['user']->specialist == 1 ) $br_list = DB::fetchAll($sql,[$_SESSION['user']->id]);
        $data = [$bp_list,$br_list];
        return Lib::view("building",$data);
    }
}