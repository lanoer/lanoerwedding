<div class="vertical-menu">

    <div class="h-100">

        <div class="user-wid text-center py-4">
            @livewire('back.user-profile-side')
        </div>

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>

                <li class="">
                    <a href="{{ route('home') }}" class="waves-effect ">
                        <i class="mdi mdi-airplay"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                @can('read role')
                    <li class="{{ Route::is('konfigurasi.*') ? 'mm-active' : '' }}">
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="mdi mdi-account-multiple"></i>
                            <span>User Management</span>
                        </a>
                        <ul class="sub-menu {{ Route::is('konfigurasi.*') ? 'mm-collapse mm-show' : '' }}"
                            aria-expanded="true">
                            <li class="{{ Route::is('konfigurasi.roles.*') ? 'mm-active' : '' }}">
                                <a href="{{ route('konfigurasi.roles.index') }}" class=" waves-effect">
                                    <span>Roles</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('konfigurasi.permissions.index') }}" class=" waves-effect">
                                    <span>Permissions</span>
                                </a>

                            </li>
                            <li>

                                <a href="{{ route('konfigurasi.users-list.index') }}" class=" waves-effect">
                                    <span>Users</span>
                                </a>
                            </li>
                        </ul>

                    </li>
                @endcan
                @can('read pages')
                    <li class="{{ Route::is('makeup.*') ? 'mm-active' : '' }}">
                        <a href="javascript: void(0);" class="has-arrow waves-effect">
                            <i class="mdi mdi-calendar-check"></i>
                            <span>Pages</span>
                        </a>
                        <ul class="sub-menu {{ Route::is('makeup.*') ? 'mm-collapse mm-show' : '' }}" aria-expanded="true">
                            <li class="{{ Route::is('makeup.list') ? 'mm-active' : '' }}">
                                <a href="{{ route('makeup.list') }}" class=" waves-effect">
                                    <span>Makeup</span>
                                </a>
                            </li>
                        </ul>
                        <ul class="sub-menu {{ Route::is('decoration.*') ? 'mm-collapse mm-show' : '' }}"
                            aria-expanded="true">
                            <li class="{{ Route::is('decoration.index') ? 'mm-active' : '' }}">
                                <a href="{{ route('decoration.index') }}" class=" waves-effect">
                                    <span>Decoration</span>
                                </a>
                            </li>
                        </ul>
                        <ul class="sub-menu {{ Route::is('entertainment.*') ? 'mm-collapse mm-show' : '' }}"
                            aria-expanded="true">
                            <li class="{{ Route::is('entertainment.index') ? 'mm-active' : '' }}">
                                <a href="{{ route('entertainment.index') }}" class=" waves-effect">
                                    <span>Entertainment</span>
                                </a>
                            </li>
                        </ul>
                        <ul class="sub-menu {{ Route::is('documentation.*') ? 'mm-collapse mm-show' : '' }}"
                            aria-expanded="true">
                            <li class="{{ Route::is('documentation.index') ? 'mm-active' : '' }}">
                                <a href="{{ route('documentation.index') }}" class=" waves-effect">
                                    <span>Documentation</span>
                                </a>

                            </li>
                        </ul>
                        <ul class="sub-menu {{ Route::is('catering.*') ? 'mm-collapse mm-show' : '' }}"
                            aria-expanded="true">
                            <li class="{{ Route::is('catering.index') ? 'mm-active' : '' }}">
                                <a href="{{ route('catering.index') }}" class=" waves-effect">
                                    <span>Catering</span>
                                </a>

                            </li>
                        </ul>
                        <ul class="sub-menu {{ Route::is('slider.*') ? 'mm-collapse mm-show' : '' }}" aria-expanded="true">
                            <li class="{{ Route::is('slider.index') ? 'mm-active' : '' }}">
                                <a href="{{ route('slider.index') }}" class=" waves-effect">
                                    <span>Slider</span>
                                </a>
                            </li>
                            <li class="{{ Route::is('testimoni.index') ? 'mm-active' : '' }}">
                                <a href="{{ route('testimoni.index') }}" class=" waves-effect">
                                    <span>Testimoni</span>
                                </a>
                            </li>
                            <li class="{{ Route::is('client.index') ? 'mm-active' : '' }}">
                                <a href="{{ route('client.index') }}" class=" waves-effect">
                                    <span>Client</span>
                                </a>
                            </li>
                        </ul>

                    </li>
                @endcan
                <li class="{{ Route::is('settings.*') ? 'mm-active' : '' }}">
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="mdi mdi-settings"></i>
                        <span>Setting web</span>
                    </a>

                    <ul class="sub-menu {{ Route::is('aboutBackend.*') ? 'mm-collapse mm-show' : '' }}
                    "
                        aria-expanded="true">
                        <li class="{{ Route::is('aboutBackend.index') ? 'mm-active' : '' }}">
                            <a href="{{ route('aboutBackend.index') }}" class=" waves-effect">
                                <span>About Us</span>
                            </a>
                        </li>
                    </ul>

                    <ul class="sub-menu {{ Route::is('team.*') ? 'mm-collapse mm-show' : '' }}
                    "
                        aria-expanded="true">
                        <li class="{{ Route::is('team.list') ? 'mm-active' : '' }}">
                            <a href="{{ route('team.list') }}" class=" waves-effect">
                                <span>Team Lanoer</span>
                            </a>
                        </li>
                    </ul>
                    <ul class="sub-menu {{ Route::is('settings.*') ? 'mm-collapse mm-show' : '' }}
                    "
                        aria-expanded="true">
                        <li class="{{ Route::is('settings.index') ? 'mm-active' : '' }}">
                            <a href="{{ route('settings.index') }}" class=" waves-effect">
                                <span>General Setting</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="">
                    <a href="{{ route('inbox.index') }}"
                        class="waves-effect {{ Route::is('inbox.*') ? 'mm-active' : '' }}">
                        <i class="mdi mdi-email-outline"></i>
                        <span>Inbox</span>
                        <span class="badge bg-danger">
                            {{ unread_inbox() }}
                        </span>
                    </a>
                </li>
                <li class="">
                    <a href="{{ route('recycle.index') }}"
                        class="waves-effect {{ Route::is('recycle.*') ? 'mm-active' : '' }}">
                        <i class="mdi mdi-delete"></i>
                        <span>Recycle Bin <span class="badge bg-danger">
                                {{ recycle_bin()->count() }}
                            </span></span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
