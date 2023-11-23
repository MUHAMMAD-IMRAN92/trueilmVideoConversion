<?php

namespace App\Http\Controllers;

use App\Imports\HadeesImport;
use App\Models\Hadees;
use App\Models\HadeesTranslation;
use App\Models\HadithChapter;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DevController extends Controller
{
    public function uploadFile()
    {
        return view('uploadFile');
    }
    public function post(Request $request)
    {
        ini_set('max_execution_time', '0');
        HadeesTranslation::truncate();
        HadithChapter::truncate();
        Hadees::truncate();
        Excel::import(new HadeesImport, $request->file);

        return 'ok';
    }
}
