<?php

namespace App\Imports;

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
        if ($row[5] != '' && $row[5] != 'Hadith No.') {
            // dd($row);
            $book =  HadeesBooks::where('_id', '655ddd6dc72b09ebea48c789')->first();
            // dd($book);
            $mainchapter = HadithChapter::where('title', $row[1])->first();
            if (!$mainchapter) {
                $mainchapter = new HadithChapter();
                $mainchapter->book_id = $book->_id;
                $mainchapter->title = $row[1];
                $mainchapter->title_arabic = $row[2];
                $mainchapter->save();
            }
            $subchapter = HadithChapter::where('title', $row[4])->first();
            if (!$subchapter) {
                $subchapter = new HadithChapter();
                $subchapter->book_id = $book->_id;
                $subchapter->title = $row[3];
                $subchapter->title_arabic = $row[4];
                $subchapter->parent_id = $mainchapter->_id;
                $subchapter->save();
                // dd($subchapter);
            }
            $type = 1;
            // if ($row[9] == '(Sahih)') {
            //     $type = 1;
            // }
            $hadees = new Hadees();
            $hadees->hadees = $row[7];
            $hadees->type = $type;
            $hadees->book_id = $book->_id;
            $hadees->added_by = '6447918217e6501d607f4943';
            $hadees->chapter_id = $subchapter->_id;
            $hadees->hadith_number =  $row[5];
            // dd($hadees);
            $hadees->save();

            $alQuranTranslation = new HadeesTranslation();
            $alQuranTranslation->translation = $row[6];
            $alQuranTranslation->hadees_id = $hadees->_id;
            $alQuranTranslation->author_lang = '655ef806406d486a7f2e4702';
            $alQuranTranslation->type = 6;
            $alQuranTranslation->added_by = '6447918217e6501d607f4943';
            $alQuranTranslation->book_id = $book->_id;
            $alQuranTranslation->chapter_id = $subchapter->_id;
            $alQuranTranslation->save();
            // $client = new  Client('http://localhost:7700', '3bc7ba18215601c4de218ef53f0f90e830a7f144');

            // $alQurantranslationsclient =  $client->index('alHadeestranslations')->addDocuments(array($alQuranTranslation), '_id');
        }
    }
}
