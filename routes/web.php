<?php

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
    return view('welcome');
});

Route::group(['prefix' => 'blog'], function () {
    Route::get('/index', function(){
        return view('adminlte.master');
    });
    Route::resource('/category', 'Blog\CategoryController');
    Route::resource('/article', 'Blog\ArticleController');
    Route::resource('/comment', 'Blog\CommentController');
    Route::get('/apitest', 'Blog\ApiDataTestController@index')->name('api.index');
    Route::post('/apitest', 'Blog\ApiDataTestController@apiTest')->name('apiTest');
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
