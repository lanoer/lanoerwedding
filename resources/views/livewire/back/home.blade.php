{{-- Dashboard Summary Cards --}}
<div class="row">
    @php
        $cards = [
            ['title' => 'Total Users', 'count' => $totalUsers, 'icon' => 'users', 'bg' => 'primary'],
            ['title' => 'Wedding Makeups', 'count' => $totalWeddings, 'icon' => 'magic', 'bg' => 'success'],
            ['title' => 'Event Makeups', 'count' => $totalEvent, 'icon' => 'paint-brush', 'bg' => 'warning'],
            ['title' => 'Catering Packages', 'count' => $totalCatering, 'icon' => 'utensils', 'bg' => 'info'],
            ['title' => 'Decorations', 'count' => $totalDecorations, 'icon' => 'gem', 'bg' => 'danger'],
            ['title' => 'Live Music', 'count' => $totalMusic, 'icon' => 'music', 'bg' => 'primary'],
            ['title' => 'Sound System', 'count' => $totalSoundSystem, 'icon' => 'music', 'bg' => 'info'],
        ];
    @endphp

    @foreach ($cards as $card)
        <div class="col-md-3 mb-3">
            <div class="card shadow border-0 bg-{{ $card['bg'] }} text-white">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-{{ $card['icon'] }} fa-2x"></i>
                    </div>
                    <div>
                        <h6 class="mb-0">{{ $card['title'] }}</h6>
                        <h2 class="mb-0">{{ $card['count'] }}</h2>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

{{-- Top Views Table --}}
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
                            @foreach ($topVisitedItems as $i => $item)
                                <tr>
                                    <td class="fw-bold">{{ $i + 1 }}</td>
                                    <td class="text-start">{{ $item['title'] }}</td>
                                    <td><span class="badge bg-info">{{ $item['model'] }}</span></td>
                                    <td><span class="badge bg-success fs-6">{{ $item['views'] }}</span></td>
                                    <td>
                                        <a href="{{ $item['url'] }}" target="_blank"
                                            class="btn btn-sm btn-outline-primary">
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



{{-- Most Visited Posts & Activity Log --}}
<div class="row">
    <div class="col-xl-8">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Most Visited Post</h4>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr class="fw-semibold text-gray-800">
                                <th>No</th>
                                <th>Post Title</th>
                                <th>Author</th>
                                <th>Views Today</th>
                                <th>Last 30 Days</th>
                                <th>Last 90 Days</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($posts as $e => $item)
                                <tr>
                                    <td>{{ $e + 1 }}</td>
                                    <td>
                                        <a href="#"
                                            style="font-size: 12px">{{ Str::limit($item->post_title, 20, '...') }}</a>
                                    </td>
                                    <td>{{ $item->author->name }}</td>
                                    <td>{{ views($item)->period(\CyrildeWit\EloquentViewable\Support\Period::since(today()))->count() }}
                                    </td>
                                    <td>{{ views($item)->period(\CyrildeWit\EloquentViewable\Support\Period::pastDays(30))->count() }}
                                    </td>
                                    <td>{{ views($item)->period(\CyrildeWit\EloquentViewable\Support\Period::pastDays(90))->count() }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{-- Activity Log --}}
    <div class="col-lg-4">
        <div class="card">
            <div class="card-body">
                @livewire('back.activity-log')
            </div>
        </div>
    </div>
</div>
{{-- Filter Waktu --}}
<div class="mb-4">
    <label for="period" class="block text-sm font-medium text-gray-700">Filter Waktu:</label>
    <select wire:model="selectedPeriod" id="period"
        class="mt-1 block w-60 p-2 border border-gray-300 rounded-md shadow-sm">
        <option value="1">Hari Ini</option>
        <option value="7">7 Hari Terakhir</option>
        <option value="30">30 Hari Terakhir</option>
        <option value="90">3 Bulan Terakhir</option>
    </select>
