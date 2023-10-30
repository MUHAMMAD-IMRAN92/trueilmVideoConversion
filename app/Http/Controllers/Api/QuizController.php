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
            // 'user_id' => 'required',
            // 'attempt_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'response' => $validator->errors(),
            ]);
        }
        $question = collect();
        $attemptResults =    AttemptResult::where('attempt_id',  $request->attempt_id)->where('lesson_id', $request->lesson_id)->where('user_id', $request->user_id)->get();
        if ($attemptResults->count() == 0) {
            $lesson = CourseLesson::where('_id', $request->lesson_id)->first();
            $shuffled = collect();
            if ($lesson && $lesson->quiz == 1) {
                $shuffled =  Questionaire::where('lesson_id', $lesson->_id)->with(['incorrectOptions' => function ($q) {
                    // $q->get('option');
                }])->with(['correctOption' => function ($c) {
                    // $c->get('option');
                }])->get()->take(10)->map(function ($shuffled) use ($request) {
                    $coptions = collect([$shuffled->correctOption]);
                    $optionsWrong = $shuffled->incorrectOptions->take(3)->toBase();
                    $mergedOptions = $coptions->merge($optionsWrong);
                    $shuffled->options = $mergedOptions;
                    // dd(count($shuffled->options))
                    $attemptResult =   new AttemptResult();
                    $attemptResult->user_id =  $request->user_id;
                    $attemptResult->question_id =  $shuffled->_id;
                    $attemptResult->question =  $shuffled->question;
                    $attemptResult->lesson_id = $request->lesson_id;
                    $attemptResult->attempt_id = $request->attempt_id;
                    $attemptResult->options =  $shuffled->options->pluck('option', '_id')->all();
                    $attemptResult->correct_option = $shuffled->correctOption['option'];
                    $attemptResult->user_selected = '';
                    $attemptResult->status = 0;
                    $attemptResult->save();

                    return $shuffled;
                })->shuffle();
            }
            $attemptResults =    AttemptResult::where('attempt_id',  $request->attempt_id)->where('lesson_id', $request->lesson_id)->where('user_id', $request->user_id)->get();
        }

        return response()->json([
            'response' => $attemptResults->makeHidden(['correct_option', 'user_selected'])
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
            $attemptResult = AttemptResult::where('_id', $request->attemp_result_id)->first();

            if ($attemptResult && $attemptResult->status == 0) {
                $attemptResult->user_id =  $request->user_id;
                $attemptResult->question_id =  $request->question_id;
                $attemptResult->lesson_id = $request->lesson_id;
                $attemptResult->user_selected = $lesson->option;
                $attemptResult->type = $lesson->type;
                $attemptResult->status = 1;
                $attemptResult->save();
                if ($request->is_ended == 1) {
                    $quizAttempts =   QuizAttempts::where('_id',  $request->attempt_id)->where('is_ended', 0)->first();
                    $quizAttempts->is_ended =  1;
                    $quizAttempts->save();
                }
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

        $attempt =   QuizAttempts::where('user_id', $request->user_id)->where('lesson_id', $request->lesson_id)->where('is_ended', 0)->first();
        if ($attempt) {

            $oDate = $attempt->start_date;
            $diff =  $nDate->diffInMinutes($oDate);
            if ($diff > 90) {
                $attempt->is_ended = 1;
                $attempt->save();


                return response()->json([
                    'response' => 'Your Attemp Expired',
                    'status' => 0
                ]);
            } else {
                $attemptResult =    AttemptResult::where('attempt', $attempt->_id)->where('lesson_id', $request->lesson_id)->where('user_id', $request->user_id)->orderBy('created_at', 'DESC')->first();

                return response()->json([
                    'response' => $attempt,
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
