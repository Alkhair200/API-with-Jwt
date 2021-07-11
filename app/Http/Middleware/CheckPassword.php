<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPassword
{

    public function handle(Request $request, Closure $next)
    {
        if ($request->api_password !== env('API_PASSWORD' ,'dC7Gfw4x4kFGCnnPnVXfL')) {
            
            return response()->json(['msg' => 'Unauthenticated.']);
        }
        
        return $next($request);
    }
}
