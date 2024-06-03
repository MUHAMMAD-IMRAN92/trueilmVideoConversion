<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckUserToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Get the token from the request headers
        $token = $request->header('Authorization');

        // Check if the token exists in the tokens table
        $tokenExists = \DB::table('auth_tokens')->where('token', $token)->exists();

        if (!$tokenExists) {
            // If token is invalid, return a 401 unauthorized response
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Proceed with the request
        return $next($request);
    }
}
