<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Permissions
{
    public function handle($request, Closure $next, $permission)
    {

        if (!Auth::check() || !Auth::user()->anycheckPermission($permission)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
