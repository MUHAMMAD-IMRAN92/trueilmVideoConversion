<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class approvalPermission
{
    public function handle($request, Closure $next )
    {

        $type = $request->route('type');
        
        $permission='';
        if($type == 1 ) 
        {

          
            $permission='pending-eBook';

        }
        if($type == 2 )
        {
            $permission='pending-audio-book';
        }
        if($type == 3 )
        {
            $permission='pending-papers';
        }
        if($type == 6 )
        {
            $permission='pending-course';
        }
        if($type == 7 )
        {
            $permission='pending-podcast';
        }
        

        if (!Auth::check() || !Auth::user()->anycheckPermission($permission)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
