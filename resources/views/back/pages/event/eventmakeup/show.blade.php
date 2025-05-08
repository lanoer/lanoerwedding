@extends('back.layouts.pages-layout')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Show Event Makeup')

@section('pageHeader')
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="page-title mb-0 font-size-18">{{ $eventMakeups->name }}</h4>

            <div class="page-title-right">
                @include('components.breadcrumbs')
            </div>
        </div>
    </div>
@endsection

@section('content')

    @livewire('back.event.event-makeup-show', ['eventMakeups' => $eventMakeups])

@endsection
