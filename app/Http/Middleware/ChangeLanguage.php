<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ChangeLanguage
{

    public function handle(Request $request, Closure $next)
    {
        app()->setlocale('en');

        if (isset($request->lang) && $request->lang == 'ar') {
            
            app()->setlocale('ar');
        }
        return $next($request);
    }
}
