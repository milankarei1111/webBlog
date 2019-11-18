<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Models\ArticleCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = ArticleCategory::orderBy('category_id','desc')->paginate(5);
        return view('category.index',compact('categories'));
        // return view('category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->only('name', 'description'), [
            'name'=>'required|max:255|min:4',
            'description'=>'max:255|min:4'
        ]);

        if ($validator->fails()) {
            $meassage = $validator->errors();
        } else {
            $result = ArticleCategory::create($request->all());
            if ($result) {
                $meassage = '新增成功';
            } else {
                $meassage = '新增失敗';
            }
        }
        return redirect()->back()->with('meassage', $meassage);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $find = new ArticleCategory;
        $category = $find->find($id)->toArray();
        return view('category.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $find = new ArticleCategory;
        $category = $find->find($id)->toArray();
        return view('category.edit', compact('category'));
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
        $category = ArticleCategory::find($id);
        $validator = Validator::make($request->only('name', 'description'), [
            'name'=>'required|max:255|min:4',
            'description'=>'max:255|min:4'
        ]);

        if ($validator->fails()) {
            $meassage = $validator->errors();
        } else {
            $status = '000000';
            $result = $category->update($request->all());
            if($result) {
                $message = $id.': 更新成功!';
            } else {
                $message = $id.': 更新失敗!!';
            }
        }
        return redirect()->back()->with('message', $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = ArticleCategory::find($id);
        if ($category) {
            $result = $category->delete();
            if($result == true) {
                $message = $id.': 刪除成功!';
            } else {
                $message = $id.': 刪除失敗!!';
            }
        } else {
            $message = $id.': 查無此筆資料!';
        }
        return redirect()->back()->with('message', $message);
    }
}
