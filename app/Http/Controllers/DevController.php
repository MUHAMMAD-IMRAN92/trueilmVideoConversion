<?php

namespace App\Http\Controllers;

use App\Imports\HadeesImport;
use App\Models\Hadees;
use App\Models\HadeesTranslation;
use App\Models\HadithChapter;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Jobs\HadeeesBookCombination;
use App\Models\HadeesBooks;

use Maatwebsite\Excel\Concerns\ToModel;
use Meilisearch\Client;

class DevController extends Controller
{
    public function uploadFile()
    {

        return view('uploadFile');
    }
    public function post(Request $request)
    {
        ini_set('max_execution_time', '0');



        // Hadees::where('book_id', '655f47441c3df94998007a1a')->delete();
        // HadeesTranslation::where('book_id', '655f47441c3df94998007a1a')->delete();
        // HadithChapter::where('book_id', '655f47441c3df94998007a1a')->delete();


        $rows = Excel::tocollection(new HadeesImport, $request->file);

        $book =  HadeesBooks::where('_id', '655f47441c3df94998007a1a')->first();
        foreach ($rows as $key1 => $row1) {
            foreach ($row1 as $key => $row) {

                if ($key != 0) {


                    $count = HadithCHapter::where('book_id', '655f47441c3df94998007a1a')->orderBy('created_at', 'DESC')->first()->auto_gen_chapter_no ?? 0;
                    $count = $count + 1;
                    // return $row[45];
                    // return $row[670];
                    $mainchapter = HadithChapter::where('title', $row[2])->where('book_id', '655f47441c3df94998007a1a')->first();
                    if (!$mainchapter) {
                        $mainchapter = new HadithChapter();
                        $mainchapter->book_id = $book->_id;
                        $mainchapter->title = $row[2];
                        $mainchapter->title_arabic = $row[3];
                        if ($row[1] == '') {
                            $chapterNo = 0;
                        } else {
                            $chapterNo = $row[1];
                        }
                        $mainchapter->chapter_no = $chapterNo;
                        $mainchapter->auto_gen_chapter_no = $count;
                        $mainchapter->save();
                    }
                    $subchapter = HadithChapter::where('title', $row[5])->where('parent_id', $mainchapter->_id)->where('book_id', '655f47441c3df94998007a1a')->first();
                    if (!$subchapter) {
                        $subchapter = new HadithChapter();
                        $subchapter->book_id = $book->_id;
                        $subchapter->title = $row[5];
                        $subchapter->title_arabic = $row[6];
                        $subchapter->parent_id = @$mainchapter->_id;
                        if ($row[4] == '') {
                            $chapterNo = 0;
                        } else {
                            $chapterNo = $row[4];
                        }
                        $subchapter->chapter_no = $row[4];
                        $subchapter->auto_gen_chapter_no = $count;
                        $subchapter->save();
                    }
                    $type = 1;
                    if ($row[11] == '(Hasan)') {
                        $type = 3;
                    }
                    if ($row[11] == '(Da`if)') {
                        $type = 2;
                    }
                    if ($row[7] == '') {
                        $aLreadyExist = Hadees::where('hadees',  $row[9])->where('hadith_number', 0)->where('chapter_id', $subchapter->_id)->first();
                        if (!$aLreadyExist) {
                            $hadees = new Hadees();
                            $hadees->hadees = $row[9];
                            $hadees->type = $type;
                            $hadees->book_id = $book->_id;
                            $hadees->added_by = '6447918217e6501d607f4943';
                            $hadees->chapter_id = $subchapter->_id;

                            $hadees->hadith_number =  0;
                            $hadees->auto_gen_chapter_no = $key;
                            $hadees->save();
                        }
                        $translationALreadyExist = HadeesTranslation::where('translation',  $row[8])->where('hadees_id', $hadees->_id ?? $aLreadyExist->_id)->first();
                        if (!$translationALreadyExist) {
                            $alQuranTranslation = new HadeesTranslation();
                            $alQuranTranslation->translation = $row[8];
                            $alQuranTranslation->hadees_id = $hadees->_id ?? $aLreadyExist->_id;
                            $alQuranTranslation->author_lang = '655ef806406d486a7f2e4702';
                            $alQuranTranslation->type = 5;
                            $alQuranTranslation->added_by = '6447918217e6501d607f4943';
                            $alQuranTranslation->book_id = $book->_id;
                            $alQuranTranslation->chapter_id = $subchapter->_id;
                            $alQuranTranslation->takreej = $row[12];
                            $alQuranTranslation->save();
                            HadeeesBookCombination::dispatch($alQuranTranslation->book_id, 5);
                        }
                        $tafseerALreadyExist = HadeesTranslation::where('translation',  $row[13])->where('hadees_id', $hadees->_id ?? $aLreadyExist->_id)->first();
                        if (!$tafseerALreadyExist) {
                            $tafseerALreadyExist = new HadeesTranslation();
                            $tafseerALreadyExist->translation = $row[13];
                            $tafseerALreadyExist->hadees_id = $hadees->_id ?? $aLreadyExist->_id;
                            $tafseerALreadyExist->author_lang = '6580231b4c98f1bb70f2df47';
                            $tafseerALreadyExist->type = 6;
                            $tafseerALreadyExist->added_by = '6447918217e6501d607f4943';
                            $tafseerALreadyExist->book_id = $book->_id;
                            $tafseerALreadyExist->chapter_id = $subchapter->_id;
                            $tafseerALreadyExist->save();
                            HadeeesBookCombination::dispatch($tafseerALreadyExist->book_id, 6);
                        }
                        $notesALreadyExist = HadeesTranslation::where('translation',  $row[14])->where('hadees_id', $hadees->_id ?? $aLreadyExist->_id)->first();
                        if (!$notesALreadyExist) {
                            $notesALreadyExist = new HadeesTranslation();
                            $notesALreadyExist->translation = $row[14];
                            $notesALreadyExist->hadees_id = $hadees->_id ?? $aLreadyExist->_id;
                            $notesALreadyExist->author_lang = '655ef806406d486a7f2e4702';
                            $notesALreadyExist->type = 3;
                            $notesALreadyExist->added_by = '6447918217e6501d607f4943';
                            $notesALreadyExist->book_id = $book->_id;
                            $notesALreadyExist->chapter_id = $subchapter->_id;
                            $notesALreadyExist->save();
                            HadeeesBookCombination::dispatch($alQuranTranslation->book_id, 6);
                        }
                        $count + 1;
                    } else {
                        $hadtihNoArr = explode(',', $row[7]);
                        foreach ($hadtihNoArr as $hadithno) {
                            $aLreadyExist = Hadees::where('hadees',  $row[9])->where('hadith_number', $hadithno)->where('chapter_id', $subchapter->_id)->first();
                            if (!$aLreadyExist) {
                                $hadees = new Hadees();
                                $hadees->hadees = $row[9];
                                $hadees->type = $type;
                                $hadees->book_id = $book->_id;
                                $hadees->added_by = '6447918217e6501d607f4943';
                                $hadees->chapter_id = $subchapter->_id;
                                if ($hadithno == '') {
                                    $chapterNo = 0;
                                } else {
                                    $chapterNo = $row[4];
                                }
                                $hadees->hadith_number =  $hadithno;
                                $hadees->auto_gen_chapter_no = $key;
                                $hadees->save();
                            }
                            $translationALreadyExist = HadeesTranslation::where('translation',  $row[8])->where('hadees_id', $hadees->_id ?? $aLreadyExist->_id)->first();
                            if (!$translationALreadyExist) {
                                $alQuranTranslation = new HadeesTranslation();
                                $alQuranTranslation->translation = $row[8];
                                $alQuranTranslation->hadees_id = $hadees->_id ?? $aLreadyExist->_id;
                                $alQuranTranslation->author_lang = '655ef806406d486a7f2e4702';
                                $alQuranTranslation->type = 5;
                                $alQuranTranslation->added_by = '6447918217e6501d607f4943';
                                $alQuranTranslation->book_id = $book->_id;
                                $alQuranTranslation->chapter_id = $subchapter->_id;
                                $alQuranTranslation->takreej = $row[12];
                                $alQuranTranslation->save();
                                HadeeesBookCombination::dispatch($alQuranTranslation->book_id, 5);
                            }
                            $tafseerALreadyExist = HadeesTranslation::where('translation',  $row[13])->where('hadees_id', $hadees->_id ?? $aLreadyExist->_id)->first();
                            if (!$tafseerALreadyExist) {
                                $tafseerALreadyExist = new HadeesTranslation();
                                $tafseerALreadyExist->translation = $row[13];
                                $tafseerALreadyExist->hadees_id = $hadees->_id ?? $aLreadyExist->_id;
                                $tafseerALreadyExist->author_lang = '6580231b4c98f1bb70f2df47';
                                $tafseerALreadyExist->type = 6;
                                $tafseerALreadyExist->added_by = '6447918217e6501d607f4943';
                                $tafseerALreadyExist->book_id = $book->_id;
                                $tafseerALreadyExist->chapter_id = $subchapter->_id;
                                $tafseerALreadyExist->save();
                                HadeeesBookCombination::dispatch($tafseerALreadyExist->book_id, 6);
                            }
                            $notesALreadyExist = HadeesTranslation::where('translation',  $row[14])->where('hadees_id', $hadees->_id ?? $aLreadyExist->_id)->first();
                            if (!$notesALreadyExist) {
                                $notesALreadyExist = new HadeesTranslation();
                                $notesALreadyExist->translation = $row[14];
                                $notesALreadyExist->hadees_id = $hadees->_id ?? $aLreadyExist->_id;
                                $notesALreadyExist->author_lang = '655ef806406d486a7f2e4702';
                                $notesALreadyExist->type = 3;
                                $notesALreadyExist->added_by = '6447918217e6501d607f4943';
                                $notesALreadyExist->book_id = $book->_id;
                                $notesALreadyExist->chapter_id = $subchapter->_id;
                                $notesALreadyExist->save();
                                HadeeesBookCombination::dispatch($alQuranTranslation->book_id, 6);
                            }
                        }
                    }
                }
            }
        }
        $count =  $count + 1;
        return 'ok';
    }
}
