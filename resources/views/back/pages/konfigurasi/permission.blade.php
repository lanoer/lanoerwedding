@extends('back.layouts.pages-layout')

@section('pageTitle', 'Permission')

@section('pageHeader')
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="page-title mb-0 font-size-18">Permission</h4>

            <div class="page-title-right">
                @include('components.breadcrumbs')
            </div>

        </div>
    </div>
@endsection
@section('content')
    <div class="row">
        @livewire('back.konfigurasi.konfigurasi-permission')
    </div>
@endsection
