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
        dd($row);
    }
}
