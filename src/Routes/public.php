<?php


// Add web middleware for use Laravel feature
Route::group(['middleware' => 'web'], function () {

    Route::get('/','Tir\Page\Controllers\HomeController@show');

});