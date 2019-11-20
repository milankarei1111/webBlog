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
            $categories = ArticleCategory::orderBy('category_id', 'desc')->get();
            return view('article.create')->withErrors($validator)->with('categories', $categories);
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
        if (! $validator->fails()) {
            $uploadData = $this->uploadFile($request);
            if ($uploadData['status']) {
                $savePath = $uploadData['meassage'];

                $article = Article::find($id);
                $data = $request->all();
                $data['image'] = $savePath;
                $result = $article->update($data);

                if ($result) {
                    $meassage = '更新成功';
                } else {
                    $meassage = '更新失敗';
                }
            } else {
                $meassage = $uploadData['meassage'];
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
            // 文件扩展名
            $extension = $picture->getClientOriginalExtension();
            // 文件名
            $fileName = $picture->getClientOriginalName();
            // 生成新的统一格式的文件名
            $newFileName = md5($fileName . time() . mt_rand(1, 10000)) . '.' . $extension;
            // 图片保存路径
            $savePath = 'images/' . $newFileName;
            // Web 访问路径
            $webPath = '/storage/' . $savePath;

            // 将文件保存到本地 storage/app/public/images 目录下，先判断同名文件是否已经存在，如果存在直接返回
            if (Storage::disk('public')->has($savePath)) {
                $data['status'] = true;
                $data['meassage'] = $webPath;
            }
            // 否则执行保存操作，保存成功将访问路径返回给调用方
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
