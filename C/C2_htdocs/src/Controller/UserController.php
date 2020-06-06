<?php

namespace Base\Controller;

use Base\App\{DB,Lib};

class UserController{
    function JoinIdCheck(){
        header("Content-Type","application/json");
        extract($_POST);
        $sql = "SELECT `user_id` FROM users WHERE `user_id` = ?";
        $result = DB::fetch($sql,[$user_id]);
        echo json_encode(['id'=>$result]);
    }

    function joinProcess(){
        extract($_POST);
        $img = $_FILES['img']['name'];
        $img_name = Lib::ImgUpload($_FILES['img']);
        $sql = "INSERT INTO users(`user_id`,`user_name`,`password`,`img`,`specialist`) VALUES(?,?,?,?,?)";
        $pass = hash("SHA256",$password);
        DB::query($sql,[$user_id,$user_name,$pass,$img_name,0]);
        Lib::msg("회원가입이 완료되었습니다.","back");
    }

    function loginProcess(){
        extract($_POST);
        if($user_id == "" || $password == "") return Lib::msg("내용을 입력해주세요.","/");
        $sql = "SELECT * FROM users WHERE `user_id` = ? AND `password` = ?";
        $result = DB::fetch($sql,[$user_id,hash("SHA256",$password)]);
        if($result == false) return Lib::msg("아이디 또는 비밀번호가 틀렸습니다.","/");
        $_SESSION['user'] = $result;
        Lib::msg("로그인이 성공적으로 완료되었습니다.","back");
    }

    function logoutProcess(){
        if(!isset($_SESSION['user'])) return Lib::msg("로그인후 이용가능합니다.");
        session_destroy();
        Lib::msg('로그아웃이 성공적으로 완료되었습니다.',"back");
    }

    
}