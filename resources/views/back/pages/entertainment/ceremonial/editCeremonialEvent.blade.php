@extends('back.layouts.pages-layout')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Edit Ceremonial Event')


@section('pageHeader')
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="page-title mb-0 font-size-18">Edit Ceremonial Event</h4>

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
                    <h4 class="card-title mb-0">Edit Ceremonial Event</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('entertainment.ceremonialevent.update', $ceremonialEvent->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <select name="lives_id" id="lives_id" class="form-control">
                            @foreach ($ceremonial as $ce)
                                <option value="{{ $ce->id }}" selected>{{ $ce->name }}</option>
                            @endforeach
                        </select>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ $ceremonialEvent->name }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image"
                                name="image" value="{{ $ceremonialEvent->image }}">
                            @error('image')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="image_holder mb-2" style="max-width: 250px">
                            <img src="{{ asset('storage/back/images/entertainment/ceremonial/' . $ceremonialEvent->image) }}"
                                alt="" class="img-thumbnail" id="image-previewer">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="ckeditor form-control @error('description') is-invalid @enderror" name="description" rows="6"
                                placeholder="Content.." id="description">{!! $ceremonialEvent->description !!}</textarea>
                            @error('description')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group d-flex justify-content-between">
                            <a href="{{ route('entertainment.ceremonial.show', 1) }}" class="btn btn-warning mt-3"><i
                                    class="bx bx-arrow-back"></i> Cancel</a>
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
                .create(document.querySelector('#description'))
                .catch(error => {
                    console.error(error);
                });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('input[type="file"][name="image"]').ijaboViewer({
                preview: '#image-previewer',
                imageShape: 'rectangular',
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
