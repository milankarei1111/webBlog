<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ArticleCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    // get
    public function test($id=null){
        if ($id) {
            $category = ArticleCategory::where("category_id", '=', $id)
                                        ->select('category_id', 'name', 'description')
                                        ->get();
        } else {
            $category = ArticleCategory::all('category_id', 'name', 'description');
        }

        if(! $category->isEmpty()) {
           $status = '000000';
        } else {
           $status = 'E00004';
        }

        return response()->json([
            'status' => $status,
            'data' => $category
        ]);
    }

    public function list($id=null){
        if ($id) {
            $category = ArticleCategory::where("category_id", '=', $id)
                                        ->select('category_id', 'name', 'description')
                                        ->get();
        } else {
            $category = ArticleCategory::all('category_id', 'name', 'description');
        }

        if(! $category->isEmpty()) {
           $status = '000000';
        } else {
           $status = 'E00004';
        }

        return response()->json([
            'status' => $status,
            'data' => $category
        ]);
    }

    public function update(Request $request, $id){
        $category = ArticleCategory::find($id);
        $validator = Validator::make($request->only('name', 'description'), [
            'name'=>'required|max:255|min:4',
            'description'=>'max:255|min:4'
        ]);

        if ($validator->fails()) {
            $status = 'E00001';

        } else {
            $status = '000000';
            $category->name = $request['name'];
            $category->description = $request['description'];
            $category->save();
        }
        return response()->json([
            'status' => $status,
            'error' => $validator->errors(),
        ]);
    }

    public function insert(Request $request){
        $validator = Validator::make($request->only('name', 'description'), [
            'name'=>'required|max:255|min:4',
            'description'=>'max:255|min:4'
        ]);

        if ($validator->fails()) {
            $status = 'E00001';

        } else {
            $status = '000000';
            ArticleCategory::create([
                'name' =>  $request['name'],
                'description' => $request['description'],
            ]);
        }
        return response()->json([
            'status' => $status,
            'error' => $validator->errors(),
        ]);
    }

    public function delete($id){
        $category = ArticleCategory::find($id);
        $category->delete();

        if($category->trashed()) {
            $status = '000000';
        } else {
            $status = 'E00001';
        }
        return response()->json([
            'status' => $status,
        ]);
    }
}
