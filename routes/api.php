<?php

use App\Http\Controllers\API\Auth\Admin\AdminLoginController;
use App\Http\Controllers\API\Auth\User\UserLoginController;
use App\Http\Controllers\API\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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






Route::group(['middleware' => ['api',/*'VerifyKey'*/]],function(){
    Route::post('categories-all',[CategoryController::class,'index']);
    Route::post('categoryById',[CategoryController::class,'categoryById']);

    Route::group(['prefix' => 'admin'],function(){
        Route::post('login',[AdminLoginController::class,'login']);
        Route::post('logout',[AdminLoginController::class,'logout']) -> middleware('auth.guard:admin-api');
    });
Route::group(['prefix' => 'user'],function(){
    Route::post('login',[UserLoginController::class,'login']);
    Route::post('logout',[UserLoginController::class,'logout']) -> middleware('auth.guard:user-api');
    Route::get('profile',function(){
        return Auth::user();
    })-> middleware('auth.guard:user-api');

    Route::get('list-categories',[CategoryController::class,'listCategories']) -> middleware('auth.guard:user-api');

});
});



