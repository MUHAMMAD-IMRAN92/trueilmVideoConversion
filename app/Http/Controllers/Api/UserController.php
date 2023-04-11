<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\UserVarification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function sendVerifyEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);
        return $request->all();
        if ($validator->fails()) {
            return sendError('Validation Failed!', $validator->errors());
        }

        return  $user = User::where('_id', $request->id)->first();
        if ($user) {
            $userEmail = $user->email;
            // $email = 'imran@gmail.com';
            Mail::to($userEmail)->send(new UserVarification($user));
        }
        return sendSuccess('Mail Has Been Sent!', []);
    }
}
