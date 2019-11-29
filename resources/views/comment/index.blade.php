@extends('adminlte.master')

@section('content')
    <div class="row">
        <div class="col-md-12">

            @if (Session::has('meassage'))
                <div class="alert alert-info">{{Session::get('meassage')}}</div>
            @endif

            <div class="box box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">評論列表</h3>
                    <div class="no-margin pull-right">
                        {{-- <a href="{{route('comment.create')}}" class="btn btn-primary btn-md">
                            <i class="fa fa-plus fa-fw"></i> 新增評論
                        </a> --}}
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                            <th class="text-center" style="width: 4em;">#</th>
                            <th class="text-left">評論內容</th>
                            <th class="text-left" style="width: 6em;">文章標題</th>
                            <th class="text-left" style="width: 6em;">會員名稱</th>
                            <th class="text-center" style="width: 4em;">編輯</th>
                            <th class="text-center" style="width: 4em;">刪除</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($comments as $comment)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{ $comment->content}}</td>
                                    <td>{{ $comment->title}}</td>
                                    <td>{{ $comment->name}}</td>
                                    <td class="text-center">
                                        <a class="btn btn-default btn-xs" href="{{ route('comment.edit', $comment->comment_id) }}">
                                            <i class="fa fa-edit fa-fw"></i>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <form action="{{ route('comment.destroy', $comment->comment_id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#exampleModal">
                                                    <i class="fa fa-times fa-fw"></i>
                                            </button>
                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">注意</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <h4 style="color:red">你確定要刪除嗎?</h4>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
                                                            <button type="submit" class="btn btn-primary">確定</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="999" class="text-center">查無資料!</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>{{-- /.box-body --}}

                <div class="box-footer clearfix">
                        {{ $comments->links() }}
                </div>{{-- /.box-footer --}}
             </div><!-- /.box -->
        </div>
    </div>
@endsection
