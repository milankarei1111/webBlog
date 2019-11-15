<?php

use Illuminate\Http\Request;
use App\Models\ArticleCategory;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'blog'], function () {
    // API 資源類
    // Route::get('category/{id?}', function($id=null){
    //     $find = ArticleCategory::find($id);
    //     if($find) {
    //         return new CategoryResource($find);
    //     } else {
    //         return CategoryResource::collection(ArticleCategory::all());
    //     }
    // });

    Route::get('category/{id?}', 'API\CategoryController@categoryList');
    Route::get('category/{id}/article', 'API\CategoryController@articelList'); // 關聯文章
    Route::patch('category/{id}', 'API\CategoryController@update');
    Route::post('category', 'API\CategoryController@insert');
    Route::delete('category/{id}', 'API\CategoryController@delete');

    Route::get('article/{id?}', 'API\ArticleController@articleList');
    Route::get('article/{id}/comment', 'API\ArticleController@commentList'); // 關聯評論
    Route::patch('article/{id}', 'API\ArticleController@update');
    Route::post('article', 'API\ArticleController@insert');
    Route::delete('article/{id}', 'API\ArticleController@delete');

    Route::get('comment/{id?}', 'API\CommentController@list');
    Route::post('comment', 'API\CommentController@insert');
});
