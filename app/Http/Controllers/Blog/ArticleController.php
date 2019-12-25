<?php

namespace App\Http\Controllers\Blog;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Models\ArticleCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $storage = '/storage/';
        $url = $storage . 'images/8e514cebcb64855ae794e6c1aba349f5.jpg';

        $articles = Article::orderBy('article_id', 'desc')->paginate(20);
        return view('article.index', compact('articles', 'url'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = ArticleCategory::orderBy('category_id', 'desc')->get();
        return view('article.create')->with('categories', $categories);
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
            'image' => 'image|max:255',
            'remark' => 'max:255',
        ]);
        $meassage = '';
        $categories = ArticleCategory::orderBy('category_id', 'desc')->get();

        if (!$validator->fails()) {
            $data = $request->all();
            if ($request->file('image')) {
                $uploadData = $this->uploadFile($request);
                if ($uploadData['status']) {
                    $savePath = $uploadData['meassage'];
                    $data['image'] = $savePath;
                } else {
                    $meassage = $uploadData['meassage'];
                    return view('article.create', compact('meassage', 'categories'));
                }
            }
            $result = Article::create($data);
            if ($result) {
                $meassage = '新增成功';
            } else {
                $meassage = '新增失敗';
            }
            return redirect()->route('article.index')->with('meassage', $meassage);
        } else {
            return view('article.create')->withErrors($validator)->with('categories', $categories);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        $comments =$article->comments()->get();
        return view('article.show', compact('comments', 'article'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $article = Article::findOrFail($id);
        $categories = ArticleCategory::orderBy('name', 'ASC')->get();
        return View::make('article.edit', compact('article', 'categories'));
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
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255|min:4',
            'content' => 'required|max:255|min:10',
            'category_id' => 'required|max:20',
            'image' => 'image|max:255',
            'remark' => 'max:255',
        ]);

        $meassage = '';
        $categories = ArticleCategory::orderBy('category_id', 'desc')->get();

        if (!$validator->fails()) {
            $data = $request->all();
            $article = Article::find($id);

            if ($request->image) {
                $uploadData = $this->uploadFile($request);
                if ($uploadData['status']) {
                    $savePath = $uploadData['meassage'];
                    $data['image'] = $savePath;
                } else {
                    $meassage = $uploadData['meassage'];
                    return view('article.edit', compact('meassage', 'categories'));
                }
            }
            $result = $article->update($data);
            if ($result) {
                $meassage = '更新成功';
            } else {
                $meassage = '更新失敗';
            }
            return redirect()->route('article.index')->with('meassage', $meassage);
        } else {
            return view('article.edit')->withErrors($validator)->with('categories', $categories);
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
            if ($result) {
                $meassage = $article->title . ': 刪除成功!';
            } else {
                $meassage = $article->title . ': 刪除失敗!!';
            }
        } else {
            $meassage = $article->title . ': 查無此筆資料!';
        }
        return redirect()->back()->with('meassage', $meassage);
    }

    private function uploadFile(Request $request)
    {
        $data = [
            'status' => false,
            'meassage' => '文件上傳失敗'
        ];
        if ($request->hasFile('image')) {
            $picture = $request->file('image');
            if (!$picture->isValid()) {
                $data['meassage'] = '無效的上傳文件';
            }
            $extension = $picture->getClientOriginalExtension();
            $fileName = $picture->getClientOriginalName();
            $newFileName = md5($fileName . time() . mt_rand(1, 10000)) . '.' . $extension;
            $savePath = 'images/' . $newFileName;
            $webPath = '/storage/' . $savePath;

            if (Storage::disk('public')->has($savePath)) {
                $data['status'] = true;
                $data['meassage'] = $webPath;
            }
            if ($picture->storePubliclyAs('images', $newFileName, ['disk' => 'public'])) {
                $data['status'] = true;
                $data['meassage'] = $webPath;
            }
        } else {
            $data['meassage'] = '請選擇要上傳的檔案';
        }
        return $data;
    }
}
