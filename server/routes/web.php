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
//    $router->resource('domain', 'DomainController');
//    $router->resource('keyword', 'KeywordController');
//    $router->resource('template', 'TemplateController');
//    $router->resource('paragraph', 'ParagraphController');
//    $router->resource('config', 'ConfigController');
//
//});

$router->resource('domain', 'DomainController');
$router->resource('keyword', 'KeywordController');
$router->resource('template', 'TemplateController');
$router->resource('paragraph', 'ParagraphController');
$router->resource('config', 'ConfigController');