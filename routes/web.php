<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->group([
//    'middleware' => 'api',
    'prefix' => 'apis/auth'
], function ($router) {
    $router->post('login', 'AuthController@login');
    $router->post('logout', 'AuthController@logout');
    $router->post('register', 'AuthController@register');
    $router->post('profile', 'AuthController@profile');
    $router->post('refresh', 'AuthController@refresh');
});

$router->group([
//    'middleware' => 'api',
    'prefix' => 'apis',
    'middleware' => ['auth:api', 'role:INSTRUCTOR']
], function ($router) {
    $router->get('instructor', 'InstructorController@index');
    $router->post('instructor/assignment', 'AssignmentController@store');
    $router->get('instructor/assignment', 'AssignmentController@index');
});
