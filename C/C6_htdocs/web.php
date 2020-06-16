<?php

use Base\App\Route;

Route::get("/","MainController@indexpage");
Route::get("/store","MainController@storepage");
Route::get("/building","MainController@buildingpage");
Route::get("/housing","MainController@housingpage");
Route::get("/specialist","MainController@specialistpage");

Route::post("/join","UserController@joinProccess");
Route::post("/joinCheck","UserController@joinCheck");
Route::post("/login","UserController@loginProccess");
Route::post("/loginCheck","UserController@loginCheck");
Route::get("/logout","UserController@logoutProccess");

Route::post("/housingwrite","HousingController@housingwrite");
Route::post("/housingscore","HousingController@housingscore");
Route::post("/reviewwrite","HousingController@reviewwrite");

Route::post("/building_post","BuildingController@building_post");
Route::post("/building_request","BuildingController@building_request");
Route::post("/building_load","BuildingController@building_load");
Route::post("/building_update","BuildingController@building_update");