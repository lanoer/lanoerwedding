@extends('back.layouts.pages-layout')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'File Manager')


@section('pageHeader')
<div class="col-12">
    <div class="page-title-box d-flex align-items-center justify-content-between">
        <h4 class="page-title mb-0 font-size-18">File Manager</h4>

        <div class="page-title-right">
            @include('components.breadcrumbs')
        </div>

    </div>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12" id="fm-main-block">
        <div id="fm"></div>
    </div>
</div>
@endsection

@push('stylesheets')
<link rel="stylesheet" href="{{ asset('vendor/file-manager/css/file-manager.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
@endpush

@push('scripts')
<script src="{{ asset('vendor/file-manager/js/file-manager.js') }}"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
      document.getElementById('fm-main-block').setAttribute('style', 'height:' + window.innerHeight + 'px');
      fm.$store.commit('fm/setFileCallBack', function(fileUrl) {
        window.opener.fmSetLink(fileUrl);
        window.close();
      });
    });
</script>
@endpush