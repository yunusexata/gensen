<?php

use App\Http\Controllers\ResiGenerator\ResiGeneratorController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'access_permission'])->group(function () {
    Route::group(["controller" => ResiGeneratorController::class, "prefix" => "resi_generator", "as" => "resi_generator."], function () {
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::get('{id}/edit', 'edit')->name('edit');
        Route::get('{id}/detail', 'detail')->name('detail');
    });
});
Route::middleware(['auth'])->group(function () {
    Route::get(
        '/resi_generator/download/{id}',
        [ResiGeneratorController::class, 'download']
    )->name('resi_generator.download');
});
