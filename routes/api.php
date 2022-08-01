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


Route::group([
    'as' => "api.",
    'namespace' => "Api",
], function () {
    Route::group(['prefix' => 'auth', 'as' => "auth."], function () {
        Route::post('login.{format}', ['as' => "login", 'uses' => "AuthController@authenticate"]);
        Route::post('logout.{format}', ['as' => "logout", 'uses' => "AuthController@logout"]);

        Route::post('register.{format}', ['as' => "register", 'uses' => "AuthController@register"]);
        Route::post('show.{format}', ['as' => "show", 'uses' => "AuthController@show"]);
    });
});
