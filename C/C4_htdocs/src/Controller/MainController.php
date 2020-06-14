<?php

namespace Base\Controller;

use Base\App\{Lib,DB};

class MainController{
    function indexpage(){
        Lib::view("index");
    }

    function storepage(){
        Lib::view("store");
    }

    function housingpage(){
        if(!isset($_SESSION['user'])) return Lib::msg("로그인해 주세요.","/");
        $sql = "SELECT U.user_name,U.user_id,H.* FROM users AS U, housing AS H WHERE H.writer_id = U.id";
        $housing = DB::fetchAll($sql);
        $sql = "SELECT * FROM score WHERE writer_id = ?";
        $score = DB::fetchAll($sql,[$_SESSION['user']->id]);
        $data = [$housing,$score];
        return Lib::view("housing",$data);
    }

    function specialistpage(){
        if(!isset($_SESSION['user'])) return Lib::msg("로그인해 주세요.","/");
        $sql = "SELECT * FROM users WHERE specialist = ?";
        $specialist = DB::fetchAll($sql,[1]);
        $sql = "SELECT AVG(score) AS score FROM review WHERE specialist_id = ?";
        $rescore = [];
        foreach($specialist as $info){
            $score = DB::fetch($sql,[$info->id]);
            $score = floor((float)$score->score);
            $rescore[] = [$score,$info->id];
        }
        $sql = "SELECT U.user_name,U.user_id,R.* FROM review AS R , users AS U WHERE R.writer_id = U.id";
        $review = DB::fetchAll($sql);
        $data = [$specialist,$rescore,$review];
        return Lib::view("specialist",$data);
    }

    function buildingpage(){
        if(!isset($_SESSION['user'])) return Lib::msg("로그인해 주세요.","/");
        $sql = "SELECT U.user_name,U.user_id,BP.* FROM users AS U, building_post AS BP WHERE BP.writer_id = U.id";
        $building = DB::fetchAll($sql);
        $specialist = [];
        if($_SESSION['user']->specialist == 1){
            $sql = "SELECT U.user_name,U.user_id,BP.*,BR.* FROM users AS U, building_post AS BP, building_request AS BR WHERE BR.writer_id = U.id AND BR.post_id = BP.id";
            $specialist = DB::fetchAll($sql);
        }
        $data = [$building,$specialist];
        return Lib::view("building",$data);
    }
}