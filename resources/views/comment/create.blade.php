@extends('adminlte.master');

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">新增評論</h3>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <form action="{{route('comment.store')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="formGroupExampleInput">內容</label>
                            <input type="text" class="form-control" name="content" id="content">
                            @if ($errors->has('content'))
                                <div class="invalid-feedbadk">
                                    <strong style="color:red;">{{$errors->first('content')}}</strong>
                                </div>
                            @endif
                        </div>
                        <div class="box-footer text-right">
                            <a href="{{ route('comment.index') }}" class="btn btn-text">取消</a>
                            <button class="btn btn-success" type="submit"><i class="fa fa-save"></i> 儲存</button>
                        </div>{{-- /.box-footer --}}
                    </form>
                </div>{{-- /.box-body --}}
             </div><!-- /.box -->
        </div>
    </div>
@endsection

