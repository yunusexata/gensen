<?php

namespace App\Services\Ichijikin;

use App\Jobs\IchijikinExtraction\ExtractionIchijikinJob;
use App\Repositories\ConvertDataIchijikin\ConvertDataIchijikinRepository;
use Carbon\Carbon;
use Exception;
use Google\Cloud\Vision\V1\AnnotateImageRequest;
use Google\Cloud\Vision\V1\BatchAnnotateImagesRequest;
use Google\Cloud\Vision\V1\Client\ImageAnnotatorClient;
use Google\Cloud\Vision\V1\Feature;
use Google\Cloud\Vision\V1\Image;
use setasign\Fpdi\Fpdi;


class IchijikinService
{
    public function cropImage($path, $coords, $des, $name)
    {
        try {
            //code...

            $srcPath = storage_path('app/public/' . $path);

            if (!file_exists($srcPath)) {
                throw new \Exception("Image not found: " . $srcPath);
            }

            // Load image (JPEG only as per your original code)
            // $src = imagecreatefromjpeg($srcPath);
            $mime = mime_content_type($srcPath);

            switch ($mime) {

                case 'image/jpeg':
                    $src = imagecreatefromjpeg($srcPath);
                    break;

                case 'image/png':
                    $src = imagecreatefrompng($srcPath);
                    break;

                case 'image/webp':
                    $src = imagecreatefromwebp($srcPath);
                    break;

                default:
                    throw new Exception("Unsupported image type");
            }

            // ==============================
            // 1️⃣ FIX EXIF ORIENTATION
            // ==============================
            $exif = @exif_read_data($srcPath);

            if (!empty($exif['Orientation'])) {
                switch ($exif['Orientation']) {
                    case 3:
                        $src = imagerotate($src, 180, 0);
                        break;
                    case 6:
                        $src = imagerotate($src, -90, 0);
                        break;
                    case 8:
                        $src = imagerotate($src, 90, 0);
                        break;
                }
            }

            // ==============================
            // 2️⃣ GET ORIGINAL SIZE
            // ==============================
            $srcWidth  = imagesx($src);
            $srcHeight = imagesy($src);

            // Reference size (size used when defining coordinates)
            $referenceWidth  = 1241;
            $referenceHeight = 1755;

            // ==============================
            // 3️⃣ CALCULATE SCALE FACTOR
            // ==============================
            $scaleX = $srcWidth  / $referenceWidth;
            $scaleY = $srcHeight / $referenceHeight;

            // ==============================
            // 4️⃣ SCALE COORDINATES
            // ==============================
            $x      = (int) round($coords['x'] * $scaleX);
            $y      = (int) round($coords['y'] * $scaleY);
            $width  = (int) round($coords['width'] * $scaleX);
            $height = (int) round($coords['height'] * $scaleY);

            // Safety boundary check
            $x = max(0, min($x, $srcWidth - 1));
            $y = max(0, min($y, $srcHeight - 1));

            if ($x + $width > $srcWidth) {
                $width = $srcWidth - $x;
            }

            if ($y + $height > $srcHeight) {
                $height = $srcHeight - $y;
            }

            // ==============================
            // 5️⃣ CROP
            // ==============================
            $dst = imagecreatetruecolor($width, $height);

            // imagecopy(
            //     $dst,
            //     $src,
            //     0,
            //     0,
            //     $x,
            //     $y,
            //     $width,
            //     $height
            // );
            imagecopyresampled(
                $dst,
                $src,
                0,
                0,
                $x,
                $y,
                $width,
                $height,
                $width,
                $height
            );

            // ==============================
            // 6️⃣ SAVE RESULT
            // ==============================
            $destFolder = storage_path('app/public/' . $des);
            $destPath   = $destFolder . "/$name.png";

            // logger([
            //     'DEST CROP',
            //     $destPath
            // ]);

            if (!file_exists($destFolder)) {
                mkdir($destFolder, 0755, true);
            }

            imagepng($dst, $destPath);
            imagedestroy($src);
            imagedestroy($dst);

            return $destPath;
        } catch (\Throwable $th) {
            //throw $th;
            // logger([
            //     'CROP SERVICE ERROR',
            //     $th
            // ]);
        }
    }

