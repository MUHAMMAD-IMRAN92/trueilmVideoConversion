<?php

namespace App\Http\Controllers;

use App\Models\Reference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReferenceController extends Controller
{
    public $user;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();

            return $next($request);
        });
    }
    public function add(Request $request)
    {
        if ($request->ref_type == 3) {
            $validator = Validator::make($request->all(), [
                'file' => 'required|mimes:epub'
            ]);
        } elseif ($request->ref_type == 4) {
            $validator = Validator::make($request->all(), [
                'file' => 'required|mimes:mp3'
            ]);
        } elseif ($request->ref_type == 5) {
            $validator = Validator::make($request->all(), [
                'file' => 'required|mimes:pdf,epub'
            ]);
        } else {
            $validator = Validator::make($request->all(), []);
        }
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $reference = new Reference();
        $reference->type = $request->referal;
        $reference->referal_id = $request->referal_id;
        $reference->reference = $request->type;
        $reference->reference_type = $request->ref_type;
        $reference->added_by = $this->user->id;
        $reference->save();

        return redirect()->back()->with('msg', 'Reference Added Successfully!');
    }
}
