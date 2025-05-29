@include('back.layouts.inc.header')

<body>
    {{-- Loader --}}
    <div id="loader" class="position-fixed top-50 start-50 translate-middle" style="display: none; z-index: 1050;">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <div class="home-btn d-none d-sm-block">
        <a href="{{ route('home') }}" class="text-reset"><i class="fas fa-home h2"></i></a>
    </div>

    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class="bg-login text-center">
                            <div class="bg-login-overlay"></div>
                            <div class="position-relative">
                                <h5 class="text-white font-size-20">Reset Password</h5>
                                <p class="text-white-50 mb-0">Reset your password with {{ config('app.name') }}.</p>
                                <a href="{{ route('home') }}" class="logo logo-admin mt-4">
                                    <img src="/back/assets/images/logo-sm-dark.png" alt="" height="30">
                                </a>
                            </div>
                        </div>

                        <div class="card-body pt-5">
                            <div class="p-2">
                                {{-- Success Notification --}}
                                @if (session('status'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('status') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                                @endif

                                {{-- Error Notification --}}
                                @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ $errors->first() }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                                @endif

                                {{-- Reset Form --}}
                                <form method="POST" action="{{ route('auth.reset-password.submit') }}"
                                    onsubmit="showLoader()">
                                    @csrf
                                    <input type="hidden" name="token" value="{{ $token }}">

                                    <div class="mb-3">
                                        <label>Email</label>
                                        <input type="email" name="email" class="form-control"
                                            placeholder="Enter your email" required>
                                    </div>

                                    <div class="mb-3">
                                        <label>New Password</label>
                                        <input type="password" name="password" class="form-control"
                                            placeholder="Enter new password" required>
                                    </div>

                                    <div class="mb-3">
                                        <label>Confirm Password</label>
                                        <input type="password" name="password_confirmation" class="form-control"
                                            placeholder="Confirm password" required>
                                    </div>

                                    <button type="submit" class="btn btn-primary w-100">Reset Password</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5 text-center">
                        <p>Back to <a href="{{ route('auth.login') }}" class="fw-medium text-primary">Login</a></p>
                        <p>© <script>
                                document.write(new Date().getFullYear())
                            </script> {{ config('app.name') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('back.layouts.inc.scripts')

    <script>
        function showLoader() {
            document.getElementById("loader").style.display = "block";
        }

        // Optional: Auto-dismiss alert after 5s
        document.addEventListener('DOMContentLoaded', function () {
            const alerts = document.querySelectorAll('.alert');
            setTimeout(() => {
                alerts.forEach(alert => {
                    const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
                    bsAlert.close();
                });
            }, 5000);
        });
    </script>
</body>