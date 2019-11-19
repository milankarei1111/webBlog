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
                        <div class="form-group">
                            <label for="formGroupExampleInput3">分類</label>
                            <input type="text" class="form-control" name="category_id" id="category_id">
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
                            <input type="file" id="image" name="image">
                            <p class="help-block">選擇輸入網址或檔案</p>
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
