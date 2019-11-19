@extends('adminlte.master')

@section('content')
    <div class="row">
        <div class="col-md-12">

            @if (Session::has('meassage'))
                <div class="alert alert-info">{{Session::get('meassage')}}</div>
            @endif

            <div class="box box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">文章評論</h3>
                </div><!-- /.box-header -->

                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                            <th class="text-center" style="width: 4em;">#</th>
                            <th class="text-left">帳號</th>
                            <th class="text-left">內容</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($comments as $comment)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$comment->user_id}}</td>
                                    <td>{{$comment->content}}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="999" class="text-center">查無資料!</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>{{-- /.box-body --}}
                <div class="box-footer text-right">
                        <a href="{{ route('category.index') }}" class="btn btn-text">返回</a>
                </div>{{-- /.box-footer --}}
             </div><!-- /.box -->
        </div>
    </div>
@endsection
