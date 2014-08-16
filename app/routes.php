<?php

Route::get('/', 'HomeController@hello');
Route::get('install', 'InstallController@completeInstall');
Route::group(array('prefix' => 'admin'), function()
{
    Route::get('/', 'HomeAdmin@showWelcome');

});