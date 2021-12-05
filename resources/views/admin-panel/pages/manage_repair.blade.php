@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container {
            width: 100% !important;
            padding: 0;
        }
        .dataTables_scrollHeadInner {
            table-layout:fixed;
            width:100% !important;
        }
        div.dataTables_scrollHead table.dataTable {
            width:100% !important;
        }
    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Operation</a></li>
            <li>Manage Repair</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title mb-3">Manage Repair</div>
                    <form method="post" action="{{isset($manage_repair_data)?route('manage_repair.update',$manage_repair_data->id):route('manage_repair.store')}}">
                        {!! csrf_field() !!}
                        @if(isset($manage_repair_data))
                            {{ method_field('PUT') }}
                        @endif
                        <input type="hidden" id="id" name="id" value="{{isset($manage_repair_data)?$manage_repair_data->id:""}}">
                        <div class="row">
                            <div class="col-md-12 form-group mb-3">
                                <label for="repair_category">Plate Number</label>
                                <select id="chassis_no_id" name="chassis_no_id" class="form-control form-control-rounded">
                                    <option value="">Select Plate No</option>
                                    @foreach($bikes as $bike)
                                        @php
                                            $isSelected=(isset($manage_repair_data)?$manage_repair_data->chassis_no:"")==$bike->id;
                                        @endphp
                                        <option value="{{$bike->id}}" {{ $isSelected ? 'selected': '' }}>{{$bike->plate_no}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12 form-group mb-3">
                                <label for="repair_category">ZDS Code</label>
                                <input class="form-control form-control-rounded" id="zds_code" name="zds_code" value="{{isset($manage_repair_data)?$manage_repair_data->zds_code:""}}" type="text" placeholder="Enter the ZDS Code" required />
                            </div>
                            <div class="col-md-12 form-group mb-3">
                                <label for="repair_category">Name</label>
                                <input class="form-control form-control-rounded" id="name" name="name" value="{{isset($manage_repair_data)?$manage_repair_data->name:""}}" type="text" placeholder="Enter the name" required />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Current KM</label>
                                <input class="form-control form-control-rounded" id="ckm" name="ckm" value="{{isset($manage_repair_data)?$manage_repair_data->ckm:""}}" type="text" placeholder="Enter Current KM" required />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Next KM</label>
                                <input class="form-control form-control-rounded" id="nkm" name="nkm" value="{{isset($manage_repair_data)?$manage_repair_data->nkm:""}}" type="text" placeholder="Enter Next KM" required />
                            </div>
                            <div class="col-md-12 form-group mb-3">
                                <label for="repair_category">Discount</label>
                                <input class="form-control form-control-rounded" id="discount" name="discount" value="{{isset($manage_repair_data)?$manage_repair_data->discount:""}}" type="text" placeholder="Enter the discount amount"  />
                            </div>
                            <div class="col-md-12 form-group mb-3">
                                <label for="repair_category">Select the repair status</label>
                                <label class="radio radio-primary">
                                    <input type="radio" name="company" value="0" {{isset($manage_repair_data)?($manage_repair_data->company == '0')? 'checked' :"" :""}} /><span>Company</span><span class="checkmark"></span>
                                </label>
                                <label class="radio radio-primary">
                                    <input type="radio" name="company" value="1" {{isset($manage_repair_data)?($manage_repair_data->company == '1')? 'checked':"" :""}} /><span>Own</span><span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-12">
                                <button class="btn btn-primary">@if(isset($manage_repair_data)) Edit @else Create  @endif Manage Repair</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="col-md-12 mb-3">
        <div class="card text-left">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="datatable">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Chassis No</th>
                            <th scope="col">Plate No</th>
                            <th scope="col">ZDS Code</th>
                            <th scope="col">Name</th>
                            <th scope="col">Company/Own</th>
                            <th scope="col">Parts/Invoice</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($manage_repairs as $manage_repair)
                            <tr>
                                <th scope="row">1</th>
                                <td>{{$manage_repair->bike->chasis_no}}</td>
                                <td>{{$manage_repair->bike->plate_no}}</td>
                                <td>{{$manage_repair->zds_code}}</td>
                                <td>{{$manage_repair->name}}</td>
                                <td>{{($manage_repair->company == '0')?"Company":"Own"}}</td>
                                <td>
                                    <a class="text-success mr-2" href="{{route('manage_repair_parts.show',$manage_repair->id)}}"><i class="nav-icon i-Up font-weight-bold"></i></a>
                                    <a class="text-success mr-2" href="{{route('repair-invoice',$manage_repair->id)}}" target="_blank"><i class="nav-icon i-Book font-weight-bold"></i></a>
                                </td>
                                <td>
                                    <a class="text-success mr-2" href="{{route('manage_repair.edit',$manage_repair->id)}}"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a>
                                    {{--<a class="text-danger mr-2" data-toggle="modal" onclick="deleteData({{$manage_repair->id}})" data-target=".bd-example-modal-sm" ><i class="nav-icon i-Close-Window font-weight-bold"></i></a></td>--}}
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    //Add parts Model
    @if(isset($repairJob_id) || isset($manage_repair_part_data))
    <div class="modal fade bd-example-modal-lg" id="for_for_parts" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="post" id="PartsAddForm" action="{{isset($manage_repair_part_data)?route('manage_repair_parts.update',$manage_repair_part_data->id):route('manage_repair_parts.store')}}">
                    {!! csrf_field() !!}
                    @if(isset($manage_repair_part_data))
                        {{ method_field('PUT') }}
                    @endif
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Add Parts</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">


                        <input type="hidden" id="id" name="id" value="{{isset($manage_repair_part_data)?$manage_repair_part_data->id:""}}">
                        <input type="hidden" id="job_id" name="job_id" value="{{isset($manage_repair_part_data)?$manage_repair_part_data->repair_job_id:(isset($repairJob_id)?$repairJob_id:"")}}" >
                        <div class="row">
                            <div class="col-md-12 form-group mb-3">
                                <label for="repair_category">Repair Parts</label>
                                @if(isset($manage_repair_part_data))
                                    <input type="hidden" id="part_id" name="part_id" value="{{isset($manage_repair_part_data)?$manage_repair_part_data->part_id:""}}">
                                @endif
                                <select id="part_id" name="part_id" class="form-control form-control-rounded" {{isset($manage_repair_part_data)?'disabled':""}}>
                                    <option value="">Select Part Number</option>
                                    @foreach($parts as $part)
                                        @php
                                            $isSelected=(isset($manage_repair_part_data)?$manage_repair_part_data->part_id:"")==$part->id;
                                        @endphp
                                        <option value="{{$part->id}}" {{ $isSelected ? 'selected': '' }}>{{$part->part_number}}</option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="col-md-12 form-group mb-3">
                                <label for="repair_category">Quantity</label>
                                <input class="form-control form-control-rounded" id="quantity" name="quantity" value="{{isset($manage_repair_part_data)?$manage_repair_part_data->quantity:""}}" type="text" placeholder="Enter the quantity" required />
                            </div>
                        </div>


                    <div class="col-md-12 mb-3">
                        <div class="card text-left">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table" id="datatable2">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Part Number</th>
                                            <th scope="col">Quantity</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach($manage_repair_parts as $manage_repair_part)
                                            <tr>
                                                <th scope="row">1</th>
                                                <td>{{$manage_repair_part->part->part_number}}</td>
                                                <td>{{$manage_repair_part->quantity}}</td>
                                                <td>
                                                    <a class="text-success mr-2" href="{{route('manage_repair_parts.edit',$manage_repair_part->id)}}"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a>
                                                    <a class="text-danger mr-2" data-toggle="modal" onclick="deleteDataPart({{$manage_repair_part->id}})" data-target=".bd-example-modal-sm" ><i class="nav-icon i-Close-Window font-weight-bold"></i></a></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary ml-2" type="submit">Save changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    <div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
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
                        <button class="btn btn-primary ml-2" type="submit" onclick="deleteSubmit()">Delete it</button>
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
    <?php
    if(isset($repairJob_id) || isset($manage_repair_part_data)){ ?>
    <script>
        $(function(){
            $('#for_for_parts').modal('show');

        });
    </script>
    <?php
    }
    ?>
    <script>
        $(document).ready(function () {
            'use strict';

            $('#datatable').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [0],"visible": false},
                ],
                "scrollY": false,
            });

            $('#datatable2').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [0],"visible": false},
                ],
                "scrollY": false,
            });


            $('#chassis_no_id,#part_id').select2({
                placeholder: 'Select an option'
            });
            // $('#part_id').select2({
            //     placeholder: 'Select an option'
            // });

        });

        function deleteData(id)
        {
            var id = id;
            var url = '{{ route('manage_repair.destroy', ":id") }}';
            url = url.replace(':id', id);

            $("#deleteForm").attr('action', url);
        }

        function deleteDataPart(id)
        {
            var id = id;
            var url = '{{ route('manage_repair_parts.destroy', ":id") }}';
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


    {{--<script>--}}
        {{--@if(Session::has('message'))--}}
        {{--var type = "{{ Session::get('alert-type', 'info') }}";--}}
        {{--switch(type){--}}
            {{--case 'test':--}}
                {{--console.log({!! $id; !!});--}}
                {{--var id ={!! $id; !!}--}}

                {{--$("#job_id").val(id);--}}
                {{--$('#for_for_parts').modal('show');--}}
                {{--break;--}}


        {{--}--}}
        {{--@endif--}}
    {{--</script>--}}

@endsection
