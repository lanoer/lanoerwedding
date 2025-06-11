<div class="row">
    <!-- Card 1 (Premium Catering) -->
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <!-- Using optional to prevent errors when $premiumCaterings is null -->
            <img src="{{ asset('storage/back/images/catering/premium/' . optional($premiumCaterings)->image) }}"
                class="card-img-top" alt="Thumbnail 1" style="height: 200px; object-fit: cover;">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title">{{ optional($premiumCaterings)->name }}</h5>
                <div class="mt-auto d-flex justify-content-between align-items-center">
                    <a href="" class="btn btn-primary btn-sm mx-2" data-bs-toggle="tooltip" data-bs-placement="top"
                        title="Show Details"><i class="bx bx-show"></i></a>
                    <a href="{{ route('catering.sub.editPremium', optional($premiumCaterings)->id) }}"
                        class="btn btn-warning btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i
                            class="bx bx-edit"></i></a>
                </div>
            </div>
        </div>
    </div> <!-- End of Card 1 -->

    <!-- Card 2 (Medium Catering) -->
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <!-- Using optional to prevent errors when $mediumCaterings is null -->
            <img src="{{ asset('storage/back/images/catering/medium/' . optional($mediumCaterings)->image) }}"
                class="card-img-top" alt="Thumbnail 1" style="height: 200px; object-fit: cover;">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title">{{ optional($mediumCaterings)->name }}</h5>
                <div class="mt-auto d-flex justify-content-between align-items-center">
                    <a href="" class="btn btn-primary btn-sm mx-2" data-bs-toggle="tooltip" data-bs-placement="top"
                        title="Show Details"><i class="bx bx-show"></i></a>
                    <a href="{{ route('catering.sub.editMedium', optional($mediumCaterings)->id) }}"
                        class="btn btn-warning btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i
                            class="bx bx-edit"></i></a>
                </div>
            </div>
        </div>
    </div> <!-- End of Card 2 -->
</div>