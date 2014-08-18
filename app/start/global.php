<?php

/*
|--------------------------------------------------------------------------
| Register The Laravel Class Loader
|--------------------------------------------------------------------------
|
| In addition to using Composer, you may use the Laravel class loader to
| load your controllers and models. This is useful for keeping all of
| your classes in the "global" namespace without Composer updating.
|
*/

ClassLoader::addDirectories(array(

//	app_path().'/commands',
	app_path().'/controllers',
    app('path.system').'/controllers/admin',
//	app_path().'/database/seeds',
//    app('path.june') .'/controllers',
    app('path.june') .'/models',
    app('path.june') .'/core',

));

/*
|--------------------------------------------------------------------------
| Application Error Logger
|--------------------------------------------------------------------------
|
| Here we will configure the error logger setup for the application which
| is built on top of the wonderful Monolog library. By default we will
| build a basic log file setup which creates a single file for logs.
|
*/

Log::useFiles(storage_path().'/logs/june.log.txt');

/*
|--------------------------------------------------------------------------
| Application Error Handler
|--------------------------------------------------------------------------
|
| Here you may handle any errors that occur in your application, including
| logging them or displaying custom views for specific errors. You may
| even register several error handlers to handle different types of
| exceptions. If nothing is returned, the default error view is
| shown, which includes a detailed stack trace during debug.
|
*/

App::error(function(Exception $exception, $code)
{
	Log::error($exception);
});

/*
|--------------------------------------------------------------------------
| Maintenance Mode Handler
|--------------------------------------------------------------------------
|
| The "down" Artisan command gives you the ability to put an application
| into maintenance mode. Here, you will define what is displayed back
| to the user if maintenance mode is in effect for the application.
|
*/

App::down(function()
{
	return Response::make("Be right back!", 503);
});

/**
 * Generate style and script tag to include Twitter Bootstrap
 *
 * @param string $type
 * @return string
 */
HTML::macro('getBootstrap', function($type = 'css')
{
    switch ($type) {
        case 'css':{
            $echo = HTML::style('public/bootstrap/css/bootstrap.min.css');
            $echo .= HTML::style('public/font-awesome/css/font-awesome.min.css');
            break;
        }
        case 'script':
            $echo = HTML::script('public/bootstrap/js/bootstrap.min.js');
            break;
        default:
            $echo = '';
            break;
    }
    return $echo;
});

/**
 * Generate script tag to include Jquery
 *
 * @param string $name
 * @return string
 */
HTML::macro('getJquery', function($name = 'jquery.min.js')
{
    return HTML::script('public/jquery/' . $name);
});

/**
 * Generate script tag to include public javascript file in public/js folder
 */
HTML::macro('js', function($name)
{
    return HTML::script('public/js/' . $name);
});

/**
 * Generate script tag to include public css file in public/css folder
 */
HTML::macro('css', function($name)
{
    return HTML::script('public/css/' . $name);
});

/*
|--------------------------------------------------------------------------
| Require The Filters File
|--------------------------------------------------------------------------
|
| Next we will load the filters file for the application. This gives us
| a nice separate location to store our route and application filter
| definitions instead of putting them all in the main routes file.
|
*/

require app_path().'/filters.php';
