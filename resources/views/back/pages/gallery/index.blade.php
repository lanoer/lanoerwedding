@extends('back.layouts.pages-layout')

@section('pageTitle', isset($pageTitle) ? $pageTitle : 'Gallery ')


@section('pageHeader')
<div class="col-12">
    <div class="page-title-box d-flex align-items-center justify-content-between">
        <h4 class="page-title mb-0 font-size-18">Gallery</h4>

        <div class="page-title-right">
            @include('components.breadcrumbs')
        </div>

    </div>
</div>
@endsection
@section('content')
@livewire('back.gallery.gallery-foto')
@endsection
@push('scripts')
<script>
    window.addEventListener('hideGalleryModal', function(e) {
            $('#gallery_modal').modal('hide');
        })
        window.addEventListener('showgalleryModal', function(e) {
            $('#gallery_modal').modal('show');
        })

        $('#gallery_modal').on('hide.bs.modal', function(e) {
            Livewire.emit('resetModalForm')
        });

        window.addEventListener('deleteGallery', function(event) {
            swal.fire({
                title: event.detail.title,
                imageWidth: 48,
                imageHeight: 48,
                html: event.detail.html,
                showCloseButton: true,
                showCancelButton: true,
                confirmButtonText: "Yes, Delete.",
                cancelButtonColor: '#d33',
                confirmButtonColor: '#3085d6',
                width: 300,
                allowOutsideClick: false

            }).then(function(result) {
                if (result.value) {
                    window.Livewire.emit('deleteGalleryAction', event.detail.id)
                }
            });
        })

        $('table tbody#sortable_gallery').sortable({
            update: function(event, ui) {
                $(this).children().each(function(index) {
                    if ($(this).attr("data-ordering") != (index + 1)) {
                        $(this).attr("data-ordering", (index + 1)).addClass("updated");
                    }
                });
                var positions = [];
                $(".updated").each(function() {
                    positions.push([$(this).attr("data-index"), $(this).attr("data-ordering")]);
                    $(this).removeClass("updated");
                });
                window.Livewire.emit("updateGalleryOrdering", positions);
            }
        })
</script>
@endpush
@push('scripts')
<script>
    window.addEventListener('deleteFotoGallery', function(event) {
            swal.fire({
                title: event.detail.title,
                imageWidth: 48,
                imageHeight: 48,
                html: event.detail.html,
                showCloseButton: true,
                showCancelButton: true,
                confirmButtonText: "Yes, Delete.",
                cancelButtonColor: '#d33',
                confirmButtonColor: '#3085d6',
                width: 300,
                allowOutsideClick: false

            }).then(function(result) {
                if (result.value) {
                    window.Livewire.emit('deleteFotoGalleryAction', event.detail.id)
                }
            });
        })
</script>
@endpush