</div>
{{-- Analytics Charts --}}
<div class="row">
    <div class="col-xl-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Views</h4>
                <div id="page-views-chart"></div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">View by Country</h4>
                <div id="country-views-chart" class="apex-charts" style="min-height: 365px;"></div>
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Top Browsers</h4>
                <div id="top-browsers-chart" class="apex-charts" style="min-height: 365px;"></div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-4">Top Operating Systems</h4>
                <div id="top-operating-systems-chart" class="apex-charts" style="min-height: 365px;"></div>
            </div>
        </div>
    </div>
</div>

{{-- Scripts --}}
@push('scripts')
    <script src="/back/assets/libs/apexcharts/apexcharts.min.js"></script>
@endpush

@push('scripts')
    <script>
        document.addEventListener('livewire:load', function() {
            var pageViewsOptions = {
                series: [{
                    name: 'Page Views',
                    data: [{{ $dailyViews }}, {{ $weeklyViews }}, {{ $monthlyViews }}]
                }],
                chart: {
                    type: 'bar',
                    height: 350
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        endingShape: 'rounded',
                        distributed: true
                    },
                },
                colors: ['#FF4560', '#00E396', '#008FFB'],
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                xaxis: {
                    categories: ['Daily', 'Weekly', 'Monthly'],
                },
                yaxis: {
                    title: {
                        text: ''
                    },
                    labels: {
                        formatter: function(val) {
                            return Math.round(val);
                        }
                    }
                },
                fill: {
                    opacity: 1
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return val + " views";
                        }
                    }
                }
            };

            var pageViewsChart = new ApexCharts(document.querySelector("#page-views-chart"), pageViewsOptions);
            pageViewsChart.render();

            // country views
            var countryViewsOptions = {
                series: [{
                    name: 'Screen Page Views',
                    data: @json($countryViews->pluck('screenPageViews'))
                }],
                chart: {
                    type: 'bar',
                    height: 350
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        endingShape: 'rounded'
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                xaxis: {
                    categories: @json($countryViews->pluck('country'))
                },
                yaxis: {
                    title: {
                        text: ''
                    },
                    labels: {
                        formatter: function(val) {
                            return Math.round(val);
                        }
                    }
                },
                fill: {
                    opacity: 1
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return val + " screen page views";
                        }
                    }
                }
            };

            var countryViewsChart = new ApexCharts(document.querySelector("#country-views-chart"),
                countryViewsOptions);
            countryViewsChart.render();

            // top browsers
            var topBrowsersOptions = {
                series: [{
                    name: 'Screen Page Views',
                    data: @json($topBrowsers->pluck('screenPageViews'))
                }],
                chart: {
                    type: 'bar',
                    height: 350,
                    horizontal: true
                },
                plotOptions: {
                    bar: {
                        horizontal: true,
                        columnWidth: '55%',
                        endingShape: 'rounded',
                        distributed: true
                    },
                },
                colors: ['#FF4560', '#00E396', '#008FFB', '#775DD0', '#FEB019'],
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                xaxis: {
                    categories: @json($topBrowsers->pluck('browser')),
                    labels: {
                        show: false
                    }
                },
                yaxis: {
                    labels: {
                        show: true
                    }
                },
                fill: {
                    opacity: 1
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return val + " screen page views";
                        }
                    }
                }
            };

            var topBrowsersChart = new ApexCharts(document.querySelector("#top-browsers-chart"),
                topBrowsersOptions);
            topBrowsersChart.render();

            // top operating systems
            var topOperatingSystemsOptions = {
                series: @json($topOperatingSystems->pluck('screenPageViews')),
                chart: {
                    type: 'donut',
                    height: 350
                },
                labels: @json($topOperatingSystems->pluck('operatingSystem')),
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }],
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return val + " screen page views";
                        }
                    }
                }
            };

            var topOperatingSystemsChart = new ApexCharts(document.querySelector("#top-operating-systems-chart"),
                topOperatingSystemsOptions);
            topOperatingSystemsChart.render();
        });
    </script>
@endpush
