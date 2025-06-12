<!-- Sidebar Section -->
<aside id="pwe-aside">
    <!-- Logo -->
    <h1 id="pwe-logo">
        <a href="/"><img src="{{ webLogo()->logo_front }}" alt="Logo" class="img-fluid"
                style="width: 70px; height: 70px;">
            <span>weddings <small>&#8226;</small> events</span></a>
    </h1>
    <!-- Menu -->
    <nav id="pwe-main-menu">
        <ul>
            <li @if (request()->is('/')) class="pwe-active" @endif><a href="/">Home</a></li>
            <li @if (request()->is('about')) class="pwe-active" @endif><a href="{{ route('aboutHome') }}">About</a>
            </li>
            <li @if (request()->is('makeups') || request()->is('makeup/event/*') || request()->is('makeup/wedding/*'))
                class="pwe-active" @endif>
                <a href="{{ route('makeups') }}">Makeups</a>
            </li>
            <li @if (request()->is('decoration/*')) class="pwe-active" @endif><a
                    href="{{ route('decoration.list') }}">Decorations</a>
            </li>
            <li @if (request()->is('entertainment/*')) class="pwe-active" @endif><a
                    href="{{ route('entertainment.list') }}">Entertainment</a>
            </li>
            <li @if (request()->is('documentation') || request()->is('documentation/*')) class="pwe-active" @endif>
                <a href="{{ route('portofolio') }}">Our Clients</a>
            </li>
            <li @if (request()->is('catering/*')) class="pwe-active" @endif><a
                    href="{{ route('catering.list') }}">Catering</a>
            </li>
            <li @if (request()->is('gallery') || request()->is('gallery/*')) class="pwe-active" @endif>
                <a href="{{ route('galleri') }}">Our Gallery</a>
            </li>
            {{--
            <li @if (request()->is('services')) class="pwe-active" @endif><a
                    href="{{ route('servicesHome') }}">Services</a></li> --}}
            {{-- <li @if (request()->is('portfolio')) class="pwe-active" @endif><a
                    href="{{ route('portfolioHome') }}">Portfolio</a></li> --}}
            {{-- <li @if (request()->is('blog')) class="pwe-active" @endif><a href="{{ route('blogHome') }}">Blog</a>
            </li> --}}
            <li @if (request()->is('contact')) class="pwe-active" @endif><a
                    href="{{ route('contactHome') }}">Contact</a></li>
        </ul>
    </nav>
    <!-- Sidebar Footer -->
    <div class="pwe-footer">
        <div class="separator"></div>
        <p>{{ webInfo()->web_telp }}
            <br />{{ webInfo()->web_email }}
        </p>
        <div class="social">
            <a href="{{ webSosmed()->facebook }}"><i class="ti-facebook"></i></a> <a
                href="{{ webSosmed()->twitter }}"><i class="ti-twitter-alt"></i></a> <a
                href="{{ webSosmed()->instagram }}"><i class="ti-instagram"></i></a> <a
                href="{{ webSosmed()->tiktok }}">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="black" class="fa-lg">
                    <path
                        d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z" />
                </svg>
            </a>
        </div>
    </div>
</aside>