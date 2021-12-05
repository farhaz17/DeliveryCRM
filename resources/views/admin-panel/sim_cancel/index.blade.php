@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <style>

    /* loading image css starts */
        .overlay{
            display: none;
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 999;
            background: rgba(255,255,255,0.8) url("{{ asset('assets/loader/loader_report.gif') }}") center no-repeat;
        }

        /* Turn off scrollbar when body element has the loading class */
        body.loading{
            overflow: hidden;
        }
        /* Make spinner image visible when body element has the loading class */
        body.loading .overlay{
            display: block;
        }
    /* loading image css ends */
    </style>
@endsection
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/user-dashboard-new') }}">All Modules</a></li>
            <li class="breadcrumb-item active text-danger" aria-current="page">All Cancel Sim</li>
        </ol>
    </nav>
    <div class="separator-breadcrumb border-top"></div>





    {{--------------------detail  model-----------------}}
    <div class="modal fade bd-example-modal-lg" id="detail_modal"   tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="post" id="checkout_form_for_bike" action="{{ route('update_cancel_status') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title text-danger" id="exampleModalCenterTitle">Remove From Canceled Status</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">

                        <div class="append_div">
                        </div>

                    </div>
                    <input type="hidden" name="primary_id" id="primary_id">
                    <input type="hidden" name="request_type" id="request_type">
                    <input type="hidden" name="rejected_btn_counts" id="rejected_btn_counts" value="0">
                    <div class="modal-footer" style="display: flow-root;">
                        <input type="submit" id="form_submit_button" style="display: none;">
                        <button class="btn btn-secondary " type="button" data-dismiss="modal">Close</button>
                        {{-- <button class="btn btn-danger float-right ml-2" id="reject_btn" type="button">Reject</button> --}}
                        <button class="btn btn-success float-right ml-2"  id="accept_btn" type="button">Removed From Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{--------------------deail model ends here-----------------}}




    <div class="col-md-12 mb-3">
        <div class="card text-left">
            <div class="card-body">




                        <div class="table-responsive">
                            <table class="display table table-striped table-bordered table-sm text-10" id="datatable_not_employee">
                                <thead >
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Sim Number</th>
                                    <th scope="col">Cancel Type</th>
                                    <th scope="col">Remarks</th>
                                    <th scope="col">Cancel Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($cancel_sims as $sim)
                                        <tr>
                                            <td>{{ $sim->id }}</td>
                                            <td>{{ $sim->sim_detail->account_number }}</td>
                                            <td>{{ $checkout_type_array[$sim->reason_type] }}</td>
                                            <td>{{ $sim->remarks }}</td>
                                            <td>{{ $sim->created_at->toDateString() }}</td>
                                            <td>
                                                <a class="text-primary mr-2 edit_btn" id="{{$sim->id}}"><i class="nav-icon i-Pen-4 font-weight-bold"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>

               </div>
            <div class="overlay"></div>
        </div>
    </div>

@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>





    <script>
        $('body').on('click','.edit_btn',function () {


            var ids = $(this).attr('id');

            $("#primary_id").val(ids);

            $.ajax({
                url: "{{ route('ajax_cancel_sim_detail') }}",
                method: 'get',
                data: {id_primary: ids},
                success: function(response) {
                    $(".append_div").empty();
                    $(".append_div").append(response.html);
                    $("#detail_modal").modal('show');
                }
            });


        });



        $("#accept_btn").click(function(){
            $("#request_type").val("1");
            $("#checkout_form_for_bike").submit();
        });



        $("#checkout_form_for_bike").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
            $('#phone').keydown();

            var url = $("#checkout_form_for_bike").attr('action');



            $("body").addClass("loading");
            $.ajax({
                url: url,
                type: "POST",
                data: new FormData(this),
                cache: false,
                contentType: false,
                processData: false,
                success: function(response)
                {
                    $("body").removeClass("loading");
                    if($.trim(response)=="success"){
                        tostr_display("success","Status Has been changed Successfully");
                        window.setTimeout(function(){
                            location.reload(true)
                        },1000);

                    }else{
                        tostr_display("error",response);
                        // alert(response);
                    }
                    // alert("form_submitted"); // show response from the php script.
                }
            });
        });



    </script>

    <script>
        $(document).ready(function () {
            'use-strict'

            $('#datatable_not_employee').DataTable( {

                "aaSorting": [],
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [0],"visible": false},

                ],

                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'On Boarding',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                    'pageLength',
                ],

                // scrollY: 300,
                responsive: true,
                // scrollX: true,
                // scroller: true
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

    <script>
        function tostr_display(type,message){


            switch(type){
                case 'info':
                    toastr.info(message);
                    break;
                case 'warning':
                    toastr.warning(message);
                    break;
                case 'success':
                    toastr.success(message);
                    break;
                case 'error':
                    toastr.error(message);
                    break;
            }

        }
    </script>


    <script>
        // Add remove loading class on body element depending on Ajax request status
        $(document).on({
            ajaxStart: function(){
                $("body").addClass("loading");
            },
            ajaxStop: function(){
                $("body").removeClass("loading");
            }
        });
    </script>






@endsection
