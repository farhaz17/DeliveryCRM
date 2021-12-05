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
    </style>
@endsection
@section('content')
    <style>
        div.dataTables_wrapper div.dataTables_processing {

            position: fixed;
            top: 50%;
            -ms-transform: translateY(-50%);
            transform: translateY(-50%);
            /*top: 50%;*/
        }
        .highlight_cls{
            background-color: yellow;
        }
    </style>
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Accident and Vacation</a></li>
            <li>Riders</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>


    {{--    status update modal--}}
    <div class="modal fade bd-example-modal-sm " id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form method="post" id="form_onboard" action="{{ route('cods.store') }}">
                    {!! csrf_field() !!}
                    @method('PUT')

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Confirmation</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="primary_id" name="id" value="">
                        <div class="row">
                            <div class="col-md-12 form-group mb-3">
                                <h5>Send Him On Board.</h5>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 plaform_div_cls" >
                                <label for="repair_category">Platform</label>
                                <select class="form-control select multi-select" id="platform" name="platform[]" required multiple="multiple">
                                    @foreach($plateform as $plat)

                                        <option value="{{$plat->id}}">{{$plat->name}}</option>
                                    @endforeach
                                </select>
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

{{--    end modal--}}


    <div class="col-md-12 mb-3">
        <div class="card text-left">
            <div class="card-body">

                {{--accordian start--}}
                <div class="accordion" id="accordionRightIcon" style="margin-bottom: 10px;">
                    <div class="card">
                        <div class="card-header header-elements-inline">
                            <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0 "><a class="text-default collapsed collapse_cls_pending" data-toggle="collapse" href="#accordion-item-icons-1" aria-expanded="false"><span><i class="i-Filter-2 ul-accordion__font"> </i></span>Filter</a></h6>
                        </div>
                        <div class="collapse" id="accordion-item-icons-1" data-parent="#accordionRightIcon">
                            <div class="card-body">

                                <div class="col-md-3 form-group mb-3 " style="float: left;"  >
                                    <label for="start_date">Select Platform</label>
                                    <select  id="platform_id" name="platform_id" class="form-control form-control-plaintext" required >
                                        <option selected disabled >select option</option>
                                        <option value="0" >All</option>
                                        @foreach($plateform as $ab)
                                        <option value="{{ $ab->id }}">{{ $ab->name }}</option>
                                        @endforeach

                                    </select>

                                </div>

                                <div class="col-md-3 form-group mb-3 "  style="float: left;"  >
                                    <label for="end_date">Search</label>
                                    <select  id="is_expired" name="is_expired" class="form-control form-control-plaintext" >
                                        <option selected disabled >select option</option>
                                        <option value="0">All</option>
                                        <option value="1">Highlighted</option>
                                        <option value="2">Not Highlighted</option>


                                    </select>

                                </div>
                                <input type="hidden" name="table_name" id="table_name" value="datatable" >
                                <div class="col-md-3 form-group mb-3 "  style="float: left; margin-top: 20px;"  >
                                    <label for="end_date" style="visibility: hidden;">End Date</label>
                                    <button class="btn btn-info btn-icon m-1" id="apply_filter" data="datatable"  type="button"><span class="ul-btn__icon"><i class="i-Magnifi-Glass1"></i></span></button>
                                    <button class="btn btn-danger btn-icon m-1" id="remove_apply_filter" data="datatable"  type="button"><span class="ul-btn__icon"><i class="i-Close"></i></span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- accordian end here--}}

                <div class="table-responsive">
                    <table class="display table table-sm table-striped table-bordered" id="datatable_not_employee">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">ZDS Code</th>
                            <th scope="col">Personal Number</th>
                            <th scope="col">Passport Number</th>
                            <th scope="col">Expected Date</th>
                            <th scope="col">Type</th>
                            <th scope="col">checkout Time</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
                <div class="overlay"></div>
            </div>
        </div>

        @endsection
        @section('js')
            <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
            <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
            <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
            <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>


        <script>


            function render_table(platform,type_ab){
                $('#datatable_not_employee').DataTable().destroy();


                var table = $('#datatable_not_employee').DataTable({
                    "aaSorting": [[0, 'desc']],
                    "language": {
                        processing: "<img id='loader' src='{{ asset('assets/images/pre-load.gif') }}'>",
                    },
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            extend: 'excel',
                            title: 'vacation_accident_rider',
                            text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                            exportOptions: {
                                modifier: {
                                    page : 'all',
                                }
                            }
                        },
                        'pageLength',
                    ],

                    "pageLength": 10,
                    "scrollY": false,
                    "processing": true,
                    "serverSide": true,

                    ajax: "{{ route('vacation_accident_rider') }}?platform="+platform+"&type="+type_ab,
                    "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                        if ( aData['is_expire'] == "1" )
                        {
                            $('td', nRow).css('background-color', '#cccc51');
                        }

                    },
                    "deferRender": true,
                    columns: [
                        {data: 'name', name: 'name'},
                        {data: 'zds_code', name: 'zds_code'},
                        {data: 'personal_no', name: 'personal_no'},
                        {data: 'passport_no', name: 'passport_no'},
                        {data: 'expected_date', name: 'expected_date'},
                        {data: 'checkout_type', name: 'checkout_type'},
                        {data: 'created_at', name: 'created_at'},
                        {data: 'action', name: 'action', orderable: false, searchable: false},
                    ]

                });


            }
            </script>
            <script>
                $(document).ready(function () {



                    $('#platform_id').select2({
                        placeholder: 'Select an option'
                    });

                    $(function () {

                        var table = $('#datatable_not_employee').DataTable({
                            "aaSorting": [[0, 'desc']],
                            "language": {
                                processing: "<img id='loader' src='{{ asset('assets/images/pre-load.gif') }}'>",
                            },
                            dom: 'Bfrtip',
                            buttons: [
                                {
                                    extend: 'excel',
                                    title: 'vacation_accident_rider',
                                    text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                                    exportOptions: {
                                        modifier: {
                                            page : 'all',
                                        }
                                    }
                                },
                                'pageLength',
                            ],

                            "pageLength": 10,
                            "scrollY": false,
                            "processing": true,
                            "serverSide": true,

                            ajax: "{{ route('vacation_accident_rider') }}",
                            "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                                if ( aData['is_expire'] == "1" )
                                {
                                    $('td', nRow).css('background-color', '#cccc51');
                                }

                            },
                            "deferRender": true,
                            columns: [
                                {data: 'name', name: 'name'},
                                {data: 'zds_code', name: 'zds_code'},
                                {data: 'personal_no', name: 'personal_no'},
                                {data: 'passport_no', name: 'passport_no'},
                                {data: 'expected_date', name: 'expected_date'},
                                {data: 'checkout_type', name: 'checkout_type'},
                                {data: 'created_at', name: 'created_at'},
                                {data: 'action', name: 'action', orderable: false, searchable: false},
                            ]

                        });

                    });

                });

                $(document).ready(function () {
                    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                        var currentTab = $(e.target).attr('href'); // get current tab

                        var split_ab = currentTab.split('#');
                        // alert(split_ab[1]);

                        var table = $('#datatable_'+split_ab[1]).DataTable();
                        $('#container').css( 'display', 'block' );
                        table.columns.adjust().draw();
                    }) ;
                });
            </script>

            <script>
                $("#apply_filter").click(function () {
                    var  platform =  $("#platform_id option:selected").val();
                    var  is_expired = $("#is_expired option:selected").val();

                    render_table(platform,is_expired);

                });
            </script>


        <script>
            $(document).on('click','.edit_cls',function(){
                // $(".edit_cls").click(function(){
                var  ids  = $(this).attr('id');
                $("#primary_id").val(ids);
                $("#edit_modal").modal('show');

                $('#platform').select2({
                    placeholder: 'Select an option'
                });


                var url = "{{ route('onboard.update','1') }}";
                var gamer = url.split("onboard/");

               var final_url = gamer[0]+'onboard/'+ids;

               $("#form_onboard").attr('action',final_url);

               console.log(final_url);



            });
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
