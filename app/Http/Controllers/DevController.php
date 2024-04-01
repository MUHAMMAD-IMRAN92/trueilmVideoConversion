<?php

namespace App\Http\Controllers;

use App\Imports\HadeesImport;
use App\Models\Hadees;
use App\Models\HadeesTranslation;
use App\Models\HadithChapter;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Jobs\HadeeesBookCombination;
use App\Models\AlQuran;
use App\Models\AlQuranTranslation;
use App\Models\HadeesBooks;
use App\Models\Khatoot;
use Maatwebsite\Excel\Concerns\ToModel;
use Meilisearch\Client;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Storage;

class DevController extends Controller
{
    public function uploadFile()
    {

        return view('uploadFile');
    }
    public function post(Request $request)
    {

        $inputFile = $request->file('file')->getPathname(); // Get the path to the uploaded file
        $outputDir = storage_path('output/'); // Output directory for HLS files

        // Ensure the output directory exists
        if (!file_exists($outputDir)) {
            mkdir($outputDir, 0755, true); // Create the directory if it doesn't exist
        }

        // Output HLS playlist filename
        $outputFile = $outputDir . 'output.m3u8';

        // Execute FFmpeg command
        $process = new Process([
            'ffmpeg',
            '-i', $inputFile,
            '-vf', 'scale=-2:480', // Adjust resolution if needed
            '-c:a', 'aac',
            '-c:v', 'h264',
            '-hls_time', '10', // Segment duration in seconds
            '-hls_list_size', '0', // List all segments in playlist
            $outputFile
        ]);

        // Start debugging
        \Log::info('FFmpeg command: ' . $process->getCommandLine()); // Log FFmpeg command being executed

        $process->run();

        // Check if FFmpeg process was successful
        if (!$process->isSuccessful()) {
            \Log::error('FFmpeg error output: ' . $process->getErrorOutput()); // Log FFmpeg error output
            throw new \RuntimeException('Failed to execute FFmpeg command');
        }

        // Output file path
        $outputFilePath = public_path('output/output.m3u8');

        // Check if the output HLS playlist was created
        if (file_exists($outputFilePath)) {
            \Log::info('HLS playlist created successfully at: ' . $outputFilePath); // Log successful HLS playlist creation
        } else {
            \Log::error('Failed to create HLS playlist'); // Log failure to create HLS playlist
            throw new \RuntimeException('Failed to create HLS playlist');
        }

        return 'ok';
        // $config = [
        //     'ffmpeg.binaries'  => 'C:\ffmpeg\ffmpeg-master-latest-linux64-gpl\bin',
        //     'ffprobe.binaries' => 'C:\ffmpeg\ffmpeg-master-latest-linux64-gpl\bin',
        //     'timeout'          => 3600, // The timeout for the underlying process
        //     'ffmpeg.threads'   => 12,   // The number of threads that FFmpeg should use
        // ];

        // $log = new Logger('FFmpeg_Streaming');
        // $log->pushHandler(new StreamHandler('/storage/log/ffmpeg-streaming.log')); // path to log file

        // $ffmpeg = \Streaming\FFMpeg::create($config, $log);

        // $video = $ffmpeg->open($request->file);
        // $video->dash()
        //     ->x264() // Format of the video. Alternatives: hevc() and vp9()
        //     ->autoGenerateRepresentations() // Auto generate representations
        //     ->save(); // It can be passed a path to the method or it can be null
        ini_set('max_execution_time', '0');



        Hadees::where('book_id', '65e96911d67654aab27f7cb8')->delete();
        HadeesTranslation::where('book_id', '65e96911d67654aab27f7cb8')->delete();
        HadithChapter::where('book_id', '65e96911d67654aab27f7cb8')->delete();

        $rows = Excel::tocollection(new HadeesImport, $request->file);

        $book =  HadeesBooks::where('_id', '65e9a1249de8bf4c113a2d30')->first();
        foreach ($rows as $key1 => $row1) {
            foreach ($row1 as $key => $row) {
                // dd($row);
                if ($key != 0) {


                    $count = HadithCHapter::where('book_id', '65e9a1249de8bf4c113a2d30')->orderBy('created_at', 'DESC')->first()->auto_gen_chapter_no ?? 0;
                    $count = $count + 1;
                    // return $row[45];
                    // return $row[670];
                    $mainchapter = HadithChapter::where('title', $row[2])->where('book_id', '65e9a1249de8bf4c113a2d30')->first();
                    if (!$mainchapter) {
                        $mainchapter = new HadithChapter();
                        $mainchapter->book_id = $book->_id;
                        $mainchapter->title = $row[2];
                        $mainchapter->title_ara = $row[3];
                        if ($row[0] == '') {
                            $chapterNo = 0;
                        } else {
                            $chapterNo = $row[0];
                        }
                        $mainchapter->chapter_no = $chapterNo;
                        $mainchapter->auto_gen_chapter_no = $count;
                        $mainchapter->save();
                    }
                    // $subchapter = HadithChapter::where('title', @$row[5])->where('parent_id', $mainchapter->_id)->where('book_id', '65e9a1249de8bf4c113a2d30')->first();
                    // if (!$subchapter) {
                    //     $subchapter = new HadithChapter();
                    //     $subchapter->book_id = $book->_id;
                    //     $subchapter->title = @$row[5];
                    //     $subchapter->title_arabic = @$row[6];
                    //     $subchapter->parent_id = @$mainchapter->_id;
                    //     if (@$row[5] == '') {
                    //         $chapterNo = 0;
                    //     } else {
                    //         $chapterNo = @$row[5];
                    //     }
                    //     $subchapter->chapter_no = @$row[5];
                    //     $subchapter->auto_gen_chapter_no = $count;
                    //     $subchapter->save();
                    // }
                    $type = 1;
                    if (@$row[8] == '(Hasan)') {
                        $type = 3;
                    }
                    if (@$row[8] == '(Daif)') {
                        $type = 2;
                    }
                    if (@$row[3] == '') {
                        $aLreadyExist = Hadees::where('hadees',  @$row[4])->where('hadith_number', 0)->where('chapter_id', $mainchapter->_id)->first();
                        if (!$aLreadyExist) {
                            $hadees = new Hadees();
                            $hadees->hadees = @$row[4];
                            $hadees->type = $type;
                            $hadees->book_id = $book->_id;
                            $hadees->added_by = '6447918217e6501d607f4943';
                            $hadees->chapter_id = $mainchapter->_id;
                            $hadees->takreej = $row[9];
                            $hadees->hadith_number =  0;
                            $hadees->auto_gen_chapter_no = $key;
                            $hadees->save();
                        }
                        $translationALreadyExist = HadeesTranslation::where('translation',  @$row[7])->where('hadees_id', $hadees->_id ?? $aLreadyExist->_id)->first();
                        if (!$translationALreadyExist) {
                            $alQuranTranslation = new HadeesTranslation();
                            $alQuranTranslation->translation = @$row[7];
                            $alQuranTranslation->hadees_id = $hadees->_id ?? $aLreadyExist->_id;
                            $alQuranTranslation->author_lang = '65cf1335e08adee9f4146f65';
                            $alQuranTranslation->type = 5;
                            $alQuranTranslation->added_by = '6447918217e6501d607f4943';
                            $alQuranTranslation->book_id = $book->_id;
                            $alQuranTranslation->chapter_id = $mainchapter->_id;

                            $alQuranTranslation->save();
                            // HadeeesBookCombination::dispatch($alQuranTranslation->book_id, 5);
                        }
                        $translationALreadyExist = HadeesTranslation::where('translation',  @$row[6])->where('hadees_id', $hadees->_id ?? $aLreadyExist->_id)->first();
                        if (!$translationALreadyExist) {
                            $alQuranTranslation = new HadeesTranslation();
                            $alQuranTranslation->translation = @$row[6];
                            $alQuranTranslation->hadees_id = $hadees->_id ?? $aLreadyExist->_id;
                            $alQuranTranslation->author_lang = '65e99e9bd67654aab27f7cd0';
                            $alQuranTranslation->type = 5;
                            $alQuranTranslation->added_by = '6447918217e6501d607f4943';
                            $alQuranTranslation->book_id = $book->_id;
                            $alQuranTranslation->chapter_id = $mainchapter->_id;

                            $alQuranTranslation->save();
                            // HadeeesBookCombination::dispatch($alQuranTranslation->book_id, 5);
                        }
                        $translationALreadyExist = HadeesTranslation::where('translation',  @$row[5])->where('hadees_id', $hadees->_id ?? $aLreadyExist->_id)->first();
                        if (!$translationALreadyExist) {
                            $alQuranTranslation = new HadeesTranslation();
                            $alQuranTranslation->translation = @$row[7];
                            $alQuranTranslation->hadees_id = $hadees->_id ?? $aLreadyExist->_id;
                            $alQuranTranslation->author_lang = '65e99ed2d67654aab27f7cd1';
                            $alQuranTranslation->type = 5;
                            $alQuranTranslation->added_by = '6447918217e6501d607f4943';
                            $alQuranTranslation->book_id = $book->_id;
                            $alQuranTranslation->chapter_id = $mainchapter->_id;

                            $alQuranTranslation->save();
                            // HadeeesBookCombination::dispatch($alQuranTranslation->book_id, 5);
                        }
                        // $tafseerALreadyExist = HadeesTranslation::where('translation',  @$row[15])->where('hadees_id', $hadees->_id ?? $aLreadyExist->_id)->first();
                        // if (!$tafseerALreadyExist) {
                        //     $tafseerALreadyExist = new HadeesTranslation();
                        //     $tafseerALreadyExist->translation = @$row[15];
                        //     $tafseerALreadyExist->hadees_id = $hadees->_id ?? $aLreadyExist->_id;
                        //     $tafseerALreadyExist->author_lang = '6571b1f7c1f6db9f71eb5c38';
                        //     $tafseerALreadyExist->type = 6;
                        //     $tafseerALreadyExist->added_by = '6447918217e6501d607f4943';
                        //     $tafseerALreadyExist->book_id = $book->_id;
                        //     $tafseerALreadyExist->chapter_id = $mainchapter->_id;
                        //     $tafseerALreadyExist->save();
                        //     // HadeeesBookCombination::dispatch($tafseerALreadyExist->book_id, 6);
                        // }
                        // $notesALreadyExist = HadeesTranslation::where('translation',  @$row[24])->where('hadees_id', $hadees->_id ?? $aLreadyExist->_id)->first();
                        // if (!$notesALreadyExist) {
                        //     $notesALreadyExist = new HadeesTranslation();
                        //     $notesALreadyExist->translation = @$row[24];
                        //     $notesALreadyExist->hadees_id = $hadees->_id ?? $aLreadyExist->_id;
                        //     $notesALreadyExist->author_lang = '65d74456172ca17ee19d9263';
                        //     $notesALreadyExist->type = 3;
                        //     $notesALreadyExist->added_by = '6447918217e6501d607f4943';
                        //     $notesALreadyExist->book_id = $book->_id;
                        //     $notesALreadyExist->chapter_id = $mainchapter->_id;
                        //     $notesALreadyExist->save();
                        //     // HadeeesBookCombination::dispatch($alQuranTranslation->book_id, 6);
                        // }
                        $count + 1;
                    } else {

                        $hadtihNoArr = explode(',', @$row[3]);
                        foreach ($hadtihNoArr as $hadithno) {
                            $aLreadyExist = Hadees::where('hadees',  @$row[4])->where('hadith_number', $hadithno)->where('chapter_id', $mainchapter->_id)->first();
                            if (!$aLreadyExist) {
                                $hadees = new Hadees();
                                $hadees->hadees = @$row[4];
                                $hadees->type = $type;
                                $hadees->book_id = $book->_id;
                                $hadees->added_by = '6447918217e6501d607f4943';
                                $hadees->chapter_id = $mainchapter->_id;
                                if ($hadithno == '') {
                                    $chapterNo = 0;
                                } else {
                                    $chapterNo = @$row[5];
                                }
                                $hadees->takreej = $row[9];
                                $hadees->hadith_number =  $hadithno;
                                $hadees->auto_gen_chapter_no = $key;
                                $hadees->save();
                            }
                            $translationALreadyExist = HadeesTranslation::where('translation',  @$row[7])->where('hadees_id', $hadees->_id ?? $aLreadyExist->_id)->first();
                            if (!$translationALreadyExist) {
                                $alQuranTranslation = new HadeesTranslation();
                                $alQuranTranslation->translation = @$row[7];
                                $alQuranTranslation->hadees_id = $hadees->_id ?? $aLreadyExist->_id;
                                $alQuranTranslation->author_lang = '65cf1335e08adee9f4146f65';
                                $alQuranTranslation->type = 5;
                                $alQuranTranslation->added_by = '6447918217e6501d607f4943';
                                $alQuranTranslation->book_id = $book->_id;
                                $alQuranTranslation->chapter_id = $mainchapter->_id;

                                $alQuranTranslation->save();
                                // HadeeesBookCombination::dispatch($alQuranTranslation->book_id, 5);
                            }
                            $translationALreadyExist = HadeesTranslation::where('translation',  @$row[6])->where('hadees_id', $hadees->_id ?? $aLreadyExist->_id)->first();
                            if (!$translationALreadyExist) {
                                $alQuranTranslation = new HadeesTranslation();
                                $alQuranTranslation->translation = @$row[6];
                                $alQuranTranslation->hadees_id = $hadees->_id ?? $aLreadyExist->_id;
                                $alQuranTranslation->author_lang = '65e99e9bd67654aab27f7cd0';
                                $alQuranTranslation->type = 5;
                                $alQuranTranslation->added_by = '6447918217e6501d607f4943';
                                $alQuranTranslation->book_id = $book->_id;
                                $alQuranTranslation->chapter_id = $mainchapter->_id;

                                $alQuranTranslation->save();
                                // HadeeesBookCombination::dispatch($alQuranTranslation->book_id, 5);
                            }
                            $translationALreadyExist = HadeesTranslation::where('translation',  @$row[5])->where('hadees_id', $hadees->_id ?? $aLreadyExist->_id)->first();
                            if (!$translationALreadyExist) {
                                $alQuranTranslation = new HadeesTranslation();
                                $alQuranTranslation->translation = @$row[5];
                                $alQuranTranslation->hadees_id = $hadees->_id ?? $aLreadyExist->_id;
                                $alQuranTranslation->author_lang = '65e99ed2d67654aab27f7cd1';
                                $alQuranTranslation->type = 5;
                                $alQuranTranslation->added_by = '6447918217e6501d607f4943';
                                $alQuranTranslation->book_id = $book->_id;
                                $alQuranTranslation->chapter_id = $mainchapter->_id;

                                $alQuranTranslation->save();
                                // HadeeesBookCombination::dispatch($alQuranTranslation->book_id, 5);
                            }
                            // $tafseerALreadyExist = HadeesTranslation::where('translation',  @$row[15])->where('hadees_id', $hadees->_id ?? $aLreadyExist->_id)->first();
                            // if (!$tafseerALreadyExist) {
                            //     $tafseerALreadyExist = new HadeesTranslation();
                            //     $tafseerALreadyExist->translation = @$row[15];
                            //     $tafseerALreadyExist->hadees_id = $hadees->_id ?? $aLreadyExist->_id;
                            //     $tafseerALreadyExist->author_lang = '6571b1f7c1f6db9f71eb5c38';
                            //     $tafseerALreadyExist->type = 6;
                            //     $tafseerALreadyExist->added_by = '6447918217e6501d607f4943';
                            //     $tafseerALreadyExist->book_id = $book->_id;
                            //     $tafseerALreadyExist->chapter_id = $mainchapter->_id;
                            //     $tafseerALreadyExist->save();
                            //     // HadeeesBookCombination::dispatch($tafseerALreadyExist->book_id, 6);
                            // }
                            // $notesALreadyExist = HadeesTranslation::where('translation',  @$row[24])->where('hadees_id', $hadees->_id ?? $aLreadyExist->_id)->first();
                            // if (!$notesALreadyExist) {
                            //     $notesALreadyExist = new HadeesTranslation();
                            //     $notesALreadyExist->translation = @$row[24];
                            //     $notesALreadyExist->hadees_id = $hadees->_id ?? $aLreadyExist->_id;
                            //     $notesALreadyExist->author_lang = '65d74456172ca17ee19d9263';
                            //     $notesALreadyExist->type = 3;
                            //     $notesALreadyExist->added_by = '6447918217e6501d607f4943';
                            //     $notesALreadyExist->book_id = $book->_id;
                            //     $notesALreadyExist->chapter_id = $mainchapter->_id;
                            //     $notesALreadyExist->save();
                            //     // HadeeesBookCombination::dispatch($alQuranTranslation->book_id, 6);
                            // }
                        }
                    }
                }
            }
        }
        $count =  $count + 1;
        return 'ok';
    }

