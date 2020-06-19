<?php

function myLoader($name){
    $prefix= "Base\\";
    $prefixLen = strlen($prefix);
    $base = __DIR__."/src/";
    if(strncmp($prefix,$name,$prefixLen) == 0){
        $realName = substr($name,$prefixLen);
        $realName = str_replace("\\","/",$realName);
        $file = "{$base}{$realName}.php";
        if(file_exists($file)) include_once $file;
    }
}

spl_autoload_register("myLoader");