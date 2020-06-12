<?php

namespace Base\Controller;

use Base\App\{Lib,DB};

class UserController{
    function joincheck(){
        header("Content-type","application/json");
        extract($_POST);
        $sql = "SELECT `user_id` FROM users WHERE `user_id` = ?";
        $result = DB::fetch($sql,[$user_id]);
        echo json_encode(!$result);
    }

    function joinProccess(){
        extract($_POST);
        $img = Lib::imgUpload($_FILES['img']);
        $pass = hash("sha256",$password);
        $sql = "INSERT INTO users(`user_id`,`password`,`user_name`,`img`,`specialist`) VALUES(?,?,?,?,?)";
        DB::query($sql,[$user_id,$pass,$user_name,$img,0]);
        Lib::msg("회원가입이 완료되었습니다.","back");
    }

    function logincheck(){
        header("Content-type","application/json");
        extract($_POST);
        $pass = hash("sha256",$password);
        $sql = "SELECT * FROM users WHERE `user_id` = ? AND `password` = ?";
        $result = DB::fetch($sql,[$user_id,$pass]);
        echo json_encode($result);
    }

    function loginProccess(){
        extract($_POST);
        $pass = hash("sha256",$password);
        $sql = "SELECT * FROM users WHERE `user_id` = ? AND `password` = ?";
        $result = DB::fetch($sql,[$user_id,$pass]);
        $_SESSION['user'] = $result;
        Lib::msg('로그인이 성공적으로 되었습니다.',"back");
    }

    function logoutProccess(){
        if(!isset($_SESSION['user'])) return Lib::msg('로그인 후 이용가능합니다.');
        session_destroy();
        Lib::msg("로그아웃되었습니다.","back");
    }
}