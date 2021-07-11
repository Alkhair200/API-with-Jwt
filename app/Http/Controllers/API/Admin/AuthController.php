<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\Traits\GeneralTrait;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Validator;

class AuthController extends Controller
{
    use GeneralTrait;

    public function login(Request $request)
    {
        
        try {

            // Vlaidator
            $rules = ['email' => 'required|exists:admins,email' , 'password' => 'required'];

            $validator = Validator::make($request->all() , $rules);

            if ($validator->fails()) {
                
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code , $validator);
            }

            // Login
            $credential = $request->only(['email' , 'password']);

            $token = Auth::guard('admin-api')->attempt($credential);

            if (!$token) {
                return $this->returnError('E001' , 'بيانات الدخول غير صحيحه');
            }

            $admin = Auth::guard('admin-api')->user();
            $admin -> api_token = $token;

            // Return Token  
            return $this->returnData('admin' , $admin , 'login successfully');          
        } catch (\Throwable $th) {
            
            return $this->returnError( $th->getCode() , $th->getMessage());
        }

    }// end of login


    public function logout(Request $request){

        $token = $request->header('auth-token');

        if ($token) {

            try {

                JWTAuth::setToken($token)->invalidate(); // logout
                
            } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
                
                return $this->returnError('E0001' , 'some thing want wrong');

            }

            return $this->returnSuccessMessage('logged out successfully');

        } else {
            
            return $this->returnError('E0001' , 'some thing want wrong');
        }
        
    }// end of logout
}
