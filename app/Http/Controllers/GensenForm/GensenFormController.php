<?php

namespace App\Http\Controllers\GensenForm;

use App\Enums\Gensen\GensenAttachmentType;
use App\Http\Controllers\Controller;
use App\Models\GensenForm\GensenFormAttachment;
use App\Models\GensenForm\GensenFormLink;
use App\Repositories\GensenForm\GensenFormLinkRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GensenFormController extends Controller
{
    public function index()
    {
        return view('app.gensen-form.gensen-form.index');
    }

    public function create()
    {
        return view('app.gensen-form.gensen-form.detail', ["objId" => null]);
    }

    public function edit(Request $request)
    {
        return view('app.gensen-form.gensen-form.detail', ["objId" => $request->id]);
    }
    public function success(Request $request)
    {
        return view('app.gensen-form.gensen-form.success', ["objId" => isset($request->id) ? $request->id : null, "phone" => isset($request->phone) ? $request->phone : null]);
    }
    public function success_default(Request $request)
    {
        return view('app.gensen-form.gensen-form.success', ["objId" => null, "phone" => isset($request->phone) ? $request->phone : null]);
    }
    public function upload_attachment(Request $request)
    {
        return view('app.gensen-form.gensen-form.upload_attachment', ["objId" => $request->id]);
    }
    public function form(Request $request)
    {
        $form = GensenFormLinkRepository::findBy([
            ['token', simple_decrypt($request->id)],
            ['status', GensenFormLink::STATUS_ACTIVE],
        ]);
        if (!$form) {
            abort(404, 'Form Tidak Tersedia');
        }
        $title = "Access form - {$form['name']} | Exata Indonesia";
        return view('app.gensen-form.gensen-form.form', [
            "objId" => $request->id,
            "title" => $title
        ]);
    }
    public function preview(GensenFormAttachment $attachment)
    {
        // abort_unless(auth()->check(), 403);

        $disk = Storage::disk($attachment->disk);

        abort_unless(
            $disk->exists($attachment->path),
            404
        );
        if ($attachment->type === GensenAttachmentType::SELURUH_BERKAS) {
            $filename = $attachment->gensenForm->nama_lengkap . " " . $attachment->gensenForm->tanggal_lahir . "." . $attachment->extension;
        } else {
            $filename = $attachment->original_name;
        }
        return response()->file(
            $disk->path($attachment->path),
            [
                'Content-Type' => $attachment->mime_type,
                'Content-Disposition' => 'inline; filename="' . $filename . '"',
            ]
        );
    }
}
