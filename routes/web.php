<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group([], __DIR__ . '/web/Auth.php');
Route::group([], __DIR__ . '/web/Other.php');
Route::group([], __DIR__ . '/web/Account.php');
Route::group([], __DIR__ . '/web/GensenForm.php');
// Route::group([], __DIR__ . '/web/BukuNenkin.php');
// Route::group([], __DIR__ . '/web/OpenAi.php');
Route::group([], __DIR__ . '/web/IchijikinExtraction.php');
Route::group([], __DIR__ . '/web/ResiGenerator.php');
Route::group([], __DIR__ . '/web/ListPosting.php');

Route::middleware(['auth', 'access_permission'])->group(function () {
    Route::group(["controller" => DashboardController::class, "prefix" => "dashboard", "as" => "dashboard."], function () {
        Route::get('/', 'index')->name('index');
    });
});
// Route::get('/test', function () {
//     app(\App\Services\ListPosting\ArtboardGeneratorService::class)
//         ->generateArtboards(5);
// });
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'time' => now(),
    ]);
});
// Route::get('/phpinfo', fn() => phpinfo());

Route::get('/403', function () {
    return response()
        ->view('errors.403', [
            'message' => session('error', 'Form ini sudah tidak dapat digunakan.')
        ], 403);
})->name('form.max-usage');