    public function handleCropDocument($model)
    {
        $file = $model->subject;
        $epath = explode('/', $file->path);
        $path = $file->path;
        // $folder = $epath[0] . '/' . $epath[1];
        $folder = "ichijikin/{$file->ichijikinExtraction->batch_name}/crop/$file->file_stored_name";
        // $storedName = pathinfo($file->stored_name, PATHINFO_FILENAME);

        // // Crop Date
        // $coord = ['x' => 30, 'y' => 250, 'width' => 250, 'height' => 45];
        // $this->cropImage($path, $coord, $folder, 'date');

        // New Reference Dimensions: Width = 1241, Height = 1755

        // Crop Kokumin
        $coord = ['x' => 665, 'y' => 55, 'width' => 200, 'height' => 65];
        $this->cropImage($path, $coord, $folder, 'kokumin');

        // Crop Payment
        $coord = ['x' => 665, 'y' => 406, 'width' => 220, 'height' => 65];
        $this->cropImage($path, $coord, $folder, 'nenkin_100');

        // Crop Income
        $coord = ['x' => 665, 'y' => 483, 'width' => 220, 'height' => 65];
        $this->cropImage($path, $coord, $folder, 'nenkin_20');

        // Crop Net
        $coord = ['x' => 665, 'y' => 581, 'width' => 220, 'height' => 65];
        $this->cropImage($path, $coord, $folder, 'nenkin_80');

        // Crop Number
        $coord = ['x' => 717, 'y' => 1042, 'width' => 290, 'height' => 65];
        $this->cropImage($path, $coord, $folder, 'no_nenkin');

        // Crop Name
        $coord = ['x' => 461, 'y' => 1097, 'width' => 780, 'height' => 80];
        $this->cropImage($path, $coord, $folder, 'nama_lengkap');

        // Crop Lama Kerja
        $coord = ['x' => 700, 'y' => 780, 'width' => 150, 'height' => 90];
        $this->cropImage($path, $coord, $folder, 'lama_kerja');

        $coord = ['x' => 439, 'y' => 1152, 'width' => 768, 'height' => 110];
        $this->cropImage($path, $coord, $folder, 'alamat');

        ExtractionIchijikinJob::dispatch($model)->onQueue('extract');
        // // Crop Payment Top
        // $coord = ['x' => 610, 'y' => 50, 'width' => 165, 'height' => 50];
        // $this->cropImage($path, $coord, $folder, 'kokumin');

        // // Crop Payment
        // $coord = ['x' => 610, 'y' => 370, 'width' => 180, 'height' => 50];
        // $this->cropImage($path, $coord, $folder, 'nenkin_100');

        // // Crop Income
        // $coord = ['x' => 610, 'y' => 440, 'width' => 180, 'height' => 50];
        // $this->cropImage($path, $coord, $folder, 'nenkin_20');

        // // Crop Net
        // $coord = ['x' => 610, 'y' => 530, 'width' => 180, 'height' => 50];
        // $this->cropImage($path, $coord, $folder, 'nenkin_80');

        // // Crop Number
        // $coord = ['x' => 660, 'y' => 950, 'width' => 170, 'height' => 50];
        // $this->cropImage($path, $coord, $folder, 'no_nenkin');

        // // Crop Name
        // $coord = ['x' => 420, 'y' => 1000, 'width' => 700, 'height' => 70];
        // $this->cropImage($path, $coord, $folder, 'nama_lengkap');

        // Crop Address
        // $coord = ['x' => 400, 'y' => 1050, 'width' => 700, 'height' => 100];
        // $this->cropImage($path, $coord, $folder, 'alamat');

        // $nenkin = ConvertDataIchijikinRepository::update($model->id, [
        //     'date' => $this->detectDocumentText(storage_path('app/public/' . $folder . '/date.png'), 'date')['text'] ?? null,
        //     'payment_top' => $this->detectDocumentText(storage_path('app/public/' . $folder . '/payment_top.png'), 'payment_top')['text'] ?? null,
        //     'payment' => $this->detectDocumentText(storage_path('app/public/' . $folder . '/payment.png'), 'payment')['text'] ?? null,
        //     'income' => $this->detectDocumentText(storage_path('app/public/' . $folder . '/income.png'), 'income')['text'] ?? null,
        //     'net' => $this->detectDocumentText(storage_path('app/public/' . $folder . '/net.png'), 'net')['text'] ?? null,
        //     'number' => $this->detectDocumentText(storage_path('app/public/' . $folder . '/number.png'), 'number')['text'] ?? null,
        //     'name' => $this->detectDocumentText(storage_path('app/public/' . $folder . '/name.png'), 'name')['text'] ?? null,
        //     'address' => $this->detectDocumentText(storage_path('app/public/' . $folder . '/address.png'), 'address')['text'] ?? null,
        // ]);

        // $this->drawLabelPdf(storage_path('app/public/' . $path), $folder, ConvertDataIchijikinRepository::find($model->id));

        // $this->drawLabelImage(storage_path('app/public/' . $path), $folder, $model->kokumin, $model->nenkin_100);
    }

