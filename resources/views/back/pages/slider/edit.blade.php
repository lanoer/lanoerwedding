@extends('back.layouts.pages-layout')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Edit Slider')


@section('pageHeader')
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="page-title mb-0 font-size-18">Edit Slider</h4>

            <div class="page-title-right">
                @include('components.breadcrumbs')
            </div>

        </div>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Edit Slider</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('slider.update', [$slider->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-2">
                            <label for="category">Category</label>
                            <input type="text" class="form-control @error('category') is-invalid @enderror"
                                id="category" name="category" value="{{ $slider->category }}">
                            @error('category')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-2">
                            <label for="title">Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                                name="title" value="{{ $slider->title }}">
                            @error('title')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-2">
                            <label for="image">Image</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image"
                                name="image" value="{{ $slider->image }}">
                            @error('image')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="image_holder mb-2" style="max-width: 250px">
                            <img src="{{ asset('storage/back/images/slider/' . $slider->image) }}" alt=""
                                class="img-thumbnail" id="image-previewer">
                        </div>
                        <div class="form-group mb-2">
                            <label for="desc_short">Description Short</label>
                            <input type="text" class="form-control @error('desc_short') is-invalid @enderror"
                                name="desc_short" placeholder="Content.." id="desc_short" value="{{ $slider->desc_short }}">
                            @error('desc_short')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-2">
                            <label for="desc_long">Description Long</label>
                            <textarea class="ckeditor form-control @error('desc_long') is-invalid @enderror" name="desc_long" rows="6"
                                placeholder="Content.." id="desc_long">{!! $slider->desc_long !!}</textarea>
                            @error('desc_long')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-2">
                            <label for="action_link">Action Link</label>
                            <input type="text" class="form-control @error('action_link') is-invalid @enderror"
                                name="action_link" placeholder="Content.." id="action_link"
                                value="{{ $slider->action_link }}">
                            @error('action_link')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-2">
                            <label for="action_text">Action Text</label>
                            <input type="text" class="form-control @error('action_text') is-invalid @enderror"
                                name="action_text" placeholder="Content.." id="action_text"
                                value="{{ $slider->action_text }}">
                            @error('action_text')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group d-flex justify-content-between">
                            <a href="{{ route('slider.index') }}" class="btn btn-warning mt-3"><i
                                    class="bx bx-arrow-back"></i>
                                Cancel</a>
                            <button type="submit" class="btn btn-primary mt-3"><i class="bx bx-save"></i> Update</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
@push('stylesheets')
    <script src="{{ asset('back/assets/vendor/ckeditor/build/ckeditor.js') }}"></script>
@endpush


@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            ClassicEditor
                .create(document.querySelector('#desc_long'))
                .catch(error => {
                    console.error(error);
                });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('input[type="file"][name="image"]').ijaboViewer({
                preview: '#image-previewer',
                imageShape: '',
                allowedExtensions: ['jpg', 'jpeg', 'png'],
                onErrorShape: function(message, element) {
                    alert(message);
                },
                onInvalidType: function(message, element) {
                    alert(message);
                },
                onSuccess: function(message, element) {
                    // Success callback
                }
            });
        });
    </script>
@endpush
