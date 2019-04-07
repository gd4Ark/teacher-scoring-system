<?php

/**
 * @var $router \App\Http\Router
 */
$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('login', 'AuthController@login');
//$router->group(['middleware' => 'auth:api'], function () use ($router) {
//
//    $router->post('logout', 'AuthController@logout');
//    $router->post('refresh', 'AuthController@refresh');
//
//
//});

$router->resource('groups', 'GroupController');
$router->resource('teachers', 'TeacherController');
$router->resource('subjects', 'SubjectController');
$router->resource('students', 'StudentController');