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
        Route::post('update.{format}', ['as' => "update", 'uses' => "AuthController@update"]);
        Route::post('forgot-password.{format}', ['as' => "forgot-password", 'uses' => "AuthController@forgot_password"]);
    });

    Route::group(['prefix' => 'category', 'as' => "category."], function () {
        Route::post('show.{format}', ['as' => "show", 'uses' => "CategoryController@show"]);
    });

    Route::group(['prefix' => 'product', 'as' => "product."], function () {
        Route::post('show.{format}', ['as' => "show", 'uses' => "ProductController@show"]);
    });

    Route::group(['prefix' => 'order', 'as' => "order."], function () {
        Route::post('create.{format}', ['as' => "create", 'uses' => "OrderController@store"]);
        Route::post('show.{format}', ['as' => "show", 'uses' => "OrderController@show"]);
        Route::post('check-unpaid.{format}', ['as' => "check-unpaid", 'uses' => "OrderController@check_unpaid_order"]);
    });
});
