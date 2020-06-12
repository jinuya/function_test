<?php

namespace Base\App;

class Lib{
    public static function view($view_path,$data=[]){
        extract($data);
        $view = SRC."/View/$view_path.php";
        include_once SRC."/View/header.php";
        include_once $view;
        include_once SRC."/View/footer.php";
    }

    public static function msg($msg,$link){
        echo "<script>alert('$msg');";
        if($link == "back") echo "history.back();";
        else if($link !=="") echo "location.href = '$link';";
        echo "</script>";
    }

    public static function randString($strlen){
        $str = "qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM1234567890";
        $result = "";
        for($i=0;$i<$strlen;$i++) $result .= $str[rand(0,strlen($str)-1)];
        return $result;
    }

    public static function imgUpload($file){
        $exp = explode("/",$file['type'])[1];
        do{$image_name = self::randString(30).".".$exp;}while(is_file(ROOT."/public/resources/user_img/"));
        $upload = ROOT."/public/resources/user_img/";
        move_uploaded_file($file['tmp_name'],$upload.$image_name);
        return $image_name;
    }
}