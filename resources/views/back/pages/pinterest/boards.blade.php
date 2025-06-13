@extends('back.layouts.pages-layout')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'boards')


@section('pageHeader')
<div class="col-12">
    <div class="page-title-box d-flex align-items-center justify-content-between">
        <h4 class="page-title mb-0 font-size-18">Dashboard</h4>

        <div class="page-title-right">
            @include('components.breadcrumbs')
        </div>

    </div>
</div>
@endsection
@section('content')
<div class="container">
    <h1 class="mb-4">Daftar Board Pinterest</h1>

    @if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID Board</th>
                <th>Nama</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($boards as $board)
            <tr>
                <td><code>{{ $board['id'] }}</code></td>
                <td>{{ $board['name'] }}</td>
                <td>{{ $board['description'] ?? '-' }}</td>
                <td>
                    <button onclick="navigator.clipboard.writeText('{{ $board['id'] }}')"
                        class="btn btn-sm btn-primary">Salin ID</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection