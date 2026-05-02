<?php

use App\Http\Controllers\GensenForm\GensenDataController;
use App\Http\Controllers\GensenForm\GensenFormController;
use App\Http\Controllers\GensenForm\GensenFormExportImportController;
use App\Http\Controllers\GensenForm\GensenFormLinkController;
use Illuminate\Support\Facades\Route;


Route::group(["controller" => GensenFormController::class, "prefix" => "gensen_form", "as" => "gensen_form."], function () {
    Route::get('{id}/form', 'form')->name('form');
    Route::get('{id}/upload_attachment', 'upload_attachment')->name('upload_attachment');
    Route::get('success_default', 'success_default')->name('success_default');
    Route::get('{id}/success', 'success')->name('success');
});
Route::get(
    '/gensen/attachment/{attachment}/preview',
    [GensenFormController::class, 'preview']
)
    ->name('gensen.attachment.preview')
;
// ->middleware('signed');
Route::get('/preview-temp-pdf/{filename}', function ($filename) {

    $path = storage_path('app/livewire-tmp/' . $filename);

    abort_unless(file_exists($path), 404);

    return response()->file($path, [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'inline'
    ]);
})->name('preview.temp.pdf');
Route::middleware(['auth', 'access_permission'])->group(function () {
    Route::group(["controller" => GensenDataController::class, "prefix" => "gensen_data", "as" => "gensen_data."], function () {
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::get('{id}/edit', 'edit')->name('edit');

        Route::get('pdf/view/{id}/{type}', 'preview_pdf')->name('preview_pdf');
    });
    Route::group(["controller" => GensenFormLinkController::class, "prefix" => "gensen_form_link", "as" => "gensen_form_link."], function () {
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::get('{id}/edit', 'edit')->name('edit');
    });
    Route::group(["controller" => GensenFormExportImportController::class, "prefix" => "gensen_form_export_import", "as" => "gensen_form_export_import."], function () {
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::get('{id}/edit', 'edit')->name('edit');
        Route::get('download/{id}', 'download')->name('download');
    });
});
Route::middleware(['auth'])->group(function () {
    Route::group(["controller" => GensenDataController::class, "prefix" => "gensen_data", "as" => "gensen_data."], function () {

        Route::get('{id}/attachment', 'attachment')->name('attachment');
    });
});
