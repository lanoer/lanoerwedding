<div class="row">
    <div class="col-md-3 mb-3">
        <div class="card shadow border-0 bg-primary text-white">
            <div class="card-body d-flex align-items-center">
                <div class="me-3">
                    <i class="fas fa-users fa-2x"></i>
                </div>
                <div>
                    <h6 class="mb-0">Total Users</h6>
                    <h2 class="mb-0">{{ $totalUsers }}</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card shadow border-0 bg-success text-white">
            <div class="card-body d-flex align-items-center">
                <div class="me-3">
                    <i class="fas fa-magic fa-2x"></i>
                </div>
                <div>
                    <h6 class="mb-0">Wedding Makeups</h6>
                    <h2 class="mb-0">{{ $totalWeddings }}</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card shadow border-0 bg-warning text-white">
            <div class="card-body d-flex align-items-center">
                <div class="me-3">
                    <i class="fas fa-paint-brush fa-2x"></i>
                </div>
                <div>
                    <h6 class="mb-0">Event Makeups</h6>
                    <h2 class="mb-0">{{ $totalEvent }}</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card shadow border-0 bg-info text-white">
            <div class="card-body d-flex align-items-center">
                <div class="me-3">
                    <i class="fas fa-utensils fa-2x"></i>
                </div>
                <div>
                    <h6 class="mb-0">Catering Packages</h6>
                    <h2 class="mb-0">{{ $totalCatering }}</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card shadow border-0 bg-danger text-white">
            <div class="card-body d-flex align-items-center">
                <div class="me-3">
                    <i class="fas fa-gem fa-2x"></i>
                </div>
                <div>
                    <h6 class="mb-0">Decorations</h6>
                    <h2 class="mb-0">{{ $totalDecorations }}</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card shadow border-0 bg-primary text-white">
            <div class="card-body d-flex align-items-center">
                <div class="me-3">
                    <i class="fas fa-music fa-2x"></i>
                </div>
                <div>
                    <h6 class="mb-0">Live Music</h6>
                    <h2 class="mb-0">{{ $totalMusic }}</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card shadow border-0 bg-info text-white">
            <div class="card-body d-flex align-items-center">
                <div class="me-3">
                    <i class="fas fa-music fa-2x"></i>
                </div>
                <div>
                    <h6 class="mb-0">Sound System</h6>
                    <h2 class="mb-0">{{ $totalSoundSystem }}</h2>
                </div>
            </div>
        </div>
    </div>


</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow border-0">
            <div class="card-header bg-primary text-white d-flex align-items-center">
                <i class="fas fa-chart-bar me-2"></i>
                <span class="fw-bold">Top Views Minggu Ini</span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width:40px">#</th>
                                <th>Nama</th>
                                <th>Model</th>
                                <th>Views</th>
                                <th>Link</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topVisitedItems as $i => $item)
                            <tr>
                                <td class="fw-bold">{{ $i+1 }}</td>
                                <td class="text-start">{{ $item['title'] }}</td>
                                <td><span class="badge bg-info">{{ $item['model'] }}</span></td>
                                <td><span class="badge bg-success fs-6">{{ $item['views'] }}</span></td>
                                <td>
                                    <a href="{{ $item['url'] }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-external-link-alt"></i> Lihat
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-12">
    <div class="row">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Most visited post</h4>
                    <div class="table-responsive">
                        <table class="table table-striped gy-7 gs-7">
                            <thead>
                                <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                    <th>No</th>
                                    <th>Post title</th>
                                    <th>Author</th>
                                    <th>Views Today</th>
                                    <th>View last 30 days</th>
                                    <th>View last 90 days</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($posts as $e => $item)
                                <tr>
                                    <td> {{ $e + 1 }}</td>
                                    <td>
                                        <a href="" style="font-size: 12px">{{ Str::limit($item->post_title, 20, '...')
                                            }}</a>
                                    </td>
                                    <td>{{ $item->author->name }}</td>
                                    <td>{{
                                        views($item)->period(\CyrildeWit\EloquentViewable\Support\Period::since(today()))->count()
                                        }}
                                    </td>
                                    <td>{{
                                        views($item)->period(\CyrildeWit\EloquentViewable\Support\Period::pastDays(30))->count()
                                        }}
                                    </td>
                                    <td>{{
                                        views($item)->period(\CyrildeWit\EloquentViewable\Support\Period::pastDays(90))->count()
                                        }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    @livewire('back.activity-log')
                </div>
            </div>
        </div>
    </div>
</div>