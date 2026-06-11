<?php

namespace App\Http\Controllers\GensenForm;

use App\Enums\Gensen\GensenAttachmentType;
use App\Enums\Gensen\JobStatus;
use App\Http\Controllers\Controller;
use App\Models\Gensen\GensenExportImportHistory;
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
        $history = GensenExportImportHistory::findOrFail(Crypt::decrypt($id));

        $disk = Storage::disk($history->disk);

        if ($history->disk === 'private') {
            $path = storage_path('app/private/' . $history->file_path);

            return response()->download($path);
        }

        $tmpPath = storage_path('app/tmp/' . basename($history->file_path));

        $stream = $disk->readStream($history->file_path);
        $target = fopen($tmpPath, 'w');

        stream_copy_to_stream($stream, $target);

        fclose($stream);
        fclose($target);

        return response()->download($tmpPath)->deleteFileAfterSend(true);
    }
}
