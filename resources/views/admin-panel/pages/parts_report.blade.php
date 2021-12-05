@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
@endsection
@section('content')


    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Reports</a></li>
            <li>Part Detail</li>
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
                            <form method="post" enctype="multipart/form-data" action="{{url('search_part_report')}}">
                                {{csrf_field()}}
                                {{ method_field('POST') }}
                                <label for="repair_category">Part Name</label>
                                <div class="input-group mb-3">

                                    <select id="part_name" name="part_name" class="form-control form-control-rounded">
                                        <option value="">
                                            Select the Part Name
                                        </option>
                                        @foreach($parts as $part)
                                            @php
                                                $isSelected=(isset($part)?$part->part_add_name:"")==$part->id;
                                            @endphp
                                            <option value="{{$part->part_name}}" {{ $isSelected ? 'selected': '' }}>{{$part->part_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <label for="repair_category">Select Date</label>
                                <div class="input-group mb-3">

                                    <div class="custom-file">

                                        <input class="form-control" placeholder="Enter Date" required id="search_date" name="search_date" type="Date" />

                                    </div>
                                </div>
                                <div class="input-group-append"><button class="btn btn-primary">Search<span class="fa fa-upload fa-right"></span></button></div>


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
                                <th scope="col">Part Name</th>
                                <th scope="col">Part Number</th>
{{--                                <th scope="col">Invoice Number</th>--}}
{{--                                <th scope="col">Date</th>--}}
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($result))



                                @foreach($result as $row)
                        <div style="display: none">
                                    {{$created_at=$row->created_at }}
                        </div>
                                    <tr>

                                        <td> {{$row->part_name}}</td>
                                        <td>{{$row->part_number}}</td>
{{--                                        <td>{{$row->part_invoice}}</td>--}}
{{--                                        <td>{{$created_at}}</td>--}}


                                    </tr>
                                @endforeach
                            @endif

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

                    {"targets": [1],"width": "80%"}
                ],
                dom: 'Bfrtip',
                buttons: [
                    'csv', 'excel', 'pdf', 'print'

                ],
                "scrollY": false,
            });
            $('#part_id').select2({
                placeholder: 'Select an option'
            });

        });




        // $("#pop").on("click", function() {
        //     $('#imagepreview').attr('src', $('#imageresource').attr('src'));
        //     // here asign the image to the modal when the user click the enlarge link
        //     $('#imagemodal').modal('show');
        //     // imagemodal is the id attribute assigned to the bootstrap modal, then i use the show function
        // });




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

