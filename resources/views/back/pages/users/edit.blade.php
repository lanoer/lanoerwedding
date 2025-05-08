@extends('back.layouts.pages-layout')

@section('pageTitle', 'Edit profile')

@section('pageHeader')
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="page-title mb-0 font-size-18">Edit Profile</h4>

            <div class="page-title-right">
                @include('components.breadcrumbs')
            </div>

        </div>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12 col-xl-3">
            <div class="card">
                <div class="card-body">
                    <div class="profile-widgets py-3">

                        <div class="text-center">
                            @livewire('back.user-profile')

                            <div class="mt-3 ">
                                <a href="#" class="text-reset fw-medium font-size-16">{{ $user->name }}</a>
                                <p class="text-body mt-1 mb-1">{{ $user->roles->first()->name }}</p>
                            </div>



                            <div class="mt-4">

                                <ui class="list-inline social-source-list">
                                    <li class="list-inline-item">
                                        <div class="avatar-xs">
                                            <span class="avatar-title rounded-circle">
                                                <a href="{{ $user->fb }}" class="text-reset">
                                                    <i class="mdi mdi-facebook"></i>
                                                </a>
                                            </span>
                                        </div>
                                    </li>

                                    <li class="list-inline-item">
                                        <div class="avatar-xs">
                                            <span class="avatar-title rounded-circle bg-info">
                                                <a href="{{ $user->tw }}" class="text-reset">
                                                    <i class='bx bxl-twitter'></i>
                                                </a>
                                            </span>
                                        </div>
                                    </li>

                                    <li class="list-inline-item">
                                        <div class="avatar-xs">
                                            <span class="avatar-title rounded-circle bg-black">
                                                <a href="{{ $user->tik }}" class="text-reset">
                                                    <i class='bx bxl-tiktok'></i>
                                                </a>
                                            </span>
                                        </div>
                                    </li>

                                    <li class="list-inline-item">
                                        <div class="avatar-xs">
                                            <span class="avatar-title rounded-circle bg-pink">
                                                <a href="{{ $user->ig }}" class="text-reset">
                                                    <i class='bx bxl-instagram'></i>
                                                </a>
                                            </span>
                                        </div>
                                    </li>
                                </ui>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3">Personal Information</h5>

                    <p class="card-title-desc">
                        {{ $user->bio }}
                    </p>

                    <div class="mt-3">
                        <p class="font-size-12 text-muted mb-1">Email Address</p>
                        <h6 class="">{{ $user->email }}</h6>
                    </div>

                    <div class="mt-3">
                        <p class="font-size-12 text-muted mb-1">Phone number</p>
                        <h6 class="">{{ $user->telp }}</h6>
                    </div>

                    <div class="mt-3">
                        <p class="font-size-12 text-muted mb-1"> Address</p>
                        <h6 class="">{{ $user->alamat }}</h6>
                    </div>

                </div>
            </div>

        </div>

        <div class="col-md-12 col-xl-9">


            <div class="card">
                <div class="card-body">

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" data-bs-toggle="tab" href="#experience" role="tab"
                                aria-selected="true">
                                <span class="d-block d-sm-none"><i class="fas fa-user"></i></span>
                                <span class="d-none d-sm-block">Personal details</span>
                            </a>
                        </li>


                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" href="#sosmed" role="tab" aria-selected="false"
                                tabindex="-1">
                                <span class="d-block d-sm-none"><i class="fas fa-globe"></i></span>
                                <span class="d-none d-sm-block">Sosial Media</span>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" href="#settings" role="tab" aria-selected="false"
                                tabindex="-1">
                                <span class="d-block d-sm-none"><i class="fas fa-key"></i></span>
                                <span class="d-none d-sm-block">Password</span>
                            </a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content p-3 text-muted">
                        <div class="tab-pane active show" id="experience" role="tabpanel">
                            <div class="timeline-count mt-5">
                                <!-- personal detail row Start -->

                                @livewire('back.personal-detail')
                                <!-- personal detail row Over -->

                            </div>
                        </div>

                        <div class="tab-pane" id="sosmed" role="tabpanel">

                            @livewire('back.sosmed')

                        </div>
                        <div class="tab-pane" id="settings" role="tabpanel">

                            @livewire('back.canghe-password')

                        </div>
                    </div>

                </div>
            </div>

        </div>


    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('triggerFileUpload').addEventListener('click', function(event) {
                event.preventDefault();
                document.getElementById('changeUserProfilePicture').click();
            });
        });
        $('#changeUserProfilePicture').ijaboCropTool({
            preview: '',
            setRatio: 1,
            allowedExtensions: ['jpg', 'jpeg', 'png'],
            buttonsText: ['CROP', 'QUIT'],
            buttonsColor: ['#30bf7d', '#ee5155', -15],
            processUrl: '{{ route('change-profile-picture') }}',
            withCSRF: ['_token', '{{ csrf_token() }}'],
            onSuccess: function(message, element, status) {
                livewire.emit('updateUserProfile');
                livewire.emit('updateTopHeader');
                livewire.emit('updateUserProfileSide');
                // flash.addSuccess(message);
                toastr.success(message);
            },
            onError: function(message, element, status) {
                toastr.error(message);
                // flash.addError(message);
            }
        });
    </script>
@endpush