    public function detectDocumentText($path, string $name)
    {
        $client = new ImageAnnotatorClient([
            'credentials' => base_path('storage/app/google-credentials.json'),
        ]);

        // Read image content
        $imageContent = file_get_contents($path);
        $image = (new Image())->setContent($imageContent);

        // Prepare the feature for DOCUMENT_TEXT_DETECTION
        $feature = (new Feature())->setType(Feature\Type::DOCUMENT_TEXT_DETECTION);

        // Annotate image
        $request = (new AnnotateImageRequest())
            ->setImage($image)
            ->setFeatures([$feature]);
        $batchRequest = (new BatchAnnotateImagesRequest())
            ->setRequests([$request]);

        $response = $client->batchAnnotateImages($batchRequest);
        $annotations = $response->getResponses()[0];

        $result = [];

        // If text found
        if ($annotations->hasFullTextAnnotation()) {
            $fullText = $annotations->getFullTextAnnotation();
            $result['text'] = $fullText->getText();

            if ($name === 'date') {

                if (!$result['text']) return null;

                $text = preg_replace('/\s+/u', '', $result['text']);

                preg_match('/(\d{4})年/u', $text, $y);
                preg_match_all('/(\d{1,2})月/u', $text, $m);
                preg_match('/(\d{1,2})日/u', $text, $d);

                if (!empty($y[1]) && !empty($m[1]) && !empty($d[1])) {

                    $year  = (int) $y[1];

                    // Ambil bulan yang paling dekat dengan 年
                    $month = (int) end($m[1]);
                    $day   = (int) $d[1];

                    try {
                        $date = Carbon::createFromDate($year, $month, $day);
                        $result['text'] = $date->format('Y-m-d');
                    } catch (\Exception $e) {
                        return null;
                    }
                } else {
                    return null;
                }
            } elseif (in_array($name, ['payment_top', 'payment', 'income', 'net'])) {
                if (!$result['text']) return null;

                $text = preg_replace('/\s+/', '', $result['text']);
                $text = preg_replace('/[^0-9]/', '', $text);

                $result['text'] = $text ?: null;
            } elseif ($name == 'name' || $name == 'address') {

                $reconstructed = '';

                foreach ($fullText->getPages() as $page) {
                    foreach ($page->getBlocks() as $block) {
                        foreach ($block->getParagraphs() as $paragraph) {

                            foreach ($paragraph->getWords() as $word) {

                                foreach ($word->getSymbols() as $symbol) {
                                    $reconstructed .= $symbol->getText();
                                }

                                // Add space between words
                                $reconstructed .= ' ';
                            }
                        }
                    }
                }

                $result['text'] = trim($reconstructed) ?: null;
            }

            // // For simplicity, we just save the full text. You can also save structured info like blocks, paragraphs, etc.
            // foreach ($fullText->getPages() as $pageIndex => $page) {
            //     foreach ($page->getBlocks() as $blockIndex => $block) {
            //         $block_text = '';
            //         foreach ($block->getParagraphs() as $paragraph) {
            //             foreach ($paragraph->getWords() as $word) {
            //                 foreach ($word->getSymbols() as $symbol) {
            //                     $block_text .= $symbol->getText();
            //                 }
            //                 $block_text .= ' ';
            //             }
            //             $block_text .= "\n";
            //         }

            //         // Get bounding box
            //         $vertices = $block->getBoundingBox()->getVertices();
            //         $bounds = [];
            //         foreach ($vertices as $vertex) {
            //             $bounds[] = [
            //                 'x' => $vertex->getX(),
            //                 'y' => $vertex->getY(),
            //             ];
            //         }

            //         // Save structured block info
            //         $result['pages'][$pageIndex]['blocks'][$blockIndex] = [
            //             'text' => trim($block_text),
            //             'confidence' => $block->getConfidence(),
            //             'bounds' => $bounds,
            //         ];
            //     }
            // }
        } else {
            $result['text'] = null;
        }

        $client->close();
        // $json = file_get_contents(storage_path('app/nenkin.json')); // or your JSON string
        // $result = json_decode($json, true);
        // $this->drawBlocksOnPdf($path, $result['pages'][0]['blocks'], public_path('output.pdf'));
        // $this->drawBlocksOnPdf($path, $result['text'], public_path('output.pdf'));

        return $result;
        // return $result['pages'][0]['blocks'];
    }

