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
use App\Models\AuthorLanguage;
use App\Models\Book;
use App\Models\BookContent;
use App\Models\Course;
use App\Models\CourseLesson;
use App\Models\HadeesBooks;
use App\Models\Khatoot;
use App\Models\UserSubscription;
use Carbon\Carbon;
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
        $course = Course::first();
        $s3Url = $course->introduction_video;
        $video =  Storage::put(public_path('videos/'), file_get_contents($s3Url));
        $path = 'videos';
        $video = $request->file;
        $video_extension = $video->getClientOriginalExtension(); // getting image extension
        $video_extension = strtolower($video_extension);
        $allowedextentions = [
            "mov", "3g2", "3gp", "4xm", "a64", "aa", "aac", "ac3", "act", "adf", "adp", "adts", "adx", "aea", "afc", "aiff", "alaw", "alias_pix", "alsa", "amr", "anm", "apc", "ape", "apng",
            "aqtitle", "asf", "asf_o", "asf_stream", "ass", "ast", "au", "avi", "avisynth", "avm2", "avr", "avs", "bethsoftvid", "bfi", "bfstm", "bin", "bink", "bit", "bmp_pipe",
            "bmv", "boa", "brender_pix", "brstm", "c93", "caf", "cavsvideo", "cdg", "cdxl", "cine", "concat", "crc", "dash", "data", "daud", "dds_pipe", "dfa", "dirac", "dnxhd",
            "dpx_pipe", "dsf", "dsicin", "dss", "dts", "dtshd", "dv", "dv1394", "dvbsub", "dvd", "dxa", "ea", "ea_cdata", "eac3", "epaf", "exr_pipe", "f32be", "f32le", "f4v",
            "f64be", "f64le", "fbdev", "ffm", "ffmetadata", "film_cpk", "filmstrip", "flac", "flic", "flv", "framecrc", "framemd5", "frm", "g722", "g723_1", "g729", "gif", "gsm", "gxf",
            "h261", "h263", "h264", "hds", "hevc", "hls", "hls", "applehttp", "hnm", "ico", "idcin", "idf", "iff", "ilbc", "image2", "image2pipe", "ingenient", "ipmovie",
            "ipod", "ircam", "ismv", "iss", "iv8", "ivf", "j2k_pipe", "jacosub", "jpeg_pipe", "jpegls_pipe", "jv", "latm", "lavfi", "live_flv", "lmlm4", "loas", "lrc",
            "lvf", "lxf", "m4v", "matroska", "mkv", "matroska", "webm", "md5", "mgsts", "microdvd", "mjpeg", "mkvtimestamp_v2", "mlp", "mlv", "mm", "mmf", "mp4", "m4a", "3gp",
            "3g2", "mj2", "mp2", "mp3", "mp4", "mpc", "mpc8", "mpeg", "mpeg1video", "mpeg2video", "mpegts", "mpegtsraw", "mpegvideo", "mpjpeg", "mpl2", "mpsub", "msnwctcp",
            "mtv", "mulaw", "mv", "mvi", "mxf", "mxf_d10", "mxf_opatom", "mxg", "nc", "nistsphere", "nsv", "null", "nut", "nuv", "oga", "ogg", "oma", "opus", "oss", "paf",
            "pictor_pipe", "pjs", "pmp", "png_pipe", "psp", "psxstr", "pulse", "pva", "pvf", "qcp", "qdraw_pipe", "r3d", "rawvideo", "realtext", "redspark", "rl2", "rm",
            "roq", "rpl", "rsd", "rso", "rtp", "rtp_mpegts", "rtsp", "s16be", "s16le", "s24be", "s24le", "s32be", "s32le", "s8", "sami", "sap", "sbg", "sdl", "sdp", "sdr2",
            "segment", "sgi_pipe", "shn", "siff", "singlejpeg", "sln", "smjpeg", "smk", "smoothstreaming", "smush", "sol", "sox", "spdif", "spx", "srt", "stl",
            "stream_segment", "ssegment", "subviewer", "subviewer1", "sunrast_pipe", "sup", "svcd", "swf", "tak", "tedcaptions", "tee", "thp", "tiertexseq",
            "tiff_pipe", "tmv", "truehd", "tta", "tty", "txd", "u16be", "u16le", "u24be", "u24le", "u32be", "u32le", "u8", "uncodedframecrc", "v4l2", "vc1", "vc1test",
            "vcd", "video4linux2", "v4l2", "vivo", "vmd", "vob", "vobsub", "voc", "vplayer", "vqf", "w64", "wav", "wc3movie", "webm", "webm_chunk", "webm_dash_manife",
            "webp", "webp_pipe", "webvtt", "wsaud", "wsvqa", "wtv", "wv", "x11grab", "xa", "xbin", "xmv", "xv", "xwma", "wmv", "yop", "yuv4mpegpipe"
        ];
        if (in_array($video_extension, $allowedextentions)) {
            $outputDirectory = base_path('public/' . $path);

            // Define the resolutions and bitrates for the renditions
            $renditions = [
                ['resolution' => '640x360', 'bitrate' => '800k'],
                ['resolution' => '854x480', 'bitrate' => '1200k'],
                ['resolution' => '1280x720', 'bitrate' => '2500k'],
            ];

            // Generate each rendition
            foreach ($renditions as $index => $rendition) {
                $filePath = $video->getRealPath();
                $outputPath = $outputDirectory . '/rendition_' . $index . '.m3u8';
                $command = "ffmpeg -i $filePath -vf scale={$rendition['resolution']} -b:v {$rendition['bitrate']} -c:a copy -hls_time 2 -hls_playlist_type vod -hls_segment_filename {$outputPath}_segment_%03d.ts {$outputPath} 2>&1";
                exec($command, $result, $status);
            }

            // Generate HLS master playlist
            $masterPlaylist = "#EXTM3U\n";
            foreach ($renditions as $index => $rendition) {
                $resolution = $rendition['resolution'];
                $bitrate = $rendition['bitrate'];
                $outputPath = 'https://trueilm.s3.eu-north-1.amazonaws.com/test_files' . '/rendition_' . $index . '.m3u8';
                $masterPlaylist .= "#EXT-X-STREAM-INF:BANDWIDTH={$bitrate},RESOLUTION={$resolution}\n{$outputPath}\n";
            }
            $nameWithoutExtension = 'video_' . \Str::random(15);
            file_put_contents($outputDirectory . '/' . $nameWithoutExtension . '.m3u8', $masterPlaylist);

            $video_destinationPath = base_path('public/' . $path); // upload path
            // $nameWithoutExtension = 'video_' . \Str::random(15);
            $video_fileName = $nameWithoutExtension . '.m3u8'; // renameing image
            $fileDestination = $video_destinationPath . '/' . $video_fileName;

            // $filePath = $video->getRealPath();
            // exec("ffmpeg -i $filePath -strict -2 -vf scale=320:240 $fileDestination 2>&1", $result, $status);
            $content =  file_get_contents(public_path('videos/' . $video_fileName));
            $filePath = 'test_files/' . $video_fileName;
            Storage::disk('s3')->put($filePath,  $content);

            if ($status === 0) {
                echo "Conversion successful!";

                // Get the directory where the HLS files are stored
                $hlsDirectory = pathinfo($fileDestination, PATHINFO_DIRNAME);

                // Get all TS files generated by ffmpeg
                $tsFiles = glob($hlsDirectory . '/*.ts');

                // Upload each TS file to the desired directory
                // Upload TS files to S3
                foreach ($tsFiles as $tsFile) {
                    $tsFileName = pathinfo($tsFile, PATHINFO_BASENAME);
                    $destinationPath = 'test_files/' . $tsFileName; // Adjust the destination directory as needed

                    // Upload the TS file to the desired directory on S3
                    Storage::disk('s3')->put($destinationPath, file_get_contents($tsFile));

                    echo "Uploaded $tsFileName to $destinationPath\n";
                }

                // Upload Rendition files to S3
                $renditionFiles = glob($hlsDirectory . '/rendition_*');

                foreach ($renditionFiles as $renditionFile) {
                    $renditionFileName = pathinfo($renditionFile, PATHINFO_BASENAME);
                    $destinationPath = 'test_files/' . $renditionFileName; // Adjust the destination directory as needed

                    // Upload the Rendition file to the desired directory on S3
                    Storage::disk('s3')->put($destinationPath, file_get_contents($renditionFile));

                    echo "Uploaded $renditionFileName to $destinationPath\n";
                }
            } else {
                echo "Conversion failed!";
            }
            // \File::delete($fileDestination);
            echo '<pre>';
            print_r($result);
            // print_r($status);
            exit;
            // $info = getVideoInformation($result);
            // $poster_name = explode('.', $video_fileName)[0] . '.jpg';
            // $poster = 'public/images/' . $path . '/posters/' . $poster_name;
            // exec("ffmpeg -ss $info[1] -i $filePath -frames:v 1 $poster 2>&1");
            // $data['file'] = '/' . $path . '/' . $video_fileName;
            // $data['poster'] = '/' . $path . '/posters/' . $poster_name;
        } else {
            $data['file'] = '';
            $data['poster'] = '';
        }
        return $data;


        return 'ok';


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
    public function videoConversion()
    {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 0);
        \File::makeDirectory(public_path('videos'), 0775, true, true);

        $activeJob = \DB::table('jobs')->where('is_active', 1)->where('key', 'hls_conversion')->first();
        $hls_conversion = 1;
        if ($activeJob) {
            return '0';
        } else {
            \DB::table('jobs')->insert(
                ['is_active' => 1, 'key' => 'hls_conversion']
            );
            // $course = CourseLesson::where('hls_conversion', 0)->get();
            $course = CourseLesson::where('hls_conversion', $hls_conversion)->get();

            foreach ($course as $c) {


                $path = 'videos';
                // $video = $request->file;
                $outputDirectory = base_path('public/' . $path);

                // Define the resolutions and bitrates for the renditions
                $renditions = [
                    ['resolution' => '480x270', 'bitrate' => '518000'],
                    ['resolution' => '640x360', 'bitrate' => '938000'],
                    ['resolution' => '854x480', 'bitrate' => '1611000'],
                    ['resolution' => '1280x720', 'bitrate' => '2520000'],
                ];

                // Generate each rendition
                foreach ($renditions as $index => $rendition) {
                    $filePath = $c->file;
                    // $filePath = 'https://trueilm.s3.eu-north-1.amazonaws.com/courses_videos_hls/SampleVideo_1280x720_1mb.mp4';
                    $outputPath = $outputDirectory . '/rendition_' . $index . '.m3u8';
                    $command = "ffmpeg -i $filePath -vf scale={$rendition['resolution']} -b:v {$rendition['bitrate']} -c:a copy -hls_time 2 -hls_playlist_type vod -hls_segment_filename {$outputPath}_segment_%03d.ts {$outputPath} 2>&1";
                    exec($command, $result, $status);
                }

                // Generate HLS master playlist
                $masterPlaylist = "#EXTM3U\n";
                foreach ($renditions as $index => $rendition) {
                    $resolution = $rendition['resolution'];
                    $bitrate = $rendition['bitrate'];
                    $outputPath = 'https://trueilm.s3.eu-north-1.amazonaws.com/courses_videos_hls2/' . $c->_id . '/rendition_' . $index . '.m3u8';
                    $masterPlaylist .= "#EXT-X-STREAM-INF:BANDWIDTH={$bitrate},RESOLUTION={$resolution}\n{$outputPath}\n";
                }
                $nameWithoutExtension = 'video_' . \Str::random(15);
                file_put_contents($outputDirectory . '/' . $nameWithoutExtension . '.m3u8', $masterPlaylist);

                $video_destinationPath = base_path('public/' . $path); // upload path
                // $nameWithoutExtension = 'video_' . \Str::random(15);
                $video_fileName = $nameWithoutExtension . '.m3u8'; // renameing image
                $fileDestination = $video_destinationPath . '/' . $video_fileName;

                // $filePath = $video->getRealPath();
                // exec("ffmpeg -i $filePath -strict -2 -vf scale=320:240 $fileDestination 2>&1", $result, $status);
                $content =  file_get_contents(public_path('videos/' . $video_fileName));
                $filePath = 'courses_videos_hls2/' . $c->_id . '/'  . $video_fileName;
                Storage::disk('s3')->put($filePath,  $content);

                if ($status === 0) {
                    echo "Conversion successful!";

                    // Get the directory where the HLS files are stored
                    $hlsDirectory = pathinfo($fileDestination, PATHINFO_DIRNAME);

                    // Get all TS files generated by ffmpeg
                    $tsFiles = glob($hlsDirectory . '/*.ts');

                    // Upload each TS file to the desired directory
                    // Upload TS files to S3
                    foreach ($tsFiles as $tsFile) {
                        $tsFileName = pathinfo($tsFile, PATHINFO_BASENAME);
                        $destinationPath = 'courses_videos_hls2/' . $c->_id . '/' . $tsFileName; // Adjust the destination directory as needed

                        // Upload the TS file to the desired directory on S3
                        Storage::disk('s3')->put($destinationPath, file_get_contents($tsFile));

                        echo "Uploaded $tsFileName to $destinationPath\n";
                    }

                    // Upload Rendition files to S3
                    $renditionFiles = glob($hlsDirectory . '/rendition_*');

                    foreach ($renditionFiles as $renditionFile) {
                        $renditionFileName = pathinfo($renditionFile, PATHINFO_BASENAME);
                        $destinationPath = 'courses_videos_hls2/' . $c->_id . '/'  . $renditionFileName; // Adjust the destination directory as needed

                        // Upload the Rendition file to the desired directory on S3
                        Storage::disk('s3')->put($destinationPath, file_get_contents($renditionFile));

                        echo "Uploaded $renditionFileName to $destinationPath\n";
                    }
                }
                $c->hls_video_url2 = 'https://trueilm.s3.eu-north-1.amazonaws.com/' . $filePath;
                $c->hls_conversion = 1;
                $c->save();
                $course = Course::where('_id',  $c->course_id)->first();
                $course->lesson_count = $course->lesson_count + 1;
                $course->save();
                system("rm -rf " . escapeshellarg(public_path('videos')));
                \File::makeDirectory(public_path('videos'), 0775, true, true);
            }
            $book = Book::where('type', "7")->pluck('_id');
            $course = BookContent::whereIn('book_id', $book)->where('type', 2)->where('hls_conversion', $hls_conversion)->get();
            foreach ($course as $c) {


                $path = 'videos';
                // $video = $request->file;
                $outputDirectory = base_path('public/' . $path);

                // Define the resolutions and bitrates for the renditions
                $renditions = [
                    ['resolution' => '480x270', 'bitrate' => '518000'],
                    ['resolution' => '640x360', 'bitrate' => '938000'],
                    ['resolution' => '854x480', 'bitrate' => '1611000'],
                    ['resolution' => '1280x720', 'bitrate' => '2520000'],
                ];

                // Generate each rendition
                foreach ($renditions as $index => $rendition) {
                    $filePath = $c->file;
                    // $filePath = 'https://trueilm.s3.eu-north-1.amazonaws.com/courses_videos_hls/SampleVideo_1280x720_1mb.mp4';
                    $outputPath = $outputDirectory . '/rendition_' . $index . '.m3u8';
                    $command = "ffmpeg -i $filePath -vf scale={$rendition['resolution']} -b:v {$rendition['bitrate']} -c:a copy -hls_time 2 -hls_playlist_type vod -hls_segment_filename {$outputPath}_segment_%03d.ts {$outputPath} 2>&1";
                    exec($command, $result, $status);
                }

                // Generate HLS master playlist
                $masterPlaylist = "#EXTM3U\n";
                foreach ($renditions as $index => $rendition) {
                    $resolution = $rendition['resolution'];
                    $bitrate = $rendition['bitrate'];
                    $outputPath = 'https://trueilm.s3.eu-north-1.amazonaws.com/courses_videos_hls2/' . $c->_id . '/rendition_' . $index . '.m3u8';
                    $masterPlaylist .= "#EXT-X-STREAM-INF:BANDWIDTH={$bitrate},RESOLUTION={$resolution}\n{$outputPath}\n";
                }
                $nameWithoutExtension = 'video_' . \Str::random(15);
                file_put_contents($outputDirectory . '/' . $nameWithoutExtension . '.m3u8', $masterPlaylist);

                $video_destinationPath = base_path('public/' . $path); // upload path
                // $nameWithoutExtension = 'video_' . \Str::random(15);
                $video_fileName = $nameWithoutExtension . '.m3u8'; // renameing image
                $fileDestination = $video_destinationPath . '/' . $video_fileName;

                // $filePath = $video->getRealPath();
                // exec("ffmpeg -i $filePath -strict -2 -vf scale=320:240 $fileDestination 2>&1", $result, $status);
                $content =  file_get_contents(public_path('videos/' . $video_fileName));
                $filePath = 'courses_videos_hls2/' . $c->_id . '/'  . $video_fileName;
                Storage::disk('s3')->put($filePath,  $content);

                if ($status === 0) {
                    echo "Conversion successful!";

                    // Get the directory where the HLS files are stored
                    $hlsDirectory = pathinfo($fileDestination, PATHINFO_DIRNAME);

                    // Get all TS files generated by ffmpeg
                    $tsFiles = glob($hlsDirectory . '/*.ts');

                    // Upload each TS file to the desired directory
                    // Upload TS files to S3
                    foreach ($tsFiles as $tsFile) {
                        $tsFileName = pathinfo($tsFile, PATHINFO_BASENAME);
                        $destinationPath = 'courses_videos_hls2/' . $c->_id . '/' . $tsFileName; // Adjust the destination directory as needed

                        // Upload the TS file to the desired directory on S3
                        Storage::disk('s3')->put($destinationPath, file_get_contents($tsFile));

                        echo "Uploaded $tsFileName to $destinationPath\n";
                    }

                    // Upload Rendition files to S3
                    $renditionFiles = glob($hlsDirectory . '/rendition_*');

                    foreach ($renditionFiles as $renditionFile) {
                        $renditionFileName = pathinfo($renditionFile, PATHINFO_BASENAME);
                        $destinationPath = 'courses_videos_hls2/' . $c->_id . '/'  . $renditionFileName; // Adjust the destination directory as needed

                        // Upload the Rendition file to the desired directory on S3
                        Storage::disk('s3')->put($destinationPath, file_get_contents($renditionFile));

                        echo "Uploaded $renditionFileName to $destinationPath\n";
                    }
                }
                $c->hls_video_url2 = 'https://trueilm.s3.eu-north-1.amazonaws.com/' . $filePath;
                $c->hls_conversion = 1;
                $c->save();

                system("rm -rf " . escapeshellarg(public_path('videos')));
                \File::makeDirectory(public_path('videos'), 0775, true, true);
            }


            $course = Course::where('hls_conversion', $hls_conversion)->get();

            foreach ($course as $c) {


                $path = 'videos';
                // $video = $request->file;
                $outputDirectory = base_path('public/' . $path);

                // Define the resolutions and bitrates for the renditions
                $renditions = [
                    ['resolution' => '480x270', 'bitrate' => '518000'],
                    ['resolution' => '640x360', 'bitrate' => '938000'],
                    ['resolution' => '854x480', 'bitrate' => '1611000'],
                    ['resolution' => '1280x720', 'bitrate' => '2520000'],
                ];

                // Generate each rendition
                foreach ($renditions as $index => $rendition) {
                    $filePath = $c->introduction_video;
                    // $filePath = 'https://trueilm.s3.eu-north-1.amazonaws.com/courses_videos_hls/SampleVideo_1280x720_1mb.mp4';
                    $outputPath = $outputDirectory . '/rendition_' . $index . '.m3u8';
                    $command = "ffmpeg -i $filePath -vf scale={$rendition['resolution']} -b:v {$rendition['bitrate']} -c:a copy -hls_time 2 -hls_playlist_type vod -hls_segment_filename {$outputPath}_segment_%03d.ts {$outputPath} 2>&1";
                    exec($command, $result, $status);
                }

                // Generate HLS master playlist
                $masterPlaylist = "#EXTM3U\n";
                foreach ($renditions as $index => $rendition) {
                    $resolution = $rendition['resolution'];
                    $bitrate = $rendition['bitrate'];
                    $outputPath = 'https://trueilm.s3.eu-north-1.amazonaws.com/courses_videos_hls2/' . $c->_id . '/rendition_' . $index . '.m3u8';
                    $masterPlaylist .= "#EXT-X-STREAM-INF:BANDWIDTH={$bitrate},RESOLUTION={$resolution}\n{$outputPath}\n";
                }
                $nameWithoutExtension = 'video_' . \Str::random(15);
                file_put_contents($outputDirectory . '/' . $nameWithoutExtension . '.m3u8', $masterPlaylist);

                $video_destinationPath = base_path('public/' . $path); // upload path
                // $nameWithoutExtension = 'video_' . \Str::random(15);
                $video_fileName = $nameWithoutExtension . '.m3u8'; // renameing image
                $fileDestination = $video_destinationPath . '/' . $video_fileName;

                // $filePath = $video->getRealPath();
                // exec("ffmpeg -i $filePath -strict -2 -vf scale=320:240 $fileDestination 2>&1", $result, $status);
                $content =  file_get_contents(public_path('videos/' . $video_fileName));
                $filePath = 'courses_videos_hls2/' . $c->_id . '/'  . $video_fileName;
                Storage::disk('s3')->put($filePath,  $content);

                if ($status === 0) {
                    echo "Conversion successful!";

                    // Get the directory where the HLS files are stored
                    $hlsDirectory = pathinfo($fileDestination, PATHINFO_DIRNAME);

                    // Get all TS files generated by ffmpeg
                    $tsFiles = glob($hlsDirectory . '/*.ts');

                    // Upload each TS file to the desired directory
                    // Upload TS files to S3
                    foreach ($tsFiles as $tsFile) {
                        $tsFileName = pathinfo($tsFile, PATHINFO_BASENAME);
                        $destinationPath = 'courses_videos_hls2/' . $c->_id . '/' . $tsFileName; // Adjust the destination directory as needed

                        // Upload the TS file to the desired directory on S3
                        Storage::disk('s3')->put($destinationPath, file_get_contents($tsFile));

                        echo "Uploaded $tsFileName to $destinationPath\n";
                    }

                    // Upload Rendition files to S3
                    $renditionFiles = glob($hlsDirectory . '/rendition_*');

                    foreach ($renditionFiles as $renditionFile) {
                        $renditionFileName = pathinfo($renditionFile, PATHINFO_BASENAME);
                        $destinationPath = 'courses_videos_hls2/' . $c->_id . '/'  . $renditionFileName; // Adjust the destination directory as needed

                        // Upload the Rendition file to the desired directory on S3
                        Storage::disk('s3')->put($destinationPath, file_get_contents($renditionFile));

                        echo "Uploaded $renditionFileName to $destinationPath\n";
                    }
                }
                $c->hls_video_url2 = 'https://trueilm.s3.eu-north-1.amazonaws.com/' . $filePath;
                $c->hls_conversion = 1;
                $c->save();
                $course = Course::where('_id',  $c->course_id)->first();
                $course->lesson_count = $course->lesson_count + 1;
                $course->save();
                system("rm -rf " . escapeshellarg(public_path('videos')));
                \File::makeDirectory(public_path('videos'), 0775, true, true);
            }
            \DB::table('jobs')
                ->where('is_active', 1)
                ->where('key', 'hls_conversion')
                ->update(['is_active' => 0]);
            return '0';
        }
    }
    public function indexing()
    {
        ini_set('max_execution_time', 0);
        ini_set("memory_limit", "-1");
        $client = new  Client('http://localhost:7700', '3bc7ba18215601c4de218ef53f0f90e830a7f144');

        $hadeesBooks = HadeesBooks::get();
        foreach ($hadeesBooks as $key => $book) {
            $translations = HadeesTranslation::where('book_id', $book->_id)->whereIn('type', [5, 6])->get();
            $client->index('alHadeestranslations')->addDocuments($translations->toArray());

            \DB::table('jobs')
                ->where('key', 'indexing')
                ->update(['completed' => $key + 1]);
        }
    }
    public static function cancelExpireSubscriptions()
    {
        ini_set('max_execution_time', 0);
        ini_set("memory_limit", "-1");
        $startOfDayUTC = Carbon::tomorrow('UTC');
        \DB::table('jobs')->insert(
            ['value' => Carbon::now()->toDateString(), 'key' => 'cancellation_job']
        );

        $userSubscriptions = UserSubscription::where('status', 'paid')
            ->where(function ($query) {
                $query->where('stripeCancelled', 1)
                    ->orWhere('istrail', 1);
            })
            ->whereDate('expiry_date', '<', $startOfDayUTC)
            ->get();
        foreach ($userSubscriptions as $userSubscription) {
            $userSubscription->status = 'cancelled';
            $userSubscription->istrail = 0;
            $userSubscription->testString = 'Cancelled By Cron Job';
            $userSubscription->save();
            $subscriptionCount = UserSubscription::where('email', $userSubscription->email)->where('status', 'paid')->count();
            if ($subscriptionCount == 0) {
                $newuserSubscription = new UserSubscription();
                $newuserSubscription->user_id = $userSubscription->user_id;
                $newuserSubscription->email = $userSubscription->email;
                $newuserSubscription->customer = $userSubscription->customer;
                $newuserSubscription->price_id = '0';
                $newuserSubscription->status = 'paid';
                $newuserSubscription->plan_name = 'Freemium';
                $newuserSubscription->plan_id = '65cf47c31b80a2d2b83f7128';
                $newuserSubscription->testString = 'Attached By Cron Job';
                $newuserSubscription->plan_type = 0;
                $newuserSubscription->save();
            }
        }
        return '1';
    }
}
