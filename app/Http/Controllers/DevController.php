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

        // Hadees::where('book_id', '655f47441c3df94998007a1a')->delete();
        // HadeesTranslation::where('book_id', '655f47441c3df94998007a1a')->delete();
        // HadithChapter::where('book_id', '655f47441c3df94998007a1a')->delete();
        // Hadees::where('book_id', '655f47441c3df94998007a1a')->delete();
        foreach ($request->file as $f) {
            Excel::import(new HadeesImport, $f);
        }

        return 'ok';
    }
}
