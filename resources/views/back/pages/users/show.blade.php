@extends('back.layouts.pages-layout')

@section('pageTitle', 'profile ' . $user->name)

@section('pageHeader')
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="page-title mb-0 font-size-18">Profile {{ $user->name }}</h4>

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
                            <div class="">
                                <img src="{{ $user->picture }}" alt=""
                                    class="avatar-lg mx-auto img-thumbnail rounded-circle">
                                <style>
                                    .profile {
                                        position: absolute;
                                        top: 50px;
                                        right: 0;
                                        left: 75px;
                                    }

                                    .edit-icon i {
                                        font-size: 16px;
                                    }
                                </style>
                            </div>

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



    </div>
@endsection
