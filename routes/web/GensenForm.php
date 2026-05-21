<?php

use App\Http\Controllers\GensenForm\GensenDataController;
use App\Http\Controllers\GensenForm\GensenFormController;
use App\Http\Controllers\GensenForm\GensenFormExportImportController;
use App\Http\Controllers\GensenForm\GensenFormLinkController;
use App\Models\GensenForm\GensenFormAttachment;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;


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
    ->name('gensen.attachment.preview');
Route::get(
    '/gensen/export-import/{history_id}/preview',
    [GensenFormController::class, 'previewExportImport']
)
    ->name('gensen.attachment.preview-export-import');
// ->middleware('signed');
Route::get('/preview-temp-pdf/{filename}', function ($filename) {
    logger([
        'preview tmp pdf 42 route',
        $filename
    ]);
    $path = storage_path('app/livewire-tmp/' . $filename);

    abort_unless(file_exists($path), 404);

    // if($)
    return response()->file($path, [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'inline'
    ]);
})->name('preview.temp.pdf');
Route::get('/preview-temp-file/{path}', function ($path) {

    // Safety check to prevent escaping the livewire-tmp directory
    if (str_contains($path, '..')) {
        abort(403);
    }

    $fullPath = 'app/livewire-tmp/' . $path;

    if (!Storage::exists($fullPath)) {
        abort(404);
    }

    return Storage::response($fullPath);
})->name('preview.temp.file')->where('path', '.*');
Route::get('/preview-image/{attachment}', function ($attachmentId) {

    $attachment = GensenFormAttachment::findOrFail($attachmentId);
    logger([
        'preview image attachment',
        $attachment
    ]);

    $disk = Storage::disk($attachment->disk);

    if (!$disk->exists($attachment->path)) {
        abort(404);
    }

    return response()->stream(function () use ($disk, $attachment) {

        $stream = $disk->readStream($attachment->path);

        fpassthru($stream);

        if (is_resource($stream)) {
            fclose($stream);
        }
    }, 200, [
        'Content-Type' => $attachment->mime_type,
        'Cache-Control' => 'private, max-age=3600',
    ]);
})->name('preview.crop.image')->middleware(['auth']);
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
