<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// API Routes
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['api' , 'checkPassword' ,'changeLanguage'])->group(function(){
    
  // route::post('get-posts' , [App\Http\Controllers\API\PostController::class , 'index']);
  route::post('get-post-by-id' , [App\Http\Controllers\PostController::class , 'getPstById']);


  Route::group(['prefix' => 'admin'] ,function(){

    route::post('login', [App\Http\Controllers\API\Admin\AuthController::class , 'login']);
    
    route::post('logout' ,[App\Http\Controllers\API\Admin\AuthController::class , 'logout'])->middleware('auth.guard:admin-api');

  });


  Route::group(['prefix' => 'user'] ,function(){

    route::post('login', [App\Http\Controllers\API\User\AuthController::class , 'login']);
    
  });

  Route::group(['prefix' => 'user' , 'middleware' => 'auth.guard:user-api'] ,function(){

    route::post('profile' ,function(){
      
    return Auth::user(); // return authenticated user data

    });
  
  });

});


Route::middleware(['api' , 'checkPassword' ,'changeLanguage' , 'checkAdminToken:admin-api'])->group(function(){

  route::post('get-posts' , [App\Http\Controllers\API\PostController::class , 'index']);
});