<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class contentPermission
{
    public function handle($request, Closure $next ,$req_action)
    {

        $type = $request->route('type');
        $permission='';
        if($type == 1)
        {
            $permission='eBook-'.$req_action;

        }
        if($type == 2)
        {
            $permission='audio-book-'.$req_action;
        }
        

        if (!Auth::check() || !Auth::user()->anycheckPermission($permission)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
