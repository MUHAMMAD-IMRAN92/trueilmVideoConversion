<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AttemptResult;
use App\Models\CourseLesson;
use Illuminate\Http\Request;
use App\Models\Questionaire;
use App\Models\QuestionaireOptions;
use App\Models\QuizAttempts;

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
    public function checkAnswer(Request $request)
    {

        $lesson = QuestionaireOptions::where('question_id', $request->question_id)->where('option',  $request->answer)->first();

        $attempt =   QuizAttempts::where('user_id', $request->user_id)->where('lesson_id', $request->lesson_id)->where('attempt', $request->attempt)->first();
        if (!$attempt) {
            $attempt = new QuizAttempts();
            $attempt->user_id =  $request->user_id;
            $attempt->lesson_id = $request->lesson_id;
            $attempt->attempt = $request->attempt;
            $attempt->save();
        }

        $attemptResult =    AttemptResult::where('lesson_id', $request->lesson_id)->where('user_id', $request->user_id)->where('question_id', $request->question_id)->where('answer', $request->answer)->first();

        if (!$attemptResult) {
            $attemptResult = new AttemptResult();
            $attemptResult->user_id =  $request->user_id;
            $attemptResult->question_id =  $request->question_id;
            $attemptResult->lesson_id = $request->lesson_id;
            $attemptResult->answer = $request->answer;
            $attemptResult->attempt = $attempt->_id;
            $attemptResult->type = $lesson->type;
            $attemptResult->save();
        } else {
            return response()->json([
                'response' => 'Response Already Submitted For This Question !',
            ]);
        }
        $response = '';
        if ($lesson) {
            if ($lesson->type == 1) {
                $response = 'True';
            } else {
                $response = 'False';
            }
        }

        return response()->json([
            'response' => $response

        ]);
    }
    public function attemptResult(Request $request)
    {
        $attempt =   QuizAttempts::where('user_id', $request->user_id)->where('lesson_id', $request->lesson_id)->where('attempt', $request->attempt)->first();
        $response = 0;
        if (!$attempt) {
            return response()->json([
                'response' => 'No Result Found !',
            ]);
        } else {
            $attemptResult =    AttemptResult::where('attempt', $attempt->_id)->where('lesson_id', $request->lesson_id)->where('user_id', $request->user_id)->where('type', 1)->count();
            if ($attemptResult) {
                $response =  $attemptResult;
            }

            return response()->json([
                'response' => $response

            ]);
        }
    }
}
