@include('front.layouts.inc.head')

<body>
    @include('front.layouts.inc.whatsapp')


    <!-- Preloader -->
    <div class="preloader-bg"></div>
    <div id="preloader">
        <div id="preloader-status">
            <div class="preloader-position loader"> <span></span> </div>
        </div>
    </div>
    <!-- Content -->
    <div id="pwe-page">
        <a href="#" class="js-pwe-nav-toggle pwe-nav-toggle"><i></i></a>
        @include('front.layouts.inc.sidebar')
        <!-- Main Section -->
        @yield('content')


        @include('front.layouts.inc.js')
