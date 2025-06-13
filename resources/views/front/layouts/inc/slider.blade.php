<aside id="pwe-hero" class="js-fullheight">
    <style>
        #pwe-hero .slider-text-inner .desc h1 {
            font-size: 2.5em;
        }

        #pwe-hero .slider-text-inner .desc p {
            font-size: 1.2em;
        }

        @media only screen and (max-width: 768px) {
            #pwe-hero .flexslider .slider-text>.slider-text-inner h1 {
                font-size: 20px;
            }

            #pwe-hero .slider-text-inner .desc {
                padding: 10px;
            }

            #pwe-hero .slider-text-inner .desc h1 {
                font-size: 1em;
            }

            #pwe-hero .slider-text-inner .desc p {
                font-size: 1em;
            }

            #pwe-hero .slider-text-inner .desc .btn-contact a {
                padding: 8px 15px;
                font-size: 0.9em;
            }
        }

        @media only screen and (max-width: 480px) {
            #pwe-hero .slider-text-inner .desc h1 {
                font-size: 1em;
            }

            #pwe-hero .slider-text-inner .desc p {
                font-size: 0.9em;
            }

            #pwe-hero .slider-text-inner .desc .btn-contact a {
                padding: 6px 12px;
                font-size: 0.8em;
            }
        }
    </style>

    <div class="flexslider js-fullheight">
        <ul class="slides">
            @foreach (slider()->where('isActive_slider', true) as $slide)
            <!-- Check if is_active is true -->
            <li style="background-image: url({{ asset('storage/back/images/slider/' . $slide->image) }});">
                <div class="overlay"></div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6 js-fullheight slider-text">
                            @if ($slide->isActive_slider)
                            <div class="slider-text-inner">
                                <div class="desc">
                                    <h6>{{ $slide->category }}</h6>
                                    <h1>{{ $slide->title }}</h1>
                                    <p>{{ $slide->desc_short }}</p>
                                    <div class="btn-contact">
                                        <a href="{{ $slide->action_link }}">
                                            <span>{{ $slide->action_text }}</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

            </li>
            @endforeach
        </ul>
    </div>
</aside>