<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Tymon\JWTAuth\Exceptions\TokenExpireException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AssignGuard extends BaseMiddleware
{

    public function handle(Request $request, Closure $next , $guard = null)
    {

        if ($guard != null) {
            
            auth()->shouldUse($guard);

            $token = $request->header('auth-token');
            $request->headers->set('auth-token' , (string) $token , true);
            $request->headers->set('Authorization' , 'Bearer' .$token , true);

            try {

                // $user  = $this->auth->authenticate($request); // check authenticated user

                $user = JWTAuth::parseToken()->authenticate();

            } catch (\TokenExpireException $e) {
                
                return $this->returnError('401' , 'unauthenticated user');

            }catch(JWTException $e){

                return $this->returnError('' , 'token invalid' , $e->getMessage());

            }

        }// end of if

        return $next($request);
    }
}
