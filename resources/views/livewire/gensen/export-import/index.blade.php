<div class="row">
    <div class="col-md-6 row flex flex-col gap-3">
        @can(PermissionHelper::transform(PermissionHelper::EXPORT_LIST_DATA_BELUM_LENGKAP, PermissionHelper::TYPE_READ))
        <h1>HS</h1>
            <div class="col-6">
                <button type="button" class="w-full btn btn-success d-flex gap-2"  data-bs-toggle="modal" data-bs-target="#exportModal" x-data 
                @click="$dispatch('setExportJobKey', { job_key: '{{\App\Enums\Gensen\ExportImportJobKey::EXPORT_LIST_DATA_BELUM_LENGKAP}}'})">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cloud-arrow-down-fill" viewBox="0 0 16 16">
                    <path d="M8 2a5.53 5.53 0 0 0-3.594 1.342c-.766.66-1.321 1.52-1.464 2.383C1.266 6.095 0 7.555 0 9.318 0 11.366 1.708 13 3.781 13h8.906C14.502 13 16 11.57 16 9.773c0-1.636-1.242-2.969-2.834-3.194C12.923 3.999 10.69 2 8 2m2.354 6.854-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 1 1 .708-.708L7.5 9.293V5.5a.5.5 0 0 1 1 0v3.793l1.146-1.147a.5.5 0 0 1 .708.708"/>
                    </svg>
                    Export List Data Belum Lengkap
                </button>
            </div>    
        @endCan
        @can(PermissionHelper::transform(PermissionHelper::EXPORT_LIST_DATA_SIAP_VERIFIKASI, PermissionHelper::TYPE_READ))
        <h1>HS2</h1>
            <div class="col-6">
                <button type="button" class="w-full btn btn-success d-flex gap-2"  data-bs-toggle="modal" data-bs-target="#exportModal" x-data 
                @click="$dispatch('setExportJobKey', { job_key: '{{\App\Enums\Gensen\ExportImportJobKey::EXPORT_LIST_DATA_SIAP_VERIFIKASI}}'})">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cloud-arrow-down-fill" viewBox="0 0 16 16">
                    <path d="M8 2a5.53 5.53 0 0 0-3.594 1.342c-.766.66-1.321 1.52-1.464 2.383C1.266 6.095 0 7.555 0 9.318 0 11.366 1.708 13 3.781 13h8.906C14.502 13 16 11.57 16 9.773c0-1.636-1.242-2.969-2.834-3.194C12.923 3.999 10.69 2 8 2m2.354 6.854-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 1 1 .708-.708L7.5 9.293V5.5a.5.5 0 0 1 1 0v3.793l1.146-1.147a.5.5 0 0 1 .708.708"/>
                    </svg>
                    Export List Data Siap Verifikasi
                </button>
            </div>    
        @endCan
        @can(PermissionHelper::transform(PermissionHelper::EXPORT_LIST_DATA_VERIFIED, PermissionHelper::TYPE_READ))
        <h1>Admin Japan</h1>
            <div class="col-6">
                <button type="button" class="w-full btn btn-success d-flex gap-2"  data-bs-toggle="modal" data-bs-target="#exportModal" x-data 
                @click="$dispatch('setExportJobKey', { job_key: '{{\App\Enums\Gensen\ExportImportJobKey::EXPORT_LIST_DATA_VERIFIED}}'})">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cloud-arrow-down-fill" viewBox="0 0 16 16">
                    <path d="M8 2a5.53 5.53 0 0 0-3.594 1.342c-.766.66-1.321 1.52-1.464 2.383C1.266 6.095 0 7.555 0 9.318 0 11.366 1.708 13 3.781 13h8.906C14.502 13 16 11.57 16 9.773c0-1.636-1.242-2.969-2.834-3.194C12.923 3.999 10.69 2 8 2m2.354 6.854-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 1 1 .708-.708L7.5 9.293V5.5a.5.5 0 0 1 1 0v3.793l1.146-1.147a.5.5 0 0 1 .708.708"/>
                    </svg>
                    Export List Data Verified
                </button>
            </div>    
        @endCan
        @can(PermissionHelper::transform(PermissionHelper::EXPORT_LIST_DATA_NO_INPUT_JAPAN, PermissionHelper::TYPE_READ))
        <h1>Admin Japan</h1>
            <div class="col-6">
                <button type="button" class="w-full btn btn-success d-flex gap-2"  data-bs-toggle="modal" data-bs-target="#exportModal" x-data 
                @click="$dispatch('setExportJobKey', { job_key: '{{\App\Enums\Gensen\ExportImportJobKey::EXPORT_LIST_DATA_NO_INPUT_JAPAN}}'})">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cloud-arrow-down-fill" viewBox="0 0 16 16">
                    <path d="M8 2a5.53 5.53 0 0 0-3.594 1.342c-.766.66-1.321 1.52-1.464 2.383C1.266 6.095 0 7.555 0 9.318 0 11.366 1.708 13 3.781 13h8.906C14.502 13 16 11.57 16 9.773c0-1.636-1.242-2.969-2.834-3.194C12.923 3.999 10.69 2 8 2m2.354 6.854-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 1 1 .708-.708L7.5 9.293V5.5a.5.5 0 0 1 1 0v3.793l1.146-1.147a.5.5 0 0 1 .708.708"/>
                    </svg>
                    Export List Data No Input Jepang
                </button>
            </div>    
        @endCan
        @can(PermissionHelper::transform(PermissionHelper::EXPORT_LIST_DATA_DALAM_PENGAJUAN, PermissionHelper::TYPE_READ))
        <h1>Accounting Exata</h1>
            <div class="col-6">
                <button type="button" class="w-full btn btn-success d-flex gap-2"  data-bs-toggle="modal" data-bs-target="#exportDalamPengajuanModal">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cloud-arrow-down-fill" viewBox="0 0 16 16">
                    <path d="M8 2a5.53 5.53 0 0 0-3.594 1.342c-.766.66-1.321 1.52-1.464 2.383C1.266 6.095 0 7.555 0 9.318 0 11.366 1.708 13 3.781 13h8.906C14.502 13 16 11.57 16 9.773c0-1.636-1.242-2.969-2.834-3.194C12.923 3.999 10.69 2 8 2m2.354 6.854-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 1 1 .708-.708L7.5 9.293V5.5a.5.5 0 0 1 1 0v3.793l1.146-1.147a.5.5 0 0 1 .708.708"/>
                    </svg>
                    Export List Data Dalam Pengajuan
                </button>
            </div>    
        @endCan
        @can(PermissionHelper::transform(PermissionHelper::EXPORT_LIST_DATA_TARIK_DATA_ACC, PermissionHelper::TYPE_READ))
        <h1>HS2</h1>
            <div class="col-6">
                <button type="button" class="w-full btn btn-success d-flex gap-2"  data-bs-toggle="modal" data-bs-target="#exportModal" x-data 
                @click="$dispatch('setExportJobKey', { job_key: '{{\App\Enums\Gensen\ExportImportJobKey::EXPORT_LIST_DATA_TARIK_DATA_ACC}}'})">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cloud-arrow-down-fill" viewBox="0 0 16 16">
                    <path d="M8 2a5.53 5.53 0 0 0-3.594 1.342c-.766.66-1.321 1.52-1.464 2.383C1.266 6.095 0 7.555 0 9.318 0 11.366 1.708 13 3.781 13h8.906C14.502 13 16 11.57 16 9.773c0-1.636-1.242-2.969-2.834-3.194C12.923 3.999 10.69 2 8 2m2.354 6.854-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 1 1 .708-.708L7.5 9.293V5.5a.5.5 0 0 1 1 0v3.793l1.146-1.147a.5.5 0 0 1 .708.708"/>
                    </svg>
                    Export List Data Tarik Data Acc
                </button>
            </div>    
        @endCan
    </div>
    <div class="col-md-6 row flex flex-col gap-3">
        @can(PermissionHelper::transform(PermissionHelper::IMPORT_LIST_DATA_LENGKAP, PermissionHelper::TYPE_CREATE))
        <h1>HS</h1>
            <div class="col-6">
                <button type="button" data-bs-toggle="modal" data-bs-target="#bulkUpdateGensenStatusModalToLengkap" class="btn btn-primary d-flex gap-2 w-full">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cloud-arrow-up-fill" viewBox="0 0 16 16">
                    <path d="M8 2a5.53 5.53 0 0 0-3.594 1.342c-.766.66-1.321 1.52-1.464 2.383C1.266 6.095 0 7.555 0 9.318 0 11.366 1.708 13 3.781 13h8.906C14.502 13 16 11.57 16 9.773c0-1.636-1.242-2.969-2.834-3.194C12.923 3.999 10.69 2 8 2m2.354 5.146a.5.5 0 0 1-.708.708L8.5 6.707V10.5a.5.5 0 0 1-1 0V6.707L6.354 7.854a.5.5 0 1 1-.708-.708l2-2a.5.5 0 0 1 .708 0z"/>
                    </svg>
                    Import List Data Lengkap
                </button>
            </div>    
        @endCan
        @can(PermissionHelper::transform(PermissionHelper::IMPORT_LIST_DATA_VERIFIED, PermissionHelper::TYPE_CREATE))
        <h1>HS2</h1>
            <div class="col-6">
                <button type="button" data-bs-toggle="modal" data-bs-target="#bulkUpdateGensenStatusModalToVerified" class="btn btn-primary d-flex gap-2 w-full">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cloud-arrow-up-fill" viewBox="0 0 16 16">
                    <path d="M8 2a5.53 5.53 0 0 0-3.594 1.342c-.766.66-1.321 1.52-1.464 2.383C1.266 6.095 0 7.555 0 9.318 0 11.366 1.708 13 3.781 13h8.906C14.502 13 16 11.57 16 9.773c0-1.636-1.242-2.969-2.834-3.194C12.923 3.999 10.69 2 8 2m2.354 5.146a.5.5 0 0 1-.708.708L8.5 6.707V10.5a.5.5 0 0 1-1 0V6.707L6.354 7.854a.5.5 0 1 1-.708-.708l2-2a.5.5 0 0 1 .708 0z"/>
                    </svg>
                    Import List Data Verified
                </button>
            </div>    
        @endCan
        @can(PermissionHelper::transform(PermissionHelper::IMPORT_LIST_DATA_NO_INPUT_JAPAN, PermissionHelper::TYPE_CREATE))
        <h1>Admin Japan</h1>
            <div class="col-6">
                <button type="button" data-bs-toggle="modal" data-bs-target="#bulkUpdateGensenNoInputJepangModal" class="btn btn-primary d-flex gap-2 w-full">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cloud-arrow-up-fill" viewBox="0 0 16 16">
                    <path d="M8 2a5.53 5.53 0 0 0-3.594 1.342c-.766.66-1.321 1.52-1.464 2.383C1.266 6.095 0 7.555 0 9.318 0 11.366 1.708 13 3.781 13h8.906C14.502 13 16 11.57 16 9.773c0-1.636-1.242-2.969-2.834-3.194C12.923 3.999 10.69 2 8 2m2.354 5.146a.5.5 0 0 1-.708.708L8.5 6.707V10.5a.5.5 0 0 1-1 0V6.707L6.354 7.854a.5.5 0 1 1-.708-.708l2-2a.5.5 0 0 1 .708 0z"/>
                    </svg>
                    Import List Data No Input Jepang / Status CANCEL, HONNIN, Mondai
                </button>
            </div>    
        @endCan
        @can(PermissionHelper::transform(PermissionHelper::IMPORT_LIST_DATA_DALAM_PENGAJUAN, PermissionHelper::TYPE_CREATE))
        <h1>Admin Japan</h1>
            <div class="col-6">
                <button type="button" data-bs-toggle="modal" data-bs-target="#bulkUpdateGensenStatusModalToDalamPengajuan" class="btn btn-primary d-flex gap-2 w-full">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cloud-arrow-up-fill" viewBox="0 0 16 16">
                    <path d="M8 2a5.53 5.53 0 0 0-3.594 1.342c-.766.66-1.321 1.52-1.464 2.383C1.266 6.095 0 7.555 0 9.318 0 11.366 1.708 13 3.781 13h8.906C14.502 13 16 11.57 16 9.773c0-1.636-1.242-2.969-2.834-3.194C12.923 3.999 10.69 2 8 2m2.354 5.146a.5.5 0 0 1-.708.708L8.5 6.707V10.5a.5.5 0 0 1-1 0V6.707L6.354 7.854a.5.5 0 1 1-.708-.708l2-2a.5.5 0 0 1 .708 0z"/>
                    </svg>
                    Import List Data Dalam Pengajuan
                </button>
            </div>    
        @endCan
        @can(PermissionHelper::transform(PermissionHelper::IMPORT_LIST_DATA_DALAM_PENGAJUAN, PermissionHelper::TYPE_CREATE))
            <div class="col-6">
            </div>    
        @endCan
        @can(PermissionHelper::transform(PermissionHelper::IMPORT_LIST_DATA_GENSEN_CAIR, PermissionHelper::TYPE_CREATE))
        <h1>HS2</h1>
            <div class="col-6">
                <button type="button" data-bs-toggle="modal" data-bs-target="#bulkUpdateGensenStatusModalToGensenCair" class="btn btn-primary d-flex gap-2 w-full">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cloud-arrow-up-fill" viewBox="0 0 16 16">
                    <path d="M8 2a5.53 5.53 0 0 0-3.594 1.342c-.766.66-1.321 1.52-1.464 2.383C1.266 6.095 0 7.555 0 9.318 0 11.366 1.708 13 3.781 13h8.906C14.502 13 16 11.57 16 9.773c0-1.636-1.242-2.969-2.834-3.194C12.923 3.999 10.69 2 8 2m2.354 5.146a.5.5 0 0 1-.708.708L8.5 6.707V10.5a.5.5 0 0 1-1 0V6.707L6.354 7.854a.5.5 0 1 1-.708-.708l2-2a.5.5 0 0 1 .708 0z"/>
                    </svg>
                    Import List Data Gensen Cair
                </button>
            </div>    
        @endCan
    </div>
    <div class="row mt-5">
        <livewire:gensen.export-import.datatable-history />
    </div>
        
    <livewire:gensen.export-import.export />
    <livewire:gensen.export-import.export-dalam-pengajuan-modal />

    <livewire:gensen-form.gensen-data.bulk-update-gensen-status-modal-to-lengkap />
    <livewire:gensen-form.gensen-data.bulk-update-gensen-status-modal-to-verified />
    <livewire:gensen-form.gensen-data.bulk-update-gensen-no-input-jepang-modal />
    <livewire:gensen-form.gensen-data.bulk-update-gensen-status-modal-to-dalam-pengajuan />
    <livewire:gensen-form.gensen-data.bulk-update-gensen-status-modal-to-gensen-cair />
</div>

@push('css')
    <style>
        .modal.fade-right .modal-dialog {
            transform: rotateY(-90deg);
            transition: all 0.6s ease;
            transform-origin: right;
        }

        .modal.show .modal-dialog {
            transform: rotateY(0);
            transform: rotateX(0);
        }
        .modal.fade .modal-dialog {
            transform: rotateX(-90deg);
            transition: all 0.6s ease;
            transform-origin: top;
        }

        .modal.show .modal-dialog {
            transform: rotateX(0);
            transform: rotateY(0);
        }
        .custom-zoom {
            transform: scale(0);
            transition: all 0.6s ease;
        }

        .modal.show .custom-zoom {
            transform: scale(1);
        }
    </style>
@endpush
