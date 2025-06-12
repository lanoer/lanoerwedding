<aside id="pwe-hero" class="js-fullheight">
    <style>
        #pwe-hero .slider-text-inner .desc h1 {
            font-size: 2.5em;
            /* Default size */
        }

        #pwe-hero .slider-text-inner .desc p {
            font-size: 1.2em;
            /* Default size */
        }

        @media only screen and (max-width: 768px) {
            #pwe-hero .flexslider .slider-text>.slider-text-inner h1 {
                font-size: 20px;
                /* Reduce font size on smaller screens */
            }

            #pwe-hero .slider-text-inner .desc {
                padding: 10px;
            }

            #pwe-hero .slider-text-inner .desc h1 {
                font-size: 1em;
                /* Reduce font size on smaller screens */
            }

            #pwe-hero .slider-text-inner .desc p {
                font-size: 1em;
                /* Reduce font size on smaller screens */
            }

            #pwe-hero .slider-text-inner .desc .btn-contact a {
                padding: 8px 15px;
                font-size: 0.9em;
                /* Reduce button size */
            }

        }

        @media only screen and (max-width: 480px) {
            #pwe-hero .slider-text-inner .desc h1 {
                font-size: 1em;
                /* Further reduce font size */
            }

            #pwe-hero .slider-text-inner .desc p {
                font-size: 0.9em;
                /* Further reduce font size */
            }

            #pwe-hero .slider-text-inner .desc .btn-contact a {
                padding: 6px 12px;
                font-size: 0.8em;
                /* Further reduce button size */
            }
        }
    </style>
    <div class="flexslider js-fullheight">
        <ul class="slides">
            @foreach (slider() as $slide)
            <li style="background-image: url({{ asset('storage/back/images/slider/' . $slide->image) }});">
                <div class="overlay"></div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6 js-fullheight slider-text">
                            <div class="slider-text-inner">
                                <div class="desc">
                                    <h6>{{ $slide->category }}</h6>
                                    <h1>{{ $slide->title }}</h1>
                                    <p>{{ $slide->desc_short }}</p>
                                    <div class="btn-contact"><a href="{{ $slide->action_link }}"><span>{{
                                                $slide->action_text }}</span></a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
</aside>