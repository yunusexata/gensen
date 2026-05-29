<?php

namespace App\Http\Controllers\IchijikinExtraction;

use App\Http\Controllers\Controller;

class IchijikinExtractionController extends Controller
{
    public function index()
    {
        return view('app.ichijikin-extraction.index');
    }
}
