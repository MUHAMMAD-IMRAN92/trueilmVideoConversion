<?php

use App\Models\Activities;
use App\Models\GlossoryAttribute;
use GrahamCampbell\ResultType\Success;
use Illuminate\Support\Facades\Response;
use App\Models\Book;
use App\Models\BookForSale;
use App\Models\Category;
use App\Models\Grant;
use Illuminate\Support\Facades\Storage;

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
    $arr = [1 => 'Approved Content', 2 => 'Rejected Content', 3 => 'Disabled Content', 4 => 'Enabled Content', 5 => ' Approved A Grant', 6 => ' Rejected A Grant'];
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
    if ($key == 5) {
        $link = 'content/revert/';
    }
    if ($key == 6) {
        $link = 'content/revert/';
    }
    $acvtivity->revert_link  = $link;
    $acvtivity->user_id = auth()->user()->_id;

    $acvtivity->title = $content->title;
    $acvtivity->status =  0;

    $acvtivity->save();
    return 1;
}
function countiesCities($countries, $book_id)
{
    ini_set('memory_limit', '-1');

    $book = BookForSale::where('_id', $book_id)->first();
    $arr = [];
    if ($countries) {
        foreach ($countries as $country) {
            $content = Storage::disk('public')->get('cities.json');
            $collect =  collect(json_decode($content));
            $filtered =   $collect->filter(function ($value, $key) use ($country) {
                return $value->country_name ==  $country;
            });
            $names = $filtered->values()->pluck('name')->toArray();
            $arr =  array_merge($arr, $names);
        }
    }
    $data['cities'] = $arr;
    // if ($book && $book->cities) {
    //     $data['oldCities'] = explode(',', $book->cities);
    // } else {
    $data['oldCities'] = [];
    // }
    return $data;
}
function getCategorydropdown($parent_id = 0, $level = 0, $product_cat = 0, $type = 0)
{
    $html = "";
    $seperator = "";
    for ($loop = 0; $loop < $level; $loop++) {
        $seperator .= "-";
    }
    $level_categories = Category::where('parent_id', (string)$parent_id)->where('type', (string)$type)->get();
    foreach ($level_categories as $key => $category) {
        $count =  Category::where('parent_id', $category->_id)->where('type',  (string)$type)->count();
        if ($count > 0) {
            $html .= '<optgroup  label="' . $seperator . $category->title . '">';
            $level++;
            $html .= getCategorydropdown($category->_id, $level, $product_cat, $type);
            $html .= '</optgroup>';
        } else {
            $selected = "";
            if ($product_cat ==  $category->_id) {
                $selected = "selected";
            }
            $html .= '<option ' . $selected . ' value="' . $category->id . '">' . $category->title . '</option>';
        }
    }
    return $html;
}
