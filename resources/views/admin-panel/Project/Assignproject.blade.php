@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <style>
        .submit-btn {
    margin-top: 24px;
        }
    #datatable .table th, .table td{
        border-top : unset !important;
    }
    .table th, .table td{
        padding: 0px !important;
    }
    .table th{
        padding: 2px;
        font-size: 14px;
    }
    .table td{
        /*padding: 2px;*/
        font-size: 14px;
    }
    .table th{
        padding: 2px;
        font-size: 14px;
        font-weight: 600;
    }

    /* #nation_id{
    height: 25px;
    width: 100px;
    } */
    #nation_id{
  font-size: 11px;
  height: 25px;
    width: 100%;
}



    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Masters</a></li>
            <li>Assign Project</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                {{-- <div class="card-body"> --}}
                    {{-- <div class="card-title mb-3">Invoice</div>
                    <form method="post" enctype="multipart/form-data" action="{{isset($projects_data)?route('project_invoice.update',$projects_data->id):route('project_invoice.store')}}">
                        {!! csrf_field() !!}
                        @if(isset($projects_data))
                            {{ method_field('PUT') }}
                        @endif
                        <input type="hidden" id="id" name="id" value="{{isset($projects_data)?$projects_data->id:""}}">

                        <div class="row">

                            <div class="col-md-4 form-group mb-1">
                                <label for="repair_category">Invoice Number</label>
                                <input class="form-control" id="part_number"
                                 name="invoice_number" value="{{isset($projects_data)?$projects_data->project_name:""}}" type="text"
                                 placeholder="Enter the part number" required />
                            </div>

                            <div class="col-md-4 form-group mb-1">
                                <label for="repair_category">Invoice Image</label>
                                <input class="form-control" id="part_number"
                                 name="image" value="{{isset($projects_data)?$projects_data->project_name:""}}" type="file"
                                 placeholder="Enter the part number" required />
                            </div>

                            <div class="col-md-4 form-group mb-1">
                                <label for="repair_category">Person Name</label>
                                <input class="form-control" id="part_number"
                                 name="person_name" value="{{isset($projects_data)?$projects_data->project_name:""}}" type="text"
                                 placeholder="Enter the part number" required />
                            </div> --}}

                            {{-- <div class="col-md-4  mb-3">
                                <label for="repair_category">Project Id</label>
                                <select id="nation_id" name="project_name" class="form-control" required>
                                    <option value=""  >Select option</option>
                                    @foreach($project as $pro)
                                    @php
                                    $isSelected=(isset($projects_data)?$projects_data->company:"")==$pro->id;
                                @endphp
                                        <option value="{{ $pro->id }}" {{ $isSelected ? 'selected': '' }}>{{ $pro->project_name  }}</option>
                                    @endforeach
                                </select>
                            </div> --}}

                            {{-- <div class="col-md-4 form-group mb-1">
                                <label for="repair_category">Amount</label>
                                <input class="form-control" id="part_number"
                                 name="amount" value="{{isset($projects_data)?$projects_data->project_name:""}}" type="text"
                                 placeholder="Enter the part number" required />
                            </div>

                            <div class="col-md-4 form-group mb-1"><br>
                                <input type="radio" id="cash" name="cash_credit" value="1">
                                <label for="cash">Cash</label>
                                <input type="radio" id="credit" name="cash_credit" value="2">
                                <label for="credit">Credit</label>
                            </div>

                            <div class="col-md-4 form-group mb-1">
                                 <button class="btn btn-primary submit-btn">@if(isset($projects_data)) Edit @else Create  @endif Part</button>
                            </div>
                        </div> --}}



                        {{-- <div class="row">
                            <div class="col-md-12 form-group mb-3">

                            </div>
                            <div class="col-md-12 form-group mb-3">

                            </div>
                            <div class="col-md-12">

                            </div>
                        </div> --}}
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-12 loading_msg" style="display: none">
        <div class="row">
            <div class="col-sm-4">
            </div>
            <div class="col-sm-4">
                <div class="loader-bubble loader-bubble-primary m-5"></div>
                <div class="loader-bubble loader-bubble-danger m-5" ></div>
                <div class="loader-bubble loader-bubble-success m-5" ></div>
            </div>
            <div class="col-sm-4">
            </div>
        </div>
    </div>

    <div class="col-md-12 mb-3">
    <div class="col-md-12 mb-3">
        <div class="card text-left">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="display table table-striped table-bordered" id="datatable">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">INV Id</th>
                            <th scope="col">Invoice Number</th>
                            <th scope="col">Person Name</th>
                            <th scope="col">Cash Credit</th>
                            <th scope="col">Amount</th>
                            {{-- <th scope="col">Project</th> --}}
                            <th scope="col">Invoice</th>
                            <th scope="col">Project Name</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($invoice as $row)
                            <tr>

                                <th scope="row">1</th>
                                <td>{{$row->inv_no}}</td>
                                <td>{{$row->invoice_number}}</td>
                                <td>{{$row->names->personal_info->full_name}}</td>
                                <td>{{$row->cash_credit}}</td>
                                <td>{{$row->amount}}</td>
                                {{-- <td>{{$row->project_id}}</td> --}}

                                <td >  <a class="attachment_display" href="{{ isset($row->invoice_image) ? url($row->invoice_image) : '#'  }}" id="passport_image" target="_blank"><strong style="color: blue">View Invoice</strong></a></td>
                                <td>

                                    <form method="post" enctype="multipart/form-data" action="{{route('project_invoice.update',$row->id)}}">
                                        {!! csrf_field() !!}
                                            {{ method_field('PUT') }}
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <select id="nation_id" name="project_name" class="form-control" required>
                                                        <option value=""  >Select option</option>
                                                        @foreach($project as $pro)
                                                        @php
                                                        $isSelected=(isset($row)?$row->company:"")==$pro->id;
                                                    @endphp
                                                            <option value="{{ $pro->id }}" {{ $isSelected ? 'selected': '' }}>{{ $pro->project_name  }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-4">
                                                    <button class="btn btn-primary " style=" font-size: 11px;height: 25px;width: 60px;"> Update</button>
                                                </div>
                                            </div>
                                    </form>

                                    </td>

                                {{-- <td>
                                    <a class="text-success mr-2" href="{{route('project.edit',$row->id)}}"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a> --}}
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>



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
                    {"targets": [1][2],"width": "40%"}
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
