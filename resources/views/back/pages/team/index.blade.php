@extends('back.layouts.pages-layout')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Team Lanoer')


@section('pageHeader')
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="page-title mb-0 font-size-18">Team Lanoer</h4>

            <div class="page-title-right">
                @include('components.breadcrumbs')
            </div>

        </div>
    </div>
@endsection
@section('content')
    @livewire('back.team.team-list')
@endsection
