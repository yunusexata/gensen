<?php

namespace App\Http\Controllers\GensenForm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GensenFormLinkController extends Controller
{
    public function index()
    {
        return view('app.gensen-form.gensen-form-link.index');
    }

    public function create()
    {
        return view('app.gensen-form.gensen-form-link.detail', ["objId" => null]);
    }

    public function edit(Request $request)
    {
        return view('app.gensen-form.gensen-form-link.detail', ["objId" => $request->id]);
    }
}
