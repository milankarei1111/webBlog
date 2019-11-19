<?php

namespace App\Http\Controllers\Blog;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::orderBy('article_id', 'desc')->paginate(20);
        return view('article.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('article.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255|min:4',
            'content' => 'required|max:255|min:10',
            'category_id' => 'required|integer|max:20',
            'image' => 'max:255',
            'remark' => 'max:255',
        ]);

        $meassage = '';
        if (!$validator->fails()) {
            $result = Article::create($request->all());
            if ($result) {
                $meassage = '新增成功';
            } else {
                $meassage = '新增失敗';
            }
            return redirect()->route('article.index')->with('meassage', $meassage);
        } else {
           return view('article.create')->withErrors($validator);
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
        $article = new Article;
        $comments = $article->find($id)->comments()->get();
        return view('article.show', compact('comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        $article = compact('article');
        return view('article.edit', $article);
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
        $category = Article::find($id);
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255|min:4',
            'content' => 'required|max:255|min:10',
            'category_id' => 'required|max:20',
            'image' => 'max:255',
            'remark' => 'max:255',
        ]);

        $meassage = '';
        if (!$validator->fails()) {
            $result = $category->update($request->all());
            if ($result) {
                $meassage = '更新成功';
            } else {
                $meassage = '更新失敗';
            }
            return redirect()->route('article.index')->with('meassage', $meassage);
        } else {
           return view('article.edit')->withErrors($validator);
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
        $article = Article::find($id);
        if ($article) {
            $result = $article->delete();
            if($result) {
                $meassage = $article->title.': 刪除成功!';
            } else {
                $meassage = $article->title.': 刪除失敗!!';
            }
        } else {
            $meassage = $article->title.': 查無此筆資料!';
        }
        return redirect()->back()->with('meassage', $meassage);
    }
}
