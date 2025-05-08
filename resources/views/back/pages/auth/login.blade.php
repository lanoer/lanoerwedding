@extends('back.layouts.pages-auth')

@section('pageTitle',isset($pageTitle) ? $pageTitle : 'Login')
@section('content')
    @livewire('back.login-form')
@endsection
