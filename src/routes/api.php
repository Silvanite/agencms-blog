<?php

namespace Silvanite\AgencmsBlog;

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

Route::prefix('agencms/blog')
     ->namespace('Silvanite\AgencmsBlog\Controllers')
     ->middleware(['api', 'cors'])
     ->group(function() {
        Route::resource('category', 'BlogCategoryController');
        Route::resource('article', 'BlogArticleController');
        // Route::resource('users', 'UserController');
        // Route::resource('policies', 'PolicyController');
        // Route::post('login', 'LoginController@login');
        // Route::get('authorize', [
        //          'as' => 'login', 
        //          'uses' => 'LoginController@required'
        //        ]);
     });