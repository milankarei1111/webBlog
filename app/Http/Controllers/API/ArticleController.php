<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    public function articleList($id=null)
    {
        if ($id) {
            $article = Article::where("article_id", '=', $id)->get();
        } else {
            $article = Article::all();
        }

        if(! $article->isEmpty()) {
           $status = '000000';
        } else {
           $status = 'E00004';
        }
        return $this->responseMessage($status, $article);
    }

    public function commentList($id)
    {
        $comment = Article::find($id)->comments()->get();

        if(! $comment->isEmpty()) {
            $status = '000000';
         } else {
            $status = 'E00004';
         }
         return $this->responseMessage($status, $comment);
    }

    public function update(Request $request, $id)
    {
        $meassage = '';
        $article = Article::find($id);
        if ($article) {
            $validator = Validator::make($request->all(), [
                'title' => 'required|max:255|min:4',
                'content' => 'required|max:255|min:10',
                'category_id' => 'required|max:20',
                'image' => 'max:255',
                'remark' => 'max:255',
            ]);
            if($validator->fails()) {
                $status = 'E00001';
                $meassage = $validator->errors();
            } else {
                $status = '000000';
                $result = $article->update($request->all());
                if ($result) {
                    $status = '000000';
                    $meassage = '更新成功';
                } else {
                    $status = 'E00001';
                    $meassage = '更新失敗';
                }
            }
        } else {
            $status = 'E00004';
            $meassage = '查無此資料!';
        }
        return $this->responseMessage($status, $meassage);
    }

    public function insert(Request $request)
    {
        $meassage = '';
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255|min:4',
            'content' => 'required|max:255|min:10',
            'category_id' => 'required|integer|max:20',
            'image' => 'max:255',
            'remark' => 'max:255',
        ]);

        if ($validator->fails()) {
            $status = 'E00001';
            $meassage = $validator->errors();
        } else {
            $article = new Article($request->all());
            $result = $article->save();
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
        $article = Article::find($id);
        if($article){
            $article->delete();
            if($article->trashed()) {
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
