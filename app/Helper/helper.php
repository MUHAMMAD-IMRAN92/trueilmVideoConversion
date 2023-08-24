<?php

use App\Models\Activities;
use App\Models\GlossoryAttribute;
use GrahamCampbell\ResultType\Success;
use Illuminate\Support\Facades\Response;
use App\Models\Book;
use App\Models\Grant;

function sendSuccess($msg, $data = null)
{
    return Response::json(['status' => 200, 'message' => $msg, 'data' => $data]);
}

function sendError($msg, $data = null)
{
    return Response::json(['status' => 400, 'message' => $msg, 'data' => $data]);
}

function glossaryAttribute($glossoryId, $type)
{
    $glossory = GlossoryAttribute::where('glossory_id', $glossoryId)->where('type', $type)->first();
    if ($glossory) {
        return $glossory->attribute;
    } else {
        return '';
    }
}
function activity($key, $id, $model)
{
    $arr = [1 => 'Approved Content', 2 => 'Rejected Content', 3 => 'Disabled Content', 4 => 'Enabled Content'];
    if ($model == 1) {
        $content = Book::where('_id', $id)->first();
    } else {
        $content = Grant::where('_id', $id)->first();
    }
    $acvtivity  = new Activities();
    $acvtivity->key  =  $arr[$key];
    $acvtivity->type  = $key;
    $acvtivity->content_id  = $id;

    if ($key == 3 || $key == 4) {
        $link = 'book/update-status/';
    }
    if ($key == 1 || $key == 2) {
        $link = 'content/revert/';
    }
    $acvtivity->revert_link  = $link;
    $acvtivity->user_id = auth()->user()->_id;

    $acvtivity->title = $content->title;
    $acvtivity->status =  0;

    $acvtivity->save();
    return 1;
}
