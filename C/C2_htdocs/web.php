<?php

use Base\App\Route;

Route::get("/","MainController@indexpage");
Route::get("/store","MainController@storepage");
Route::get("/housing","MainController@housingpage");
Route::get("/specialist","MainController@specialistpage");
Route::get("/building","MainController@buildingpage");

Route::post("/JoinIdCheck","UserController@JoinIdCheck");
Route::post("/join","UserController@joinProcess");
Route::post('/login',"UserController@loginProcess");
Route::get("/logout","UserController@logoutProcess");

Route::post("/addhousing","HousingController@addhousing");
Route::post("/addHousingScore","HousingController@addHousingScore");
Route::post("/addreview","HousingController@addreview");

Route::post("/BuildingSend","BuildingController@BuildingSend");
Route::post("/BuildingRequestingSend","BuildingController@BuildingRequestingSend");
Route::post("/BuildingChoose","BuildingController@BuildingChoose");
Route::post("/BuildingRequestWatch","BuildingController@BuildingRequestWatch");