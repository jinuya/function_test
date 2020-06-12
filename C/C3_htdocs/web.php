<?php

use Base\App\Route;

Route::get("/","MainController@indexpage");
Route::get("/housing","MainController@housingpage");
Route::get("/building","MainController@buildingpage");
Route::get("/specialist","MainController@specialistpage");
Route::get("/store","MainController@storepage");

Route::post("/joincheck","UserController@joincheck");
Route::post("/join","UserController@joinProccess");
Route::post("/logincheck","UserController@logincheck");
Route::post("/login","UserController@loginProccess");
Route::get("/logout","UserController@logoutProccess");

Route::post("/writeHousing","HousingController@writeHousing");
Route::post("/housingscoreadd","HousingController@housingScore");
Route::post("/writeSpecialist","HousingController@writeSpecialist");

Route::post("/buildingPost","BuildingController@buildingPost");
Route::post("/buildingRequest","BuildingController@buildingRequest");
Route::post("/buildingAccept","BuildingController@buildingAccept");
Route::post("/buildingWatch","BuildingController@buildingWatch");