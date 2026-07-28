<?php

use App\Http\Controllers\DashboardController;
use App\Models\Gensen\GensenExportImportHistory;
use App\Repositories\Ai\AiJobRepository;
use App\Repositories\ResiGenerator\ResiGeneratorDetailRepository;
use App\Services\Ichijikin\IchijikinService;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Spatie\Browsershot\Browsershot;

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
Route::group([], __DIR__ . '/web/ListPosting.php');

Route::middleware(['auth', 'access_permission'])->group(function () {
    Route::group(["controller" => DashboardController::class, "prefix" => "dashboard", "as" => "dashboard."], function () {
        Route::get('/', 'index')->name('index');
    });
});
// Route::get('/php-check', function () {
//     dd([
//         'upload_max_filesize' => ini_get('upload_max_filesize'),
//         'post_max_size' => ini_get('post_max_size'),
//         'memory_limit' => ini_get('memory_limit'),
//         'loaded_ini' => php_ini_loaded_file(),
//     ]);
// });
Route::get('/test', function () {
    app(\App\Services\ListPosting\ArtboardGeneratorService::class)
        ->generateArtboards(9);
});
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'time' => now(),
    ]);
});
// Route::get('/phpinfo', fn() => phpinfo());
// Route::get('/test-browsershot', function () {
//     try {
//         $path = storage_path('app/browsershot-test.pdf');

//         // Uji dengan HTML sederhana
//         Browsershot::html('<h1>Browsershot Bekerja di Linux!</h1><p>Waktu: ' . now() . '</p>')
//             ->noSandbox()
//             ->save($path);

//         return "Berhasil! PDF telah dibuat di: " . $path;
//     } catch (\Exception $e) {
//         return "Gagal! Error: " . $e->getMessage();
//     }
// });
// Route::get('/test-shot', function () {
//     ini_set('memory_limit', '1024M');
//     set_time_limit(300); // 5 minutes

//     $resiDetail = ResiGeneratorDetailRepository::find(720);
//     $htmlContent = view('app.resi-generator.template.version1', ['data' => $resiDetail])->render();

//     $cleanExcelRekening = preg_replace('/\D/', '', $resiDetail->rekening);
//     $fileName =
//         str_pad($resiDetail->id, 4, "0", STR_PAD_LEFT)
//         . '_' .
//         strtoupper($resiDetail->resi->bank)
//         . '_' .
//         strtoupper($resiDetail->nama)
//         . '_' .
//         $cleanExcelRekening . '.jpg';

//     $relativePath = 'resi-generated/' .
//         $resiDetail->resi->label .
//         '/' .
//         $fileName;

//     $storageDisk = 'private';
//     $disk = Storage::disk($storageDisk);

//     // pastikan folder ada
//     $disk->makeDirectory(
//         'resi-generated/' . $resiDetail->resi->label
//     );

//     // absolute path untuk Browsershot
//     $absolutePath = $disk->path($relativePath);

//     Browsershot::html($htmlContent)
//         ->noSandbox()
//         ->addChromiumArguments([
//             '--disable-dev-shm-usage',
//             '--disable-setuid-sandbox',
//             '--no-first-run',
//             '--headless',
//         ])
//         ->setScreenshotType('jpeg', 90)
//         ->windowSize(600, 800)
//         ->fullPage()
//         ->save($absolutePath);
//     return 'OK';
// });
Route::get('/403', function () {
    // abort(403, session('error', 'Form ini sudah tidak dapat digunakan.'));
    return response()
        ->view('errors.403', [
            'message' => session('error', 'Form ini sudah tidak dapat digunakan.')
        ], 403);
})->name('form.max-usage');
