<?php

namespace App\Imports;

use App\\Models\Hadees;
use Maatwebsite\Excel\Concerns\ToModel;

class HadeesImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Hadees([
            //
        ]);
    }
}
