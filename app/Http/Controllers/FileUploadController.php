<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileUploadController extends Controller
{
    public function uploadChunks(Request $request)
    {
        ini_set('max_execution_time', '0');
        ini_set("memory_limit", "-1");
        $file = $request->file('file');
        $filename = $request->resumableFilename;
        $chunkNumber = $request->resumableChunkNumber;
        $totalChunks = $request->resumableTotalChunks;

        $tempDir = storage_path('app/temp');
        if (!is_dir($tempDir)) {
            mkdir($tempDir, 0777, true);
        }

        $tempFilePath = $tempDir . DIRECTORY_SEPARATOR . $filename . '.part' . $chunkNumber;
        $file->move($tempDir, $tempFilePath);

        // Check if all chunks are uploaded
        $allChunksUploaded = true;
        for ($i = 1; $i <= $totalChunks; $i++) {
            if (!file_exists($tempDir . DIRECTORY_SEPARATOR . $filename . '.part' . $i)) {
                $allChunksUploaded = false;
                break;
            }
        }

        if ($allChunksUploaded) {
            // Combine all chunks
            $finalFilePath = $tempDir . DIRECTORY_SEPARATOR . $filename;
            $finalFile = fopen($finalFilePath, 'w');

            for ($i = 1; $i <= $totalChunks; $i++) {
                $chunkFilePath = $tempDir . DIRECTORY_SEPARATOR . $filename . '.part' . $i;
                $chunkFile = fopen($chunkFilePath, 'r');
                fwrite($finalFile, fread($chunkFile, filesize($chunkFilePath)));
                fclose($chunkFile);
                unlink($chunkFilePath);
            }

            fclose($finalFile);

            $previousUrl = url()->previous();

            // Define the new variable
            $newVariable = '';

            // Check if the previous URL includes the word "book"
            if (strpos($previousUrl, 'book') !== false) {
                $newVariable = 'files';
            } else {
                $newVariable = 'courses_videos';
            }
            $base_path = 'https://trueilm.s3.eu-north-1.amazonaws.com/' . $newVariable;
            // Upload the combined file to S3
            $path = Storage::disk('s3')->put($newVariable . '/' . $filename, fopen($finalFilePath, 'r+'));
            Storage::disk('s3')->setVisibility($newVariable . '/' . $filename, 'public');
            unlink($finalFilePath);

            return $filename;
        }

        return response()->json(['message' => 'Chunk uploaded successfully'], 200);
    }
}
