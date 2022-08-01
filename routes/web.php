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

Route::get('/', function () {
    // return redirect()->route('resident.login');
    return redirect()->route('resident.index');
});


Route::group(

    array(
        'as' => "resident.",
        'prefix' => "resident",
        'namespace' => "Resident",
        'middleware' => ["system.prevent-back-history"],
    ),

    function () {

        Route::get('login/{redirect_uri?}', ['as' => "login", 'uses' => "AuthController@login"]);
        Route::post('login/{redirect_uri?}', ['as' => "authenticate", 'uses' => "AuthController@authenticate"]);
        Route::any('logout', ['as' => "logout", 'uses' => "AuthController@logout"]);

        Route::get('/', ['as' => "index", 'uses' => "Residence@index"]);
        Route::get('about', ['as' => "about", 'uses' => "Residence@about"]);
        Route::get('signup', ['as' => "signup", 'uses' => "Residence@signup"]);

        Route::post('signup', ['as' => "post-signup", 'uses' => "Residence@postSignup"]);




        Route::group(['middleware' => ["system.auth:client"]], function () {
            Route::any('home', ['as' => "client-home", 'uses' => "Residence@index"]);


            Route::get('message', ['as' => "goto-message", 'uses' => "MessageController@goto_message"]);
            Route::post('message', ['as' => "send-message", 'uses' => "MessageController@store"]);

            Route::get('request', ['as' => "request", 'uses' => "RequestController@request"]);
            Route::post('request', ['as' => "store_request", 'uses' => "RequestController@store_request"]);
        });
    }

);



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

            Route::get('annoucements', ['as' => "annoucements", 'uses' => "AnnouncementController@index"]);
            Route::post('annoucements', ['uses' => "AnnouncementController@store"]);

            Route::get('news', ['as' => "news", 'uses' => "NewsController@index"]);
            Route::post('news', ['uses' => "NewsController@store"]);

            Route::get('get_annoucement/{id}', ['uses' => "AnnouncementController@get_annoucement"]);
            Route::post('update_announcement', ['uses' => "AnnouncementController@update"]);

            Route::post('put_banner_annoucement/{id}', ['uses' => "AnnouncementController@put_banner_annoucement"]);
            Route::post('remove_banner_annoucement/{id}', ['uses' => "AnnouncementController@remove_banner_annoucement"]);

            Route::get('requests', ['as' => "requests", 'uses' => "RequestController@index"]);


            Route::get('printCertificate/{id}/{type}', ['uses' => "RequestController@printCertificate"]);

            Route::post('approved/{id}', ['uses' => "RequestController@approved"]);
            Route::post('disapproved/{id}', ['uses' => "RequestController@disapproved"]);
            Route::post('complete_print/{id}', ['uses' => "RequestController@complete_print"]);

            Route::get('get_news/{id}', ['uses' => "NewsController@get_news"]);
            Route::post('update_news', ['uses' => "NewsController@update"]);

            Route::get('messages', ['as' => "messages", 'uses' => "MessagesController@index"]);
            Route::post('messages', ['uses' => "MessagesController@store"]);

            Route::any('delete_messages/{id}', ['as' => "delete-messages", 'uses' => "MessagesController@destroy"]);
        });
    }

);
