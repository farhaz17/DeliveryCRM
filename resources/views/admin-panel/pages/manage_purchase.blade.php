@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
@endsection
@section('content')


    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Operations</a></li>
            <li>Manage Invoice</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>

    <div class="row">
        <div class="col-md-12">

            <div class="card mb-4">
                <div class="card-body">



                    <!----------------------------------------------------Upload file ------------------------------------------------------------------>
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">Image Upload</div>

                            <form  action="{{isset($result)?action('ManagepurchaseController@update',$result->id):route('image.upload')}}" aria-label="{{ __('Upload') }}" method="post"  enctype="multipart/form-data">
{{--                            <form   action="{{ route('image.upload') }}" aria-label="{{ __('Upload') }}" method="post"  enctype="multipart/form-data">--}}

                            {!! csrf_field() !!}
                                @if(isset($result))
                                    {{ method_field('PUT') }}
                                @endif
                                @if(isset($result))
                                <div class="input-group mb-3">
                                    <div class="custom-file">
                                        <input class="custom-file-input" id="inputGroupFile02" name="image_name" type="file" />
                                        <label class="custom-file-label" for="inputGroupFile02"  aria-describedby="inputGroupFileAddon02">Choose Image</label>
                                    </div>
                                </div>
                                @endif
                                @if(!isset($result))
                                    <div class="input-group mb-3">
                                        <div class="custom-file">
                                            <input class="custom-file-input" required id="inputGroupFile02" name="image_name" type="file" />
                                            <label class="custom-file-label" for="inputGroupFile02"  aria-describedby="inputGroupFileAddon02">Choose Image</label>
                                        </div>
                                    </div>
                                @endif
                                <label for="repair_category">Vendor Name</label>
                                <div class="input-group mb-3">

                                    <div class="custom-file">

                                        <input class="form-control"  value="{{isset($result)?$result->vendor_name:""}}" placeholder="Enter Vendor Name" required id="vendor_name" name="vendor_name" type="text" />

                                    </div>
                                </div>
                                <label for="repair_category">Invoice Number</label>
                                <div class="input-group mb-3">

                                    <div class="custom-file">
                                        <input class="form-control" value="{{isset($result)?$result->invoice_number:""}}" placeholder="Enter Invoice Number" required id="invoice_number" name="invoice_number" type="text" />
                                    </div>
                                </div>
                                <div class="input-group-append"><button class="btn btn-primary">Save<span class="fa fa-upload fa-right"></span></button></div>


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
                                <th scope="col">Image</th>
                                <th scope="col">Vendor Name</th>
                                <th scope="col">Date Upload</th>
                                <th scope="col">Invoice Number</th>
                                <th scope="col">Return Purchase</th>
                                <th scope="col">Action</th>
                                <th scope="col"></th>


                            </tr>
                            </thead>
                            <tbody>
                            @foreach($manage_purchase as $row)

                                <tr class="data-row">

                                    <td>{{$row['id']}}</td>
                                    <td>
                                        <a href="{{$row['image_path']}}" target="_blank">
                                            <span class="badge badge-pill badge-outline-secondary p-2 m-1">View</span>
                                        </a>
                                    </td>
                                    <td>{{$row['vendor_name']}}</td>
                                    <td>{{$row['upload_date']}}</td>
                                    <td>{{$row['invoice_number']}}</td>

                                    <td>
                                        <form method="post" id="myForm" action="{{url('return_purchase_index')}}">
                                        {!! csrf_field() !!}
                                        {{ method_field('POST') }}


                                        <input type="hidden" name="invoice" value="{{$row['invoice_number']}}">

                                        <button class="text-danger mr-2"    type="submit" >

                                            <span class="badge badge-pill badge-primary p-2 m-1">Return</span>
                                        </button>
                                        </form>

{{--                                        <a href="{{route('return_purchase',$row['id'])}}">--}}
{{--                                            <span class="badge badge-pill badge-primary p-2 m-1">Return</span>--}}
{{--                                        </a>--}}
                                    </td>
                                    <td>
                                        <a class="text-success mr-2"  href="{{route('manage_purchase.show',$row['id'])}}">
                                            <i class="nav-icon i-Pen-2 font-weight-bold"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a class="text-success mr-2"  href="{{route('manage_purchase.edit',$row['id'])}}">
                                            <i class="nav-icon i-Add-Window font-weight-bold"></i>
                                        </a>
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



    <!---------image model---------------->
    <div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>

                </div>
                <div class="modal-body">
                    <img src="" id="imagepreview" style="width: 800px; height: 650px;" >
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!------------image model ends------------------------->



    <!-----------------------Edit Model Ends------------------>



@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            'use strict';
            $('#datatable').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [0],"visible": false},
                    // {"targets": [1],"width": "80%"}
                ],
                "scrollY": false,
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


@endsection

