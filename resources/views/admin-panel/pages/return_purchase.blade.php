@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />

@endsection
@section('content')

{{--    <!---------Delete Model---------->--}}


    <!--------------Delete Model ends----->
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Manage Purchase</a></li>
            <li>Return Purchase</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>

    <div class="row">
        <div class="col-md-12">

            <div class="card mb-4">
                <div class="card-body">
                {{--                    <div class="card-title mb-3">Bike Details</div>--}}


                <!----------------------------------------------------Upload file ------------------------------------------------------------------>
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">Return Purchase</div>

                            <form method="post" action="{{isset($edit_inv_data)?action('ReturnPurchaseController@store',$edit_inv_data->id):url('return_purchase_value')}}">
                                {!! csrf_field() !!}
                                @if(isset($edit_inv_data))
                                    {{ method_field('POST') }}
                                @endif


                                <input type="hidden" id="id" name="id" value="{{isset($inv_parts_data)?$inv_parts_data->id:""}}">
                                <div class="row">
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="repair_category">Part Number</label>
                                        @if(isset($inv_parts_data))
                                            <input type="hidden" id="part_id" name="part_number" value="{{isset($inv_parts_data)?$inv_parts_data->parts_id:""}}">
                                        @endif


                                        <select id="part_id" name="part_number" class="form-control form-control-rounded"  required {{isset($inv_parts_data)?'disabled':""}}>
                                            <option value="">
                                                Select the Part Number
                                            </option>
                                            @foreach($parts as $part)
                                                @php
                                                    $isSelected=(isset($inv_parts_data)?$inv_parts_data->parts_id:"")==$part->id;
                                                @endphp
                                                <option value="{{$part->id}}" {{ $isSelected ? 'selected': '' }}>{{$part->part_number}}</option>
                                            @endforeach
                                        </select>

                                    </div>


                                    <div class="col-md-6 form-group mb-3">
                                        <label for="repair_category">Qty</label>
                                        <input class="form-control form-control-rounded" id="part_qty" value="{{isset($edit_inv_data)?$insert_qty:""}}" name="part_qty"  type="text" placeholder="Enter the part QTY" required />
                                        <input class="form-control form-control-rounded" id="qty_id" value="{{isset($edit_inv_data)?$edit_inv_data->id:""}}" name="qty_id"  type="hidden" placeholder="Enter the part QTY">

                                        @if(isset($edit_inv_data))

                                        <input class="form-control form-control-rounded" id="invoice_no" value="{{isset($edit_inv_data)?$edit_inv_data->invoice_no:""}}" name="invoice_no"  type="hidden" placeholder="Enter the part QTY">

                                        @endif
                                        @if(!isset($edit_inv_data))

                                        <input class="form-control form-control-rounded" id="invoice_no" value="{{ $invoice }}" name="invoice_no"  type="hidden" placeholder="Enter the part QTY">

                                        @endif
                                    </div>


                                    <div class="col-md-6">
                                        <button class="btn btn-primary">  Return  </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>



                    <!-------------------------------------------------Upload File Ends-------------------------------------------------------------->

                </div>
            </div>
        </div>
    </div>


    <div class="col-md-12 mb-3">
        <div class="card text-left">
            <div class="card-body">
                {{--                <input type='button' id='btn' value='Print' onclick='printDiv();'>--}}
                <div class="table-responsive">
                    <table class="table" id="datatable">
                        <thead class="thead-dark">
                        <tr>
                            {{--                            <th scope="col">#</th>--}}
                            <th scope="col">Part Number</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Invoice Number</th>
                            <th scope="col">Update</th>
                            <th scope="col">Delete</th>



                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($inv))
                            @foreach($inv as $row)
                                <tr>
                                    <td>{{$row->part->part_number}}</td>
                                    <td>{{ $row->qty }}</td>
                                    <td>{{ $row->invoice_no }}</td>




                                          <td>

                                              <form method="post" action="{{url('return_purchase_edit')}}">
                                            {!! csrf_field() !!}
                                            {{ method_field('POST') }}
                                            <input type="hidden" id="id" name="id" value="{{$row->id}}">

                                            <input type="hidden" id="insert_qty" name="insert_qty" value="{{ $row->qty}}">
                                            <input type="hidden" id="par_number" name="part_number" value="{{ $row->part_number}}">
                                                  <input type="hidden" id="par_number" name="invoice_no" value="{{ $row->invoice_no}}">

                                            <button class="text-success mr-2">
                                                <i class="nav-icon i-Pen-2 font-weight-bold">
                                                </i>
                                            </button>
                                        </form></td>





                                    <td>

                                        <a class="text-danger mr-2" onclick="deleteData({{$row->id}})" data-toggle="modal" data-target=".bd-example-modal-sm" >
                                            <i class="nav-icon i-Close-Window font-weight-bold"></i></a>
                                    </td>





                                </tr>
                            @endforeach
                        @endif

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<!---------Delete Model---------->
<div class="modal fade bd-example-modal-sm" id="delteForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form action="" id="deleteForm" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle-1">Deletion Confirmation</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>

                <div class="modal-body">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    Are you sure want to delete the data?
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary ml-2"  onclick="deleteSubmit()">Delete it</button>
                </div>
            </form>
        </div>
    </div>
</div>



@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script>



        $(document).ready(function () {
            'use strict';

            $('#datatable').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "columnDefs": [

                    {"targets": [1],"width": "80%"}
                ],
                "scrollY": false,
            });
            $('#part_id').select2({
                placeholder: 'Select an option'
            });


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


    <script !src="">



        function deleteData(id) {
            var id = id;
            var url = '{{ route('return_purchase.destroy', ":id") }}';
            url = url.replace(':id', id);

            $("#deleteForm").attr('action', url);
        }
        function deleteSubmit()
        {
            $("#deleteForm").submit();
        }
    </script>




@endsection


