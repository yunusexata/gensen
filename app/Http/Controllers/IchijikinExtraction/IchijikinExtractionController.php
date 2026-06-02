<?php

namespace App\Http\Controllers\IchijikinExtraction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
}
