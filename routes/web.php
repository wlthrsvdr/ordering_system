<?php

use App\Http\Controllers\Residence;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     // return redirect()->route('resident.login');
//     return redirect()->route('resident.index');
// });


Route::group(

    array(
        'as' => "admin.",
        'prefix' => "admin",
        'namespace' => "Admin",
        'middleware' => ["system.prevent-back-history"],
    ),

    function () {

        Route::get('login/{redirect_uri?}', ['as' => "login", 'uses' => "AuthController@login"]);
        Route::post('login/{redirect_uri?}', ['as' => "authenticate", 'uses' => "AuthController@authenticate"]);
        Route::any('logout', ['as' => "logout", 'uses' => "AuthController@logout"]);


        Route::group(['middleware' => ["system.auth:admin"]], function () {

            Route::any('/', ['as' => "dashboard", 'uses' => "MainController@index"]);

            Route::get('users', ['as' => "users", 'uses' => "UserManagement@users"]);
            Route::post('users', ['uses' => "UserManagement@store"]);

            Route::get('get_user/{id}', ['uses' => "UserManagement@get_user"]);
            Route::post('update_user', ['uses' => "UserManagement@update"]);
            Route::post('approved_user/{id}', ['uses' => "UserManagement@approvedUser"]);
            Route::post('block_user/{id}', ['uses' => "UserManagement@blockedUser"]);
        });

        Route::group(['prefix' => 'users', 'as' => "users."], function () {
            Route::group(['prefix' => 'student', 'as' => "student."], function () {
                Route::any('/', ['as' => "index", 'uses' => "UserManagement@students"]);
                Route::get('update-status/{id?}', ['as' => "update-status", 'uses' => "UserManagement@update_status"]);
            });
            Route::group(['prefix' => 'admin', 'as' => "admin."], function () {
                Route::any('/', ['as' => "index", 'uses' => "UserManagement@admins"]);
                Route::get('update-status/{id?}', ['as' => "update-status", 'uses' => "UserManagement@update_status"]);
            });
        });
    }

);
