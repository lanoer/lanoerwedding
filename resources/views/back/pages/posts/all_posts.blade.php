@extends('back.layouts.pages-layout')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'All Posts')


@section('pageHeader')
<div class="col-12">
    <div class="page-title-box d-flex align-items-center justify-content-between">
        <h4 class="page-title mb-0 font-size-18">All Posts</h4>

        <div class="page-title-right">
            @include('components.breadcrumbs')
        </div>

    </div>
</div>
@endsection
@section('content')
<div class="row">
    @livewire('back.posts.all-posts')
</div>
@endsection
@push('scripts')
<script>
    window.addEventListener('deletePost', function(event){
            swal.fire({
                 title:event.detail.title,
                imageWidth:48,
                imageHeight:48,
                html:event.detail.html,
                showCloseButton:true,
                showCancelButton:true,
                confirmButtonText:"Yes, Delete.",
                cancelButtonColor:'#d33',
                confirmButtonColor:'#3085d6',
                width:300,
                allowOutsideClick:false

            }).then(function(result){
                if (result.value) {
                    window.Livewire.emit('deletePostAction',event.detail.id)
                }
            });
        })
</script>
@endpush