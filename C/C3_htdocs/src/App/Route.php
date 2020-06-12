<?php

namespace Base\App;

class Route{
    private static $action = [];
    public static function route(){
        $path = explode("@",$_SERVER['REQUEST_URI'])[0];
        foreach(self::$action as $act){
            if($path == $act[0]){
                $urlAction = explode("@",$act[1]);
                $controllerClass = "\\Base\\Controller\\{$urlAction[0]}";
                $controller = new $controllerClass();
                $controller->{$urlAction[1]}();
                return ;
            }
        }
    }

    public static function __callStatic($name,$args){
        $method = strtolower($_SERVER['REQUEST_METHOD']);
        if($method == $name) self::$action[] = $args; 
    }
}