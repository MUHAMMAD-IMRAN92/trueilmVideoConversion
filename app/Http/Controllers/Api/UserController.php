<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\ResetPassword;
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
        if ($validator->fails()) {
            return sendError('Validation Failed!', $validator->errors());
        }

        $user = User::find($request->id);
        if ($user) {
            $userEmail = $user->email;
            // $email = 'imran@gmail.com';
            Mail::to($userEmail)->send(new UserVarification($user));
            return sendSuccess('Mail Has Been Sent!', []);
        } else {
            return sendError('User Not Found!', []);
        }
    }
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            return sendError('Validation Failed!', $validator->errors());
        }

        $user = User::find($request->id);
        if ($user) {
            $userEmail = $user->email;
            // $email = 'imran@gmail.com';
            Mail::to($userEmail)->send(new ResetPassword($user));
            return sendSuccess('Mail Has Been Sent!', []);
        } else {
            return sendError('User Not Found!', []);
        }
    }
}
