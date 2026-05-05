<?php

namespace App\Http\Controllers\BukuNenkin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BukuNenkinController extends Controller
{
    public function index()
    {
        return view('app.buku-nenkin.index');
    }

    public function create()
    {
        return view('app.buku-nenkin.detail', ["objId" => null]);
    }

    public function edit(Request $request)
    {
        return view('app.buku-nenkin.detail', ["objId" => $request->id]);
    }

    public function generate(Request $request)
    {
        return view('app.buku-nenkin.generate', ["objId" => $request->id]);
    }
}
