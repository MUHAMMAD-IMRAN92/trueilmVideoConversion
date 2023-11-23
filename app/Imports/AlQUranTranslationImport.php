<?php

namespace App\Imports;

use App\AlQuranTranslation;
use Maatwebsite\Excel\Concerns\ToModel;

class AlQUranTranslationImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new AlQuranTranslation([
            //
        ]);
    }

}
