<?php

use App\Ai\Agents\DocumentClassificationEngine;
use App\Jobs\IchijikinExtraction\CropIchijikinJob;
use App\Jobs\SendGensenFormCreatedEmailJob;
use App\Models\Ai\AiJob;
use App\Models\GensenForm\GensenForm;
use App\Models\Ichijikin\IchijikinExtractionFile;
use App\Repositories\GensenForm\GensenFormRepository;
use App\Services\Ichijikin\IchijikinService;
use Gemini\Laravel\Facades\Gemini;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Laravel\Ai\Files;
use OpenAI\Laravel\Facades\OpenAI;

Route::get('/ai-test', function () {
    // $response = Gemini::models()->retrieve('models/gemini-2.5-flash-lite');
    // return dd($response->model);


    // return Storage::disk('public')->path('files/trial/ai/G HENDRA SEPTIAN-1.pdf');
    // $response = OpenAI::chat()->create([
    //     'model' => 'gpt-4o-mini',
    //     'messages' => [
    //         ['role' => 'user', 'content' => 'hello']
    //     ],
    // ]);
    //     $response = (new DocumentClassificationEngine)->prompt(
    //         'Analyze the uploaded document image or PDF.

    // Classify the document into ONE of the following types:

    // - gensen_choshu_hyo
    // - remittance
    // - kartu_keluarga
    // - unknown_document

    // Definitions:

    // gensen_choshu_hyo:
    // Japanese tax withholding slip (源泉徴収票).
    // Contains employer name, tax year (Reiwa/Heisei), income amount, withholding tax table.

    // remittance:
    // Money transfer proof showing sender, receiver, transfer company, or transaction confirmation.

    // kartu_keluarga:
    // Indonesian Family Card (Kartu Keluarga) issued by Dukcapil Indonesia.

    // unknown_document:
    // Document does not clearly belong to any category.

    // Extract minimal metadata ONLY when confident.

    // Return JSON using EXACT schema below.',
    //         attachments: [
    //             Files\Document::fromStorage('files/trial/ai/G HENDRA SEPTIAN-1.pdf', 'public'), // Attach a document from a filesystem disk...
    //             // Files\Document::fromPath('/home/laravel/transcript.md'), // Attach a document from a local path...
    //             // $request->file('transcript'), // Attach an uploaded file...
    //         ]
    //     );

    // $gensen = GensenForm::first();
    // SendGensenFormCreatedEmailJob::dispatch($gensen);

    // $disk = env('DEFAULT_STORE_DISK', 'private');
    // $url = Storage::disk($disk)->temporaryUrl(
    //     'test.txt',
    //     now()->addMinutes(5)
    // );
    // // $url = 'oke';
    // Storage::disk($disk)->put(
    //     'test.txt',
    //     'Hello Supabase Storage'
    // );
    // return $url;
    $att = IchijikinExtractionFile::first();
    // $job = AiJob::firstOrCreate(
    //     [
    //         'subject_type' => IchijikinExtractionFile::class,
    //         'subject_id'   => $att->id,
    //         'job_type'     => AiJob::JOB_TYPE_ICHIJIKIN_EXTRACTION,
    //         'status'       => 'pending',
    //     ],
    //     [
    //         'provider' => 'gemini-ai',
    //         'model'    => env('GEMINI_MODEL', 'gemini-3.1-flash-lite'),
    //     ]
    // );

    // CropIchijikinJob::dispatch($att)->onQueue('crop');
    $data = app(IchijikinService::class)
        ->handleCropDocument($att);

    return 'oke';
});
