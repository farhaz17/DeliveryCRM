@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">

    <style>
        .fc .fc-col-header-cell-cushion {
            display: inline-block !important;
            padding: 2px 4px !important;
        }
        .fc .fc-col-header-cell-cushion {
            padding-top: 5px;
            padding-bottom: 5px;
        }

        .fc-day .fc-widget-content  {
            height: 2.5em !important;
        }
        .fc-agendaWeek-view tr {
            height: 40px !important;
        }

        .fc-agendaDay-view tr {
            height: 40px !important;
        }
        .fc-agenda-slots td div {
            height: 40px !important;
        }
        .fc-event-vert {
            min-height: 25px;
        }
        .calendar-parent {
            height: 100vh;
        }

        .fc-toolbar {
            padding: 15px 20px 10px;
        }
        .fc-title{
            color :white;
        }
        .fc-rigid{
            height: 70px !important;;
        }

        .table th, .table td{
        padding: 0px !important;
    }
    .table th{
        padding: 2px;
        font-size: 12px;
    }
    .table td{
        padding: 2px;
        font-size: 12px;
    }
    .table th{
        padding: 2px;
        font-size: 12px;
        font-weight: 600;
    }
    .btn-view {
    padding: 2px;
            }

    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Upload SIM Bill Sheets</a></li>
            <li>Upload Forms</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row pb-2" >
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <a href="{{ asset('assets/sample/simbill/1607340117_1.xls') }}" download target="_blank">(Download Sample File)</a>
                    </div>

                    @if(isset($salik_last_date->start_date))
                        <h5 class="text-center mb-3 font-weight-bold" id="div_complete">Last Uploaded Sheet Dates: <span class="text-success" id="start_date_div" >{{ $salik_last_date->start_date }}</span> <span id="div_to">TO</span> <span class="text-success" id="end_date_div">{{ $salik_last_date->end_date }}</span>
                            <br>
                            Company name: <span class="text-primary" id="company_name_div">{{ isset($salik_last_date->get_company_info->company_detail->name) ? $salik_last_date->get_company_info->company_detail->name : 'N/A' }}</span>
                        </h5>
                    @else
                        <h5 class="text-center mb-3 font-weight-bold" style="display: none;"  id="div_complete" >
                            Company name: <span class="text-primary" id="company_name_div"></span>
                        </h5>
                    @endif



                    <form method="post" enctype="multipart/form-data" action="{{ route('sim_bill_upload.store') }}"  aria-label="{{ __('Upload') }}" >
                        {!! csrf_field() !!}



                        <div class="col-md-3 form-group"  style="float: left;" >
                            <label for="end_date">Browse File</label>
                            <input class="form-control" id="select_file" type="file" name="select_file" />
                        </div>


                        <div class="col-md-12 form-group mb-3 "  style="float: left;"  >
                            <input  class="btn btn-primary" type="submit" value="Upload">
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 mb-3">
            <div class=" text-left">
                <div class="card text-left">
                    <div class="card-body">
                        <div class="table-responsive">




                            <table class="display table table-striped table-bordered" id="datatable_not_employee">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Upload Date</th>
                                    <th scope="col">Total Amount Due</th>
                                    <th scope="col">Total Amount To Pay</th>
                                    <th scope="col">Total Count</th>
                                    <th scope="col">Uploaded File</th>
                                    <th scope="col">Uploaded File</th>
                                    <th scope="col">Revert/Delete</th>
                                </tr>
                                </thead>
                                <tbody>
                                        @foreach($uploads as $upload)
                                             <tr>
                                                 <td>{{ $upload->created_at->toDateString() }}</td>
                                                 <td>{{ $upload->total_amount_due() }}</td>
                                                 <td>{{ $upload->total_amount_to_pay() }}</td>
                                                 <td>{{ $upload->simbill_detail->count() }}</td>
                                                 <td>
                                                    <a class="btn btn-primary  text-white btn-view mr-2" target="_blank" href="{{route('sim_bill_upload.show',$upload->id)}}">
                                                        <i class="fa fa-Eye"></i> View
                                                    </a>
                                            </td>
                                                 <td>

                                                    <a href="{{Storage::temporaryUrl('assets/upload/excel_file/simbill_upload/'.$upload->file_path, now()->addMinutes(5))}}"
                                                          class="btn btn-info btn-view"  id="download-{{ $upload->id }}"  download  >

                                                          <i class="fa fa-Download"></i>  Download File</a>

                                                        </a>

                                                     {{-- <a href="{{ url($upload->file_path) }}"  class="font-weight-bold"    download  >download file</a></td> --}}
                                                     <td>
                                                        <a class="btn btn-danger text-white mr-2 btn-view" data-toggle="modal" onclick="deleteData({{$upload->id}})" data-target=".bd-example-modal-lg" >
                                                            <i class="fa fa-trash"></i>   Delete
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
    </div>


    {{--    <div class="row pb-2" >--}}
    {{--        <div class="col-md-12">--}}
    {{--            <div class="card">--}}
    {{--                <div class="card-body">--}}

    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}

    <div class="row pb-2" >
        <div class="col-md-12" id="render_calender">

        </div>
    </div>


      {{-- ------------------------------------------------------------- --}}

      <div class="row pb-2" >
        <div class="col-md-12">
            @if(Session::has('message'))
                <!-- Modal -->
                @php
                    $missing_sim = array_filter(explode(',',session()->get('missing_plate')));

                @endphp
                @if($missing_sim)
                <div class="modal fade" id="TalabatMissingRiderIdModal" tabindex="-1" role="dialog" aria-labelledby="ModalTitle" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h4 class="modal-title" id="ModalTitle">Upload Failed!</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                                <div class="alert alert-danger">
                                <p class="m-0 font-weight-bold"> These SIM numbers are not available in the system. Kindly add SIM numbers to upload bills</p>
                                </div>
                                <div class="responsive">
                                    <table class="table table-sm table-hover text-10" id="TalabatMissingRiderIddatatable" width='100%'>
                                        <thead>
                                            <tr>
                                                <td>#</td>
                                                <td>SIM No</td>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $count=1;
                                            @endphp
                                            @foreach ( $missing_sim as $key => $missing_sim)
                                                <tr>
                                                    <td>{{$count}}</td>
                                                    <td class='font-weight-bold'>{{$missing_sim}}</td>
                                                </tr>
                                                @php
                                                    $count++;
                                                @endphp
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

            @endif
            @endif

        </div>
    </div>


    {{-- --------------------------------------------------------- --}}

    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="" id="deleteForm" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle-1">Deletion Confirmation</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="alert alert-warning" role="alert">
                        <strong class="text-capitalize">Warning!</strong> File deleted once, uploaded data will be deleted permanently!.

                    </div>
                    <div class="modal-body">
                        {{csrf_field()}}
                        {{method_field('DELETE')}}
                      <strong>
                           <h5> Are you sure want to delete the?
                           </h5>
                      </strong>
                    </div>



                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-danger ml-2" type="submit" onclick="deleteSubmit()">Delete it</button>
                    </div>
                </form>
            </div>
        </div>
    </div>




