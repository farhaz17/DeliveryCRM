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
        #datatable .table th, .table td{
        border-top : unset !important;
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
            <li><a href="">Upload Labour card print</a></li>
            <li>Upload Forms</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row pb-2" >
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <div class="card-title">
                        <a href="{{ asset('assets/sample/Fines_Sample/sample_ab_fine.xlsx') }}" download target="_blank">(Download Sample File)</a>
                    </div>

                    <form method="post" enctype="multipart/form-data" action="{{ route('labour_card_upload_store') }}"  aria-label="{{ __('Upload') }}" >
                        {!! csrf_field() !!}
                        <div class="col-md-12 form-group"  style="float: left;" >
                            
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
    @if (isset($message_code))
    <div class="row pb-2" >
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <div class="card-title">
                        <div class="alert alert-danger" role="alert"><strong class="text-capitalize">Error! Failed to Upload</strong> Following data is has not reached to <strong>Labour Card Print</strong> or visa process not started yet.

                        </div>
                    </div>


                    <table class="display table table-striped table-bordered table-sm text-10" id="datatable" >
                        <thead class="thead-dark">
                        <tr class="t-row">
                            <th scope="col">Passport No</th>
                            <th scope="col">PPUID</th>
                            <th scope="col">Name</th>

                        </tr>
                        </thead>
                        <tbody>
                        @foreach($gamer_array as $res)
                            <tr>
                                {{-- <td>{{$res['passport_id']}}</td> --}}
                                <td>{{$res['passport_no']}}</td>
                                <td>{{$res['ppuid']}}</td>
                                <td>{{$res['name']}}</td>
                                {{-- <td>{{$res['passport_no']}}</td>
                                <td>{{$res['ppuid']}}</td> --}}
                            </tr>
                        @endforeach


                </div>
            </div>
        </div>
    </div>

    @endif



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
                            var url = '{{ route('fine_uploads.destroy', ":id") }}';
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

{{-- <script type="text/javascript">
    @if(Session::has('message'))
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
</script> --}}

    <script>
        $(document).ready(function () {
            'use strict';

            $('#datatable').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'Not Completed Visa Process',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=10px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                ],

                "scrollY": false,
            });

            $('#part_id').select2({
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




@endsection
