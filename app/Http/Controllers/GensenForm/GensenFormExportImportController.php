<?php

namespace App\Http\Controllers\GensenForm;

use App\Enums\Gensen\GensenAttachmentType;
use App\Enums\Gensen\JobStatus;
use App\Http\Controllers\Controller;
use App\Models\Gensen\GensenExportImportHistory;
use App\Models\GensenForm\GensenForm;
use Illuminate\Http\Request;

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
        $history = GensenExportImportHistory::findOrFail(decrypt($id));

        if ($history->status !== JobStatus::DONE) {
            abort(403);
        }

        return response()->download(
            storage_path('app/private/' . $history->file_path)
        );
    }
}
