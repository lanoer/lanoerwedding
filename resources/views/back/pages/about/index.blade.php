@extends('back.layouts.pages-layout')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'About')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm rounded-4 border-0">
                <div
                    class="card-header bg-light d-flex justify-content-between align-items-center rounded-top-4 border-bottom">
                    <h5 class="card-title text-primary m-0">{{ $pageTitle }}</h5>
                </div>
                <div class="card-body">
                    <!-- Title -->
                    <div class="mb-4">
                        <h4 class="section-title">{{ $about->title }}</h4>
                    </div>

                    <!-- Image -->
                    <div class="mb-4">
                        <h6 class="sub-title">Image</h6>
                        <img src="{{ asset('storage/back/images/about/'.$about->image) }}" alt="{{ $about->title }}"
                            class="img-fluid rounded shadow-sm custom-img">
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <h6 class="sub-title">Description</h6>
                        <div class="description-content">
                            {!! $about->description !!}
                        </div>
                    </div>

                    <!-- Meta Information -->
                    <div class="mb-4">
                        <h6 class="sub-title">Meta Description</h6>
                        <p>{{ $about->meta_description }}</p>
                    </div>

                    <div class="mb-4">
                        <h6 class="sub-title">Meta Keywords</h6>
                        <p>{{ $about->meta_keywords }}</p>
                    </div>

                    <div class="mb-4">
                        <h6 class="sub-title">Meta Tags</h6>
                        <p>{{ $about->meta_tags }}</p>
                    </div>

                    <!-- Edit Button -->
                    <div class="text-end mt-5">
                        <a href="{{ route('aboutBackend.mainEdit', $about->id) }}" class="btn btn-primary px-4 py-2">
                            Edit
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('stylesheets')
<style>
    .custom-img {
        max-width: 50%;
        height: auto;
        margin: 0 auto;
        display: block;
        transition: transform 0.3s ease-in-out;
    }

    .custom-img:hover {
        transform: scale(1.05);
    }

    .section-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: #28a745;
        border-bottom: 2px solid #dee2e6;
        padding-bottom: 6px;
    }

    .sub-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #007bff;
        border-left: 4px solid #007bff;
        padding-left: 10px;
        margin-bottom: 10px;
    }

    .description-content img {
        max-width: 100%;
        height: auto;
        display: block;
        margin: 10px auto;
        border-radius: 6px;
    }

    .card-body {
        padding: 2rem;
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
        transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    @media (max-width: 768px) {
        .custom-img {
            max-width: 90%;
        }

        .section-title {
            font-size: 1.4rem;
        }
    }
</style>
@endpush