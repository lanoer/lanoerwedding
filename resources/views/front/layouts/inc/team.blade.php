<div class="team-section team pt-90 pb-90 bg-pink">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 mb-30"> <span class="heading-meta">associate</span>
                <h2 class="pwe-heading mb-30 animate-box" data-animate-effect="fadeInLeft">Creative Team</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 owl-carousel owl-theme animate-box" data-animate-effect="fadeInLeft">
                @foreach (teamCreative() as $team)
                <div class="item">
                    <div class="img"> <img
                            src="{{ asset('storage/back/images/team/thumbnails/thumb_600_' . $team->image) }}" alt="">
                    </div>
                    <div class="info">
                        <h6>{{ $team->name }}</h6>
                        <p>{{ $team->position }}</p>
                        <div class="social valign">
                            <div class="full-width">
                                <style>
                                    .social-icon {
                                        display: inline-flex;
                                        align-items: center;
                                        justify-content: center;
                                        width: 30px;
                                        height: 30px;
                                        margin: 0 5px;
                                    }

                                    .social-icon i {
                                        font-size: 15px;
                                    }

                                    .social-icon svg {
                                        width: 15px;
                                        height: 15px;
                                    }
                                </style>
                                <p><i>Follow Me!</i></p>
                                <a href="{{ $team->facebook }}" class="social-icon"><i class="ti-facebook"></i></a>
                                <a href="{{ $team->twitter }}" class="social-icon"><i class="ti-twitter-alt"></i></a>
                                <a href="{{ $team->instagram }}" class="social-icon"><i class="ti-instagram"></i></a>
                                <a href="{{ $team->tiktok }}" class="social-icon">
                                    <svg width="15" height="15" viewBox="0 0 25 25" fill="black" class="fa-lg">
                                        <path
                                            d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>