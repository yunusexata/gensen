<?php

use App\Http\Controllers\ListPosting\ListPostingController;
use App\Http\Controllers\ListPosting\TemplatePostingController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'access_permission'])->group(function () {
    Route::group(["controller" => ListPostingController::class, "prefix" => "list_posting", "as" => "list_posting."], function () {
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::get('{id}/edit', 'edit')->name('edit');
        Route::get('{id}/detail', 'detail')->name('detail');
    });
    Route::group(["controller" => TemplatePostingController::class, "prefix" => "template_posting", "as" => "template_posting."], function () {
        Route::get('/', 'index')->name('index');
        Route::get('create', 'create')->name('create');
        Route::get('{id}/edit', 'edit')->name('edit');
        Route::get('{id}/detail', 'detail')->name('detail');
    });

    Route::get(
        '/template_posting/{template}/preview',
        [TemplatePostingController::class, 'preview']
    )
        ->name('template_posting.preview');
});
Route::middleware(['auth'])->group(function () {
    Route::get(
        '/resi_generator/download/{id}',
        [ListPostingController::class, 'download']
    )->name('resi_generator.download');
});
