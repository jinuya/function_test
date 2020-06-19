<?php

namespace Base\Controller;

use Base\App\{Lib,DB};

class UserController{
    function joinProccess(){
        extract($_POST);
        $pass = hash("sha256",$password);
        $img = Lib::imgUpload($_FILES['img']);
        $sql = "INSERT INTO users(`user_id`,`user_name`,`password`,`img`) VALUES(?,?,?,?)";
        DB::query($sql,[$user_id,$user_name,$pass,$img]);
        return Lib::msg("회원가입이 되었습니다.","back");
    }

    function joinCheck(){
        header("Content-Type","application/json");
        extract($_POST);
        $result = true;
        $sql = "SELECT * FROM users WHERE `user_id` = ?";
        $data = DB::fetch($sql,[$user_id]);
        if($data !== false) $result = false;
        echo json_encode($result);
    }

    function loginProccess(){
        extract($_POST);
        $pass = hash("sha256",$password);
        $sql = "SELECT * FROM users WHERE `user_id`= ? AND `password` = ? ";
        $data = DB::fetch($sql,[$user_id,$pass]);
        $_SESSION['user'] = $data;
        return Lib::msg("로그인되었습니다.","back");
    }

    function loginCheck(){
        header("Content-Type","application/json");
        extract($_POST);
        $result = true;
        $pass = hash("sha256",$password);
        $sql = "SELECT * FROM users WHERE `user_id` = ? AND `password` = ?";
        $data = DB::fetchAll($sql,[$user_id,$pass]);
        if($data == false) $result = false;
        echo json_encode($result);
    }

    function logoutProccess(){
        if(isset($_SESSION['user'])){
            session_destroy();
            Lib::msg("로그아웃되었습니다.","back");
        }
    }
}