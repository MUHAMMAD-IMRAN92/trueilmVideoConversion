<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class IsSuperAdmin
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check() || !auth()->user()->email == env('super_admin_email')) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
