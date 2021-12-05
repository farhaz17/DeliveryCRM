@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />

@endsection
@section('content')


    <!--------------Delete Model ends----->
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Operations</a></li>
            <li>Manage Purchase</li>
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
                            <div class="card-title">Manage Purchase</div>

                            <form method="post" id="form2" action="{{isset($edit_inv_data)?route('save_invoice.update',$edit_inv_data->id):url('save_invoice')}}">
                                {!! csrf_field() !!}
                                @if(isset($edit_inv_data))
                                    {{ method_field('PUT') }}
                                @endif
                                 <input type="hidden" id="abc" name="id" value="{{isset($inv_parts_data)?$inv_parts_data->id:""}}">
                                <div class="row">
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="repair_category">Part Number</label>
                                        @if(isset($inv_parts_data))
                                            <input type="hidden" id="part_id" name="part_number" value="{{isset($inv_parts_data)?$inv_parts_data->parts_id:""}}">
                                        @endif
                                        <select id="part_id" name="part_number" class="form-control form-control-rounded" required {{isset($inv_parts_data)?'disabled':""}}>
                                            <option value="">
                                             Select the Part Number
                                            </option>
                                            @foreach($parts as $part)
                                                @php
                                                    $isSelected=(isset($inv_parts_data)?$inv_parts_data->parts_id:"")== $part->id;
                                                @endphp
                                                <option value="{{$part->id}}" {{ $isSelected ? 'selected': '' }}>{{$part->part_number}}</option>
                                            @endforeach
                                        </select>

                                        <input type="hidden" name="invoice_number" id="invoice_number" value="{{isset($edit_invoice_data1)?$edit_invoice_data1->invoice_number:""}}" >
                                        <input type="hidden" placeholder="invoice number" name="invoice_number2" id="invoice_number2" value="{{isset($edit_inv_data)?$edit_inv_data->invoice_number:""}}" >
                                    </div>
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="repair_category">Part Name</label>
                                        <input class="form-control form-control-rounded" id="part_name" name="part_name"  value="{{isset($edit_inv_data)?$edit_inv_data->part_name:""}}"  type="text" placeholder="Enter the part name" required />

                                        <div>


                                        </div>

                                    </div>
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="repair_category">Part Description</label>
                                        <input class="form-control form-control-rounded" id="part_des" name="part_des" value="{{isset($edit_inv_data)?$edit_inv_data->part_des:""}}"  type="text" placeholder="Enter the part description" required />
                                    </div>
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="repair_category">Qty</label>
                                        <input class="form-control form-control-rounded" id="part_qty" name="part_qty" value="{{isset($edit_inv_data)?$edit_inv_data->part_qty:""}}" type="text" placeholder="Enter the part QTY" required />

                                        <input class="form-control form-control-rounded" id="part_qty_balance" name="part_qty_balance"  value="{{isset($edit_inv_data)?$edit_inv_data->part_qty_balance:""}}"  type="hidden" required />

                                    </div>
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="repair_category">Amount</label>
                                        <input class="form-control form-control-rounded" id="amount" name="amount" value="{{isset($edit_inv_data)?$edit_inv_data->amount:""}}"  type="number" placeholder="Enter amount" required />
                                    </div>
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="repair_category">VAT %</label>
                                        <input class="form-control form-control-rounded" id="vat" name="vat" value="5"  value="{{isset($edit_inv_data)?$edit_inv_data->vat:""}}"  type="text" placeholder="Enter the VAT %" required />
                                    </div>
                                    <div class="col-md-6">
                                        <button class="btn btn-primary">  Add  </button>
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
    <!-------------------------------------Data Table------------------------------>
    <div class="row">
                            <div class="col-md-12">
                                <div class="card text-left">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table  class="table" id="datatable">
                                                <thead class="thead-dark">
                                                <tr>
                                                    <th scope="col">ID</th>
                                                    <th scope="col">Part Number</th>
                                                    <th scope="col">Part Name</th>
                                                    <th scope="col">Description</th>
                                                    <th scope="col">QTY</th>
                                                    <th scope="col">Amount</th>
                                                    <th scope="col">VAT</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                                @foreach($invoice as $row)


                                                    <tr class="data-row">
                                                        <td>{{$row['id']}}</td>
{{--                                                        part number should come here instead of id--}}

                                                        <td>{{$row->part->part_number}}</td>
                                                        <td>{{$row['part_name']}}</td>
                                                        <td>{{$row['part_des']}}</td>
                                                        <td>{{$row['part_qty']}}</td>
                                                        <td>{{$row['amount']}}</td>
                                                        <td>{{$row['vat']}}</td>
                                                        <td>
                                                            <a class="text-success mr-2" href="{{action('BikeinvoicesController@edit', $row['id'])}}">
                                                                <i class="nav-icon i-Pen-2 font-weight-bold"></i></a>
                                                            <a class="text-danger mr-2" id="btnsub" onclick="deleteData({{$row['id']}})" data-toggle="modal" data-target=".bd-example-modal-sm" >
                                                                <i class="nav-icon i-Close-Window font-weight-bold"></i></a>

                                                        </td>




                                                    </tr>
                                                @endforeach

                                                </tbody>
                                            </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!------------------------------Data Table Ends--------------------------------------------->






    <!---------Delete Model---------->
    <div class="modal fade bd-example-modal-sm" id="delteForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form action="" class="deleteForm" id="deleteForm" method="post">
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
                        <button class="btn btn-primary ml-2"  type="button" onclick="deleteSubmit()">Delete it</button>
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
                    {"targets": [0],"visible": false},
                    {"targets": [1],"width": "80%"}
                ],
                "scrollY": false,
            });
            $('#part_id').select2({
                placeholder: 'Select an option'
            });
        });


        function deleteData(id) {

            var id = id;
            var url = '{{ route('manage_purchase.destroy', ":id") }}';
            url = url.replace(':id', id);

            $("#deleteForm").attr('action', url);


        }


        function deleteSubmit()
        {

            $("#deleteForm").submit();
        }



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


