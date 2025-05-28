<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>@yield('pageTitle')</title>
    <base href="/">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{--
    <meta content="{{ webInfo()->web_desc }}" name="description" />
    <meta content="{{ webInfo()->web_name }}" name="author" /> --}}
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ webLogo()->logo_favicon }}">

    <!-- jquery.vectormap css -->
    <link href="{{ asset('back/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}"
        rel="stylesheet" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="{{ asset('back/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet"
        type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('back/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('back/assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('back/assets/vendor/amsify/amsify.suggestags.css') }}">
    <!-- CSS for this page only -->
    <link rel="stylesheet" href="{{ asset('back/assets/vendor/ijabo/ijabo.min.css') }}">
    <link rel="stylesheet" href="{{ asset('back/assets/vendor/ijaboCropTool/ijaboCropTool.min.css') }}">
    <link rel="stylesheet" href="{{ asset('back/assets/vendor/boxicons-2.1.4/boxicons-2.1.4/css/boxicons.min.css') }}">
    @stack('stylesheets')
    @livewireStyles

</head>