@extends('adminlte.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">編輯文章</h3>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <form action="{{route('article.update', $article->article_id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <label for="formGroupExampleInput">標題</label>
                            <input type="text" class="form-control" name="title" id="title" placeholder="標題" value="{{$article->title}}">
                            @if ($errors->has('title'))
                                <div class="invalid-feedbadk">
                                    <strong style="color:red;">{{$errors->first('title')}}</strong>
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="formGroupExampleInput2">內容</label>
                        <input type="text" class="form-control" name="content" id="content" placeholder="內容" value="{{$article->content}}">
                            @if ($errors->has('content'))
                                <div class="invalid-feedbadk">
                                    <strong style="color:red;">{{$errors->first('content')}}</strong>
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                                <label for="formGroupExampleInput3">分類</label>
                                <select name="category_id" id="category_id" class="form-control form-control-sm">
                                    @foreach($categories as $category)
                                            <option value="{{ $category->category_id }}" {{ ($article->category_id == $category->category_id)?"selected":"" }}>
                                                {{ $category->name }}
                                            </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('category_id'))
                                    <div class="invalid-feedbadk">
                                        <strong style="color:red;">{{$errors->first('category_id')}}</strong>
                                    </div>
                                @endif
                         </div>
                        <div class="form-group">
                            <label for="exampleInputFile">圖片上傳</label>
                            <div>
                                @if ($article->image)
                                    <img src="{{asset($article->image)}}" class="img-thumbnail" alt="Responsive image">
                                @endif
                            </div>
                            <input type="file" name="image">
                        </div>
                        <div class="form-group">
                            <label for="formGroupExampleInput5">備註</label>
                            <input type="text" class="form-control" name="remark" id="remark" value="{{$article['remark']}}">
                            @if ($errors->has('remark'))
                                <div class="invalid-feedbadk">
                                    <strong style="color:red;">{{$errors->first('remark')}}</strong>
                                </div>
                            @endif
                        </div>
                        <div class="box-footer text-right">
                            <a href="{{ route('article.index') }}" class="btn btn-text">取消</a>
                            <button class="btn btn-success" type="submit"><i class="fa fa-save"></i> 儲存</button>
                        </div>{{-- /.box-footer --}}
                    </form>
                </div>{{-- /.box-body --}}
             </div><!-- /.box -->
        </div>
    </div>
@endsection
