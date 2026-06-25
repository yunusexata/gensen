<?php

namespace App\Http\Controllers\ResiGenerator;

use App\Http\Controllers\Controller;
use App\Models\Ichijikin\IchijikinExtraction;
use App\Repositories\IchijikinExtraction\IchijikinExtractionRepository;
use App\Repositories\ResiGenerator\ResiGeneratorRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class ResiGeneratorController extends Controller
{
    public function index()
    {
        return view('app.resi-generator.index');
    }
    public function create()
    {
        return view('app.resi-generator.detail', ["objId" => null]);
    }

    public function edit(Request $request)
    {
        return view('app.resi-generator.edit', ["objId" => $request->id]);
    }

    public function detail(Request $request)
    {
        return view('app.resi-generator.detail', ["objId" => $request->id]);
    }
    public function download($id)
    {
        $item = ResiGeneratorRepository::find(Crypt::decrypt($id));

        abort_if(
            blank($item->zip_path),
            404
        );

        return response()->download(
            storage_path('app/public/' . $item->zip_path)
        );
    }
}
