@include('back.layouts.inc.header')

<body data-layout="detached" data-topbar="colored">
    <!-- <body data-layout="horizontal" data-topbar="dark"> -->

    <div class="container-fluid">
        <!-- Begin page -->
        <div id="layout-wrapper">

            <header id="page-topbar">
                <div class="navbar-header">
                    <div class="container-fluid">
                        <div class="float-end">

                            <div class="dropdown d-inline-block d-lg-none ms-2">
                                <button type="button" class="btn header-item noti-icon waves-effect"
                                    id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    <i class="mdi mdi-magnify"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                                    aria-labelledby="page-header-search-dropdown">

                                    <form class="p-3">
                                        <div class="m-0">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Search ..."
                                                    aria-label="Recipient's username">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" type="submit"><i
                                                            class="mdi mdi-magnify"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="dropdown d-none d-lg-inline-block ms-1">
                                <button type="button" class="btn header-item noti-icon waves-effect"
                                    data-toggle="fullscreen">
                                    <i class="mdi mdi-fullscreen"></i>
                                </button>
                            </div>

                            @include('back.layouts.inc.notif')

                            @include('back.layouts.inc.top-bar')

                            <div class="dropdown d-inline-block">
                                <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect"
                                    data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample"
                                    aria-controls="offcanvasExample">
                                    <i class="mdi mdi-settings-outline"></i>
                                </button>
                            </div>

                        </div>
                        <div>
                            <!-- LOGO -->
                            <div class="navbar-brand-box">
                                <a href="/" class="logo logo-dark">
                                    <span class="logo-sm">
                                        <img src="{{ webLogo()->logo_utama }}" alt="{{ webInfo()->web_name }}"
                                            height="50">
                                    </span>
                                    <span class="logo-lg">
                                        <img src="{{ webLogo()->logo_utama }}" alt="{{ webInfo()->web_name }}"
                                            height="60">
                                    </span>
                                </a>

                                <a href="/" class="logo logo-light">
                                    <span class="logo-sm">
                                        <img src="{{ webLogo()->logo_utama }}" alt="{{ webInfo()->web_name }}"
                                            height="40">
                                    </span>
                                    <span class="logo-lg">
                                        <img src="{{ webLogo()->logo_utama }}" alt="{{ webInfo()->web_name }}"
                                            height="45">
                                    </span>
                                </a>
                            </div>

                            <button type="button"
                                class="btn btn-sm px-3 font-size-16 header-item toggle-btn waves-effect"
                                id="vertical-menu-btn">
                                <i class="fa fa-fw fa-bars"></i>
                            </button>

                            <!-- App Search-->
                            <form class="app-search d-none d-lg-inline-block">
                                <div class="position-relative">
                                    <input type="text" class="form-control" placeholder="Search...">
                                    <span class="bx bx-search-alt"></span>
                                </div>
                            </form>

                            <div class="dropdown dropdown-mega d-none d-lg-inline-block ms-2">
                                <button type="button" class="btn header-item waves-effect" data-bs-toggle="dropdown"
                                    aria-haspopup="false" aria-expanded="false">
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </header>
            <!-- ========== Left Sidebar Start ========== -->
            @include('back.layouts.inc.sidebar')
            <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">

                    <!-- start page title -->
                    <div class="row">
                        @yield('pageHeader')
                    </div>
                    <!-- end page title -->
                    <div class="row">
                        @yield('content')
                    </div>
                </div>
                <!-- End Page-content -->
                @include('back.layouts.inc.footer')
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

    </div>
    <!-- end container-fluid -->

    <!-- Right Sidebar -->

    @include('back.layouts.inc.right-sidebar')

    <!-- /Right-bar -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    <!-- JAVASCRIPT -->
    @include('back.layouts.inc.scripts')
