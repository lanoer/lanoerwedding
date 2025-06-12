@extends('back.layouts.pages-layout')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Catering')

@section('pageHeader')
<div class="col-12">
    <div class="page-title-box d-flex align-items-center justify-content-between">
        <h4 class="page-title mb-0 font-size-18">{{ $pageTitle }}</h4>

        <div class="page-title-right">
            @include('components.breadcrumbs')
        </div>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <!-- Table to display premiumCaterings -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <!-- Title and Add Button in one row -->
                <h5 class="card-title mb-0">Premium Catering Details for "{{ $catering->name }}"</h5>
                <a href="{{ route('catering.sub.createPremium', $catering->id) }}" class="btn btn-primary btn-sm">
                    Add
                </a>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Thumbnails</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($catering->premiumCaterings as $index => $premium)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $premium->name }}</td>
                            <td>
                                <img src="{{ asset('storage/back/images/catering/premium/' . $premium->image) }}" alt=""
                                    style="width: 50px; height: 50px; background-size: cover; background-position: center;">
                            </td>
                            <td>
                                <!-- Add edit and delete actions here -->
                                <a href="{{ route('catering.sub.editPremium', $premium->id) }}"
                                    class="btn btn-warning btn-sm">Edit</a>

                                <form action="{{ route('catering.sub.destroyPremium', $premium->id) }}" method="POST"
                                    style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <!-- Simulate DELETE request -->
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to delete this premium catering?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    @if (session('message'))
        toastr.success("{{ session('message') }}");
    @endif
</script>
@endpush