    public function drawLabelImage($imagePath, $desPath, $fileName, $kokumin = null, $nenkin_100 = null)
    {
        // logger([
        //     'draw label',
        //     $imagePath,
        //     $desPath,
        //     $fileName,
        //     $kokumin,
        //     $nenkin_100
        // ]);
        // Load image
        $image = imagecreatefromjpeg($imagePath);

        $currentWidth  = imagesx($image);
        $currentHeight = imagesy($image);

        // New Blueprint / Reference Size
        $referenceWidth  = 1241;
        $referenceHeight = 1755;

        // Calculate dynamic ratio based on the newly uploaded image vs reference
        $scaleX = $currentWidth / $referenceWidth;
        $scaleY = $currentHeight / $referenceHeight;

        // Colors
        $blue   = imagecolorallocate($image, 0, 2, 245);
        $red    = imagecolorallocate($image, 245, 5, 1);
        $orange = imagecolorallocate($image, 250, 100, 6);

        imagesetthickness($image, 6);

        if ($kokumin && !$nenkin_100) {
            // === SCALE POSITION (Kokumin) ===
            $x = 313 * $scaleX;
            $y = 55  * $scaleY;

            $rectX1 = 669 * $scaleX;
            $rectY1 = 55  * $scaleY;
            $rectX2 = 889 * $scaleX; // 669 + 220 width
            $rectY2 = 132 * $scaleY; // 55 + 77 height

            // Resize label
            $labelImage = imagecreatefrompng(public_path('100%.png'));

            $labelWidth  = 219 * $scaleX;
            $labelHeight = 77  * $scaleY;

            imagecopyresampled(
                $image,
                $labelImage,
                $x,
                $y,
                0,
                0,
                $labelWidth,
                $labelHeight,
                imagesx($labelImage),
                imagesy($labelImage)
            );

            // === SCALE POSITION (Kokumin) ===
            $x = 300 * $scaleX;
            $y = 1  * $scaleY;

            // $rectX1 = 669 * $scaleX;
            // $rectY1 = 55  * $scaleY;
            // $rectX2 = 889 * $scaleX; // 669 + 220 width
            // $rectY2 = 132 * $scaleY; // 55 + 77 height

            // Resize label
            $labelImage = imagecreatefrompng(public_path('kokumin_nenkin.png'));

            $labelWidth  = 219 * $scaleX;
            $labelHeight = 50  * $scaleY;

            imagecopyresampled(
                $image,
                $labelImage,
                $x,
                $y,
                0,
                0,
                $labelWidth,
                $labelHeight,
                imagesx($labelImage),
                imagesy($labelImage)
            );

            imagerectangle($image, $rectX1, $rectY1, $rectX2, $rectY2, $blue);
        }

        if ($nenkin_100) {

            // === SCALE POSITION (Kokumin) ===
            $x = 300 * $scaleX;
            $y = 350  * $scaleY;

            // $rectX1 = 669 * $scaleX;
            // $rectY1 = 55  * $scaleY;
            // $rectX2 = 889 * $scaleX; // 669 + 220 width
            // $rectY2 = 132 * $scaleY; // 55 + 77 height

            // Resize label
            $labelImage = imagecreatefrompng(public_path('kousei_nenkin.png'));

            $labelWidth  = 219 * $scaleX;
            $labelHeight = 50  * $scaleY;

            imagecopyresampled(
                $image,
                $labelImage,
                $x,
                $y,
                0,
                0,
                $labelWidth,
                $labelHeight,
                imagesx($labelImage),
                imagesy($labelImage)
            );
            /*
        === DRAW 100% LABEL ===
        */
            $x = 313 * $scaleX;
            $y = 406 * $scaleY;

            $rectX1 = 669 * $scaleX;
            $rectY1 = 406 * $scaleY;
            $rectX2 = 889 * $scaleX;
            $rectY2 = 483 * $scaleY;

            $labelImage = imagecreatefrompng(public_path('100%.png'));

            $labelWidth  = 219 * $scaleX;
            $labelHeight = 77  * $scaleY;

            imagecopyresampled(
                $image,
                $labelImage,
                $x,
                $y,
                0,
                0,
                $labelWidth,
                $labelHeight,
                imagesx($labelImage),
                imagesy($labelImage)
            );

            imagerectangle($image, $rectX1, $rectY1, $rectX2, $rectY2, $blue);

            /*
        === DRAW 20% LABEL ===
        */
            $x = 313 * $scaleX;
            $y = 494 * $scaleY;

            $rectX1 = 669 * $scaleX;
            $rectY1 = 494 * $scaleY;
            $rectX2 = 889 * $scaleX;
            $rectY2 = 570 * $scaleY;

            $labelImage = imagecreatefrompng(public_path('20%.png'));

            imagecopyresampled(
                $image,
                $labelImage,
                $x,
                $y,
                0,
                0,
                $labelWidth,
                $labelHeight,
                imagesx($labelImage),
                imagesy($labelImage)
            );

            imagerectangle($image, $rectX1, $rectY1, $rectX2, $rectY2, $red);

            /*
        === DRAW 80% LABEL ===
        */
            $x = 313 * $scaleX;
            $y = 581 * $scaleY;

            $rectX1 = 669 * $scaleX;
            $rectY1 = 581 * $scaleY;
            $rectX2 = 889 * $scaleX;
            $rectY2 = 658 * $scaleY;

            $labelImage = imagecreatefrompng(public_path('80%.png'));

            imagecopyresampled(
                $image,
                $labelImage,
                $x,
                $y,
                0,
                0,
                $labelWidth,
                $labelHeight,
                imagesx($labelImage),
                imagesy($labelImage)
            );

            imagerectangle($image, $rectX1, $rectY1, $rectX2, $rectY2, $orange);
        }

        // Destination folder
        $destFolder = storage_path('app/public/' . $desPath);

        if (!file_exists($destFolder)) {
            mkdir($destFolder, 0755, true);
        }

        // Fixed Bug: Defined the actual output path before saving
        $outputPath = $destFolder . "/$fileName.jpg";

        // Save as JPG
        $resized = imagescale(
            $image,
            (int)($currentWidth * 0.7),
            (int)($currentHeight * 0.7)
        );

        imagejpeg($resized, $outputPath, 60);

        // Free up memory
        imagedestroy($image);

        return $outputPath;
    }
    public function drawLabelImageOld($imagePath, $desPath, $kokumin = null, $nenkin_100 = null)
    {
        // Load image
        $image = imagecreatefromjpeg($imagePath);

        $currentWidth  = imagesx($image);
        $currentHeight = imagesy($image);

        // Blueprint size (acuan desain koordinat Anda)
        $baseWidth  = 1131;
        $baseHeight = 1600;

        // Hitung rasio
        $scaleX = $currentWidth / $baseWidth;
        $scaleY = $currentHeight / $baseHeight;

        // Colors
        $blue = imagecolorallocate($image, 0, 2, 245);
        $red = imagecolorallocate($image, 245, 5, 1);
        $orange = imagecolorallocate($image, 250, 100, 6);

        imagesetthickness($image, 6);

        if ($kokumin) {

            // === SCALE POSITION ===
            $x = 285 * $scaleX;
            $y = 50  * $scaleY;

            $rectX1 = 610 * $scaleX;
            $rectY1 = 50  * $scaleY;
            $rectX2 = (610 + 200) * $scaleX;
            $rectY2 = (70 + 50)  * $scaleY;

            // Resize label
            $label100 = imagecreatefrompng(public_path('100%.png'));

            $labelWidth  = 200 * $scaleX;
            $labelHeight = 70  * $scaleY;

            imagecopyresampled(
                $image,
                $label100,
                $x,
                $y,
                0,
                0,
                $labelWidth,
                $labelHeight,
                imagesx($label100),
                imagesy($label100)
            );

            imagerectangle(
                $image,
                $rectX1,
                $rectY1,
                $rectX2,
                $rectY2,
                $blue
            );
        }

        if ($nenkin_100) {
            /*
            === DRAW 100% LABEL ===
            */

            // === SCALE POSITION ===
            $x = 285 * $scaleX;
            $y = 370  * $scaleY;

            $rectX1 = 610 * $scaleX;
            $rectY1 = 370  * $scaleY;
            $rectX2 = (610 + 200) * $scaleX;
            $rectY2 = (390 + 50)  * $scaleY;

            // Resize label
            $label100 = imagecreatefrompng(public_path('100%.png'));

            $labelWidth  = 200 * $scaleX;
            $labelHeight = 70  * $scaleY;
            imagecopyresampled(
                $image,
                $label100,
                $x,
                $y,
                0,
                0,
                $labelWidth,
                $labelHeight,
                imagesx($label100),
                imagesy($label100)
            );

            imagerectangle(
                $image,
                $rectX1,
                $rectY1,
                $rectX2,
                $rectY2,
                $blue
            );

            /*
            === DRAW 20% LABEL ===
            */
            // === SCALE POSITION ===
            $x = 285 * $scaleX;
            $y = 450  * $scaleY;

            $rectX1 = 610 * $scaleX;
            $rectY1 = 450  * $scaleY;
            $rectX2 = (610 + 200) * $scaleX;
            $rectY2 = (470 + 50)  * $scaleY;

            // Resize label
            $label100 = imagecreatefrompng(public_path('20%.png'));

            $labelWidth  = 200 * $scaleX;
            $labelHeight = 70  * $scaleY;
            imagecopyresampled(
                $image,
                $label100,
                $x,
                $y,
                0,
                0,
                $labelWidth,
                $labelHeight,
                imagesx($label100),
                imagesy($label100)
            );

            imagerectangle(
                $image,
                $rectX1,
                $rectY1,
                $rectX2,
                $rectY2,
                $red
            );

            /*
            === DRAW 80% LABEL ===
            */
            // === SCALE POSITION ===
            $x = 285 * $scaleX;
            $y = 530  * $scaleY;

            $rectX1 = 610 * $scaleX;
            $rectY1 = 530  * $scaleY;
            $rectX2 = (610 + 200) * $scaleX;
            $rectY2 = (550 + 50)  * $scaleY;

            // Resize label
            $label100 = imagecreatefrompng(public_path('80%.png'));

            $labelWidth  = 200 * $scaleX;
            $labelHeight = 70  * $scaleY;
            imagecopyresampled(
                $image,
                $label100,
                $x,
                $y,
                0,
                0,
                $labelWidth,
                $labelHeight,
                imagesx($label100),
                imagesy($label100)
            );

            imagerectangle(
                $image,
                $rectX1,
                $rectY1,
                $rectX2,
                $rectY2,
                $orange
            );
        }

        // Destination folder
        $destFolder = storage_path('app/public/convert-data-ichijikin-labeled');

        if (!file_exists($destFolder)) {
            mkdir($destFolder, 0755, true);
        }

        // $outputPath = $destFolder . '/' . $model->number . '-' . $model->name . '.jpg';

        // Save as JPG
        imagejpeg($image, $outputPath, 100);

        $outputPath = storage_path('app/public/' . $desPath . '/labeled.jpg');

        imagejpeg($image, $outputPath, 100);

        return $outputPath;
    }

