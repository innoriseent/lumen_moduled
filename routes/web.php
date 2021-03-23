<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$app = app();
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    die("This is forked by Foxtools");
});

$router->group(['prefix' => 'v1'], function () use ($router) {
    $router->group(['prefix' => 'user'], function () use ($router) {
        $router->post('/register','UsersController@register');

    });
});
