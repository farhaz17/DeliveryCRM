@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <style>
        table#datatable {
            font-size: 13px;
        }
        tr.t-row {
            font-size: 12px;
            white-space: nowrap;
        }

        .chat-sidebar-container {
            height: auto;
            min-height: unset;
        }
        /*.chat-sidebar-container .chat-content-wrap .chat-content {*/
        /*    padding: 1.5rem 1.5rem 0;*/
        /*    position: relative;*/
        /*    bottom: 0px;*/
        /*    height: calc(100vh - 335px);*/
        /*}*/
    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Visa Process</a></li>
            <li>Visa Cancelation</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>

    <div class="col-md-12 mb-3">

        <div class="row">
            <div class="col-8">
                <div class="card text-left">
                    <div class="card-body">

                        <div class="card mb-4">
                            <div class="card-body">

                                <div class="ul-widget-app__browser-list-1 mb-4">
                                    <i class="i-Financial text-white purple-500 rounded-circle p-2 mr-3"></i>
                                    <span class="text-15">Passport No </span>
                                    <span class="cod-text">{{$result->passport->passport_no}}
                                    </span>
                                </div>


                                <div class="ul-widget-app__browser-list-1 mb-4">
                                    <i class="i-Financial text-white purple-500 rounded-circle p-2 mr-3"></i>
                                    <span class="text-15"> ZDS Code </span>
                                    <span class="cod-text">{{$result->passport->zds_code->zds_code}}
                                    </span>
                                </div>

                                <div class="ul-widget-app__browser-list-1 mb-4">
                                    <i class="i-Financial text-white purple-500 rounded-circle p-2 mr-3"></i>
                                    <span class="text-15"> Name</span>
                                    <span class="cod-text">{{$result->passport->personal_info->full_name}}
                                    </span>
                                </div>

                                <div class="ul-widget-app__browser-list-1 mb-4">
                                    <i class="i-Financial text-white purple-500 rounded-circle p-2 mr-3"></i>
                                    <span class="text-15"> Cancellation Type</span>
                                    <span class="cod-text">
                                        @if ($result->cancallation_type =='1')
                                            Resign
                                        @else
                                            Termination
                                        @endif
                                    </span>
                                </div>

                                <div class="ul-widget-app__browser-list-1 mb-4">
                                    <i class="i-Financial text-white purple-500 rounded-circle p-2 mr-3"></i>
                                    <span class="text-15">Resignation Type:</span>
                                    <span class="cod-text">

                                            @if ($result->resignation_type =='1')
                                            Instant
                                        @elseif($result->resignation_type =='2')
                                            Wait For Cancallation Until He Continues
                                        @else
                                            N/A
                                        @endif
                                    </span>
                                </div>

                                <div class="ul-widget-app__browser-list-1 mb-4">
                                    <i class="i-Financial text-white purple-500 rounded-circle p-2 mr-3"></i>
                                    <span class="text-15"> Remarks</span>
                                    <span class="cod-text">{{$result->remarks}}
                                    </span>
                                </div>
                                <div class="ul-widget-app__browser-list-1 mb-4">
                                    <i class="i-Financial text-white purple-500 rounded-circle p-2 mr-3"></i>
                                    <span class="text-15"> Date Untill He Works</span>
                                    <span class="cod-text">{{$result->date_until_works}}
                                    </span>
                                </div>

                                <div class="ul-widget-app__browser-list-1 mb-4">
                                    <i class="i-Financial text-white purple-500 rounded-circle p-2 mr-3"></i>
                                    <span class="text-15"> When To Start Cancellation:</span>
                                    <span class="cod-text">{{$result->start_cancel_date}}
                                    </span>
                                </div>
                                <div class="ul-widget-app__browser-list-1 mb-4">
                                    <i class="i-Financial text-white purple-500 rounded-circle p-2 mr-3"></i>
                                    <span class="text-15"> Added By:</span>
                                    <span class="cod-text">{{$result->user_name->name}}
                                    </span>
                                </div>

                                <div class="ul-widget-app__browser-list-1 mb-4">
                                    <i class="i-Financial text-white purple-500 rounded-circle p-2 mr-3"></i>
                                    <span class="text-15"> Cancellation Sheet:</span>
                                    <span class="cod-text">
                                        <a href="{{isset($result->upload_path)? url($result->upload_path):""}}"  target="_blank"><strong>View Cancellation Sheet</strong></a>
                                    </span>
                                </div>
                                <div class="ul-widget-app__browser-list-1 mb-4">
                                    <i class="i-Financial text-white purple-500 rounded-circle p-2 mr-3"></i>
                                    <span class="text-15"> Action:</span>
                                    <span class="cod-text">
                                    @foreach($clear_res as $clear)
                                            @if($major_dep_id=='1')
                                                @php
                                                    $clear_status = count($clear_res->where('cancallation_id',$result->id)->where('payroll_status','1'));
                                                @endphp
                                                @if($clear_status=='1')
                                                    <span class="badge badge-success">Cleared</span>
                                                @else
                                                    <input type="hidden" name="clearance_id" id="clearance_id" value="{{$result->id}}">
                                                    <input type="hidden" name="passport_id_id" id="passport_id" value="{{$result->passport_id}}">

                                                    <button  class="btn btn-warning btn-payroll font-weight-bold" type="button">Clear</button>
                                                @endif
                                            @elseif($major_dep_id=='3')
                                                @php
                                                    $clear_status = count($clear_res->where('cancallation_id',$result->id)->where('operation_status','1'));
                                                @endphp
                                                @if($clear_status=='1')
                                                    <span class="badge badge-success">Cleared</span>
                                                @else
                                                    <input type="hidden" name="clearance_id" id="clearance_id" value="{{$result->id}}">
                                                    <input type="hidden" name="passport_id_id" id="passport_id" value="{{$result->passport_id}}">

                                                    <button  class="btn btn-warning btn-payroll font-weight-bold" type="button">Clear</button>
                                                @endif
                                            @elseif($major_dep_id=='4')
                                                @php
                                                    $clear_status = count($clear_res->where('cancallation_id',$result->id)->where('maintenance_status','1'));
                                                @endphp
                                                @if($clear_status=='1')
                                                    <span class="badge badge-success">Cleared</span>
                                                @else
                                                    <input type="hidden" name="clearance_id" id="clearance_id" value="{{$result->id}}">
                                                    <input type="hidden" name="passport_id_id" id="passport_id" value="{{$result->passport_id}}">

                                                    <button  class="btn btn btn-warning  btn-sm btn-payroll font-weight-bold" type="button">Clear</button>
                                                @endif
                                            @elseif($major_dep_id=='6')
                                                @php
                                                    $clear_status = count($clear_res->where('cancallation_id',$result->id)->where('payroll_status','1')->where('maintenance_status','1')->where('operation_status','1')->where('admin_status','!=','1')->where('pro_status','!=','1'));
                                                    $clear_status2 = count($clear_res->where('cancallation_id',$result->id)->where('payroll_status','1')->where('maintenance_status','1')->where('operation_status','1')->where('admin_status','1')->where('pro_status','1'));
                                                @endphp
                                                @if($clear_status=='1')
                                                    <input type="hidden" name="clearance_id" id="clearance_id" value="{{$result->id}}">
                                                    <input type="hidden" name="passport_id_id" id="passport_id" value="{{$result->passport_id}}">
                                                    <button  class="btn btn btn-warning  btn-sm btn-payroll font-weight-bold" type="button">Clear</button>
                                                @elseif($clear_status2 =='1')

                                                    <span class="badge badge-success">Cleared</span>
                                                @else
                                                    @php
                                                        $payroll_status = count($clear_res->where('cancallation_id',$result->id)->where('payroll_status','1'));
                                                    @endphp

                                                    @if($payroll_status=='1')
                                                        <span> Payroll </span>
                                                        <i class="text-20 i-Yes text-success"></i>
                                                    @else
                                                        <span> Payroll </span>
                                                        <i class="text-20 i-Close-Window text-danger"></i>
                                                    @endif

                                                    <br>
                                                    @php
                                                        $maintenance_status = count($clear_res->where('cancallation_id',$result->id)->where('maintenance_status','1'));
                                                    @endphp
                                                    @if($maintenance_status=='1')
                                                        <span> Maintenance </span>
                                                        <i class="text-20 i-Yes text-success"></i>
                                                    @else
                                                        <span> Maintenance </span>
                                                        <i class="text-20 i-Close-Window text-danger"></i>
                                                    @endif
                                                    <br>
                                                    @php
                                                        $operation_status = count($clear_res->where('cancallation_id',$result->id)->where('operation_status','1'));
                                                    @endphp
                                                    @if($operation_status=='1')
                                                        <span> Opeations </span>
                                                        <i class="text-20 i-Yes text-success"></i>
                                                    @else
                                                        <span> Opeations </span>
                                                        <i class="text-20 i-Close-Window text-danger"></i>
                                                    @endif

                                                @endif
                                            @elseif($major_dep_id=='5')
                                                @php
                                                    $clear_status = count($clear_res->where('cancallation_id',$result->id)->where('payroll_status','1')->where('maintenance_status','1')->where('operation_status','1')->where('admin_status','1')->where('pro_status','!=','1'));
                                                    $clear_status2 = count($clear_res->where('cancallation_id',$result->id)->where('payroll_status','1')->where('maintenance_status','1')->where('operation_status','1')->where('admin_status','1')->where('pro_status','1'));
                                                @endphp
                                                @if($clear_status=='1')
                                                    <input type="hidden" name="clearance_id" id="clearance_id" value="{{$result->id}}">
                                                    <input type="hidden" name="passport_id_id" id="passport_id" value="{{$result->passport_id}}">
                                                    <button  class="btn btn-warning  btn-sm btn-pro font-weight-bold" type="button">Clear</button>
                                                @elseif($clear_status2 =='1')

                                                    <span class="badge badge-success">Cleared</span>
                                                @else

                                                    @php
                                                        $payroll_status = count($clear_res->where('cancallation_id',$result->id)->where('payroll_status','1'));
                                                    @endphp

                                                    @if($payroll_status=='1')
                                                        <span> Payroll </span>
                                                        <i class="text-20 i-Yes text-success"></i>
                                                    @else
                                                        <span> Payroll </span>
                                                        <i class="text-20 i-Close-Window text-danger"></i>
                                                    @endif

                                                    <br>
                                                    @php
                                                        $maintenance_status = count($clear_res->where('cancallation_id',$result->id)->where('maintenance_status','1'));
                                                    @endphp
                                                    @if($maintenance_status=='1')
                                                        <span> Maintenance </span>
                                                        <i class="text-20 i-Yes text-success"></i>
                                                    @else
                                                        <span> Maintenance </span>
                                                        <i class="text-20 i-Close-Window text-danger"></i>
                                                    @endif
                                                    <br>
                                                    @php
                                                        $operation_status = count($clear_res->where('cancallation_id',$result->id)->where('operation_status','1'));
                                                    @endphp
                                                    @if($operation_status=='1')
                                                        <span> Opeations </span>
                                                        <i class="text-20 i-Yes text-success"></i>
                                                    @else
                                                        <span> Opeations </span>
                                                        <i class="text-20 i-Close-Window text-danger"></i>
                                                    @endif
                                                    <br>
                                                    @php
                                                        $admin_status = count($clear_res->where('cancallation_id',$result->id)->where('admin_status','1'));
                                                    @endphp
                                                    @if($admin_status=='1')
                                                        <span> Admin </span>
                                                        <i class="text-20 i-Yes text-success"></i>
                                                    @else
                                                        <span> Admin </span>
                                                        <i class="text-20 i-Close-Window text-danger"></i>
                                                    @endif
                                                    <br>
                                                @endif
                                            @endif
                                        @endforeach
                                    </span>
                                </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                        </div>


            <div class="col-md-4">
                <div class="card-title mb-3">Public Chat</div>
                <div class="card chat-sidebar-container" data-sidebar-container="chat">
                    <div class="chat-content-wrap" data-sidebar-content="chat">
                        <div class="chat-content perfect-scrollbar" data-suppress-scroll-x="true">
                            <div id="bodyData">
                            </div>
                        </div>


                        <div class="pl-3 pr-3 pt-3 pb-3 box-shadow-1 chat-input-area">

                            <input type="hidden" id="user_id" name="user_id" value="{{auth()->user()->id}}" >

                            <div class="form-group">
                                            <textarea class="form-control form-control-rounded" id="chat_message"
                                                      name="chat_message" placeholder="Type your message" name="message" cols="30" rows="3"></textarea>
                            </div>

                            <div class="d-flex">
                                <div class="flex-grow-1"></div>
                                <button type="button" id="bike_handing_save" class="btn btn-icon btn-rounded btn-primary mr-2"><i class="i-Paper-Plane"></i>Send</button>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="modal fade bd-example-modal-sm-3" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog">
            <div class="modal-content">
                <form action="{{url('clear_dep_visa_req')}}" id="updateForm" method="post">

                    <input type="hidden" name="department_id" value="{{auth()->user()->id}}">
                    <input type="hidden" name="clear_id" id="clear_id" value="">
                    <input type="hidden" name="passport_id" id="pass_id" value="">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle-1">Visa Cancallation Confirm</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        {!! csrf_field() !!}
                        <textarea id="myTextarea" name="remarks" class="form-control" placeholder="Your remarks.." rows="4" cols="50"></textarea>

                        <p>Are you  sure to Clear?</p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary ml-2" type="submit">Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{--    pro--}}
    <div class="modal fade bd-example-modal-sm-4" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog">
            <div class="modal-content">
                <form action="{{url('clear_pro_visa')}}" id="updateForm" method="post">

                    <input type="hidden" name="department_id" value="{{auth()->user()->id}}">
                    <input type="hidden" name="clear_id" id="clear_id" value="">
                    <input type="hidden" name="passport_id" id="pass_id" value="">
                    <br>

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle-1">Visa Cancallation Confirm</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        {!! csrf_field() !!}

                        <select id="cancel_status"  name="cancel_status" class="form-control" required>
                            <option value="" selected disabled  >Select option</option>
                            @foreach($can_status as $can)
                                <option value="{{ $can->id }}">{{ $can->name  }}</option>
                            @endforeach
                        </select>
                        <br>

                        <p>Are you  sure to Clear?</p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary ml-2" type="submit">Yes</button>
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
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>


    <script>
        // bik_btn_cls
        $('#bike_handing_save').on('click', function() {
            // var token = $("input[name='_token']").val();
            var chat_message = $('#chat_message').val();
            var user_id = $('#user_id').val();
            $.ajax({
                url: "{{ route('visa_chat') }}",
                method: 'POST',
                data: {
                    "_token": "{{ csrf_token() }}",
                    chat_message: chat_message,
                    user_id: user_id,
                    cancel_id: <?php echo $result->id;?>,

                },
                success: function(response) {
                    if(response=="success"){
                        toastr.success("{{'Message sent successfully!'}}");
                        $('input[type="text"],textarea').val('');
                        $('.chat-content perfect-scrollbar').scrollTop($('.container')[0].scrollHeight);

                        $.ajax({
                            url: "{{ route('getMessageData') }}",
                            type: "POST",
                            data:{
                                _token:'{{ csrf_token() }}',
                                cancel_id: <?php echo $result->id;?>,
                            },
                            cache: false,
                            dataType: 'json',
                            async: true,
                            success: function (response) {
                                $('#bodyData').empty();
                                $('#bodyData').append(response.html);
                                $('.chat-content perfect-scrollbar').scrollTop($('.container')[0].scrollHeight);
                            }
                        });


                    }else{
                        toastr.error("{{'Error! Try Again'}}");
                    }
                }
            });
            //else finishing here
        });
    </script>



    <script>

        window.setInterval(function () {

            $.ajax({
                url: "{{ route('getMessageData') }}",
                type: "POST",
                data:{
                    _token:'{{ csrf_token() }}',
                    cancel_id: <?php echo $result->id;?>,
                },
                cache: false,
                dataType: 'json',
                async: true,
                success: function (response) {
                    $('#bodyData').empty();
                    $('#bodyData').append(response.html);
                    $('.chat-content perfect-scrollbar').scrollTop($('.container')[0].scrollHeight);
                }
            });
        },5000 );



        $(document).ready(function() {
            {{--var url = "{{URL('userData')}}";--}}

            $.ajax({
                url: "{{ route('getMessageData') }}",
                type: "POST",
                data:{
                    _token:'{{ csrf_token() }}',
                    cancel_id: <?php echo $result->id;?>,
                },
                cache: false,
                dataType: 'json',
                async: true,
                success: function (response) {
                    $('#bodyData').append(response.html);
                    $('.chat-content perfect-scrollbar').scrollTop($('.container')[0].scrollHeight);
                }
            });
        });


    </script>





    <script>
        $('.btn-payroll').on('click', function() {
            var passport_id = $('#passport_id').val();
            var clearance_id = $('#clearance_id').val();
            $('input[name="clear_id"]').val(clearance_id);
            $('input[name="passport_id"]').val(passport_id);
            $(".bd-example-modal-sm-3").modal('show')
        });
        $('.btn-pro').on('click', function() {
            var passport_id = $('#passport_id').val();
            var clearance_id = $('#clearance_id').val();
            $('input[name="clear_id"]').val(clearance_id);
            $('input[name="passport_id"]').val(passport_id);
            $(".bd-example-modal-sm-4").modal('show')
        });



        function approve(id)
        {
            var id = id;
            var url = '{{ route('cancal_approve_update', ":id") }}';
            url = url.replace(':id', id);

            $("#updateForm").attr('action', url);
        }

        function start_Submit()
        {
            $("#updateForm").submit();

        }
    </script>
    <script>
        $(document).ready(function () {
            'use strict';

            $('#datatable').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [0],"visible": true},
                    {"targets": [1][2],"width": "40%"}
                ],
                "scrollY": false,
            });

        });

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



    {{--    <script>--}}
    {{--        $(document).ready(function() {--}}
    {{--            --}}{{--var url = "{{URL('userData')}}";--}}
    {{--            $.ajax({--}}
    {{--                url: "{{ route('getMessageData') }}",--}}
    {{--                type: "POST",--}}
    {{--                data:{--}}
    {{--                    _token:'{{ csrf_token() }}'--}}
    {{--                },--}}
    {{--                cache: false,--}}
    {{--                dataType: 'json',--}}
    {{--                success: function(dataResult){--}}
    {{--                    console.log(dataResult);--}}
    {{--                    var resultData = dataResult.data;--}}
    {{--                    var bodyData = '';--}}
    {{--                    var len = 0;--}}

    {{--                    $.each(resultData,function(index,row){--}}
    {{--                        bodyData+=" <div class=\"d-flex mb-4\">"--}}
    {{--                        bodyData+="<div class=\"message flex-grow-1\">"--}}
    {{--                        bodyData+="<div class=\"d-flex\">"--}}
    {{--                        bodyData+="<p class=\"mb-1 text-title text-16 flex-grow-1\">"--}}
    {{--                        bodyData+="</p><span class=\"text-small text-muted\">"+row.chat_message+"</span>"--}}
    {{--                        bodyData+="</div>"--}}
    {{--                        bodyData+="<p class=\"m-0\"></p>"--}}
    {{--                        bodyData+="</div>"--}}
    {{--                        bodyData+="</div>"--}}
    {{--                    })--}}

    {{--                    $("#bodyData").append(bodyData);--}}
    {{--                }--}}
    {{--            });--}}
    {{--        });--}}
    {{--    </script>--}}


@endsection

