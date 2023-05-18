<?php

namespace App\Http\Controllers;

use App\Models\Book;
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
        $reference = new Reference();
        $reference->type = $request->type;
        $reference->referal_id = $request->ayatId;
        $reference->reference_type = $request->ref_type;
        if ($request->fileId) {
            $book = Book::where('_id', $request->fileId)->first();
            $reference->reference = $book->file;
            $reference->reference_title = $book->title;
        }
        $reference->added_by = $this->user->id;
        $reference->save();

        return $reference;
    }
    function delete(Request $request)
    {
        $reference = Reference::where('_id', $request->ref_id)->delete();
        return sendSuccess('Deleted!', []);
    }
}
