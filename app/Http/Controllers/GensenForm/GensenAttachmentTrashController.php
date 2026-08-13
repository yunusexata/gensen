<?php

namespace App\Http\Controllers\GensenForm;

use App\Http\Controllers\Controller;

class GensenAttachmentTrashController extends Controller
{
    public function index()
    {
        return view('app.gensen-form.sampah-berkas.index');
    }
}
