<?php

namespace App\Imports;

use App\Jobs\HadeeesBookCombination;
use App\Models\Hadees;
use App\Models\HadeesBooks;
use App\Models\HadeesTranslation;
use App\Models\HadithChapter;
use App\Models\Khatoot;
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
        $noString = $row[3] . ':' . $row[8];

        $Khatoot = Khatoot::where('type', 1)->where('verse_key', (string)$noString)->update([
            'ayat' => $row[9]
        ]);
    }
}
