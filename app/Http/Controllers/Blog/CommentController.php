<?php

namespace App\Http\Controllers\Blog;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::orderBy('comment_id', 'desc')->paginate(20);

        if($comments){
            foreach ($comments as $key =>$comment) {
                $title = Comment::find($comment->comment_id)->article()->first()->title;
                $name = Comment::find($comment->user_id)->user()->first();
                if($name){
                    $comments[$key]['name'] = $name->name;
                } else {
                    $comments[$key]['name'] = '';
                }
                $comments[$key]['title'] = $title;
            }
        }
        return view('comment.index', compact('comments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('comment.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all() ,[
            'content' => 'required|max:255|min:4',
            'article_id' => 'required',
            'user_id' => 'required',
        ]);

        $meassage = '';
        if (!$validator->fails()) {
            $result = Comment::create($request->all());
            if ($result) {
                $meassage = '新增成功';
            } else {
                $meassage = '新增失敗';
            }
            return redirect()->route('comment.index')->with('meassage', $meassage);
        } else {
           return view('comment.create')->withErrors($validator);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        $comment = compact('comment');
        return view('comment.edit', $comment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $meassage = '';
        $comment = Comment::find($id);
        $validator = Validator::make([
            'content' => $request->content
            ], [
            'content' => 'required|max:255|min:4'
            ]);

        if ($validator->fails()) {
            return view('comment.edit')->withErrors($validator);
        } else {
            $result = $comment->update([
                'content'=>$request->content
            ],[
                'content' => $request['content']
            ]);
            if ($result) {
                $meassage = '更新成功';
            } else {
                $meassage = '更新失敗';
            }
            return redirect()->route('comment.index')->with('meassage', $meassage);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = Comment::find($id);
        if ($comment) {
            $result = $comment->delete();
            if($result) {
                $meassage = '刪除成功!';
            } else {
                $meassage = '刪除失敗!!';
            }
        } else {
            $meassage = $comment->title.': 查無此筆資料!';
        }
        return redirect()->back()->with('meassage', $meassage);
    }
}
