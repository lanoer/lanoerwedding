<div class="vertical-menu">
    <div class="h-100">
        <div class="user-wid text-center py-4">
            @livewire('back.user-profile-side')
        </div>

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <!-- Dashboard -->
                <li class="menu-title">Main Navigation</li>
                <li class="">
                    <a href="{{ route('home') }}" class="waves-effect">
                        <i class="mdi mdi-airplay"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <!-- User Management Section -->
                @can('read role')
                <li class="menu-title">Administration</li>
                <li class="{{ Route::is('konfigurasi.*') ? 'mm-active' : '' }}">
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="mdi mdi-account-multiple"></i>
                        <span>User Management</span>
                    </a>
                    <ul class="sub-menu {{ Route::is('konfigurasi.*') ? 'mm-collapse mm-show' : '' }}"
                        aria-expanded="true">
                        <li class="{{ Route::is('konfigurasi.roles.*') ? 'mm-active' : '' }}">
                            <a href="{{ route('konfigurasi.roles.index') }}"><span>Roles</span></a>
                        </li>
                        <li>
                            <a href="{{ route('konfigurasi.permissions.index') }}"><span>Permissions</span></a>
                        </li>
                        <li>
                            <a href="{{ route('konfigurasi.users-list.index') }}"><span>Users</span></a>
                        </li>
                    </ul>
                </li>
                @endcan

                <!-- Content Management -->
                @can('read pages')
                <li class="menu-title">Content Management</li>

                <!-- Wedding Services -->
                <li
                    class="{{ Route::is('makeup.*') || Route::is('decoration.*') || Route::is('entertainment.*') || Route::is('documentation.*') || Route::is('catering.*') || Route::is('event.*') ? 'mm-active' : '' }}">
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="mdi mdi-heart-outline"></i>
                        <span>Wedding Services</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="true">
                        <li
                            class="{{ Route::is('makeup.list') ? 'mm-active' : '' }} {{ Route::is('event.*') ? 'mm-active' : '' }} {{ Route::is('wedding.*') ? 'mm-active' : '' }} ">
                            <a href="{{ route('makeup.list') }}"><span>Makeup</span></a>
                        </li>
                        <li class="{{ Route::is('decoration.index') ? 'mm-active' : '' }}">
                            <a href="{{ route('decoration.index') }}"><span>Decoration</span></a>
                        </li>
                        <li
                            class="{{ Route::is('entertainment.index') ? 'mm-active' : '' }} {{ Route::is('entertainment.sound.*') ? 'mm-active' : '' }} {{ Route::is('entertainment.live.*') ? 'mm-active' : '' }} {{ Route::is('entertainment.ceremonial.*') ? 'mm-active' : '' }} {{ Route::is('entertainment.soundSystem.*') ? 'mm-active' : '' }} {{ Route::is('entertainment.livemusic.*') ? 'mm-active' : '' }} {{ Route::is('entertainment.ceremonialevent.*') ? 'mm-active' : '' }} ">
                            <a href="{{ route('entertainment.index') }}"><span>Entertainment</span></a>
                        </li>
                        <li
                            class="{{ Route::is('documentation.index') ? 'mm-active' : '' }} {{ Route::is('documentation.add-foto') ? 'mm-active' : '' }} ">
                            <a href="{{ route('documentation.index') }}"><span>Documentation</span></a>
                        </li>
                        <li class="{{ Route::is('catering.index') ? 'mm-active' : '' }}">
                            <a href="{{ route('catering.index') }}"><span>Catering</span></a>
                        </li>
                    </ul>
                </li>

                <!-- Website Content -->
                <li
                    class="{{ Route::is('slider.*') ? 'mm-active' : '' }} {{ Route::is('testimoni.*') ? 'mm-active' : '' }} {{ Route::is('client.*') ? 'mm-active' : '' }} {{ Route::is('aboutBackend.*') ? 'mm-active' : '' }} {{ Route::is('team.list') ? 'mm-active' : '' }}">
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="mdi mdi-web"></i>
                        <span>Website Content</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="true">
                        <li class="{{ Route::is('slider.index') ? 'mm-active' : '' }}">
                            <a href="{{ route('slider.index') }}"><span>Slider</span></a>
                        </li>
                        <li class="{{ Route::is('testimoni.index') ? 'mm-active' : '' }}">
                            <a href="{{ route('testimoni.index') }}"><span>Testimonials</span></a>
                        </li>
                        <li class="{{ Route::is('client.index') ? 'mm-active' : '' }}">
                            <a href="{{ route('client.index') }}"><span>Clients</span></a>
                        </li>
                        <li class="{{ Route::is('aboutBackend.index') ? 'mm-active' : '' }}">
                            <a href="{{ route('aboutBackend.index') }}"><span>About Us</span></a>
                        </li>
                        <li class="{{ Route::is('team.list') ? 'mm-active' : '' }}">
                            <a href="{{ route('team.list') }}"><span>Team</span></a>
                        </li>
                    </ul>
                </li>

                <!-- posts & categories -->
                <li class="{{ Route::is('posts.*') ? 'mm-active' : '' }}">
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="mdi mdi-file-document-outline"></i>
                        <span>Posts & Categories</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="true">

                        <li class="{{ Route::is('posts.categories') ? 'mm-active' : '' }}">
                            <a href="{{ route('posts.categories') }}"><span>Categories</span></a>
                        </li>
                        <li class="{{ Route::is('posts.add-posts') ? 'mm-active' : '' }}">
                            <a href="{{ route('posts.add-posts') }}"><span>Add Post</span></a>
                        </li>
                        <li class="{{ Route::is('posts.all_posts') ? 'mm-active' : '' }}">
                            <a href="{{ route('posts.all_posts') }}"><span>All Post</span></a>
                        </li>
                    </ul>
                </li>

                <!-- Settings & Configuration -->
                <li class="menu-title">Settings & Tools</li>
                <li class="{{ Route::is('settings.*') ? 'mm-active' : '' }}">
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="mdi mdi-settings"></i>
                        <span>Website Settings</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="true">

                        <li class="{{ Route::is('settings.index') ? 'mm-active' : '' }}">
                            <a href="{{ route('settings.index') }}"><span>General Settings</span></a>
                        </li>
                        <li class="{{ Route::is('insert-code') ? 'mm-active' : '' }}">
                            <a href="{{ route('insert-code') }}" class=" waves-effect">
                                <span>Insert code</span>
                            </a>

                        </li>
                    </ul>
                </li>

                <!-- Communication & Maintenance -->
                <li class="menu-title">Communication & Maintenance</li>
                @can('read contact')
                <li>
                    <a href="{{ route('inbox.index') }}"
                        class="waves-effect {{ Route::is('inbox.*') ? 'mm-active' : '' }}">
                        <i class="mdi mdi-email-outline"></i>
                        <span>Inbox</span>
                        <span class="badge bg-danger">{{ unread_inbox() }}</span>
                    </a>
                </li>
                <li class="{{ Route::is('comments') ? 'mm-active' : '' }}">
                    <a href="{{ route('comments') }}" class="waves-effect">
                        <i class="mdi mdi-comment-text-multiple"></i>
                        <span class="badge rounded-pill bg-info float-end">{{ approved_comment()->count() }}</span>
                        <span>Comments</span>
                    </a>
                </li>
                @endcan



                <li>
                    <a href="{{ route('recycle.index') }}"
                        class="waves-effect {{ Route::is('recycle.*') ? 'mm-active' : '' }}">
                        <i class="mdi mdi-delete"></i>
                        <span>Recycle Bin <span class="badge bg-danger">{{ recycle_bin()->count() }}</span></span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('logs') }}" class="waves-effect {{ Route::is('logs.*') ? 'mm-active' : '' }}">
                        <i class="mdi mdi-history"></i>
                        <span>Logs </span>
                    </a>
                </li>

                @endcan
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>