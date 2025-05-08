@extends('back.layouts.pages-layout')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'General Settings')


@section('pageHeader')
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="page-title mb-0 font-size-18">General Settings</h4>

            <div class="page-title-right">
                @include('components.breadcrumbs')
            </div>

        </div>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">

                    <h4 class="card-title">General Settings</h4>
                    <p class="card-title-desc">
                        General settings for the website.
                    </p>

                    <!-- Nav tabs -->
                    <ul class="nav nav-pills nav-justified" role="tablist">
                        <li class="nav-item waves-effect waves-light" role="presentation">
                            <a class="nav-link active" data-bs-toggle="tab" href="#home-1" role="tab"
                                aria-selected="true">
                                <span class="d-block d-sm-none"><i class="fas fa-cogs"></i></span>
                                <span class="d-none d-sm-block">General</span>
                            </a>
                        </li>
                        <li class="nav-item waves-effect waves-light" role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" href="#profile-1" role="tab" aria-selected="false"
                                tabindex="-1">
                                <span class="d-block d-sm-none"><i class="fas fa-share-alt"></i></span>
                                <span class="d-none d-sm-block">Social Media</span>
                            </a>
                        </li>
                        <li class="nav-item waves-effect waves-light" role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" href="#messages-1" role="tab" aria-selected="false"
                                tabindex="-1">
                                <span class="d-block d-sm-none"><i class="fas fa-image"></i></span>
                                <span class="d-none d-sm-block">Logo</span>
                            </a>
                        </li>

                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content p-3 text-muted">
                        <div class="tab-pane active show" id="home-1" role="tabpanel">
                            @livewire('back.setting.general-setting')
                        </div>
                        <div class="tab-pane" id="profile-1" role="tabpanel">
                            @livewire('back.setting.social-media')
                        </div>
                        <div class="tab-pane" id="messages-1" role="tabpanel">
                            <div class="col">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <h4>Set Logo Backend</h4>
                                        <div class="mb-2" style="max-width: 200px">
                                            <img src="" alt="" class="img-thumbnail" id="logo-image-preview"
                                                data-ijabo-default-img="{{ webLogo()->logo_utama }}">
                                        </div>
                                        <form action="{{ route('change-web-logo') }}" method="post"
                                            id="changeBlogLogoForm">
                                            @csrf
                                            <div class="mb-2">
                                                <input type="file" name="logo_utama" class="form-control">
                                            </div>
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </form>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <h4>Set Logo Email</h4>
                                        <div class="mb-2" style="max-width: 200px">
                                            <img src="" alt="" class="img-thumbnail"
                                                id="email-image-preview"
                                                data-ijabo-default-img="{{ webLogo()->logo_email }}">
                                        </div>
                                        <form action="{{ route('change-email-logo') }}" method="post"
                                            id="changeWebEmailLogoForm">
                                            @csrf
                                            <div class="mb-2">
                                                <input type="file" name="logo_email" class="form-control">
                                            </div>
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </form>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <h4>Set Logo Favicon</h4>
                                        <div class="mb-2" style="max-width: 200px">
                                            <img src="" alt="" class="img-thumbnail"
                                                id="favicon-image-preview"
                                                data-ijabo-default-img="{{ webLogo()->logo_favicon }}">
                                        </div>
                                        <form action="{{ route('change-web-favicon') }}" method="post"
                                            id="changeBlogFaviconForm">
                                            @csrf
                                            <div class="mb-2">
                                                <input type="file" name="logo_favicon" class="form-control">
                                            </div>
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </form>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <h4>Set Logo Front</h4>
                                            <div class="mb-2" style="max-width: 200px">
                                                <img src="" alt="" class="img-thumbnail"
                                                    id="front-image-preview"
                                                    data-ijabo-default-img="{{ webLogo()->logo_front }}">
                                            </div>
                                            <form action="{{ route('change-web-front') }}" method="post"
                                                id="changeBlogFrontForm">
                                                @csrf
                                                <div class="mb-2">
                                                    <input type="file" name="logo_front" class="form-control">
                                                </div>
                                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                            </form>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <h4>Set Logo Front Mobile</h4>
                                            <div style="max-width: 100px">
                                                <img src="" alt="" class="img-thumbnail"
                                                    id="front2-image-preview"
                                                    data-ijabo-default-img="{{ webLogo()->logo_front2 }}">
                                            </div>
                                            <form action="{{ route('change-web-front2') }}" method="post"
                                                id="changeBlogFront2Form">
                                                @csrf
                                                <div class="mb-2">
                                                    <input type="file" name="logo_front2" class="form-control">
                                                </div>
                                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $('input[name="logo_utama"]').ijaboViewer({
            preview: '#logo-image-preview',
            // imageShape: 'rectangular',
            allowedExtensions: ['jpg', 'jpeg', 'png'],
            onErrorShape: function(message, element) {
                alert(message);
            },
            onInvalidType: function(message, element) {
                alert(message);
            },
            onSuccess: function(message, element) {

            }
        });
        $('input[name="logo_email"]').ijaboViewer({
            preview: '#email-image-preview',
            // imageShape: 'rectangular',
            allowedExtensions: ['jpg', 'jpeg', 'png'],
            onErrorShape: function(message, element) {
                alert(message);
            },
            onInvalidType: function(message, element) {
                alert(message);
            },
            onSuccess: function(message, element) {

            }
        });
        $('input[name="logo_favicon"]').ijaboViewer({
            preview: '#favicon-image-preview',
            // imageShape: 'square',
            allowedExtensions: ['ico'],
            onErrorShape: function(message, element) {
                alert(message);
            },
            onInvalidType: function(message, element) {
                alert(message);
            },
            onSuccess: function(message, element) {

            }
        });
        $('input[name="logo_front"]').ijaboViewer({
            preview: '#front-image-preview',
            // imageShape: 'square',
            allowedExtensions: ['jpg', 'jpeg', 'png'],
            onErrorShape: function(message, element) {
                alert(message);
            },
            onInvalidType: function(message, element) {
                alert(message);
            },
            onSuccess: function(message, element) {

            }
        });
        $('input[name="logo_front2"]').ijaboViewer({
            preview: '#front2-image-preview',
            // imageShape: 'square',
            allowedExtensions: ['jpg', 'jpeg', 'png'],
            onErrorShape: function(message, element) {
                alert(message);
            },
            onInvalidType: function(message, element) {
                alert(message);
            },
            onSuccess: function(message, element) {

            }
        });

        $('#changeBlogLogoForm').submit(function(e) {
            e.preventDefault();
            var form = this;
            $.ajax({
                url: $(form).attr('action'),
                method: $(form).attr('method'),
                data: new FormData(form),
                processData: false,
                dataType: 'json',
                contentType: false,
                beforeSend: function() {},
                success: function(data) {
                    toastr.remove();
                    if (data.status == 1) {
                        toastr.success(data.msg);
                        $(form)[0].reset();
                        Livewire.emit('updateTopHeader')
                    } else {
                        toastr.error(data.msg);
                    }
                }
            });
        })

        $('#changeWebEmailLogoForm').submit(function(e) {
            e.preventDefault();
            var form = this;
            $.ajax({
                url: $(form).attr('action'),
                method: $(form).attr('method'),
                data: new FormData(form),
                processData: false,
                dataType: 'json',
                contentType: false,
                beforeSend: function() {},
                success: function(data) {
                    toastr.remove();
                    if (data.status == 1) {
                        toastr.success(data.msg);
                        $(form)[0].reset();
                        Livewire.emit('updateTopHeader')
                    } else {
                        toastr.error(data.msg);
                    }
                }
            });
        })
        $('#changeBlogFaviconForm').submit(function(e) {
            e.preventDefault();
            var form = this;
            $.ajax({
                url: $(form).attr('action'),
                method: $(form).attr('method'),
                data: new FormData(form),
                processData: false,
                dataType: 'json',
                contentType: false,
                beforeSend: function() {},
                success: function(data) {
                    toastr.remove();
                    if (data.status == 1) {
                        toastr.success(data.msg);
                        $(form)[0].reset();
                        // Livewire.emit('updateTopHeader')
                    } else {
                        toastr.error(data.msg);
                    }
                }
            });
        })
        $('#changeBlogFrontForm').submit(function(e) {
            e.preventDefault();
            var form = this;
            $.ajax({
                url: $(form).attr('action'),
                method: $(form).attr('method'),
                data: new FormData(form),
                processData: false,
                dataType: 'json',
                contentType: false,
                beforeSend: function() {},
                success: function(data) {
                    toastr.remove();
                    if (data.status == 1) {
                        toastr.success(data.msg);
                        $(form)[0].reset();
                        // Livewire.emit('updateTopHeader')
                    } else {
                        toastr.error(data.msg);
                    }
                }
            });
        })
        $('#changeBlogFront2Form').submit(function(e) {
            e.preventDefault();
            var form = this;
            $.ajax({
                url: $(form).attr('action'),
                method: $(form).attr('method'),
                data: new FormData(form),
                processData: false,
                dataType: 'json',
                contentType: false,
                beforeSend: function() {},
                success: function(data) {
                    toastr.remove();
                    if (data.status == 1) {
                        toastr.success(data.msg);
                        $(form)[0].reset();
                        // Livewire.emit('updateTopHeader')
                    } else {
                        toastr.error(data.msg);
                    }
                }
            });
        })
    </script>
@endpush