    public function updateChapter(Request $request)
    {
        ini_set('max_execution_time', 0);
        ini_set("memory_limit", "-1");
        $records = [];
        $rows = Excel::tocollection(new HadeesImport, $request->file);
        foreach ($rows as $key1 => $row1) {
            foreach ($row1 as $key => $row) {
                // dd($row);
                if ($key != 0) {
                    $alQuran = AlQuran::where('verse_key', $row[0] . ':' . $row[3])->first();
                    if ($alQuran != null) {

                        $records[] = [
                            'translation' =>  $row[5],
                            'ayat_id' => $alQuran->_id,
                            'surah_id' => $alQuran->surah_id,
                            'author_lang' => '65f298fd5937a0b37a63507d',
                            'type' => 1,
                            'added_by' => '6447918217e6501d607f4943',
                        ];

                        $records[] = [
                            'translation' =>  $row[6],
                            'ayat_id' => $alQuran->_id,
                            'surah_id' => $alQuran->surah_id,
                            'author_lang' => '65f299245937a0b37a63507e',
                            'type' => 2,
                            'added_by' => '6447918217e6501d607f4943',
                        ];
                    }
                }
            }
        }
        $chunkSize = 1000;
        $chunks = array_chunk($records, $chunkSize);
        foreach ($chunks as $chunk) {
            AlQuranTranslation::insert($chunk);
        }
        return 'save!';
    }
}
