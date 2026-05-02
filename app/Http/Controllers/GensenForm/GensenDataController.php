<?php

namespace App\Http\Controllers\GensenForm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GensenDataController extends Controller
{
    public function index()
    {
        return view('app.gensen-form.gensen-data.index');
    }

    public function create()
    {
        return view('app.gensen-form.gensen-data.detail', ["objId" => null]);
    }

    public function edit(Request $request)
    {
        return view('app.gensen-form.gensen-data.detail', ["objId" => $request->id]);
    }

    public function attachment(Request $request)
    {
        return view('app.gensen-form.gensen-data.attachment', ["objId" => $request->id]);
    }

    public function preview_pdf(Request $request)
    {
        // if (!in_array($request->type, array_keys(Exata::FILTER_ATTACHMENT_CHOICE))) {
        //     abort(404);
        // }
        // if ($request->type == Exata::FILTER_ATTACHMENT_CV) {
        //     $document = ExataCurriculumVitaeRepository::find(Crypt::decrypt($request->id));

        //     $path = $document->file;

        //     if (!Storage::disk('public')->exists($path)) {
        //         abort(404);
        //     }
        // }
        // if ($request->type == Exata::FILTER_ATTACHMENT_SERTIFIKAT_BAHASA_JEPANG) {
        //     $document = ExataJapaneseLanguageCertificateRepository::find(Crypt::decrypt($request->id));

        //     $path = $document->file;

        //     if (!Storage::disk('public')->exists($path)) {
        //         abort(404);
        //     }
        // }

        return response()->file(
            storage_path('app/public/' . $path),
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="document.pdf"'
            ]
        );
    }
}
