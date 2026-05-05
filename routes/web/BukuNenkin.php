<?php

use App\Http\Controllers\BukuNenkin\BukuNenkinController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'access_permission'])->group(function () {
    Route::group(["controller" => BukuNenkinController::class, "prefix" => "buku_nenkin", "as" => "buku_nenkin."], function () {
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::get('{id}/edit', 'edit')->name('edit');
        Route::get('{id}/generate', 'generate')->name('generate');
    });
});
