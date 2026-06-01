<?php

namespace App\Http\Controllers\GensenForm;

use App\Enums\Gensen\GensenAttachmentType;
use App\Http\Controllers\Controller;
use App\Models\Gensen\GensenExportImportHistory;
use App\Models\GensenForm\GensenFormAttachment;
use App\Models\GensenForm\GensenFormLink;
use App\Repositories\GensenForm\GensenFormLinkRepository;
use Carbon\Carbon;
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
        if (!$request->id) {
            abort(404, 'Form Tidak Tersedia');
        }

        $token = simple_decrypt($request->id);
        $form = GensenFormLinkRepository::findBy([
            ['token', $token],
        ]);
        if (!$form) {
            abort(404, 'Form Tidak Tersedia');
        }
        if ($form->expired_at && now()->greaterThan($form->expired_at)) {
            GensenFormLinkRepository::updateBy(
                [
                    ['token', $token]
                ],
                ['status' => GensenFormLink::STATUS_EXPIRED]
            );
            abort(403, "Form {$form['name']} sudah expired");
        }
        if ($form->max_usage <= $form->used_count && $form->status == GensenFormLink::STATUS_CLOSED) {
            abort(403, "Form {$form['name']} sudah Maksimal");
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
            $filename = "G " . $attachment->gensenForm->nama_lengkap . " " . Carbon::parse($attachment->gensenForm->tanggal_lahir)->format('Ymd') . "." . $attachment->extension;
        } else {
            $filename = $attachment->original_name;
        }
        logger(['preview filename', $filename]);
        return response()->file(
            $disk->path($attachment->path),
            [
                'Content-Type' => $attachment->mime_type,
                'Content-Disposition' =>
                "inline; filename=\"{$filename}\"; filename*=UTF-8''" .
                    rawurlencode($filename),
            ]
        );
    }
    // public function previewSuabase(GensenFormAttachment $attachment)
    // {
    //     $disk = Storage::disk($attachment->disk);

    //     abort_unless(
    //         $disk->exists($attachment->path),
    //         404
    //     );

    //     if ($attachment->type === GensenAttachmentType::SELURUH_BERKAS) {
    //         $filename =
    //             "G {$attachment->gensenForm->nama_lengkap} " .
    //             Carbon::parse($attachment->gensenForm->tanggal_lahir)->format('Ymd') .
    //             ".{$attachment->extension}";
    //     } else {
    //         $filename = $attachment->original_name;
    //     }

    //     $temporaryUrl = $disk->temporaryUrl(
    //         $attachment->path,
    //         now()->addMinutes(30),
    //         [
    //             'ResponseContentDisposition' => 'inline; filename="' . $filename . '"',
    //             'ResponseContentType' => $attachment->mime_type,
    //         ]
    //     );

    //     return redirect()->away($temporaryUrl);
    // }
    public function previewExportImport(GensenExportImportHistory $history)
    {
        // abort_unless(auth()->check(), 403);

        $disk = Storage::disk($history->disk);

        abort_unless(
            $disk->exists($history->path),
            404
        );
        // if ($history->type === GensenAttachmentType::SELURUH_BERKAS) {
        $filename = $history->job_key->value . "." . $history->extension;
        // } else {
        //     $filename = $history->original_name;
        // }
        return response()->file(
            $disk->path($history->path),
            [
                'Content-Type' => $history->mime_type,
                'Content-Disposition' => 'inline; filename="' . $filename . '"',
            ]
        );
    }
}
