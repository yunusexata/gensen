<?php

use App\Http\Controllers\IchijikinExtraction\IchijikinExtractionController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'access_permission'])->group(function () {
    Route::group(["controller" => IchijikinExtractionController::class, "prefix" => "ichijikin_extraction", "as" => "ichijikin_extraction."], function () {
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::get('{id}/edit', 'edit')->name('edit');
    });
});
