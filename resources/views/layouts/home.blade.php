@extends('layouts.base')

@section('head')
    <link rel="stylesheet" href="{{ asset('public/css/home.css')  }}">
@stop

@section('body')

    <div class="wrapper">
        @include('layouts.header')
        <div class="content-box">
            @include('layouts.aside')
            <div class="content-body">
                <div class="app-container">
                    @yield('app-container')
                </div>
                @include('layouts.footer')
            </div>
        </div>
    </div>

@stop