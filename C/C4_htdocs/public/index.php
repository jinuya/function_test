<?php

session_start();

define("ROOT",dirname(__DIR__));
define("SRC",ROOT."/src/");

include_once ROOT."/autoload.php";
include_once ROOT."/Lib.php";
include_once ROOT."/web.php";

Base\App\Route::route();