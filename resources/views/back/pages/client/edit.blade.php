@extends('back.layouts.pages-layout')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Edit Client')


@section('pageHeader')
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="page-title mb-0 font-size-18">Edit Client</h4>

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
                    <h4 class="card-title mb-0">Edit Client</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('client.update', [$client->id]) }}" method="POST" enctype="multipart/form-data"
                        id="client-form">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-2">
                            <label for="name">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ $client->name }}">
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-2">
                            <label for="image">Image</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image"
                                name="image" value="{{ $client->image }}">
                            @error('image')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="image_holder mb-2" style="max-width: 250px">
                            <img src="{{ asset($client->image) }}" alt="" class="img-thumbnail"
                                id="image-previewer">
                        </div>

                        <div class="form-group d-flex justify-content-between">
                            <a href="{{ route('client.index') }}" class="btn btn-warning mt-3"><i
                                    class="bx bx-arrow-back"></i>
                                Cancel</a>
                            <button type="submit" class="btn btn-primary mt-3" id="submit-btn"><i class="bx bx-save"></i>
                                Update</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection


@push('scripts')
    <script>
        $(document).ready(function() {
            $('#client-form').on('submit', function() {
                const submitBtn = $(this).find('button[type="submit"]');
                submitBtn.prop('disabled', true);
                submitBtn.html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...'
                );
                $(this).submit();
                setTimeout(function() {
                    submitBtn.prop('disabled', false);
                    submitBtn.html('<i class="bx bx-save"></i> Update');
                }, 3000);
            });
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
