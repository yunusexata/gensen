@extends('app.layouts.panel')

@section('title', 'Exata - Link Gensen')

@section('header')
    <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
        <!--begin::Title-->
        <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Exata - Link Gensen</h1>
        <!--end::Title-->
        <!--begin::Breadcrumb-->
        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
            <li class="breadcrumb-item text-muted">Exata - Link Gensen</li>
            {{-- <li class="breadcrumb-item">
                <span class="bullet bg-gray-400 w-5px h-2px"></span>
            </li> --}}
        </ul>
        <!--end::Breadcrumb-->

            <div class='row'>
                <div class="col-md-auto mt-2">
                    <a class="btn btn-success" href="{{ route('gensen_form_link.create') }}">
                        <i class="ki-duotone ki-plus fs-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i>
                        Tambah Baru
                    </a>
                </div>
            </div>
        
    </div>
@stop

@section('content')

    <div class="card">
        <div class="card-body">
            <livewire:gensen-form.gensen-form-link.datatable lazy>
        </div>
    </div>
@stop
