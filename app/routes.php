<?php

Route::get('install', 'InstallController@update');
Route::group(array('prefix' => 'admin'), function()
{
    Route::get('/', 'HomeAdmin@showWelcome');

});