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
        <div class="card-header">
            
            <!-- Stats Cards -->
            <div class="mb-6 d-flex row w-100">
                <!-- Total -->
                <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm flex items-center justify-between col-md-3">
                    <div>
                        <p class="text-sm font-semibold text-gray-400 dark:text-gray-400">Total</p>
                        <h4 class="text-2xl font-bold text-gray-800 dark:text-white mt-1">100</h4>
                    </div>
                    <div class="w-12 h-12 bg-blue-50 dark:bg-blue-900/20 text-blue-500 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13.828 10.172a4 4 0 010 5.656l-3 3a4 4 0 01-5.656-5.656l1.5-1.5m7.156-1.156a4 4 0 010-5.656l3-3a4 4 0 115.656 5.656l-1.5 1.5" />
                        </svg>
                    </div>
                </div>
                
                <!-- Aktif -->
                <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm flex items-center justify-between col-md-3">
                    <div>
                        <p class="text-sm font-semibold text-gray-400 dark:text-gray-400">Aktif</p>
                        <h4 class="text-2xl font-bold text-purple-500 mt-1">100</h4>
                    </div>
                    <div class="w-12 h-12 bg-purple-50 dark:bg-purple-900/20 text-purple-500 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>

                <!-- Submit -->
                <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm flex items-center justify-between col-md-3">
                    <div>
                        <p class="text-sm font-semibold text-gray-400 dark:text-gray-400">Submit</p>
                        <h4 class="text-2xl font-bold text-green-500 mt-1">100</h4>
                    </div>
                    <div class="w-12 h-12 bg-green-50 dark:bg-green-900/20 text-green-500 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                
                <!-- Expired -->
                <div class="bg-white dark:bg-gray-800 p-5 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm flex items-center justify-between col-md-3">
                    <div>
                        <p class="text-sm font-semibold text-gray-400 dark:text-gray-400">Expired</p>
                        <h4 class="text-2xl font-bold text-red-500 mt-1">100</h4>
                    </div>
                    <div class="w-12 h-12 bg-red-50 dark:bg-red-900/20 text-red-500 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-header">
            <livewire:gensen-form.gensen-form-link.filter />
        </div>
        <div class="card-body">
            <livewire:gensen-form.gensen-form-link.datatable lazy />
        </div>
    </div>
@stop
