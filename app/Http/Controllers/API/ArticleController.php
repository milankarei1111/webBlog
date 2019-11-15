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

        return response()->json([
            'status' => $status,
            'data' => $article
        ]);
    }

    public function commentList($id)
    {
        $comment = Article::find($id)->comments()->get();

        if(! $comment->isEmpty()) {
            $status = '000000';
         } else {
            $status = 'E00004';
         }

         return response()->json([
             'status' => $status,
             'data' => $comment
         ]);

    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255|min:4',
            'content' => 'required|max:255|min:10',
            'category_id' => 'required|max:20',
            'image' => 'max:255',
            'remark' => 'max:255',
        ]);

        $article = Article::find($id);
        if($validator->fails()) {
            $status = 'E00001';
        } else {
            $status = '000000';
            $article->update($request->all());
        }

        return response()->json([
            'status' => $status,
            'error' => $validator->errors(),
        ]);
    }

    public function insert(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255|min:4',
            'content' => 'required|max:255|min:10',
            'category_id' => 'required|max:20',
            'image' => 'required|max:255',
            'remark' => 'max:255',
        ]);

        if ($validator->fails()) {
            $status = 'E00001';
        } else {
            $article = new Article($request->all());
            $article->save();
        }
        return response()->json([
            'status' => $status,
            'error' => $validator->errors(),
        ]);
    }

    public function delete($id)
    {
        $article = Article::find($id);
        $article->delete();

        if($article->trashed()) {
            $status = '000000';
        } else {
            $status = 'E00001';
        }
        return response()->json([
            'status' => $status,
        ]);
    }
}
