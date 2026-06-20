<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Models\Gensen\GensenExportImportHistory;

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
Route::group([], __DIR__ . '/web/BukuNenkin.php');
Route::group([], __DIR__ . '/web/OpenAi.php');
Route::group([], __DIR__ . '/web/IchijikinExtraction.php');
Route::group([], __DIR__ . '/web/ResiGenerator.php');

Route::middleware(['auth', 'access_permission'])->group(function () {
    Route::group(["controller" => DashboardController::class, "prefix" => "dashboard", "as" => "dashboard."], function () {
        Route::get('/', 'index')->name('index');
    });
});
Route::get('/php-check', function () {
    dd([
        'upload_max_filesize' => ini_get('upload_max_filesize'),
        'post_max_size' => ini_get('post_max_size'),
        'memory_limit' => ini_get('memory_limit'),
        'loaded_ini' => php_ini_loaded_file(),
    ]);
});
// Route::get('/sentry-test', function () {
//     throw new Exception('Sentry Test');
// });
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'time' => now(),
    ]);
});
// Route::get('/phpinfo', fn() => phpinfo());

Route::get('/403', function () {
    abort(403, session('error', 'Form ini sudah tidak dapat digunakan.'));
})->name('form.max-usage');
