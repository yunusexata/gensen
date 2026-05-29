<?php

namespace App\Http\Controllers;

use Exception;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        dd([
            'gd' => extension_loaded('gd'),
            'exif' => extension_loaded('exif'),
            'imagick' => extension_loaded('imagick'),
        ]);
        return view('app.dashboard.index');
    }
}
