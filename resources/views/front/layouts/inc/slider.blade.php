<aside id="pwe-hero" class="js-fullheight">
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
                                        <div class="btn-contact"><a href="{{ $slide->action_link }}"
                                                target="_blank"><span>{{ $slide->action_text }}</span></a></div>
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
