@extends('adminlte.master');

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">API呼叫測試</h3>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <form action="{{route('getApiTest')}}" method="POST">
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
                                <table id="myTable" class="table order-list">
                                        <thead>
                                        <tr>
                                            <th class="text-center">key</th>
                                            <th class="text-center">value</th>
                                            <th class="text-center">description</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <input type="text" name="param[0][key]" class="form-control" />
                                            </td>
                                            <td>
                                                <input type="text" name="param[0][value]"  class="form-control"/>
                                            </td>
                                            <td>
                                                <input type="text" name="param[0][description]"  class="form-control"/>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="5" style="text-align: left;">
                                                <input type="button" class="btn btn-lg btn-block " id="addrow" value="新增一列" />
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

                </div>{{-- /.box-body --}}
             </div><!-- /.box -->
        </div>
    </div>

    <!-- script -->
    <script type="text/javascript">
        $(document).ready(function () {
        var counter = 1;

            $("#addrow").on("click", function () {
                var newRow = $("<tr>");
                var cols = "";

                cols += '<td><input type="text" class="form-control" name="param[' + counter + '][key]"/></td>';
                cols += '<td><input type="text" class="form-control" name="param[' + counter + '[value]"/></td>';
                cols += '<td><input type="text" class="form-control" name="param[' + counter + '[description]"/></td>';

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

