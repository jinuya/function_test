<?php

namespace Base\App;

use Base\App\{DB};

class Lib{
    public static function view($view_path,$data=[]){
        extract($data);
        $view = SRC."/View/$view_path.php";
        include_once SRC."/View/header.php";
        include_once $view;
        include_once SRC."/View/footer.php";
    }

    public static function msg($msg,$link=""){
        echo "<script> alert('$msg');";
        if($link == "back") echo "history.back();";
        else if($link !== "") echo "location.href='$link';";
        echo "</script>";
    }

    public static function randString($strlen){
        $str ="qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM1234567890";
        $result = "";
        for($i=0;$i<$strlen;$i++) $result.=$str[rand(0,strlen($str)-1)];
        return $result;
    }

    public static function imgUpload($file){
        $exp = explode("/",$file['type'])[1];
        $base = ROOT."/public/resources/user_img/";
        do{$img_name = self::randString(30).".".$exp;}while(is_file($base.$img_name));
        move_uploaded_file($file['tmp_name'],$base.$img_name);
        return $img_name;
    }
}