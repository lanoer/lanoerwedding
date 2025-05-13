@extends('back.layouts.pages-layout')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Catering')


@section('pageHeader')
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="page-title mb-0 font-size-18">Catering</h4>

            <div class="page-title-right">
                @include('components.breadcrumbs')
            </div>

        </div>
    </div>
@endsection
@section('content')
    @livewire('back.catering-list')
@endsection
