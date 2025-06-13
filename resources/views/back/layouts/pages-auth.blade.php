@include('back.layouts.inc.header')

<style>
    .card.transparan {
        background: rgba(255, 255, 255, 0.3);
        /* Putih transparan */
        backdrop-filter: blur(5px);
        /* Efek blur pada background */
        -webkit-backdrop-filter: blur(8px);
        /* Untuk Safari */
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 8px 32px 0 rgba(255, 220, 152, 0.37);
    }

    .card.transparan .card-body {
        color: #222;
        /* Pastikan teks tetap jelas */
    }

    .bg-animate {
        animation: zoomMoveBg 20s linear infinite;
        background-repeat: no-repeat;
    }

    @keyframes zoomMoveBg {
        0% {
            background-size: 100% 100%;
            background-position: center top;
        }

        50% {
            background-size: 110% 110%;
            background-position: center bottom;
        }

        100% {
            background-size: 100% 100%;
            background-position: center top;
        }
    }
</style>

<body class="bg-animate" style="background-image: url('{{ asset('back/assets/images/21.jpg') }}');">
    <div class="home-btn d-none d-sm-block">
        <a href="/home" class="text-reset"><i class="fas fa-home h2"></i></a>
    </div>
    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden transparan">
                        <div class="text-center">
                            {{-- <div class="bg-login-overlay"></div> --}}
                            <div class="position-relative">
                                <h5 class="mt-5 font-size-20">Welcome Back !</h5>
                                <p class="mb-0" style="color: #222;">Sign in to continue to Lanoer Wedding.</p>
                            </div>
                        </div>
                        <div class="card-body pt-5">
                            @yield('content')

                        </div>
                    </div>
                    <div class="mt-5 text-center text-white">
                        <p>©
                            <script>
                                document.write(new Date().getFullYear())
                            </script> Lanoer Wedding
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @include('back.layouts.inc.scripts')