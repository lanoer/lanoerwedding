<div>
    <div class="row mt-3">
        <div class="col-md-12 mb-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold text-dark">Inbox</span>
                    </h3>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped gy-7 gs-7">
                            <thead>
                                <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200">
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Komentar</th>
                                    <th>Komentar Artikel</th>
                                    <th>Status Approval</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                    <th class="w-1"></th>
                                </tr>
                            </thead>
                            <tbody>


                                @forelse ($comments as $item)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$item->username}}</td>
                                    <td>{{Str::limit($item->comment, 10, '...')}}</td>
                                    <td>
                                        <a href="{{route('blog.detail', $item->post->slug)}}"
                                            target="_blank">{{$item->post->post_title}}</a>
                                    </td>
                                    <td>
                                        @livewire('back.comments.comment-status', ['model' => $item, 'field' =>
                                        'approved'],
                                        key($item->id))
                                    </td>
                                    <td>{{$item->created_at}}</td>
                                    <td>
                                        <div class="d-flex py-2 align-items-center">
                                            <a href="#" wire:click.prevent='deleteKomentar({{$item->id}})'
                                                class="btn btn-sm btn-danger">Delete</a>
                                            <a data-bs-toggle="modal" data-bs-target="#view{{ $item->id }}"
                                                class="btn btn-primary btn-sm" style="margin-left: 3px">View</a>
                                            @php
                                            $balasanAdmin = $item->replies()
                                            ->where(function($q){
                                            $q->where('is_admin_reply', 1);
                                            })->first();
                                            @endphp
                                            @if($balasanAdmin)
                                            <button class="btn btn-success btn-sm ms-2" data-bs-toggle="modal"
                                                data-bs-target="#balasanAdmin{{ $item->id }}">Admin Reply</button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7"><span class="text-danger justify-center">Komentar Not Found!</span>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="row mt-4">
                            {{$comments->links('livewire::bootstrap')}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @forelse ($comments as $item)
    <div class="modal modal-blur fade" id="view{{ $item->id }}" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Komentar from: {{ $item->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <dl class="row">
                            <dt class="col-5">Name :</dt>
                            <dd class="col-7">{{ $item->username }}</dd>
                            <dt class="col-5">Email :</dt>
                            <dd class="col-7">{{ $item->email }}</dd>
                            <dt class="col-5">Pesan :</dt>
                            <dd class="col-7">{{ $item->comment }}</dd>
                            <dt class="col-5">Tanggal :</dt>
                            <dd class="col-7">{{ $item->created_at }}</dd>
                        </dl>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    @php
    $balasanAdmin = $item->replies()
    ->where(function($q){
    $q->where('is_admin_reply', 1);
    })->first();
    @endphp
    @if($balasanAdmin)
    <div class="modal modal-blur fade" id="balasanAdmin{{ $item->id }}" tabindex="-1" style="display: none;"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Balasan Admin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <dl class="row">
                            <dt class="col-5">Admin :</dt>
                            <dd class="col-7">{{ $balasanAdmin->username }}</dd>
                            <dt class="col-5">Balasan :</dt>
                            <dd class="col-7">{{ $balasanAdmin->comment }}</dd>
                            <dt class="col-5">Tanggal :</dt>
                            <dd class="col-7">{{ $balasanAdmin->created_at }}</dd>
                        </dl>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    @endif
    @empty

    @endforelse
</div>