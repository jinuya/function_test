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

    function specialistpage(){
        if(!isset($_SESSION['user'])) return Lib::msg("로그인해 주세요.","/");
        $sql = "SELECT * FROM users WHERE specialist = ?";
        $specialist = DB::fetchAll($sql,[1]);
        $score = [];
        foreach($specialist as $i){
            $sql = "SELECT AVG(R.score) AS score, U.id FROM users AS U , review AS R WHERE R.specialist_id = ?";
            $list = DB::fetch($sql,[$i->id]);
            $list->id = $i->id;
            $list->score = floor((float)$list->score);
            $score[] = $list;
        }
        $sql = "SELECT U.user_id,U.user_name,R.* FROM users AS U, review AS R WHERE R.writer_id = U.id";
        $review = DB::fetchAll($sql);
        $data = [$specialist,$score,$review];
        Lib::view("specialist",$data);
    }

    function housingpage(){
        if(!isset($_SESSION['user'])) return Lib::msg("로그인해 주세요.","/");
        $sql = "SELECT U.user_name,U.user_id,H.* FROM users AS U , housing AS H WHERE H.writer_id = U.id";
        $post = DB::fetchAll($sql);
        $sql = "SELECT * FROM score WHERE writer_id = ?";
        $score = DB::fetchAll($sql,[$_SESSION['user']->id]);
        $data = [$post,$score];
        Lib::view("housing",$data);
    }

    function buildingpage(){
        if(!isset($_SESSION['user'])) return Lib::msg("로그인해 주세요.","/");
        $sql = "SELECT U.user_id,U.user_name,BP.* FROM users AS U , building_post AS BP WHERE BP.writer_id = U.id";
        $bp_list = DB::fetchAll($sql);
        $br_list = [];
        if($_SESSION['user']->specialist == 1){
            $sql = "SELECT U.user_id, U.user_name,BP.*,BR.* FROM users AS U , building_post AS BP, building_request AS BR WHERE BR.post_id = BP.id AND U.id = BP.writer_id AND BR.writer_id = ?";
            $br_list = DB::fetchAll($sql,[$_SESSION['user']->id]);
        }
        $data = [$bp_list,$br_list];
        Lib::view("building",$data);
    }
}