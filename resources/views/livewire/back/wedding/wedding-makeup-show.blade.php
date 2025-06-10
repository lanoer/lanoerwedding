<div>
    <div class="app-container container-xxl">


        <div class="row row-cards">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title">
                        <!--begin::Search-->
                        <div class="d-flex align-items-center position-relative my-1 me-5">
                            All {{ $weddingMakeups->name }}
                        </div>
                        <!--end::Search-->
                    </div>
                    <div class="card-toolbar">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search..." wire:model='search'
                                style="padding-right: 40px;">
                            <span class="input-group-text"
                                style="position: absolute; right: 10px; border: none; background: transparent; z-index: 1000;">
                                <i class="mdi mdi-magnify"></i>
                            </span>
                        </div>
                    </div>

                </div>
                <div class="card-body border-bottom py-3">
                    <div class="d-flex">
                        <div class="text-muted">
                            Show
                            <div class="mx-2 d-inline-block ">
                                <select wire:model.live='perPage' class="form-select">
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </div>
                            entries
                        </div>
                        <div class="ms-auto">
                            <a href="{{ route('wedding.sub.create') }}" class="btn btn-primary">Add
                                {{ $weddingMakeups->name }}</a>
                        </div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped gy-7 gs-7">
                        <thead>
                            <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                <th>No</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th class="w-1">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($weddings as $w=>$wedding)
                            <tr>
                                <td>{{ $w + 1 }}</td>
                                <td>
                                    <div class="d-flex py-1 align-items-center">
                                        <span class="avatar me-2"
                                            style="background-image: url('{{ asset('storage/back/images/wedding/weddingmakeup/' . $wedding->image) }}');
                                    width: 50px; height: 50px; background-size: cover; background-position: center;"></span>
                                    </div>
                                </td>
                                <td>
                                    <div class="">
                                        {!! Str::limit($wedding->name, 15, ' ...') !!}
                                    </div>
                                </td>
                                <td class="text-muted">
                                    {!! Str::limit($wedding->description, 15, ' ...') !!}
                                </td>
                                <td>
                                    <div class="d-flex py-1 align-items-center">

                                        <a href="{{ route('makeup.wedding.detail', ['weddingMakeupSlug' => $wedding->weddingMakeups->slug, 'slug' => $wedding->slug]) }}"
                                            class="btn btn-sm btn-primary mx-1" target="_blank" data-bs-toggle="tooltip"
                                            data-bs-placement="top" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button class="btn btn-sm btn-info mx-1"
                                            onclick="copyToClipboard('{{ route('makeup.wedding.detail', ['weddingMakeupSlug' => $wedding->weddingMakeups->slug, 'slug' => $wedding->slug]) }}')"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Copy URL">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                        <a href="{{ route('wedding.sub.edit', [$wedding->id]) }}"
                                            class="btn btn-sm btn-warning ">Edit</a>

                                        <a href=""
                                            wire:click.prevent='deleteEvent({{ $wedding->id }}, "{{ $wedding->name }}")'
                                            class="btn btn-sm btn-danger" style="margin-left: 3px">Delete</a>
                                    </div>
                                </td>
                            </tr>

                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-danger">No {{ $weddingMakeups->name }}
                                    found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>


        </div>
        <div class="row mt-4">
            {{ $weddings->links() }}
        </div>
    </div>

</div>

@push('scripts')
<script>
    function copyToClipboard(url) {
            // Buat elemen textarea sementara
            var textarea = document.createElement("textarea");
            textarea.value = url;
            document.body.appendChild(textarea);
            textarea.select();
            try {
                // Salin teks ke clipboard
                document.execCommand('copy');
                toastr.success('URL copied to clipboard');
            } catch (err) {
                toastr.error('Failed to copy URL');
            }
            // Hapus elemen textarea sementara
            document.body.removeChild(textarea);
        }
</script>
@endpush