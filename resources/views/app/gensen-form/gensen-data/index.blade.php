@extends('app.layouts.panel')

@section('title', 'Exata - Gensen Data')

@section('header')
    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
        <!--begin::Title-->
        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Exata - Gensen Data</h1>
        <!--end::Title-->
        <!--begin::Breadcrumb-->
        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
            <li class="breadcrumb-item text-muted">Exata - Gensen Data</li>
            {{-- <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li> --}}
        </ul>
        <!--end::Breadcrumb-->
        
        @can(PermissionHelper::transform(PermissionHelper::ACCESS_GENSEN_DATA, PermissionHelper::TYPE_CREATE))
            <div class='row'>
                <div class="col-md-auto mt-2">
                    <a class="btn btn-success" href="{{ route('gensen_data.create') }}">
                        <i class="ki-duotone ki-plus fs-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i>
                        Tambah Baru
                    </a>
                </div>
            </div>
        @endCan
        
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <livewire:gensen-form.gensen-data.datatable>
        </div>
    </div>
    <livewire:gensen-form.gensen-data.bulk-update-gensen-status-modal-to-lengkap>
    <livewire:gensen-form.gensen-data.bulk-update-gensen-status-modal-to-verified>
@stop

@push('css')
    <style>
        .progress-box {
            width: 24px;
            height: 24px;
            border-radius: 3px;
            display: inline-block;
            cursor: pointer;
        }
    </style>
@endpush

@push('js')
    <script>
        var stickyElement = document.querySelector("#kt_sticky_control");
var sticky = new KTSticky(stickyElement);
KTSticky.createInstances();
    </script>
@endpush
