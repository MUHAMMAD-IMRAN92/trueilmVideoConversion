<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AttemptResult;
use App\Models\CourseLesson;
use Illuminate\Http\Request;
use App\Models\Questionaire;
use App\Models\QuestionaireOptions;
use App\Models\QuizAttempts;
use Carbon\Carbon;

class QuizController extends Controller
{
    public function quiz(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'lesson_id' => 'required',

        ]);

        if ($validator->fails()) {
            return response()->json([
                'response' => 'Lesson Id is required !',
            ]);
        }
        $question = collect();
        $lesson = CourseLesson::where('_id', $request->lesson_id)->first();
        $shuffled = collect();
        if ($lesson && $lesson->quiz == 1) {
            $shuffled =  Questionaire::where('lesson_id', $lesson->_id)->with(['incorrectOptions' => function ($q) {
                // $q->get('option');
            }])->with(['correctOption' => function ($c) {
                // $c->get('option');
            }])->get()->take(10)->map(function ($shuffled) {
                $shuffled->correctOption->makeHidden(['type']);
                $shuffled->incorrectOptions->makeHidden(['type']);
                $options = collect([$shuffled->correctOption]);
                $optionsWrong = $shuffled->incorrectOptions->take(3)->toBase();
                $mergedOptions = $options->merge($optionsWrong);
                $shuffled->makeHidden('incorrectOptions', 'correctOption');
                $shuffled->options = $mergedOptions;
                return $shuffled;
            })->shuffle();
        }

        return response()->json([
            'quiz' => $shuffled->all()

        ]);
    }
    public function checkAnswer(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'lesson_id' => 'required',
            'user_id' => 'required',
            'attempt_id' => 'required',
            'answer_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'response' => $validator->errors(),
            ]);
        }
        $lesson = QuestionaireOptions::where('question_id', $request->question_id)->where('_id',  $request->answer_id)->first();


        if ($lesson) {
            $attemptResult =    AttemptResult::where('attempt_id',  $request->attempt_id)->where('lesson_id', $request->lesson_id)->where('user_id', $request->user_id)->where('question_id', $request->question_id)->where('answer', $request->answer)->first();

            if (!$attemptResult) {
                $attemptResult = new AttemptResult();
                $attemptResult->user_id =  $request->user_id;
                $attemptResult->question_id =  $request->question_id;
                $attemptResult->lesson_id = $request->lesson_id;
                $attemptResult->answer = $request->answer;
                $attemptResult->attempt = $request->attempt_id;
                $attemptResult->type = $lesson->type;
                $attemptResult->save();
            } else {
                return response()->json([
                    'response' => 'Response Already Submitted For This Question !',
                ]);
            }
            $response = '';

            if ($lesson->type == 1) {
                $response = 'True';
            } else {
                $response = 'False';
            }

            return response()->json([
                'response' => $response

            ]);
        } else {
            return response()->json([
                'response' => 'Some Thing Went Wrong !'

            ]);
        }
    }
    public function attemptResult(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'lesson_id' => 'required',
            'user_id' => 'required',
            'attempt_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'response' => $validator->errors(),
            ]);
        }
        $attempt =   QuizAttempts::where('user_id', $request->user_id)->where('lesson_id', $request->lesson_id)->where('_id', $request->attempt_id)->first();
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

    public function checkExpiry(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'lesson_id' => 'required',
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'response' => $validator->errors(),
            ]);
        }

        $nDate = Carbon::createFromFormat('Y-m-d H:s:i', now());

        $attempt =   QuizAttempts::where('user_id', $request->user_id)->where('lesson_id', $request->lesson_id)->first();
        if ($attempt) {

            $oDate = $attempt->start_date;
            $diff =  $nDate->diffInMinutes($oDate);
            if ($diff > 90) {
                $attempt->is_ended = 0;
                $attempt->save();
                return response()->json([
                    'response' => 'Your Attemp Expired',
                    'status' => 0
                ]);
            } else {
                $attemptResult =    AttemptResult::where('attempt', $attempt->_id)->where('lesson_id', $request->lesson_id)->where('user_id', $request->user_id)->orderBy('created_at', 'DESC')->first();

                return response()->json([
                    'start_date' => @$attempt->start_date,
                    'attempt_id' => @$attempt->_id,
                    'question_id' => @$attemptResult->_id ?? 0,
                    'status' => 1
                ]);
            }
        } else {
            $attempt = new QuizAttempts();
            $attempt->user_id =  $request->user_id;
            $attempt->lesson_id = $request->lesson_id;
            $attempt->start_date = $request->start_date;
            $attempt->is_ended = 0;
            $attempt->save();
            return response()->json([
                'response' => $attempt,
            ]);
        }
    }
}
