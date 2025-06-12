@extends('back.layouts.pages-layout')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Create')


@section('pageHeader')
<div class="col-12">
    <div class="page-title-box d-flex align-items-center justify-content-between">
        <h4 class="page-title mb-0 font-size-18">Create</h4>

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
                <h4 class="card-title mb-0">Create</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('catering.sub.storePremium') }}" method="POST" enctype="multipart/form-data"
                    id="premiumform">
                    @csrf
                    <!-- Catering Package Dropdown -->
                    <div class="form-group mb-3">
                        <label for="catering_package_id">Category</label>
                        <select class="form-control @error('catering_packages_id') is-invalid @enderror"
                            name="catering_packages_id" id="catering_packages_id">
                            <option value="">-- Pilih Category --</option>
                            @foreach ($catering as $package)
                            <option value="{{ $package->id }}" {{ old('catering_packages_id')==$package->id ? 'selected'
                                : '' }}>
                                {{ $package->name }}
                                <!-- Assuming 'name' is the column for the package name -->
                            </option>
                            @endforeach
                        </select>
                        @error('catering_package_id')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="name">Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                            name="name" value="{{ old('name') }}">
                        @error('name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Main Image -->
                    <div class="form-group mb-3">
                        <label for="main_image">Main Image</label>
                        <input type="file" class="form-control @error('main_image') is-invalid @enderror"
                            id="main_image" name="main_image" accept="image/*">
                        @error('main_image')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Dropzone untuk gallery -->
                    <div class="form-group mb-3">
                        <label>Gallery Images</label>
                        <div class="dropzone" id="gallery-dropzone"></div>
                        @error('gallery')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                        @error('gallery.*')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label for="description">Description</label>
                        <textarea class=" form-control @error('description') is-invalid @enderror" name="description"
                            rows="6" placeholder="Content.." id="description">{!! old('description') !!}</textarea>
                        @error('description')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group mb-3 mt-3">
                        <label for="meta_description">Meta Description</label>
                        <input type="text" class="form-control @error('meta_description') is-invalid @enderror"
                            id="meta_description" name="meta_description" value="{{ old('meta_description') }}">
                        @error('meta_description')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group mb-3 mt-3">
                        <label for="meta_keywords">Meta Keywords</label>
                        <input type="text" class="form-control @error('meta_keywords') is-invalid @enderror"
                            id="meta_keywords" name="meta_keywords" value="{{ old('meta_keywords') }}">
                        @error('meta_keywords')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group mb-3 mt-3">
                        <label for="meta_tags">Meta Tags</label>
                        <input type="text" class="form-control @error('meta_tags') is-invalid @enderror" id="meta_tags"
                            name="meta_tags" value="{{ old('meta_tags') }}">
                        @error('meta_tags')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group d-flex justify-content-between">
                        <a href="{{ route('catering.index') }}" class="btn btn-warning mt-3"><i
                                class="bx bx-arrow-back"></i> Cancel</a>
                        <button type="submit" id="submitBtn" class="btn btn-primary mt-3">
                            <i class="bx bx-loader bx-spin font-size-16 align-middle me-2 d-none"
                                id="loadingSpinner"></i>
                            <span id="buttonText">Create</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('stylesheets')
<link href="{{ asset('back/assets/vendor/summernote/summernote-bs5.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('back/assets/vendor/dropzone/dropzone.min.css') }}">
@endpush


@push('scripts')
<script src="{{ asset('back/assets/vendor/summernote/summernote-bs5.js') }}"></script>
<script src="{{ asset('back/assets/vendor/dropzone/dropzone.min.js') }}"></script>
<script>
    $('input[name="meta_tags"]').amsifySuggestags({
            type: 'amsify'
        });
</script>
<script>
    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
</script>
<script>
    // Inisialisasi Dropzone
        Dropzone.autoDiscover = false;
        var galleryDropzone = new Dropzone("#gallery-dropzone", {
            url: "#", // Tidak dipakai, submit manual
            paramName: "gallery[]",
            maxFilesize: 2, // MB
            acceptedFiles: "image/*",
            addRemoveLinks: true,
            dictDefaultMessage: "Drop images here or click to upload",
            autoProcessQueue: false,
            uploadMultiple: true,
            parallelUploads: 10,
            previewsContainer: "#gallery-dropzone",
        });

        document.getElementById('premiumform').addEventListener('submit', function(e) {
            e.preventDefault();

            var formData = new FormData(this);
            galleryDropzone.files.forEach(function(file) {
                formData.append('gallery[]', file);
            });

            var submitBtn = document.getElementById('submitBtn');
            var loadingSpinner = document.getElementById('loadingSpinner');
            var buttonText = document.getElementById('buttonText');
            submitBtn.disabled = true;
            loadingSpinner.classList.remove('d-none');
            buttonText.textContent = 'Saving...';

            fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data); // Debugging respons server
                    if (data.errors) {
                        Object.keys(data.errors).forEach(function(field) {
                            $('#' + field).addClass('is-invalid');
                            $('#' + field).siblings('.text-danger').text(data.errors[field][0]);
                        });
                    } else if (data.error) {
                        toastr.error(data.error);
                    } else {
                        toastr.success(data.success);
                    }
                    submitBtn.disabled = false;
                    loadingSpinner.classList.add('d-none');
                    buttonText.textContent = 'Create';
                })
                .catch(error => {
                    toastr.error('Terjadi kesalahan saat menyimpan data');
                    submitBtn.disabled = false;
                    loadingSpinner.classList.add('d-none');
                    buttonText.textContent = 'Create';
                });
        });

        // Hapus gambar gallery
        $('.delete-gallery-img').click(function() {
            var imgId = $(this).data('id');
            if (confirm('Delete this image?')) {
                $.ajax({
                    url: '{{ route('catering.delete.premiumGallery.image', ':id') }}'.replace(':id',
                        imgId),
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(res) {
                        $('#gallery-img-' + imgId).remove();
                        toastr.success('Image deleted successfully');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error deleting image:', error);
                    }
                });
            }
        });
</script>

<script>
    $('#description').summernote({
            height: 300,

            callbacks: {
                onImageUpload: function(files) {
                    uploadImage(files[0]);
                },
                onMediaDelete: function(target) {
                    var imageUrl = target[0].src;
                    deleteImage(imageUrl);
                }
            }
        });

        function uploadImage(file) {
            var formData = new FormData();
            formData.append('image', file);

            $.ajax({
                url: '/catering/sub/premium/upload-image', // Endpoint untuk upload gambar
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#description').summernote('insertImage', response
                        .location); // Sisipkan gambar setelah berhasil diupload
                }
            });
        }

        function deleteImage(imageUrl) {
            console.log("Mengirim URL gambar ke server untuk dihapus:", imageUrl); // Log URL gambar yang akan dihapus

            $.ajax({
                url: '/catering/sub/premium/delete-image',
                type: 'POST',
                data: {
                    imageUrl: imageUrl,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        console.log('Gambar berhasil dihapus');
                    } else {
                        console.log('Gambar gagal dihapus');
                    }
                }
            });
        }
</script>
<script>
    $(document).ready(function() {
            $('input[type="file"][name="main_image"]').ijaboViewer({
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