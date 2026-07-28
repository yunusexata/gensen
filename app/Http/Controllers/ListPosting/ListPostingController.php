<?php

namespace App\Http\Controllers\ListPosting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class ListPostingController extends Controller
{
    public function index()
    {
        return view('app.list-posting.index');
    }
    public function create()
    {
        return view('app.list-posting.detail', ["objId" => null]);
    }

    public function edit(Request $request)
    {
        return view('app.list-posting.edit', ["objId" => $request->id]);
    }

    public function detail(Request $request)
    {
        return view('app.list-posting.detail', ["objId" => $request->id]);
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