    public function drawLabelPdf($imagePath, $desPath, $model)
    {
        $pdf = new Fpdi();
        $pageWidth = 1130;
        $pageHeight = 1680;
        $pdf->AddPage('P', [$pageWidth, $pageHeight]);

        // Draw the base image
        $pdf->Image($imagePath, 0, 0, $pageWidth, $pageHeight);

        // Draw label 100%
        $pdf->Image(public_path('100%.png'), 285, 390, 200, 70);
        $pdf->SetDrawColor(0, 2, 245);
        $pdf->SetLineWidth(6);
        $pdf->Rect(610, 390, 200, 70);

        // Draw label 20%
        $pdf->Image(public_path('20%.png'), 285, 475, 200, 70);
        $pdf->SetDrawColor(245, 5, 1);
        $pdf->SetLineWidth(6);
        $pdf->Rect(610, 475, 200, 70);

        // Draw label 80%
        $pdf->Image(public_path('80%.png'), 285, 560, 200, 70);
        $pdf->SetDrawColor(250, 100, 6);
        $pdf->SetLineWidth(6);
        $pdf->Rect(610, 560, 200, 70);

        // Save the PDF

        $destFolder = storage_path('app/public/labeled');

        // Make sure folder exists
        if (!file_exists($destFolder)) {
            mkdir($destFolder, 0755, true);
        }
        $pdf->Output('F', storage_path('app/public/' . $desPath . '/labeled.pdf'));
        // $pdf->Output('F', storage_path('app/public/labeled/' . $model->number . '-' . $model->name . '.pdf'));
        $pdf->Close();
    }

