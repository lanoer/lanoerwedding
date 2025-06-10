@extends('back.layouts.pages-layout')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Edit About')

@section('content')
<div>
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Edit About</h4>
            </div>
            <div class="card-body">
                <form id="editAboutForm" action="{{ route('aboutBackend.update', ['id' => $about->id]) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-10">
                            <div class="form-group mb-2">
                                <label for="title">Title</label>
                                <input type="text" name="title"
                                    class="form-control @error('title') is-invalid @enderror"
                                    value="{{ old('title', $about->title) }}">
                                @error('title')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>

                            <div class="form-group mb-2">
                                <label for="image">Image</label>
                                <input type="file" name="image" id="image"
                                    class="form-control @error('image') is-invalid @enderror">
                                @error('image')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>

                            <div class="image_holder mb-2" style="max-width: 250px">
                                <img src="{{ asset('storage/back/images/about/' . old('image')) }}" alt=""
                                    class="img-thumbnail" id="image-previewer">
                                @if($about->image)
                                <img src="{{ asset('storage/back/images/about/' . $about->image) }}" alt=""
                                    class="img-thumbnail" id="image-previewer">
                                @endif
                            </div>

                            <div class="form-group mb-2">
                                <label for="description">Description</label>
                                <textarea name="description"
                                    class="form-control description @error('description') is-invalid @enderror"
                                    id="description">{{ old('description', $about->description) }}</textarea>
                                @error('description')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>

                            <div class="form-group mb-2">
                                <label for="meta_description">Meta Description</label>
                                <input type="text" name="meta_description"
                                    class="form-control @error('meta_description') is-invalid @enderror"
                                    value="{{ old('meta_description', $about->meta_description) }}">
                                @error('meta_description')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>

                            <div class="form-group mb-2">
                                <label for="meta_keywords">Meta Keywords</label>
                                <input type="text" name="meta_keywords"
                                    class="form-control @error('meta_keywords') is-invalid @enderror"
                                    value="{{ old('meta_keywords', $about->meta_keywords) }}">
                                @error('meta_keywords')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>

                            <div class="form-group mb-2">
                                <label for="meta_tags">Meta Tags</label>
                                <input type="text" name="meta_tags"
                                    class="form-control @error('meta_tags') is-invalid @enderror"
                                    value="{{ old('meta_tags', $about->meta_tags) }}">
                                @error('meta_tags')<span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mt-3">
                            <button type="submit" id="saveButton" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('stylesheets')
<link href="{{ asset('back/assets/vendor/summernote/summernote-bs5.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
@endpush

@push('scripts')
<script src="{{ asset('back/assets/vendor/summernote/summernote-bs5.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    $('input[name="meta_tags"]').amsifySuggestags({ type: 'amsify' });

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
            url: '/aboutBackend/upload-image',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                $('#description').summernote('insertImage', response.location);
            }
        });
    }

    function deleteImage(imageUrl) {
        $.ajax({
            url: '/aboutBackend/delete-image',
            type: 'POST',
            data: { imageUrl: imageUrl, _token: '{{ csrf_token() }}' },
            success: function(response) {
                console.log(response.success ? 'Image deleted successfully' : 'Image deletion failed');
            }
        });
    }

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
            }
        });
    });

    document.getElementById('editAboutForm').addEventListener('submit', function (e) {
        e.preventDefault();

        document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        document.querySelectorAll('.text-danger').forEach(el => el.remove());

        var button = document.getElementById('saveButton');
        button.innerHTML = 'Loading...';
        button.disabled = true;

        var formData = new FormData(this);

        fetch(this.action, {
            method: this.method,
            body: formData,
            headers: { 'Accept': 'application/json' }
        })
        .then(response => response.json())
        .then(data => {
            button.innerHTML = 'Save';
            button.disabled = false;

            if (data.success) {
                toastr.success('Data berhasil diperbarui!');
                setTimeout(() => {
                    window.location.href = "{{ route('aboutBackend.main') }}";
                }, 1500);
            } else if (data.errors) {
                for (let field in data.errors) {
                    let errorField = document.querySelector(`[name="${field}"]`);
                    if (errorField) {
                        errorField.classList.add('is-invalid');
                        let errorDiv = document.createElement('span');
                        errorDiv.classList.add('text-danger');
                        errorDiv.textContent = data.errors[field].join(', ');
                        errorField.parentElement.appendChild(errorDiv);
                    }
                }
                toastr.error('Periksa kembali isian Anda.');
            }
        })
        .catch(error => {
            toastr.error('Terjadi kesalahan saat menyimpan data.');
            button.innerHTML = 'Save';
            button.disabled = false;
        });
    });
</script>

@if(session('success'))
<script>
    toastr.success("{{ session('success') }}");
</script>
@endif
@if(session('error'))
<script>
    toastr.error("{{ session('error') }}");
</script>
@endif
@endpush