<?php

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
    return $router->app->version();
});

$router->group(['prefix' => 'user', 'middleware' => 'auth'], function () use ($router) {
    $router->get('/', ['as' => 'user', 'uses' => 'UserController@listUsers']);
    $router->get('/{id}', 'UserController@getUserById');
    $router->post('/', ['as' => 'user.insert', 'uses' => 'UserController@insertUser']);
    $router->put('/{id}', ['as' => 'user.update', 'uses' => 'UserController@updateUser']);
    $router->delete('/{id}', 'UserController@deleteUser');
});