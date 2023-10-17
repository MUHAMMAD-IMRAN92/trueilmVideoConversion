<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CourseLesson;
use Illuminate\Http\Request;
use App\Models\Questionaire;

class QuizController extends Controller
{
    public function quiz($lesson_id)
    {
        $question = collect();
        $lesson = CourseLesson::where('_id', $lesson_id)->first();
        if ($lesson && $lesson->quiz == 1) {
            $shuffled =  Questionaire::where('lesson_id', $lesson->_id)->with(['correctOption' => function ($q) {
                $q->where('type', 1)->first()->pluck('_id', 'option'); // Get one right option
            }])
                ->with(['incorrectOptions' => function ($q) {
                    $q->where('type', 0)->take(2);
                }])->get()->take(10)->map(function ($shuffled) {
                    $options = collect([$shuffled->correctOption]);
                    $optionsWrong = $shuffled->incorrectOptions->toBase();
                    $mergedOptions = $options->merge($optionsWrong);
                    $shuffled->makeHidden('incorrectOptions', 'correctOption');
                    $shuffled->options = $mergedOptions->pluck('option', '_id');
                    return $shuffled;
                })->shuffle();
        }

        return response()->json([
            'quiz' => $shuffled->all()

        ]);
    }
}
