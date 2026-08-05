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
}
