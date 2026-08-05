<?php

namespace App\Http\Controllers\GensenForm;

use App\Enums\Gensen\GensenAttachmentType;
use App\Enums\Gensen\JobStatus;
use App\Helpers\AppCrypt;
use App\Http\Controllers\Controller;
use App\Models\Gensen\GensenExportImportHistory;
use App\Models\Gensen\GensenSeluruhBerkasZipJob;
use App\Models\GensenForm\GensenForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class GensenFormExportImportController extends Controller
{
    public function index()
    {
        return view('app.gensen-form.gensen-form-export-import.index');
    }

    public function create()
    {
        return view('app.gensen-form.gensen-form-export-import.detail', ["objId" => null]);
    }

    public function edit(Request $request)
    {
        return view('app.gensen-form.gensen-form-export-import.detail', ["objId" => $request->id]);
    }
    public function download($id)
    {
        $id = AppCrypt::decrypt($id);
        if (!$id) {
            abort(404, 'Link tidak valid atau telah dimanipulasi.');
        }
        $history = GensenExportImportHistory::findOrFail($id);

        // 'supabase' atau 's3' atau 'private' - semuanya bisa menggunakan method ini
        $disk = Storage::disk($history->disk);

        if (!$disk->exists($history->file_path)) {
            abort(404, 'File tidak ditemukan.');
        }

        // Ini akan men-trigger download langsung dari Supabase ke browser user
        return $disk->download($history->file_path, basename($history->file_path));
    }
    public function downloadSeluruhBerkas($id)
    {

        $id = AppCrypt::decrypt($id);
        if (!$id) {
            abort(404, 'Link tidak valid atau telah dimanipulasi.');
        }
        $zipJob = GensenSeluruhBerkasZipJob::findOrFail($id);

        // 'supabase' atau 's3' atau 'private' - semuanya bisa menggunakan method ini
        $disk = Storage::disk($zipJob->zip_disk);

        if (!$disk->exists($zipJob->zip_path)) {
            abort(404, 'File tidak ditemukan.');
        }

        // Ini akan men-trigger download langsung dari Supabase ke browser user
        return $disk->download(
            $zipJob->zip_path,
            basename($zipJob->zip_path)
        );
    }
}
