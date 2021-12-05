@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
@endsection
@section('content')
<div class="breadcrumb">
    <h1 class="mr-2">Home</h1>
    <ul>
        <li><a href="">Careem</a></li>
        <li>Close Month</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="col-md-12 mb-3">
    <div class="card text-left">
        <div class="card-body">
            <form action="{{ route('save_close_month') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="form-group col-4"></div>
                    <div class="form-group col-4">
                        <label for="date">Date</label>
                        <input name="date" id="date" class="form-control form-control-sm" type="date" value="{{ date('Y-m-d') }}" required/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-primary" id="save_btn" style="float: right;">save</button>
                    </div>
                </div>
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-bordered text-11" id="cash_cod" style="width:100%;">
                            <thead>
                            <tr>
                                <th></th>
                                <th scope="col">
                                    <label class="checkbox checkbox-outline-success" style="margin-bottom: -2px;">
                                        <input type="checkbox"   id="checkAll" checked><span>All</span><span class="checkmark"></span>
                                    </label>
                                </th>
                                <th scope="col">Name</th>
                                <th scope="col">Rider Id</th>
                                <th scope="col">Remain Cod</th>
                                <th scope="col">Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($uploads as $key => $upload)
                                    <?php
                                    $total_paid_amount = 0;
                                    $remain_cod = $upload->total;
                                    $remain_amount = 0;
                                    $now_cod = $cods->where('passport_id',$upload->passport_id)->sum('amount');
                                    $close = $close_month->where('passport_id','=',$upload->passport_id)->sum('close_month_amount');

                                    if($now_cod != null){
                                    $total_paid_amount = $now_cod;
                                    }
                                    if($close != null){
                                    $total_paid_amount = $total_paid_amount+$close;
                                    }
                                    // dd($total_paid_amount);
                                    if($remain_cod != null){
                                    $remain_amount = number_format((float)$remain_cod-$total_paid_amount, 2, '.', '');;
                                    }

                                    ?>
                                    @if ($remain_amount > '0')
                                    <tr>
                                        <td></td>
                                        <td>
                                            <label class="checkbox checkbox-outline-primary">
                                                <input type="checkbox" name="details[{{$key}}][rider_ids]" value="{{ isset($upload->driver_id) ? $upload->driver_id : '' }}"  checked="checked" class="checkbox_cls"><span></span><span class="checkmark"></span>
                                            </label>
                                        </td>
                                        <td>{{$upload->passport->personal_info->full_name}}</td>
                                        <td>{{$upload->driver_id}}</td>
                                        <td>{{$remain_amount}}</td>
                                        <td><input type="number" class="form-control form-control-sm" value="{{ $remain_amount }}" name="details[{{$key}}][amount]" required></td>
                                        <input type="hidden" value="{{$upload->passport_id}}" id="name" name="details[{{$key}}][passport_id]" >
                                    </tr>
                                    @endif
                                @endforeach
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <button type="submit" class="btn btn-primary" id="form_submit_btn" style="display: none;">save</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-sm"  id="question_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle-1">Confirmation</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    Are you sure to close month.?
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">No</button>
                    <button class="btn btn-primary ml-2" type="button"  id="yes_btn">Yes</button>
                </div>

        </div>
    </div>
</div>
@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            'use strict';
            $('#cash_cod').DataTable( {
                    dom: 'Bfrtip',
                        buttons: [
                            {
                                extend: 'excel',
                                title: 'Careem Cod',
                                text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                            exportOptions: {
                        modifier: {
                            page : 'all',
                        }
                    }
                },
                    'pageLength',
                ],
                "aaSorting": [[0, 'desc']],
                "pageLength": 1000,
                "columnDefs": [
                    {"targets": [0],"visible": false},
                    {"targets": [1][2],"width": "40%"}
                ],
                "scrollY": false,
            });
        });
    </script>
    <script>
        $("#checkAll").click(function () {
            $('.checkbox_cls').not(this).prop('checked', this.checked);
        });
    </script>
    <script>
        $('#save_btn').on('click', function() {
            $("#question_modal").modal('show');
        });

        $("#yes_btn").click(function(){
            $("#form_submit_btn").click();
        });
    </script>
    <script>
        @if(Session::has('message'))
        var type = "{{ Session::get('alert-type', 'info') }}";
        switch(type){
            case 'info':
                toastr.info("{{ Session::get('message') }}", "Information!", { timeOut:10000 , progressBar : true});
                break;

            case 'warning':
                toastr.warning("{{ Session::get('message') }}", "Warning!", { timeOut:10000 , progressBar : true});
                break;

            case 'success':
                toastr.success("{{ Session::get('message') }}", "Success!", { timeOut:10000 , progressBar : true});
                break;

            case 'error':
                toastr.error("{{ Session::get('message') }}", "Failed!", { timeOut:10000 , progressBar : true});
                break;
        }
        @endif
    </script>
@endsection
