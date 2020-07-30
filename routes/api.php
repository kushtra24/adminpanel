<?php

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::middleware('auth:api')->group( function(){
    Route::apiResources(['user' => 'API\UserController']);
    Route::get('profile', 'API\UserController@profile');
    Route::put('profile', 'API\UserController@updateProfile');
    Route::get('category', 'API\CategoryController@index');

});

Route::get('article/{slug}', 'API\ArticleController@show');
//Route::apiResources(['article' => 'API\ArticleController']);


