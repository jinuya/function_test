<?php

function myLoader($name){
    $prefix = "Base\\";
    $prefixLen = strlen($prefix);
    $base_dir = __DIR__."/src/";
    if(strncmp($name,$prefix,$prefixLen) == 0){
        $realName = substr($name,$prefixLen);
        $realName = str_replace("\\","/",$realName);
        $file = "{$base_dir}{$realName}.php";
        if(file_exists($file)) include_once $file;
    }
}

spl_autoload_register("myLoader");