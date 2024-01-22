<?php

namespace App\Imports;

use App\Jobs\HadeeesBookCombination;
use App\Models\Hadees;
use App\Models\HadeesBooks;
use App\Models\HadeesTranslation;
use App\Models\HadithChapter;
use Maatwebsite\Excel\Concerns\ToModel;
use Meilisearch\Client;

class HadeesImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // dd($row);
        if ($row[5] != '' && $row[5] != 'Hadith No.') {
            $book =  HadeesBooks::where('_id', '656f3eb8b85aa464aa6c9932')->first();
            // dd($book);
            $mainchapter = HadithChapter::where('title', $row[1])->where('book_id', '656f3eb8b85aa464aa6c9932')->first();
            if (!$mainchapter) {
                $mainchapter = new HadithChapter();
                $mainchapter->book_id = $book->_id;
                $mainchapter->title = $row[1];
                $mainchapter->title_arabic = $row[2];
                $mainchapter->save();
            }
            $subchapter = HadithChapter::where('title', $row[3])->where('book_id', '656f3eb8b85aa464aa6c9932')->first();
            if ($subchapter) {
                // $subchapter = new HadithChapter();
                // $subchapter->book_id = $book->_id;
                // $subchapter->title = $row[3];
                // $subchapter->title_arabic = $row[4];
                $subchapter->parent_id = @$mainchapter->_id;
                $subchapter->save();
            }
            // $type = 1;
            // if ($row[9] == '(Hasan)') {
            //     $type = 3;
            // }
            // if ($row[9] == '(Da`if)') {
            //     $type = 2;
            // }
            // $aLreadyExist = Hadees::where('hadees',  $row[7])->where('hadith_number', $row[5])->where('chapter_id', $subchapter->_id)->first();
            // if (!$aLreadyExist) {
            //     $hadees = new Hadees();
            //     $hadees->hadees = $row[7];
            //     $hadees->type = $type;
            //     $hadees->book_id = $book->_id;
            //     $hadees->added_by = '6447918217e6501d607f4943';
            //     $hadees->chapter_id = $subchapter->_id;
            //     $hadees->hadith_number =  $row[5];
            //     $hadees->save();
            // }
            // $translationALreadyExist = HadeesTranslation::where('translation',  $row[6])->where('hadees_id', $hadees->_id ?? $aLreadyExist->_id)->first();
            // if (!$translationALreadyExist) {
            //     $alQuranTranslation = new HadeesTranslation();
            //     $alQuranTranslation->translation = $row[6];
            //     $alQuranTranslation->hadees_id = $hadees->_id ?? $aLreadyExist->_id;
            //     $alQuranTranslation->author_lang = '655ef806406d486a7f2e4702';
            //     $alQuranTranslation->type = 5;
            //     $alQuranTranslation->added_by = '6447918217e6501d607f4943';
            //     $alQuranTranslation->book_id = $book->_id;
            //     $alQuranTranslation->chapter_id = $subchapter->_id;
            //     $alQuranTranslation->save();
            //     HadeeesBookCombination::dispatch($alQuranTranslation->book_id, 5);
            // }
            // $tafseerALreadyExist = HadeesTranslation::where('translation',  $row[10])->where('hadees_id', $hadees->_id ?? $aLreadyExist->_id)->first();
            // if (!$tafseerALreadyExist) {
            //     $tafseerALreadyExist = new HadeesTranslation();
            //     $tafseerALreadyExist->translation = $row[10];
            //     $tafseerALreadyExist->hadees_id = $hadees->_id ?? $aLreadyExist->_id;
            //     $tafseerALreadyExist->author_lang = '6580231b4c98f1bb70f2df47';
            //     $tafseerALreadyExist->type = 6;
            //     $tafseerALreadyExist->added_by = '6447918217e6501d607f4943';
            //     $tafseerALreadyExist->book_id = $book->_id;
            //     $tafseerALreadyExist->chapter_id = $subchapter->_id;
            //     $tafseerALreadyExist->save();
            //     HadeeesBookCombination::dispatch($tafseerALreadyExist->book_id, 6);
            // }
            // $notesALreadyExist = HadeesTranslation::where('translation',  $row[12])->where('hadees_id', $hadees->_id ?? $aLreadyExist->_id)->first();
            // if (!$notesALreadyExist) {
            //     $notesALreadyExist = new HadeesTranslation();
            //     $notesALreadyExist->translation = $row[12];
            //     $notesALreadyExist->hadees_id = $hadees->_id ?? $aLreadyExist->_id;
            //     $notesALreadyExist->author_lang = '655ef806406d486a7f2e4702';
            //     $notesALreadyExist->type = 3;
            //     $notesALreadyExist->added_by = '6447918217e6501d607f4943';
            //     $notesALreadyExist->book_id = $book->_id;
            //     $notesALreadyExist->chapter_id = $subchapter->_id;
            //     $notesALreadyExist->save();
            //     // HadeeesBookCombination::dispatch($alQuranTranslation->book_id, 6);
            // }

            // $client = new  Client('http://localhost:7700', '3bc7ba18215601c4de218ef53f0f90e830a7f144');

            // $alQurantranslationsclient =  $client->index('alHadeestranslations')->addDocuments(array($alQuranTranslation), '_id');
        }
    }
}
