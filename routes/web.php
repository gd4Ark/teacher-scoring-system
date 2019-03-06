<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index')->with([
        'view_title' => '首页',
    ]);
});


Route::get('/login', function () {
    return view('login')->with([
        'view_title' => '登录',
    ]);
});