@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

    <script>
        function deleteData(id)
                       {
                           var id = id;
                           var url = '{{ route('sim_bill_upload.destroy', ":id") }}';
                           url = url.replace(':id', id);
                           $("#deleteForm").attr('action', url);
                       }

                       function deleteSubmit()
                       {
                           $("#deleteForm").submit();
                           // alert('Deleted!!!111 Chal band kar');
                       }
   </script>

    <script>
        tail.DateTime("#start_date",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,

        }).on("change", function(){
            tail.DateTime("#end_date",{
                dateStart: $('#start_date').val(),
                dateFormat: "YYYY-mm-dd",
                timeFormat: false

            }).reload();

        });
    </script>
    <script type="text/javascript">
        @if(Session::has('message') && ($missing_sim))
            $(window).on('load', function() {
                $('#TalabatMissingRiderIdModal').modal('show');
                $('#TalabatMissingRiderIddatatable').DataTable( {
                    "aaSorting": [[0, 'asc']],
                    responsive: true,
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            extend: 'excel',
                            title: 'DC Riders',
                            text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=10px;>',
                            exportOptions: {
                                modifier: {
                                    page : 'all',
                                }
                            }
                        },
                    ],
                });
            });

        @endif
    </script>



    <script>
        $(document).ready(function () {
            'use strict';

            $('#datatable_not_employee').DataTable( {
                "aaSorting": [],
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [1],"width": "25%"}
                ],
                "scrollY": false,
            });

            $('#part_id').select2({
                placeholder: 'Select an option'
            });

            $('#account_number').select2({
                placeholder: 'Select an option'
            });


        });


        // function deleteData(id)
        // {
        //     var id = id;
        //     var url = '{{ route('inv_parts.destroy', ":id") }}';
        //     url = url.replace(':id', id);
        //     $("#deleteForm").attr('action', url);
        // }

        // function deleteSubmit()
        // {
        //     $("#deleteForm").submit();
        // }
        //-----------Download sample divs------------------
        $(document).ready(function() {
            $("#titles").hide();
            $(".sam").hide();
        });
        $('#form_type').change(function() {
            var id = ($('#form_type').val());
            $("#titles").show();
            $(".sam").hide();
            $("#"+id).show();


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



    <script>
        $("#platform_id").change(function (){

            var ids = $(this).val();

            $("#render_calender").html("");

            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('render_calender') }}",
                method: 'POST',
                data: {platform_id: ids ,_token:token},
                success: function(response) {
                    $("#render_calender").html(response);

                }
            });

        });
    </script>

    <script>
        $("#account_number").change(function () {

            var ids = $(this).val();

            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('ajax_company_name') }}",
                method: 'POST',
                data: {id: ids ,_token:token},
                success: function(response) {
                    var  array = JSON.parse(response);

                    $("#div_complete").show();
                    $("#company_name_div").html(array.name);
                    $("#start_date_div").html(array.start_date);
                    $("#end_date_div").html(array.end_date);
                }
            });

        });
    </script>





@endsection
