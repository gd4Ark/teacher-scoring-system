@extends('layouts.base')

@section('head')
    <link rel="stylesheet" href="{{ asset('public/css/login.css')  }}">
    <style>
        .app-container{
            background: url({{asset('public/images/login_bg.jpg')}});
            background-size: cover;
        }
    </style>
@stop

@section('body')

    <div class="app-container">
        <div class="inner-container">
            <div class="text">
                <h1>{{ config('global.title')  }}</h1>
                <p>不忘初心，方得始终</p>
                <p>那些成功的人，往往是有着坚定目标，并持续努力的人</p>
            </div>
            <div class="login-panel panel">
                <div class="panel-header">
                    <h2 class="panel-title">登录</h2>
                </div>
                <div class="panel-body">
                    <form>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-3 col-form-label">用户名</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="inputEmail3" placeholder="Username">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPassword3" class="col-sm-3 col-form-label">密码</label>
                            <div class="col-sm-9">
                                <input type="password" class="form-control" id="inputPassword3" placeholder="Password">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-9 offset-3">
                                <button type="button" class="btn btn-primary">登录</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @include('layouts.footer')
    </div>

@stop