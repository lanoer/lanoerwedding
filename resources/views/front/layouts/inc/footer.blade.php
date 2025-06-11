<!-- Footer -->
{{-- <style>
    #pwe-footer2 {
        padding: 100px 60px;
        background: #f9f3ed;
    }

    #pwe-footer2 h2,
    #pwe-footer2 h2 a {
        font-family: 'Cormorant Garamond', serif;
        font-size: 40px;
        font-weight: 500;
        display: block;
        width: 100%;
        position: relative;
        color: #000000;
        line-height: 1em;
        letter-spacing: 0px;
    }

    #pwe-footer2 p {
        color: #000000
    }

    #pwe-footer2 .social a {
        color: #000000
    }
</style> --}}

<style>
    #pwe-footer2 {
        padding: 100px 60px;
        background: linear-gradient(to bottom, #f6f2ed, #d8c9a3);
        /* Top-to-bottom gradient */
    }

    #pwe-footer2 h2,
    #pwe-footer2 h2 a {
        font-family: 'Cormorant Garamond', serif;
        font-size: 40px;
        font-weight: 500;
        display: block;
        width: 100%;
        position: relative;
        color: #000000;
        line-height: 1em;
        letter-spacing: 0px;
    }

    #pwe-footer2 p {
        color: #000000;
    }

    #pwe-footer2 .social a {
        color: #000000;
    }
</style>
<div id="pwe-footer2">
    <div class="pwe-narrow-content">
        <div class="row">
            <div class="col-md-3 animate-box" data-animate-effect="fadeInLeft">
                <h2>
                    <a href="/">
                        <img src="{{ webLogo()->logo_front2 }}" alt="Logo" class="img-fluid"
                            style="width: 70px; height: 70px; margin-bottom: 10px;">
                        <span>weddings <small>&#8226;</small> events</span>
                    </a>
                </h2>
                <style>
                    .social a {
                        font-size: 24px;
                        /* Set the size for the icons */
                        margin-right: 15px;
                        /* Space between icons */
                    }

                    .social a i,
                    .social a svg {
                        transition: color 0.3s ease;
                        /* Smooth transition on hover */
                    }

                    /* Facebook icon color */
                    .social a[href="{{ webSosmed()->facebook }}"] i {
                        color: #1877F2;
                        /* Facebook blue */
                    }

                    /* Twitter icon color */
                    .social a[href="{{ webSosmed()->twitter }}"] i {
                        color: #1DA1F2;
                        /* Twitter blue */
                    }

                    /* Instagram icon color */
                    .social a[href="{{ webSosmed()->instagram }}"] i {
                        color: #E4405F;
                        /* Instagram pink */
                    }

                    /* TikTok icon color */
                    .social a[href="{{ webSosmed()->tiktok }}"] svg {
                        fill: #000000;
                        /* TikTok default color */
                    }

                    /* Hover effects for icons */
                    .social a:hover i,
                    .social a:hover svg {
                        color: #000;
                        /* Change to black when hovered */
                    }
                </style>
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
            <div class="col-md-3 animate-box" data-animate-effect="fadeInLeft">
                <h6>Our Links</h6>
                <div class="row">
                    <div class="col-6">
                        <p><a href="{{ route('home') }}">Home</a></p>
                        <p><a href="{{ route('aboutHome') }}">About</a></p>
                    </div>
                    <div class="col-6">
                        <p><a href="{{ route('blog') }}">Blog</a></p>
                        <p><a href="">Contact</a></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 animate-box" data-animate-effect="fadeInLeft">
                <h6>Phone</h6>
                <p>{{ webInfo()->web_telp }}</p>
                <h6>Email</h6>
                <p>{{ webInfo()->web_email }}</p>
            </div>
            <div class="col-md-3 animate-box" data-animate-effect="fadeInLeft">
                <h6>Address</h6>
                <p>{{ webInfo()->web_alamat }}</p>
                <p class="copyright" style="color:#000000">{{ webInfo()->web_name }}&copy; {{ date('Y') }}. All rights
                    reserved.</p>
            </div>
        </div>
    </div>
</div>