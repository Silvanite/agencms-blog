<?php

namespace Agencms\Blog;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('agencms/blog')
    ->namespace('Agencms\Blog\Controllers')
    ->middleware(['api', 'cors'])
    ->group(function () {
        Route::resource('category', 'BlogCategoryController');
        Route::resource('article', 'BlogArticleController');
    });
