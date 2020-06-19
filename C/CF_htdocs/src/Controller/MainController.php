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
        if(!isset($_SESSION['user']->id)) return Lib::msg("로그인해 주세요.","/");
        $sql = "SELECT U.user_id,U.user_name,H.* FROM users AS U,housing AS H WHERE H.writer_id = U.id";
        $housing = DB::fetchAll($sql);
        $sql = "SELECT post_id FROM score WHERE writer_id = ? ";
        $score = DB::fetchAll($sql,[$_SESSION['user']->id]);
        $data = [$housing,$score];
        Lib::view("housing",$data);
    }

    function specialistpage(){
        if(!isset($_SESSION['user']->id)) return Lib::msg("로그인해 주세요.","/");
        $sql = "SELECT * FROM users WHERE specialist = ?";
        $info = DB::fetchAll($sql,[1]);
        $score = [];
        $sql = "SELECT AVG(score) AS score,specialist_id FROM review WHERE specialist_id = ?";
        foreach($info as $id){
            $data = DB::fetch($sql,[$id->id]);
            $data->score = floor((float)$data->score);
            $data->specialist_id = $id->id;
            $score[] = $data;
        }
        $sql = "SELECT U.user_name,U.user_id,R.* FROM users AS U, review AS R WHERE R.writer_id = U.id";
        $review = DB::fetchAll($sql);
        $data = [$info,$score,$review];
        Lib::view("specialist",$data);
    }

    function buildingpage(){
        if(!isset($_SESSION['user']->id)) return Lib::msg("로그인해 주세요.","/");
        $sql = "SELECT U.user_name,U.user_id,BP.* FROM users AS U, building_post AS BP WHERE BP.writer_id = U.id";
        $bp_list = DB::fetchAll($sql);
        $br_list = [];
        $sql = "SELECT * FROM building_request WHERE writer_id = ?";
        if($_SESSION['user']->specialist == 1) $br_list = DB::fetchAll($sql,[$_SESSION['user']->id]);
        $data = [$bp_list,$br_list];
        Lib::view("building",$data);
    }
}