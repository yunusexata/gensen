<?php

namespace App\Http\Controllers\IchijikinExtraction;

use App\Http\Controllers\Controller;
use App\Models\Ichijikin\IchijikinExtraction;
use App\Repositories\IchijikinExtraction\IchijikinExtractionRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class IchijikinExtractionController extends Controller
{
    public function index()
    {
        return view('app.ichijikin-extraction.index');
    }
    public function create()
    {
        return view('app.ichijikin-extraction.detail', ["objId" => null]);
    }

    public function edit(Request $request)
    {
        return view('app.ichijikin-extraction.edit', ["objId" => $request->id]);
    }

    public function detail(Request $request)
    {
        return view('app.ichijikin-extraction.detail', ["objId" => $request->id]);
    }
    public function download($id)
    {
        $item = IchijikinExtractionRepository::find(Crypt::decrypt($id));

        abort_if(
            blank($item->zip_path),
            404
        );

        return response()->download(
            storage_path('app/public/' . $item->zip_path)
        );
    }
}
