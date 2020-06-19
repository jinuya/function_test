<?php

use Base\App\Route;

Route::get("/","MainController@indexpage");
Route::get("/store","MainController@storepage");
Route::get("/housing","MainController@housingpage");
Route::get("/specialist","MainController@specialistpage");
Route::get("/building","MainController@buildingpage");

Route::post("/join","UserController@joinProccess");
Route::post("/joinCheck","UserController@joinCheck");
Route::post("/login","UserController@loginProccess");
Route::post("/loginCheck","UserController@loginCheck");
Route::get("/logout","UserController@logoutProccess");

Route::post("/housing_write","HousingController@housing_write");
Route::post("/housing_score","HousingController@housing_score");
Route::post("/review_write","HousingController@review_write");

Route::post("/building_post","BuildingController@building_post");
Route::post("/building_request","BuildingController@building_request");
Route::post("/building_update","BuildingController@building_update");
Route::post("/building_load","BuildingController@building_load");