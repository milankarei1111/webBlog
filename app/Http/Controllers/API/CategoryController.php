<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ArticleCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function categoryList($id=null)
    {
        if ($id) {
            $category = ArticleCategory::where("category_id", '=', $id)->get();
        } else {
            $category = ArticleCategory::all();
        }

        if(! $category->isEmpty()) {
           $status = '000000';
        } else {
           $status = 'E00004';
        }
        return $this->responseMessage($status, $category);
    }

    public function articelList($id)
    {
        if ($id) {
            $article = ArticleCategory::find($id)->articles()->get();
        }

        if(! $article->isEmpty()) {
           $status = '000000';
        } else {
           $status = 'E00004';
        }

        return response()->json([
            'status' => $status,
            'data' => $article
        ]);
    }

    public function update(Request $request, $id)
    {
        $category = ArticleCategory::find($id);
        $validator = Validator::make($request->only('name', 'description'), [
            'name'=>'required|max:255|min:4',
            'description'=>'max:255|min:4'
        ]);

        if ($validator->fails()) {
            $status = 'E00001';
            $meassage = $validator->errors();
        } else {
            $status = '000000';
            $result = $category->update($request->all());
            if ($result) {
                $status = '000000';
                $meassage = '更新成功';
            } else {
                $status = 'E00001';
                $meassage = '更新失敗';
            }
        }
        return $this->responseMessage($status, $meassage);
    }

    public function insert(Request $request)
    {
        $validator = Validator::make($request->only('name', 'description'), [
            'name'=>'required|max:255|min:4',
            'description'=>'max:255|min:4'
        ]);

        if ($validator->fails()) {
            $status = 'E00001';
            $meassage = $validator->errors();
        } else {
            $result = ArticleCategory::create($request->all());
            if ($result) {
                $status = '000000';
                $meassage = '新增成功';
            } else {
                $status = 'E00001';
                $meassage = '新增失敗';
            }
        }
        return $this->responseMessage($status, $meassage);
    }

    public function delete($id)
    {
        $meassage = '';
        $category = ArticleCategory::find($id);
        if ($category) {
            $category->delete();

            if($category->trashed()) {
                $status = '000000';
                $meassage = '刪除成功';
            } else {
                $status = 'E00001';
                $meassage = '刪除失敗';
            }
        } else {
            $status= 'E00004';
            $meassage = '查無此資料!';
        }
        return $this->responseMessage($status, $meassage);
    }

    public function responseMessage($status, $value=null)
    {
        return response()->json([
            'status' => $status,
            'value' => $value
        ]);
    }
}
