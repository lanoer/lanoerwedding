@extends('back.layouts.pages-layout')

@section('pageTitle', 'Roles')

@section('pageHeader')
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="page-title mb-0 font-size-18">Roles</h4>

            <div class="page-title-right">
                @include('components.breadcrumbs')
            </div>

        </div>
    </div>
@endsection
@section('content')
    @livewire('back.konfigurasi.konfigurasi-role')
@endsection
@push('scripts')
    <script src="/back/assets/vendor/sweetalert2/sweetalert2.all.min.js"></script>
    <script>
        window.addEventListener('hideRoleModal', function(e) {
            $('#role_modal').modal('hide');
        })
        window.addEventListener('showroleModal', function(e) {
            $('#role_modal').modal('show');
        })
        window.addEventListener('hideSubCategoryModal', function(e) {
            $('#subrole_modal').modal('hide');
        })
        window.addEventListener('showSubroleModal', function(e) {
            $('#subrole_modal').modal('show');
        })

        $('#role_modal,#subrole_modal').on('hide.bs.modal', function(e) {
            Livewire.emit('resetModalForm')
        });

        window.addEventListener('deleteRole', function(event) {
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
                    window.Livewire.emit('deleteRoleAction', event.detail.id)
                }
            });
        })
    </script>
@endpush
