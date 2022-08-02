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
//     return redirect()->route('admin.login');
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

            Route::get('users', ['as' => "users", 'uses' => "UserManagementController@users"]);
            Route::post('users', ['uses' => "UserManagementController@store"]);

            Route::get('get_user/{id}', ['uses' => "UserManagementController@get_user"]);
            Route::post('update_user', ['uses' => "UserManagementController@update"]);
            Route::post('approved_user/{id}', ['uses' => "UserManagementController@approvedUser"]);
            Route::post('block_user/{id}', ['uses' => "UserManagementController@blockedUser"]);
        });

        Route::group(['prefix' => 'users', 'as' => "users."], function () {
            Route::group(['prefix' => 'student', 'as' => "student."], function () {
                Route::any('/', ['as' => "index", 'uses' => "UserManagementController@students"]);
                Route::get('update-status/{id?}', ['as' => "update-status", 'uses' => "UserManagementController@update_status"]);
            });
            Route::group(['prefix' => 'admin', 'as' => "admin."], function () {
                Route::any('/', ['as' => "index", 'uses' => "UserManagementController@admins"]);
                Route::get('update-status/{id?}', ['as' => "update-status", 'uses' => "UserManagementController@update_status"]);

                Route::get('create', ['as' => "create", 'uses' => "UserManagementController@create_admin"]);
                Route::post('create', ['uses' => "UserManagementController@store_admin"]);

                Route::get('edit/{id?}', ['as' => "edit", 'uses' => "UserManagementController@edit_admin"]);
                Route::post('edit/{id?}', ['uses' => "UserManagementController@update_admin"]);
            });
        });

        Route::group(['prefix' => 'transactions', 'as' => "transactions."], function () {
        });

        Route::group(['prefix' => 'categories', 'as' => "categories."], function () {
            Route::any('/', ['as' => "index", 'uses' => "CategoryController@index"]);
            Route::get('update-status/{id?}', ['as' => "update-status", 'uses' => "CategoryController@update_status"]);

            Route::get('create', ['as' => "create", 'uses' => "CategoryController@create"]);
            Route::post('create', ['uses' => "CategoryController@store"]);

            
            Route::get('edit/{id?}', ['as' => "edit", 'uses' => "CategoryController@edit"]);
            Route::post('edit/{id?}', ['uses' => "CategoryController@update"]);
        });
    }

);
