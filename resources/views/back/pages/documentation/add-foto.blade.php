@extends('back.layouts.pages-layout')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Add Foto')

@section('pageHeader')
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="page-title mb-0 font-size-18">Add Foto</h4>

            <div class="page-title-right">
                @include('components.breadcrumbs')
            </div>

        </div>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="app-container">
            <div class="col-md-8">
                <div class="card">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif

                    @if ($message = Session::get('error'))
                        <div class="alert alert-danger alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ $message }}</strong>
                        </div>
                    @endif
                    <div class="card-header">
                        <div class="card-header">
                            <h2 class="card-title">
                                <!--begin::Search-->
                                Add foto
                                <!--end::Search-->
                            </h2>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('documentation.store-foto') }}" method="post" id="clientform"
                            class="dropzone" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="mb-3">
                                    <label class="form-label">Album</label>
                                    <select class="form-control" name="album_id" id="album_id" wire:model='album_id'>
                                        <option value="">-- PILIH ALBUM --</option>
                                        @foreach ($albums as $al)
                                            <option value="{{ $al->id }}">{{ $al->album_name }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger">
                                        @error('album_id')
                                            {!! $message !!}
                                        @enderror
                                    </span>
                                </div>
                                <div class="mb-3">
                                    <label for="">Files</label>
                                    <div class="dropzone" id="file-dropzone">
                                        <div class="row">
                                            <style>
                                                .dz-preview .dz-image image {
                                                    width: 100px;
                                                    height: 100px;
                                                }

                                                .dz-preview .dz-details {
                                                    display: none;
                                                }
                                            </style>
                                            <div class="images-preview-div"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <div class="mt-3">
                                    <button type="submit" class="btn btn-dark waves-effect waves-light" id="submitBtn">
                                        <i class="bx bx-loader bx-spin font-size-16 align-middle me-2 d-none"
                                            id="loadingSpinner"></i>
                                        <span id="buttonText">Save</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('stylesheets')
    <link rel="stylesheet" href="{{ asset('back/assets/vendor/dropzone/dropzone.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('back/assets/vendor/dropzone/dropzone.min.js') }}"></script>
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('clientform');
                const submitBtn = document.getElementById('submitBtn');
                const loadingSpinner = document.getElementById('loadingSpinner');
                const buttonText = document.getElementById('buttonText');

                if (form) {
                    submitBtn.addEventListener('click', function(event) {
                        event.preventDefault(); // Mencegah pengiriman formulir default
                        console.log('Submit button clicked');
                        submitBtn.disabled = true;
                        loadingSpinner.classList.remove('d-none');
                        buttonText.textContent = 'Saving...';

                        // Validasi album_id
                        var albumId = document.getElementById("album_id").value;
                        if (!albumId) {
                            toastr.error('Album harus diisi');
                            submitBtn.disabled = false;
                            loadingSpinner.classList.add('d-none');
                            buttonText.textContent = 'Save';
                            return;
                        }

                        // Jika validasi berhasil, proses antrian Dropzone
                        Dropzone.forElement("#clientform").processQueue();
                    });

                    Dropzone.options.clientform = {
                        paramName: "image[]", // The name that will be used to transfer the file
                        maxFilesize: 2, // MB
                        acceptedFiles: "image/*",
                        addRemoveLinks: true,
                        dictDefaultMessage: "Drop files here or click to upload",
                        autoProcessQueue: false, // Prevents Dropzone from uploading files immediately
                        previewsContainer: ".images-preview-div", // Define the container to display the previews
                        parallelUploads: 10, // Number of files to process in parallel
                        init: function() {
                            var myDropzone = this;

                            this.on("sending", function(file, xhr, formData) {
                                formData.append("album_id", document.getElementById("album_id")
                                    .value); // Append additional data
                            });

                            this.on("queuecomplete", function() {
                                toastr.success('All files have been uploaded successfully!');
                                myDropzone.removeAllFiles(); // Reset Dropzone
                                document.getElementById("clientform").reset(); // Reset form
                                submitBtn.disabled = false;
                                loadingSpinner.classList.add('d-none');
                                buttonText.textContent = 'Save';
                            });

                            this.on("error", function(file, response) {
                                if (typeof response === 'string') {
                                    toastr.error(response); // Display string error message
                                } else if (response.message) {
                                    toastr.error(response
                                        .message); // Display error message from response object
                                } else {
                                    toastr.error('File upload failed!'); // Default error message
                                }
                                submitBtn.disabled = false;
                                loadingSpinner.classList.add('d-none');
                                buttonText.textContent = 'Save';
                            });
                        }
                    };
                } else {
                    console.error('Form element not found');
                }
            });
        </script>
    @endpush
@endpush
