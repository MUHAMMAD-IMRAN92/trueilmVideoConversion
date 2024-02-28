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



        Hadees::where('book_id', '65df2525158f6781d30cda21')->delete();
        HadeesTranslation::where('book_id', '65df2525158f6781d30cda21')->delete();
        HadithChapter::where('book_id', '65df2525158f6781d30cda21')->delete();


        $rows = Excel::tocollection(new HadeesImport, $request->file);

        $book =  HadeesBooks::where('_id', '65df2525158f6781d30cda21')->first();
        foreach ($rows as $key1 => $row1) {
            foreach ($row1 as $key => $row) {
                // dd($row);
                if ($key != 0) {


                    $count = HadithCHapter::where('book_id', '65df2525158f6781d30cda21')->orderBy('created_at', 'DESC')->first()->auto_gen_chapter_no ?? 0;
                    $count = $count + 1;
                    // return $row[45];
                    // return $row[670];
                    $mainchapter = HadithChapter::where('title', $row[2])->where('book_id', '65df2525158f6781d30cda21')->first();
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
                    // $subchapter = HadithChapter::where('title', @$row[5])->where('parent_id', $mainchapter->_id)->where('book_id', '65df2525158f6781d30cda21')->first();
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
                    if (@$row[7] == '(Hasan)') {
                        $type = 3;
                    }
                    if (@$row[7] == '(Daif)') {
                        $type = 2;
                    }
                    if (@$row[4] == '') {
                        $aLreadyExist = Hadees::where('hadees',  @$row[6])->where('hadith_number', 0)->where('chapter_id', $mainchapter->_id)->first();
                        if (!$aLreadyExist) {
                            $hadees = new Hadees();
                            $hadees->hadees = @$row[6];
                            $hadees->type = $type;
                            $hadees->book_id = $book->_id;
                            $hadees->added_by = '6447918217e6501d607f4943';
                            $hadees->chapter_id = $mainchapter->_id;
                            $hadees->takreej = $row[8];
                            $hadees->hadith_number =  0;
                            $hadees->auto_gen_chapter_no = $key;
                            $hadees->save();
                        }
                        $translationALreadyExist = HadeesTranslation::where('translation',  @$row[5])->where('hadees_id', $hadees->_id ?? $aLreadyExist->_id)->first();
                        if (!$translationALreadyExist) {
                            $alQuranTranslation = new HadeesTranslation();
                            $alQuranTranslation->translation = @$row[5];
                            $alQuranTranslation->hadees_id = $hadees->_id ?? $aLreadyExist->_id;
                            $alQuranTranslation->author_lang = '65d74456172ca17ee19d9263';
                            $alQuranTranslation->type = 5;
                            $alQuranTranslation->added_by = '6447918217e6501d607f4943';
                            $alQuranTranslation->book_id = $book->_id;
                            $alQuranTranslation->chapter_id = $mainchapter->_id;

                            $alQuranTranslation->save();
                            // HadeeesBookCombination::dispatch($alQuranTranslation->book_id, 5);
                        }
                        $tafseerALreadyExist = HadeesTranslation::where('translation',  @$row[9])->where('hadees_id', $hadees->_id ?? $aLreadyExist->_id)->first();
                        if (!$tafseerALreadyExist) {
                            $tafseerALreadyExist = new HadeesTranslation();
                            $tafseerALreadyExist->translation = @$row[9];
                            $tafseerALreadyExist->hadees_id = $hadees->_id ?? $aLreadyExist->_id;
                            $tafseerALreadyExist->author_lang = '6571b1f7c1f6db9f71eb5c38';
                            $tafseerALreadyExist->type = 6;
                            $tafseerALreadyExist->added_by = '6447918217e6501d607f4943';
                            $tafseerALreadyExist->book_id = $book->_id;
                            $tafseerALreadyExist->chapter_id = $mainchapter->_id;
                            $tafseerALreadyExist->save();
                            // HadeeesBookCombination::dispatch($tafseerALreadyExist->book_id, 6);
                        }
                        $notesALreadyExist = HadeesTranslation::where('translation',  @$row[10])->where('hadees_id', $hadees->_id ?? $aLreadyExist->_id)->first();
                        if (!$notesALreadyExist) {
                            $notesALreadyExist = new HadeesTranslation();
                            $notesALreadyExist->translation = @$row[10];
                            $notesALreadyExist->hadees_id = $hadees->_id ?? $aLreadyExist->_id;
                            $notesALreadyExist->author_lang = '65d74456172ca17ee19d9263';
                            $notesALreadyExist->type = 3;
                            $notesALreadyExist->added_by = '6447918217e6501d607f4943';
                            $notesALreadyExist->book_id = $book->_id;
                            $notesALreadyExist->chapter_id = $mainchapter->_id;
                            $notesALreadyExist->save();
                            // HadeeesBookCombination::dispatch($alQuranTranslation->book_id, 6);
                        }
                        $count + 1;
                    } else {

                        $hadtihNoArr = explode(',', @$row[4]);
                        foreach ($hadtihNoArr as $hadithno) {
                            $aLreadyExist = Hadees::where('hadees',  @$row[6])->where('hadith_number', $hadithno)->where('chapter_id', $mainchapter->_id)->first();
                            if (!$aLreadyExist) {
                                $hadees = new Hadees();
                                $hadees->hadees = @$row[6];
                                $hadees->type = $type;
                                $hadees->book_id = $book->_id;
                                $hadees->added_by = '6447918217e6501d607f4943';
                                $hadees->chapter_id = $mainchapter->_id;
                                if ($hadithno == '') {
                                    $chapterNo = 0;
                                } else {
                                    $chapterNo = @$row[5];
                                }
                                $hadees->takreej = $row[8];
                                $hadees->hadith_number =  $hadithno;
                                $hadees->auto_gen_chapter_no = $key;
                                $hadees->save();
                            }
                            $translationALreadyExist = HadeesTranslation::where('translation',  @$row[5])->where('hadees_id', $hadees->_id ?? $aLreadyExist->_id)->first();
                            if (!$translationALreadyExist) {
                                $alQuranTranslation = new HadeesTranslation();
                                $alQuranTranslation->translation = @$row[5];
                                $alQuranTranslation->hadees_id = $hadees->_id ?? $aLreadyExist->_id;
                                $alQuranTranslation->author_lang = '65d74456172ca17ee19d9263';
                                $alQuranTranslation->type = 5;
                                $alQuranTranslation->added_by = '6447918217e6501d607f4943';
                                $alQuranTranslation->book_id = $book->_id;
                                $alQuranTranslation->chapter_id = $mainchapter->_id;

                                $alQuranTranslation->save();
                                // HadeeesBookCombination::dispatch($alQuranTranslation->book_id, 5);
                            }
                            $tafseerALreadyExist = HadeesTranslation::where('translation',  @$row[9])->where('hadees_id', $hadees->_id ?? $aLreadyExist->_id)->first();
                            if (!$tafseerALreadyExist) {
                                $tafseerALreadyExist = new HadeesTranslation();
                                $tafseerALreadyExist->translation = @$row[9];
                                $tafseerALreadyExist->hadees_id = $hadees->_id ?? $aLreadyExist->_id;
                                $tafseerALreadyExist->author_lang = '6571b1f7c1f6db9f71eb5c38';
                                $tafseerALreadyExist->type = 6;
                                $tafseerALreadyExist->added_by = '6447918217e6501d607f4943';
                                $tafseerALreadyExist->book_id = $book->_id;
                                $tafseerALreadyExist->chapter_id = $mainchapter->_id;
                                $tafseerALreadyExist->save();
                                // HadeeesBookCombination::dispatch($tafseerALreadyExist->book_id, 6);
                            }
                            $notesALreadyExist = HadeesTranslation::where('translation',  @$row[10])->where('hadees_id', $hadees->_id ?? $aLreadyExist->_id)->first();
                            if (!$notesALreadyExist) {
                                $notesALreadyExist = new HadeesTranslation();
                                $notesALreadyExist->translation = @$row[10];
                                $notesALreadyExist->hadees_id = $hadees->_id ?? $aLreadyExist->_id;
                                $notesALreadyExist->author_lang = '65d74456172ca17ee19d9263';
                                $notesALreadyExist->type = 3;
                                $notesALreadyExist->added_by = '6447918217e6501d607f4943';
                                $notesALreadyExist->book_id = $book->_id;
                                $notesALreadyExist->chapter_id = $mainchapter->_id;
                                $notesALreadyExist->save();
                                // HadeeesBookCombination::dispatch($alQuranTranslation->book_id, 6);
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
