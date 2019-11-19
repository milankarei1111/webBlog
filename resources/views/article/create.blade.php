@extends('adminlte.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">新增文章</h3>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <form action="{{route('article.store')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="formGroupExampleInput">標題</label>
                            <input type="text" class="form-control" name="title" id="title" placeholder="標題">
                            @if ($errors->has('title'))
                                <div class="invalid-feedbadk">
                                    <strong style="color:red;">{{$errors->first('title')}}</strong>
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="formGroupExampleInput2">內容</label>
                            <textarea class="form-control" rows="3" name="content" id="content"></textarea>
                            @if ($errors->has('content'))
                                <div class="invalid-feedbadk">
                                    <strong style="color:red;">{{$errors->first('content')}}</strong>
                                </div>
                            @endif
                        </div>
                        {{-- <div class="form-group row">
                            <label for="type" class="col-sm-2 col-form-label-sm text-md-right">分類</label>
                            <div class="col-sm-8">
                                <select name="types" id="types" class="form-control form-control-sm">
                                    <option value="0">請選擇分類</option>
                                    @if ($categories)
                                        @foreach($categories as $category)
                                            <option value="{{$category->category_id}}">
                                                {{$category->name}}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                @if ($errors->has('category_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('category_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                         </div> --}}
                        <div class="form-group">
                            <select name="category_id" id="category_id" class="form-control form-control-sm">
                                <option value="">請選擇文章分類</option>
                                @foreach($categories as $category)
                                <option value="{{$category->category_id}}">
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
                            <label for="formGroupExampleInput3">圖片</label>
                            <input type="text" class="form-control" name="image" id="image" placeholder="網址">
                            @if ($errors->has('image'))
                                <div class="invalid-feedbadk">
                                    <strong style="color:red;">{{$errors->first('image')}}</strong>
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="formGroupExampleInput4">備註</label>
                            <textarea class="form-control" rows="3" name="remark" id="remark"></textarea>
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
