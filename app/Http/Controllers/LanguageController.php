<?php

namespace App\Http\Controllers;

use App\Models\Languages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LanguageController extends Controller
{
    public $user;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();

            return $next($request);
        });
    }
    public function allLanguage()
    {
        return Languages::all();
    }
    public function index()
    {

        $languages =  Languages::all();

        return view('language.index', [
            'languages' =>  $languages
        ]);
    }
    public function create()
    {


        $languages =  Languages::all();

        return view('language.add', [
            'languages' =>  $languages
        ]);
    }
    public function store(Request $request)
    {
        if ($request->id) {
            $language =  Languages::where('_id', $request->id)->first();
            $language->title = $request->title;
            $language->added_by = $this->user->_id;
            $language->direction = $request->direction;
            $language->save();
            return redirect()->to('/language')->with('msg', "Language Has Updated !");
        } else {
            $languageExit =  Languages::where('title', $request->title)->first();
            if ($languageExit) {
                return redirect()->to('/language')->with('dmsg', "Language Already Exit !");
            } else {
                $language = new Languages();
                $language->title = $request->title;
                $language->added_by = $this->user->_id;
                $language->direction = $request->direction;
                $language->save();
                return redirect()->to('/language')->with('msg', "Language Has Added !");
            }
        }
    }
    public function edit($id)
    {
        $language =  Languages::where('_id', $id)->first();
        return view('language.edit', [
            'language' =>  $language
        ]);
    }
}
