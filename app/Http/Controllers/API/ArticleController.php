<?php

namespace App\Http\Controllers\API;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    public function articleList($id = null)
    {
        if ($id) {
            $article = Article::where("article_id", '=', $id)->get();
        } else {
            $article = Article::all();
        }

        if (!$article->isEmpty()) {
            $status = '000000';
        } else {
            $status = 'E00004';
        }
        return $this->responseMessage($status, $article);
    }

    public function commentList($id)
    {
        $comment = Article::find($id)->comments()->get();

        if (!$comment->isEmpty()) {
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
                'image' => 'image|max:255',
                'remark' => 'max:255',
            ]);
            if ($validator->fails()) {
                $status = 'E00002';
                $meassage = $validator->errors();
            } else {
                $data = $request->all();
                if ($request->image) {
                    $uploadData = $this->uploadFile($request);
                    if ($uploadData['status']) {
                        $savePath = $uploadData['meassage'];
                        $data['image'] = $savePath;
                    } else {
                        $status = 'E00002';
                        $meassage = $uploadData['meassage'];
                    }
                }

                $result = $article->update( $data);

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
            'image' => 'image|max:255',
            'remark' => 'max:255',
        ]);

        if ($validator->fails()) {
            $status = 'E00002';
            $meassage = $validator->errors();
        } else {
            $data = $request->all();
            if ($request->image) {
                $uploadData = $this->uploadFile($request);
                if ($uploadData['status']) {
                    $savePath = $uploadData['meassage'];
                    $data['image'] = $savePath;
                }
            }
            $result = Article::create($data);
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
        if ($article) {
            $article->delete();
            if ($article->trashed()) {
                $status = '000000';
                $meassage = '刪除成功';
            } else {
                $status = 'E00001';
                $meassage = '刪除失敗';
            }
        } else {
            $status = 'E00004';
            $meassage = '查無此資料!';
        }
        return $this->responseMessage($status, $meassage);
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

    public function responseMessage($status, $value = null)
    {
        return response()->json([
            'status' => $status,
            'value' => $value
        ]);
    }
}
