@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        i.nav-icon.i-Pen-2.font-weight-bold {
            color: #1b1bff;
        }
        i.nav-icon.i-Brush.font-weight-bold {
            color: red;
        }
    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Report</a></li>
            <li>Assigning Report</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>

    {{--    agrement history Modal--}}
    <div class="modal fade " id="history_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle-1">Agreement History</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body text-center" id="history_modal_body">


                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    {{--    agrement history Modal end--}}




    <div class="col-md-12 mb-3">
        <div class="card text-left">
            <div class="card-body">

                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item"><a class="nav-link active" id="home-basic-tab" data-toggle="tab" href="#homeBasic" role="tab" aria-controls="homeBasic" aria-selected="true">All</a></li>
                    <li class="nav-item"><a class="nav-link" id="profile-basic-tab" data-toggle="tab" href="#profileBasic" role="tab" aria-controls="profileBasic" aria-selected="false">Labour Card Employee</a></li>
                    <li class="nav-item"><a class="nav-link" id="agreement-tab" data-toggle="tab" href="#agreementBasic" role="tab" aria-controls="profileBasic" aria-selected="false">Agreement</a></li>
                </ul>
                <div class="tab-content" id="myTabContent">



                    <div class="tab-pane fade show active" id="homeBasic" role="tabpanel" aria-labelledby="home-basic-tab">

                        <div class="row form-group mb-6">
                            @foreach($company as $com)

                                <div class="col-md-4 text-left ">
                                <div class="form-check-inline">
                                    <label class="radio radio-outline-primary">
                                        <input type="radio" class="company_cls"  value="{{$com->id}}" name="company_name"><span>{{$com->name}} ({{ isset($com->offer_letters) ? count($com->offer_letters) : '0' }}) </span><span class="checkmark"></span>
                                    </label>
                                </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="table2">
                        <table class="table" id="datatable" >
                            <thead class="thead-dark">
                            <tr>

                                <th scope="col">Name</th>
                                <th scope="col">Passport Number</th>
                                <th scope="col">ZDS Code</th>
                                <th scope="col">PPUID</th>
                                <th scope="col">Personal Number</th>
                                <th scope="col">SIM Number</th>
                                <th scope="col">Bike Plate Number</th>
                                <th scope="col">Platform</th>
                                <th scope="col">Emirates ID</th>
                                <th scope="col">Driving License</th>
                                <th scope="col">Labour Card No.</th>
                                <th scope="col">Verifing Status</th>
                                <th scope="col">Agreement</th>

                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="profileBasic" role="tabpanel" aria-labelledby="profile-basic-tab">
                        <div class="row form-group mb-6">
                            @foreach($labour_wise_company as $com)

                                <div class="col-md-4 text-left ">
                                    <div class="form-check-inline">
                                        <label class="radio radio-outline-primary">
                                            <input type="radio" class="labour_company_cls" value="{{$com['id'] }}" name="labour_company_name"><span>{{$com['name']}} ({{ isset($com['total']) ? $com['total'] : '0' }}) </span><span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="table2">
                            <table class="table" id="labour_datatable" >
                                <thead class="thead-dark">
                                <tr>

                                    <th scope="col">Name</th>
                                    <th scope="col">Passport Number</th>
                                    <th scope="col">ZDS Code</th>
                                    <th scope="col">PPUID</th>
                                    <th scope="col">Personal Number</th>
                                    <th scope="col">SIM Number</th>
                                    <th scope="col">Bike Plate Number</th>
                                    <th scope="col">Platform</th>
                                    <th scope="col">Emirates ID</th>
                                    <th scope="col">Driving License</th>
                                    <th scope="col">Labour Card No.</th>
                                    <th scope="col">Verifing Status</th>
                                    <th scope="col">Agreement</th>

                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="agreementBasic" role="tabpanel" aria-labelledby="agreement-tab">
                        <div class="row">
                            <div class="col-md-12 text-center">

                                <div class="form-check-inline">
                                    <label class="radio radio-outline-success">
                                        <input type="radio" class="employee_type_cls"  checked value="1" name="employee_type_name"><span>Not Employee</span><span class="checkmark"></span>
                                    </label>
                                </div>

                                <div class="form-check-inline">
                                    <label class="radio radio-outline-primary">
                                        <input type="radio" class="employee_type_cls"  value="2" name="employee_type_name"><span>Full Time</span><span class="checkmark"></span>
                                    </label>
                                </div>
                                <div class="form-check-inline">
                                    <label class="radio radio-outline-success">
                                        <input type="radio" class="employee_type_cls"  value="3" name="employee_type_name"><span>Part Time</span><span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row form-group mb-6 " id="agreement_append_company">
                            @foreach($company as $com)
                                <div class="col-md-4 text-left ">
                                    <div class="form-check-inline">
                                        <label class="radio radio-outline-primary">
                                            <input type="radio" class="agreement_company_cls" value="{{$com->id }}" name="agreement_not_employee_name"><span>{{$com->name}} ({{  $com->total_apply_visa_company_not_employee() }}) </span><span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="table2">
                            <table class="table" id="agreement_datatable" >
                                <thead class="thead-dark">
                                <tr>

                                    <th scope="col">Name</th>
                                    <th scope="col">Passport Number</th>
                                    <th scope="col">ZDS Code</th>
                                    <th scope="col">PPUID</th>
                                    <th scope="col">Personal Number</th>
                                    <th scope="col">SIM Number</th>
                                    <th scope="col">Bike Plate Number</th>
                                    <th scope="col">Platform</th>
                                    <th scope="col">Emirates ID</th>
                                    <th scope="col">Driving License</th>
                                    <th scope="col">Labour Card No.</th>
                                    <th scope="col">Verifing Status</th>
                                    <th scope="col">Agreement</th>

                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>



                    </div>
                </div>
                </div>


                {{--                tabs ends--}}


            </div>

    </div>

    @csrf




