@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>
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
        div#missing_ids {
            height: 900px;
            max-height: 900px;
            overflow: hidden;
            overflow-x: hidden;
        }
        div#missing_ids:hover {
            height: 900px;
            max-height: 900px;
            overflow: scroll;
            overflow-x: hidden;
        }



    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Performance</a></li>
            <li>Upload Perfermance Sheet</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row pb-2" >
        <div class="col-md-10">
             <div class="row">
                 <div class="col-md-12">
                     <div class="card">
                         <div class="card-body">

                             {{--                    @foreach($result as $res)--}}

                             {{--                        <div class="card-title sam" style="display: none;" id="{{ $res->id}}"><a href="{{ URL::to( $res->sample_file)}}" target="_blank">(Download Sample File)</a></div>--}}

                             {{--                    @endforeach--}}

                             <form method="post" enctype="multipart/form-data" action="{{ url('/performance_upload') }}"  aria-label="{{ __('Upload') }}" >
                                 {!! csrf_field() !!}
                                 <div class="row">
                                     <div class="col-md-12 form-group mb-3">
                                         <div class="card-title">
                                             <a href="{{ URL::to("assets/sample/Performance_Sample/Deliveroo Performance.xlsx")}}" target="_blank">
                                                 (Download Sample File)
                                             </a>
                                         </div>
                                     </div>
                                     <div class="col-md-6 form-group mb-3">
                                         <label for="repair_category">Select Platform</label>
                                         <input type="text" name="platform_name" value="{{$platform_name}}" class="form-control" readonly>
                                         <input type="hidden" name="platform" value="{{$platform_id}}" class="form-control">
                                     </div>
                                     <div class="col-md-6   form-group mb-3">
                                         <label for="repair_category">Choose File</label>
                                         <input class="form-control" id="select_file" type="file" name="select_file" aria-describedby="inputGroupFileAddon01" />
                                     </div>
                                     <div class="col-md-6 form-group mb-3">
                                         <label for="repair_category">Date From</label>
                                         <input class="form-control" id="select_file" type="date" name="from" />
                                     </div>
                                     <div class="col-md-6 form-group mb-3">
                                         <label for="repair_category">Date To</label>
                                         <input class="form-control" id="select_file" type="date" name="to" />
                                     </div>
                                     <div class="col-md-12 input-group  form-group mb-3">
                                         <button class="btn btn-primary" type="submit">Upload</button>
                                     </div>
                                 </div>

                             </form>
                         </div>
                     </div>
                 </div>
                 <br><br>

                 <div class="col-md-12 mt-4">
                     <div class="card">
                         <div class="card-body">
                             {!! $calendar->calendar() !!}
                         </div>
                     </div>
                 </div>
             </div>

        </div>



        <div class="col-md-2" >
            <div class="card" id="missing_ids">
                <div class="card-body">
                    <h5 class="card-title">Missing Rider IDs</h5>
                    <ul class="list-group">
                    @if(isset($deliveroo))
                    @foreach($deliveroo as $del)
                        @if(!isset($del->platform_code->platform_code))
                                <li class="list-group-item font-weight-bold">{{$del->rider_id}}</li>
                            @endif
                        @endforeach
    @else
                            <h6 class="card-title">No Rider ID Missing</h6>
    @endif

                    </ul>
                </div>
            </div>
        </div>
    </div>







{{--    <div class="row pb-2" >--}}
{{--        <div class="col-md-12">--}}
{{--            <div class="card">--}}
{{--                <div class="card-body">--}}
{{--                    {!! $calendar->calendar() !!}--}}

{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}



@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>
    {!! $calendar->script() !!}


    <script>
        $(document).ready(function () {
            setTimeout( function(){
                $('.fc-rigid').css('height','70px !important');
                $('.fc-toolbar').css('height','70px !important');

                console.log("we are here");
            },1000);
        });
    </script>
    <script>
        $(document).ready(function () {
            'use strict';

            $('#datatable').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [0],"visible": false},
                    {"targets": [1][2],"width": "30%"}
                ],
                "scrollY": false,
            });

            $('#platform').select2({
                placeholder: 'Select an option'
            });



        });




        function deleteData(id)
        {
            var id = id;
            var url = '{{ route('inv_parts.destroy', ":id") }}';
            url = url.replace(':id', id);
            $("#deleteForm").attr('action', url);
        }

        function deleteSubmit()
        {
            $("#deleteForm").submit();
        }
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


@endsection
