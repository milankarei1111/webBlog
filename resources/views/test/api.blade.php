@extends('adminlte.master');

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">API呼叫測試</h3>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <form action="{{route('apiTest')}}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="formGroupExampleInput">Http method</label>
                            <select name="method" id="method" class="form-control form-control-sm">
                                @foreach($methods as $method)
                                    <option value="{{$method}}">
                                        {{ $method }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="formGroupExampleInput">網址</label>
                            <input type="text" class="form-control" name="url" id="url" placeholder="URL">
                        </div>
                        <div class="box-body table-responsive no-padding">
                                <div class="alert alert-primary" role="alert">
                                     <h4 class="alert-heading">傳入參數說明</h4>
                                       <ul>
                                           <li>新增/修改/刪除權限需帶入參數:「api_token」</li>
                                       </ul>
                                 </div>
                                <table id="myTable" class="table order-list">
                                        <thead>
                                        <tr>
                                            <th class="text-center">key</th>
                                            <th class="text-center">value</th>
                                            <th class="text-center">description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="5" style="text-align: left;">
                                                <input type="button" class="btn btn-primary btn-lg btn-block " id="addrow" value="新增參數" />
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>{{-- /.box-body --}}
                        <div class="box-footer text-right">
                            <a href="{{ route('home') }}" class="btn btn-text">取消</a>
                            <button class="btn btn-success" type="submit"><i class="fa fa-save"></i>傳送</button>
                        </div>{{-- /.box-footer --}}
                    </form>
                    <div>
                       <label>回傳資料:</label>
                       <br>
                        @if (isset($data))
                            <textarea class="form-control" rows="20" style="min-width: 100%" name="json_text">{{$data}}</textarea>
                        @else
                        <textarea class="form-control" rows="20" style="max-heigh:100% ;max-width: 100%" name="json_text"></textarea>
                        @endif
                    </div>
                </div>{{-- /.box-body --}}
             </div><!-- /.box -->
        </div>
    </div>

    <!-- script -->
    <script type="text/javascript">
        $(document).ready(function () {
        var counter = 0;

            $("#addrow").on("click", function () {
                var newRow = $("<tr>");
                var cols = "";

                cols += '<td><input type="text" class="form-control" name="param[' + counter + '][key]"/></td>';
                cols += '<td><input type="text" class="form-control" name="param[' + counter + '][value]"/></td>';
                cols += '<td><input type="text" class="form-control" name="param[' + counter + '][description]"/></td>';

                cols += '<td><input type="button" class="ibtnDel btn btn-md btn-danger "  value="Delete"></td>';
                newRow.append(cols);
                $("table.order-list").append(newRow);
                counter++;
            });


            $("table.order-list").on("click", ".ibtnDel", function (event) {
                $(this).closest("tr").remove();
                counter -= 1
            });

        });

        function calculateRow(row) {
            var price = +row.find('input[name^="price"]').val();
        }

        function calculateGrandTotal() {
            var grandTotal = 0;
            $("table.order-list").find('input[name^="price"]').each(function () {
                grandTotal += +$(this).val();
            });
            $("#grandtotal").text(grandTotal.toFixed(2));
        }
    </script>
     <!-- script -->
@endsection

