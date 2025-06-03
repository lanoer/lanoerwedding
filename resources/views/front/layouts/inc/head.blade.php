<!DOCTYPE HTML>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('pageTitle')</title>
    <base href="/">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @stack('meta')
    @stack('schema')
    <link rel="icon" type="image/png" href="{{ webLogo()->logo_favicon }}" />
    <link rel="stylesheet" href="{{ asset('front/assets/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('front/assets/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('front/assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('front/assets/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('front/assets/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('front/assets/css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('front/assets/css/flexslider.css') }}">
    <link rel="stylesheet" href="{{ asset('front/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('front/assets/css/custom.css') }}">
    @stack('css')
    @livewireStyles
    @include('feed::links')
</head>