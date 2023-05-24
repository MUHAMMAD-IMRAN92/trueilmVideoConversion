<?php

namespace App\Http\Controllers;

use App\Models\Languages;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function allLanguage()
    {
        return Languages::all();
    }
}
