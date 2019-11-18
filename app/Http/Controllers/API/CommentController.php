<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function commentList($id=null)
    {
        if($id) {
            $comment = Comment::where('comment_id', '=', $id)->get();
        } else {
            $comment = Comment::all();
        }
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
       $comment = Comment::find($id);
       if ($comment) {
           $validator = Validator::make([
               'content' => $request->content
            ], [
            'content' => 'required|max:255|min:4'
            ]);

           if ($validator->fails()) {
                $status = 'E00002';
                $meassage = $validator->errors();
           } else {
                $result = $comment->update([
                    'content'=>$request->content
                ],[
                    'content' => $request['content']
                ]);
                if ($result) {
                    $status = '000000';
                    $meassage = '更新成功';
                } else {
                    $status = 'E00001';
                    $meassage = '更新失敗';
                }
            }
       } else {
            $status= 'E00004';
            $meassage = '查無此資料!';
       }
       return $this->responseMessage($status, $meassage);
    }

    public function insert(Request $request)
    {
        $meassage = '';
        $validator = Validator::make($request->all() ,[
            'content' => 'required|max:255|min:4',
            'article_id' => 'required',
            'user_id' => 'required',
        ]);
        if ($validator->fails()) {
           $status = 'E00002';
           $meassage = $validator->errors();
        } else {
            $comment = new Comment;
            $result = $comment->create($request->all());
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
        $comment = Comment::find($id);
        if ($comment) {
            $comment->delete();

            if($comment->trashed()) {
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
