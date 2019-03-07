<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Cache-Control" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <script src="{{ asset('/public/js/app.js')  }}"></script>
    <link rel="stylesheet" href="//at.alicdn.com/t/font_998291_pt0d7mxmwpg.css">
    <title>{{ $view_title  }} - {{ config('global.title')  }}</title>
    <style>
        {{-- 解决刚进入页面时a标签颜色闪的问题 --}}
        a{
            color: #34495e;
        }
    </style>
    @yield('head')
</head>
<body>
    @yield('body')
</body>
</html>