@extends('adminlte.master')

@section('content')
    <div class="row">
        <div class="col-md-12">

            @if (Session::has('meassage'))
                <div class="alert alert-info">{{Session::get('meassage')}}</div>
            @endif

            <div class="box box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">文章列表</h3>
                    <div class="no-margin pull-right">
                        <a href="{{route('article.create')}}" class="btn btn-primary btn-md">
                            <i class="fa fa-plus fa-fw"></i> 新增文章
                        </a>
                    </div>
                </div><!-- /.box-header -->

                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                            <th class="text-center" style="width: 4em;">#</th>
                            <th class="text-left">標題</th>
                            <th class="text-left">內容</th>
                            <th class="text-left">圖片</th>
                            <th class="text-left">備註</th>
                            <th class="text-center" style="width: 6em;">查看文章</th>
                            <th class="text-center" style="width: 4em;">編輯</th>
                            <th class="text-center" style="width: 4em;">刪除</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($articles as $article)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$article->title}}</td>
                                    <td>{{$article->content}}</td>
                                    <td>{{$article->image}}</td>
                                    <td>{{$article->remark}}</td>
                                    <td class="text-center">
                                        <a class="btn btn-default btn-xs" href="{{ route('article.show', $article->article_id) }}">
                                            <i class="fa fa-eye fa-fw"></i>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <a class="btn btn-default btn-xs" href="{{ route('article.edit', $article->article_id) }}">
                                            <i class="fa fa-edit fa-fw"></i>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <form action="{{ route('category.destroy', $article->article_id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-xs" type="submit">
                                                <i class="fa fa-times fa-fw"></i>
                                            </button>
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
                        {{-- {{ $article->links() }} --}}
                </div>{{-- /.box-footer --}}
             </div><!-- /.box -->
        </div>
    </div>
@endsection