@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>




    <script type="text/javascript">

        function newexportaction(e, dt, button, config) {
            var self = this;
            var oldStart = dt.settings()[0]._iDisplayStart;
            dt.one('preXhr', function (e, s, data) {
                // Just this once, load all data from the server...
                data.start = 0;
                data.length = 2147483647;
                dt.one('preDraw', function (e, settings) {
                    // Call the original action function
                    if (button[0].className.indexOf('buttons-copy') >= 0) {
                        $.fn.dataTable.ext.buttons.copyHtml5.action.call(self, e, dt, button, config);
                    } else if (button[0].className.indexOf('buttons-excel') >= 0) {
                        $.fn.dataTable.ext.buttons.excelHtml5.available(dt, config) ?
                            $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config) :
                            $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
                    } else if (button[0].className.indexOf('buttons-csv') >= 0) {
                        $.fn.dataTable.ext.buttons.csvHtml5.available(dt, config) ?
                            $.fn.dataTable.ext.buttons.csvHtml5.action.call(self, e, dt, button, config) :
                            $.fn.dataTable.ext.buttons.csvFlash.action.call(self, e, dt, button, config);
                    } else if (button[0].className.indexOf('buttons-pdf') >= 0) {
                        $.fn.dataTable.ext.buttons.pdfHtml5.available(dt, config) ?
                            $.fn.dataTable.ext.buttons.pdfHtml5.action.call(self, e, dt, button, config) :
                            $.fn.dataTable.ext.buttons.pdfFlash.action.call(self, e, dt, button, config);
                    } else if (button[0].className.indexOf('buttons-print') >= 0) {
                        $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
                    }
                    dt.one('preXhr', function (e, s, data) {
                        // DataTables thinks the first item displayed is index 0, but we're not drawing that.
                        // Set the property to what it was before exporting.
                        settings._iDisplayStart = oldStart;
                        data.start = oldStart;
                    });
                    // Reload the grid with the original page. Otherwise, API functions like table.cell(this) don't work properly.
                    setTimeout(dt.ajax.reload, 0);
                    // Prevent rendering of the full data to the DOM
                    return false;
                });
            });
            // Requery the server with the new one-time export settings
            dt.ajax.reload();
        };


       function all_load_data(company= '',employee_type){

            var table = $('#datatable').DataTable({
                "aaSorting": [],
                "language": {
                    processing: "<img id='loader' src='{{ asset('assets/images/pre-load.gif') }}'>",
                },
                "pageLength": 10,
                "columnDefs": [
                    // {"targets": [0],"visible": false},
                    {"targets": [0][1],"width": "30%"}
                ],
                dom: 'Bfrtip',
                "lengthMenu": [[25, 100, -1], [25, 100, "All"]],
                buttons: [
                    {
                        extend: 'excel',
                        "action": newexportaction,
                        title: 'All Data',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                                search: 'applied',
                                order: 'applied'
                            }
                        }
                    },
                    'pageLength',
                ],

                "scrollY": false,
                "scrollX": true,
                "processing": true,
                "serverSide": true,



                ajax:{
                    url : "{{ url('assign_report_admin') }}",
                    data:{company_id:company,employee_type:employee_type},
                },


                "deferRender": true,
                columns: [
                    {data: 'full_name', name: 'full_name'},
                    {data: 'passport_no', name: 'passport_no'},
                    {data: 'zds_code', name: 'zds_code'},
                    {data: 'pp_uid', name: 'pp_uid'},
                    {data: 'personal_mob', name: 'personal_mob'},
                    {data: 'sim_assign', name: 'sim_assign'},
                    {data: 'bike_assign', name: 'bike_assign'},
                    {data: 'platform_assign', name: 'platform_assign'},
                    {data: 'emirates_id', name: 'emirates_id'},
                    {data: 'driving_license', name: 'driving_license'},
                    {data: 'elect_pre_approval', name: 'elect_pre_approval'},

                    {data: 'verified', name: 'verified'},
                    {data: 'agreement', name: 'agreement'},
                ]
            });
        }


       function labour_load_data(company=''){

           var table = $('#labour_datatable').DataTable({
               "aaSorting": [],
               "language": {
                   processing: "<img id='loader' src='{{ asset('assets/images/pre-load.gif') }}'>",
               },
               "pageLength": 10,
               "columnDefs": [
                   // {"targets": [0],"visible": false},
                   {"targets": [0][1],"width": "30%"}
               ],
               "lengthMenu": [[25, 100, -1], [25, 100, "All"]],
               dom: 'Bfrtip',
               buttons: [
                   {
                       extend: 'excel',
                       "action": newexportaction,
                       title: 'Labour Data',
                       text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                       exportOptions: {
                           modifier: {
                               page : 'all',
                               search: 'applied',
                               order: 'applied'
                           }
                       }
                   },
                   'pageLength',
               ],
               "scrollY": false,
               "scrollX": true,
               "processing": true,
               "serverSide": true,



               ajax:{
                   url : "{{ url('assign_report_admin') }}",
                   data:{labour_company_id:company},
               },


               "deferRender": true,
               columns: [
                   {data: 'full_name', name: 'full_name'},
                   {data: 'passport_no', name: 'passport_no'},
                   {data: 'zds_code', name: 'zds_code'},
                   {data: 'pp_uid', name: 'pp_uid'},
                   {data: 'personal_mob', name: 'personal_mob'},
                   {data: 'sim_assign', name: 'sim_assign'},
                   {data: 'bike_assign', name: 'bike_assign'},
                   {data: 'platform_assign', name: 'platform_assign'},
                   {data: 'emirates_id', name: 'emirates_id'},
                   {data: 'driving_license', name: 'driving_license'},
                   {data: 'elect_pre_approval', name: 'elect_pre_approval'},

                   {data: 'verified', name: 'verified'},
                   {data: 'agreement', name: 'agreement'},
               ]
           });
       }

       function agreement_data(company= '',employee_type){

           var table = $('#agreement_datatable').DataTable({
               "aaSorting": [],
               "language": {
                   processing: "<img id='loader' src='{{ asset('assets/images/pre-load.gif') }}'>",
               },
               "pageLength": 10,
               "columnDefs": [
                   // {"targets": [0],"visible": false},
                   {"targets": [0][1],"width": "30%"}
               ],
               dom: 'Bfrtip',
               "lengthMenu": [[25, 100, -1], [25, 100, "All"]],
               buttons: [
                   {
                       extend: 'excel',
                       "action": newexportaction,
                       title: 'Agreement Data',
                       text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                       exportOptions: {
                           modifier: {
                               page : 'all',
                               search: 'applied',
                               order: 'applied'
                           }
                       }
                   },
                   'pageLength',
               ],
               "scrollY": false,
               "scrollX": true,
               "processing": true,
               "serverSide": true,

               ajax:{
                   url : "{{ url('assign_report_admin') }}",
                   data:{agreement_company_id:company,employee_type:employee_type},
               },

               "deferRender": true,
               columns: [
                   {data: 'full_name', name: 'full_name'},
                   {data: 'passport_no', name: 'passport_no'},
                   {data: 'zds_code', name: 'zds_code'},
                   {data: 'pp_uid', name: 'pp_uid'},
                   {data: 'personal_mob', name: 'personal_mob'},
                   {data: 'sim_assign', name: 'sim_assign'},
                   {data: 'bike_assign', name: 'bike_assign'},
                   {data: 'platform_assign', name: 'platform_assign'},
                   {data: 'emirates_id', name: 'emirates_id'},
                   {data: 'driving_license', name: 'driving_license'},
                   {data: 'elect_pre_approval', name: 'elect_pre_approval'},

                   {data: 'verified', name: 'verified'},
                   {data: 'agreement', name: 'agreement'},
               ]
           });
       }



    </script>

    <script>


        $('input[type=radio][name=company_name]').change(function() {

          var id = $(this).val();

            $('#datatable').DataTable().destroy();
            all_load_data(id);

        });

        $('input[type=radio][name=labour_company_name]').change(function() {

            var id = $(this).val();

            $('#labour_datatable').DataTable().destroy();
            labour_load_data(id);

        });

        $('input[type=radio][name=employee_type_name]').change(function() {
            var ids = $(this).val();
            var token = $("input[name='_token']").val();

            $.ajax({
                url: "{{ route('assign_report_admin_ajax_employee') }}",
                method: 'POST',
                data: {_token:token,employee_id:ids},
                success: function(response) {
                    $('#agreement_append_company').html('');
                    $('#agreement_append_company').append(response);
                }
            });
        });

        $(document).on('change', 'input[name=agreement_not_employee_name]', function() {

            var ids = $(this).val();

            $('#agreement_datatable').DataTable().destroy();
            agreement_data(ids,"1");

        });

        $(document).on('change', 'input[name=agreement_full_time_name]', function() {

            var ids = $(this).val();

            $('#agreement_datatable').DataTable().destroy();
            agreement_data(ids,"2");
        });

        $(document).on('change', 'input[name=agreement_part_time_name]', function() {
              var ids = $(this).val();

            $('#agreement_datatable').DataTable().destroy();
            agreement_data(ids,"3");

        });

    </script>

    <script>
        $(document).on('click', '.amendment_modal_cls', function() {
        // $(".amendment_modal_cls").click(function () {
            var ab = $(this).attr('id');
            var now_id  = ab.split('-');

            var final_id = now_id[1];

            $("#history_modal").modal('show');

            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('get_amendment_history_ajax') }}",
                method: 'POST',
                data: {agreement_id: final_id , _token:token},
                success: function(response) {
                    $("#history_modal_body").html('');
                    $("#history_modal_body").append(response);

                }
            });


        });
    </script>


    <script>
        $(document).ready(function () {

            $('#datatable22').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'Report',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all'

                            }

                        }
                    },
                    'pageLength',
                ],
                "scrollY": true,
                "scrollX": true,
            });

        });
    </script>

    <script>
        $(document).ready(function () {
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                var currentTab = $(e.target).attr('id'); // get current tab

                var split_ab = currentTab;
                // alert(split_ab[1]);

                if(split_ab=="home-basic-tab"){

                    var table = $('#datatable').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();

                    var table = $('#datatable').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();

                }

                else{
                    var table = $('#datatable2').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw()

                }


            }) ;
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
