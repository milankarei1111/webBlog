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
    Route::get('category/{id?}', function($id=null){
        $find = ArticleCategory::find($id);
        if($find) {
            return new CategoryResource($find);
        } else {
            return CategoryResource::collection(ArticleCategory::all());
        }
    });
});