    public function drawBlocksOnPdf($imagePath, $blocks, $outputPath)
    {
        $pdf = new Fpdi();
        $pageWidth = 1130;
        $pageHeight = 1680;
        $pdf->AddPage('P', [$pageWidth, $pageHeight]);

        // Draw the base image
        $pdf->Image($imagePath, 0, 0, $pageWidth, $pageHeight);

        // === Draw coordinate ruler ===
        $pdf->SetDrawColor(0, 0, 200); // Blue lines for grid
        $pdf->SetFont('Arial', '', 30);
        $pdf->SetTextColor(255, 0, 0);
        $pdf->SetLineWidth(2);

        $step = 50; // 50 units per line

        // Vertical lines + labels (X-axis)
        for ($x = 0; $x <= $pageWidth; $x += $step) {
            $pdf->Line($x, 0, $x, $pageHeight);        // Draw vertical line
            $pdf->Text($x + 1, 8, (string)$x);        // Label at top
        }

        // Horizontal lines + labels (Y-axis)
        for ($y = 0; $y <= $pageHeight; $y += $step) {
            $pdf->Line(0, $y, $pageWidth, $y);        // Draw horizontal line
            $pdf->Text(2, $y + 3, (string)$y);       // Label at left
        }

        // === Draw blocks ===
        $pdf->SetDrawColor(255, 0, 0); // Red border for blocks
        foreach ($blocks as $index => $block) {
            $bounds = $block['bounds'];
            $x1 = $bounds[0]['x'];
            $y1 = $bounds[0]['y'] + ($index * 0.57);
            $x2 = $bounds[2]['x'];
            $y2 = $bounds[2]['y'] + ($index * 0.57);

            $width = $x2 - $x1;
            $height = $y2 - $y1;

            $pdf->Rect($x1, $y1, $width, $height);
        }

        // Save the PDF
        $pdf->Output('F', $outputPath);
    }

    public function detectDocumentText1($path)
    {
        $client = new ImageAnnotatorClient([
            'credentials' => base_path(env('GOOGLE_CLOUD_CREDENTIALS')),
            'transport' => 'rest',
        ]);

        $imageContent = file_get_contents($path);

        $image = (new Image())
            ->setContent($imageContent);

        $feature = (new Feature())
            ->setType(Feature\Type::DOCUMENT_TEXT_DETECTION);

        $annotateRequest = (new AnnotateImageRequest())
            ->setImage($image)
            ->setFeatures([$feature]);

        $batchRequest = (new BatchAnnotateImagesRequest())
            ->setRequests([$annotateRequest]);

        $response = $client->batchAnnotateImages($batchRequest);

        $annotations = $response->getResponses()[0];

        $text = $annotations->getFullTextAnnotation();

        $text = $text?->getText();
        preg_match('/(\d{4})\s*年\s*(\d{1,2})\s*月\s*(\d{1,2})\s*日/u', $text, $matches);

        if ($matches) {
            $year  = $matches[1];
            $month = $matches[2];
            $day   = $matches[3];
        }

        return [
            'year' => $year ?? null,
            'month' => $month ?? null,
            'day' => $day ?? null,
            'text' => $text,
        ];
    }
}
