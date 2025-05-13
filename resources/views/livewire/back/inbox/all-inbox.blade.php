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
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Url</th>
                                    <th>Message</th>
                                    <th>Read</th>
                                    <td>Sent</td>
                                    <th class="w-1"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($inboxes as $in)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $in->name }}</td>
                                        <td>{{ $in->email }}</td>
                                        <td>{{ Str::limit($in->url, '10', '...') }}</td>
                                        <td>{{ Str::limit($in->pesan, 10, '...') }}</td>
                                        <td>
                                            @livewire('back.inbox.inbox-status', ['model' => $in, 'field' => 'isActive'], key($in->id))
                                        </td>
                                        <td>{{ $in->formatted_created_at }}</td>
                                        <td>
                                            <div class="d-flex py-2 align-items-center">
                                                <a href="#" wire:click.prevent='deleteInbox({{ $in->id }})'
                                                    class="btn btn-sm btn-danger">Delete</a>
                                                <a data-bs-toggle="modal" data-bs-target="#view{{ $in->id }}"
                                                    class="btn btn-primary btn-sm" style="margin-left: 3px">View</a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7"><span class="text-danger justify-content-center">Inbox Not
                                                Found!</span></td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="row mt-4">
                            {{ $inboxes->links('livewire::bootstrap') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @forelse ($inboxes as $in)
        <div class="modal modal-blur fade" id="view{{ $in->id }}" tabindex="-1" style="display: none;"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Inbox from: {{ $in->name }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card-body">
                            <dl class="row">
                                <dt class="col-5">Full Name :</dt>
                                <dd class="col-7">{{ $in->name }}</dd>
                                <dt class="col-5">Email :</dt>
                                <dd class="col-7">{{ $in->email }}</dd>
                                <dt class="col-5">Url :</dt>
                                <dd class="col-7">
                                    @if ($in->url == null)
                                        -
                                    @else
                                        {{ $in->url }}
                                    @endif
                                </dd>
                                <dt class="col-5">Message :</dt>
                                <dd class="col-7">{{ $in->pesan }}</dd>
                                <dt class="col-5">Sent :</dt>
                                <dd class="col-7">{{ $in->formatted_created_at }}</dd>
                            </dl>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @empty
    @endforelse
</div>
