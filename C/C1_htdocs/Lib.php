<?php

namespace Base\App;

use Base\App\DB;

class Lib{
    public static function view($view_page,$data = []){
        extract($data);
        $view = SRC."/View/".$view_page.".php";
        include_once SRC."/View/header.php";
        include_once $view;
        include_once SRC."/View/footer.php";
    }

    public static function msg($str,$view = ""){
        echo "<script>alert('$str');</script>";
        if($view == "back") echo "<script>history.back();</script>";
        if($view !== "") echo "<script>location.href ='$view';</script>";
    }

    public function LandString($strlen){
        $str = "qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM1234567890";
        $result = "";
        for($i = 0; $i < $strlen; $i++) $result.=$str[rand(0,strlen($str)-1)];
        return $result;
    }

    public function ImgUpload($file){
        $exp = explode("/",$file['type'])[1];
        do{$image_name = self::LandString(30).".".$exp;}while(is_file(ROOT."/public/resources/user_img/"));
        $uploadfile = ROOT."/public/resources/user_img/";
        move_uploaded_file($file['tmp_name'],$uploadfile.$image_name);
        return $image_name;
    }

    public function AddScore($score,$post_id,$table){
        $sql = "INSERT INTO score(`writer_id`,`post_id`,`value`,`type`) VALUES(?,?,?,?)";
        DB::query($sql,[$_SESSION['user']->id,$post_id,$score,$table]);
        $sql = "SELECT AVG(`value`) AS val FROM score WHERE `type` = ? AND post_id = ?";
        $avg = DB::fetch($sql,[$table,$post_id]);
        $avg = $avg->val;
        return $avg;
    }
}