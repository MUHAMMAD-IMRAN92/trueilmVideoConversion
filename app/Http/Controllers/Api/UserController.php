<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\UserVarification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function sendVerifyEmail(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        $user = User::find($request->id);
        if ($user) {
            $userEmail = $user->email;

            Mail::to($user->email)->send(new UserVarification($user));
        }

        return sendSuccess('Mail Has Been Sent To Your Email Address!', 'done');
    }
}
