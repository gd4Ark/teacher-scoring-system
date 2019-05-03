<?php

/**
 * @var $router \App\Http\Router
 */
$router->get('/', function () use ($router) {
    return $router->app->version();
});


$router->group(['prefix' => 'api'], function () use ($router) {

    $router->post('login', 'AuthController@login');

    $router->group(['middleware' => 'auth:api'], function () use ($router) {

        $router->post('logout', 'AuthController@logout');
        $router->post('refresh', 'AuthController@refresh');
        $router->post('reset', 'AuthController@resetPassword');

    });

    $router->resource('groups', 'GroupsController');
    $router->put('groups/allow', 'GroupsController@updateAllow');
    $router->resource('teachers', 'TeachersController');
    $router->resource('subjects', 'SubjectsController');
    $router->resource('students', 'StudentsController');
    $router->post('students/login', 'StudentsController@login');
    $router->post('students/submit', 'StudentsController@submit');
    $router->resource('teachings', 'TeachingsController');
    $router->resource('scores', 'ScoresController',[
        'only' => ['index']
    ]);
    $router->get('scores/detail/{subject_id:[\d]+}/{teacher:[\d]+}', 'ScoresController@detail');

});