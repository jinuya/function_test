<?php

use Base\App\Route;

Route::get("/","MainController@indexpage");
Route::get("/store","MainController@storepage");
Route::get("/building","MainController@buildingpage");
Route::get("/housing","MainController@housingpage");
Route::get("/specialist","MainController@specialistpage");

Route::post("/join","UserController@join");
Route::post("/joincheck","UserController@joinCheck");
Route::post("/login","UserController@login");
Route::post("/logincheck","UserController@loginCheck");
Route::get("/logout","UserController@logout");

Route::post("/housingWrite","HousingController@housingWrite");
Route::post("/housingAddScore","HousingController@housingAddScore");
Route::post("/reviewWrite","HousingController@reviewWrite");

Route::post("/building_post","BuildingController@building_post");
Route::post("/building_request","BuildingController@building_request");
Route::post("/building_update","BuildingController@building_update");
Route::post("/building_load","BuildingController@building_load");