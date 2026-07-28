<?php

namespace App\Http\Controllers\ListPosting;

use App\Http\Controllers\Controller;
use App\Models\ListPosting\TemplatePosting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TemplatePostingController extends Controller
{
    public function index()
    {
        return view('app.template-posting.index');
    }
    public function create()
    {
        return view('app.template-posting.detail', ["objId" => null]);
    }

    public function edit(Request $request)
    {
        return view('app.template-posting.edit', ["objId" => $request->id]);
    }

    public function detail(Request $request)
    {
        return view('app.template-posting.detail', ["objId" => $request->id]);
    }

    public function preview(TemplatePosting $template)
    {
        // abort_unless(auth()->check(), 403);

        $disk = Storage::disk($template->disk);

        abort_unless(
            $disk->exists($template->path),
            404
        );

        return response()->file(
            $disk->path($template->path),
            [
                'Content-Type' => $template->mime_type,
                'Content-Disposition' =>
                "inline; filename*=UTF-8''",
            ]
        );
    }
}
