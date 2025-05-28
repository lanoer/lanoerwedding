@extends('back.layouts.pages-layout')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Events')


@section('pageHeader')
<div class="col-12">
    <div class="page-title-box d-flex align-items-center justify-content-between">
        <h4 class="page-title mb-0 font-size-18">Events</h4>

        <div class="page-title-right">
            @include('components.breadcrumbs')
        </div>

    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <img src="{{ asset('storage/back/images/wedding/weddingmakeup/' . $weddingMakeups->image) }}"
                class="card-img-top" alt="Thumbnail 1" style="height: 200px; object-fit: cover;">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title">{{ $weddingMakeups->name }}</h5>
                <p class="card-text">{!! $weddingMakeups->description !!}</p>
                <div class="mt-auto d-flex justify-content-between align-items-center">
                    <button class="btn btn-info ">Total Wedding Makeup <span class="badge bg-primary">{{
                            $weddingMakeups->weddings_count }}</span></button>
                    <a href="{{ route('wedding.show', $weddingMakeups->id) }}" class="btn btn-primary mx-2"
                        data-bs-toggle="tooltip" data-bs-placement="top" title="Show Details"><i
                            class="bx bx-show"></i></a>
                    <a href="{{ route('wedding.edit', $weddingMakeups->id) }}" class="btn btn-warning"
                        data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Wedding"><i
                            class="bx bx-edit"></i></a>
                </div>
            </div>
        </div>
    </div> <!-- Card 1 -->

    <!-- Card 2 -->
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <img src="{{ asset('storage/back/images/wedding/weddingmakeup/' . $weddingMakeups->image) }}"
                class="card-img-top" alt="Thumbnail 2" style="height: 200px; object-fit: cover;">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title">{{ $weddingMakeups->name }}</h5>
                <p class="card-text">{!! $weddingMakeups->description !!}</p>
                <div class="mt-auto d-flex justify-content-between align-items-center">
                    <button class="btn btn-info btn-sm">Total Wedding Makeup <span class="badge bg-primary">{{
                            $weddingMakeups->weddings_count }}</span></button>
                    <a href="{{ route('wedding.show', $weddingMakeups->id) }}" class="btn btn-primary btn-sm mx-2"
                        data-bs-toggle="tooltip" data-bs-placement="top" title="Show Details"><i
                            class="bx bx-show"></i></a>
                    <a href="{{ route('wedding.edit', $weddingMakeups->id) }}" class="btn btn-warning btn-sm"
                        data-bs-toggle="tooltip" data-bs-placement="top" title="Edit Wedding"><i
                            class="bx bx-edit"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection