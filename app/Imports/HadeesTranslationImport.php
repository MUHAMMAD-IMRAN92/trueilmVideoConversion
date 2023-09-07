<?php

namespace App\Imports;

use App\HadeesTranslation;
use Maatwebsite\Excel\Concerns\ToModel;

class HadeesTranslationImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new HadeesTranslation([
            //
        ]);
    }
}
