@extends('adminlte.master');

@section('breadcrumb')
  <section class="content-header">
    <h1>文章分類管理</h1>
    {{ Breadcrumbs::render() }}
  </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">編輯文章分類</h3>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <form action="{{route('category.update', $category['category_id'])}}" method="POST">

                        @csrf
                        @method('PATCH')
                        <div class="form-group">
                            <label for="formGroupExampleInput">文章分類名稱</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="分類" value="{{ $category['name'] }}">
                            @if ($errors->has('name'))
                                <div class="invalid-feedbadk">
                                    <strong style="color:red;">{{$errors->first('name')}}</strong>
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="formGroupExampleInput2">文章分類描述</label>
                            <input type="text" class="form-control" name="description" id="description" placeholder="描述" value="{{ $category['description'] }}">
                            @if ($errors->has('description'))
                                <div class="invalid-feedbadk">
                                    <strong style="color:red;">{{$errors->first('description')}}</strong>
                                </div>
                            @endif
                        </div>
                        <div class="box-footer text-right">
                            <a href="{{ route('category.index') }}" class="btn btn-text">取消</a>
                            <button class="btn btn-success" type="submit"><i class="fa fa-save"></i> 儲存</button>
                        </div>{{-- /.box-footer --}}
                    </form>
                </div>{{-- /.box-body --}}
             </div><!-- /.box -->
        </div>
    </div>
@endsection

