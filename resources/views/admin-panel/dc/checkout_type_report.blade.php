@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        #datatable2 .table th, .table td{
            border-top : unset !important;
        }
        .table th, .table td{
            padding: 0px !important;
        }
        .table th{
            padding: 2px;
            font-size: 13px;
        }
        .table td{
            padding: 2px;
            font-size: 13px;
        }
        .table th{
            padding: 2px;
            font-size: 13px;
            font-weight: 600;
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

    {{-- auto complete search css start --}}

    <style>
        .col-lg-12.sugg-drop {
            width: 550px;
            line-height: 12px;
            font-size: 12px;
            /*border: 1px solid #775dd0;*/
            /*padding-top: 15px;*/
            /*padding-bottom: 15px;*/

        }
        .col-lg-12.sugg-drop_checkout {
            width: 550px;
            line-height: 12px;
            font-size: 12px;
            /*border: 1px solid #775dd0;*/
            /*padding-top: 15px;*/
            /*padding-bottom: 15px;*/

        }

        span#full_name_drop {
            font-size: 10px;
        }
        ul.typeahead.dropdown-menu {
            height: 400px;
            overflow: hidden;
            width: 770px;

        }
        ul.typeahead.dropdown-menu:hover {
            height: 400px;
            overflow: scroll;

        }
        #clear {
            position: relative;
            float: right;
            height: 20px;
            width: 21px;
            top: 7px;
            right: 28px;
            border-radius: 20px;
            background: #f1f1f1;
            color: white;
            font-weight: bold;
            text-align: center;
            cursor: pointer;
            font-size: 14px;
        }
        #clear:hover {
            background: #ccc;
        }
        .input-group-prepend {
            border-left: none;
        }
        input#keyword {
            border-right: none;
            background: #ffffff;
            border-left: none;
        }
        span#basic-addon2 {
            border-left: none;
        }
        hr {
            margin-top: 0rem;
            margin-bottom: 0rem;
            border: 0;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
            height: 0;
        }
        #drop-full_name {
            font-weight: 700;
        }
        #drop-bike {
            font-weight: 700;
            color: #FF0000;
        }
        span#drop-name {
            color: #010165;
        }
    </style>

    {{-- auto complete search end  --}}

@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Checkout</a></li>
            <li>Checkout Report</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>


    <!--  search modal -->
    <div class="modal fade bd-example-modal-lg"  id="seatch_modal"tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle-1">Search Candidate</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <form action="{{ route('search_result_career_selected') }}" method="POST" id="search_form" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8">
                                <label>Search name /zds /Passport number /ppuid</label>
                                <div class="input-group ">
                                    <div class="input-group-prepend"><span class="input-group-text bg-transparent" id="basic-addon1"><i class="i-Magnifi-Glass1"></i></span></div>
                                    <input class="form-control typeahead " id="keyword" autocomplete="off" type="text" name="search_value" placeholder="search..." aria-label="Username" required aria-describedby="basic-addon1">
                                    <div class="input-group-append"><span class="input-group-text bg-transparent" id="basic-addon2"><i class="i-Search-People"></i></span></div>
                                    <div id="clear">
                                        X
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="user_passport_id" />

                        <div class="row append_search_result mt-4">


                        </div>



                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        {{-- <button class="btn btn-primary ml-2" type="submit">Search</button> --}}
                    </div>
                </form>
            </div>
        </div>
    </div><!-- end of search modal -->



    {{--------------------passport  model-----------------}}
    <div class="modal fade bd-example-modal-lg" id="detail_modal"   tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="post" id="checkout_form" action="{{ route('after_accept_reject_send_onboard') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Checkout Request Detail</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">

                        <div class="append_div">
                        </div>

                    </div>
                    <input type="hidden" name="primary_id" id="primary_id">
                    <input type="hidden" name="request_type" id="request_type">
                    <div class="modal-footer" style="display: flow-root;">
                        <input type="submit" id="form_submit_button" style="display: none;">
                        <button class="btn btn-secondary " type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary float-right ml-2" id="reject_btn" type="button">Send to Wait List</button>
                        <button class="btn btn-success float-right ml-2"  id="accept_btn" type="button">Send to Onboard</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{--------------------Passport model ends here-----------------}}


    <div class="row">
         <div class="col-md-6">
             <div class="card text-left">
             <label for="repair_category">Select Platform</label>
             <select class="form-control  " name="platform_id" id="platform_id" required >
                 <option value="">select an option</option>
                 <option value="all">All</option>
                 @foreach($platforms as $platform)
                     <option value="{{ $platform->id }}">{{ $platform->name }}</option>
                 @endforeach

             </select>
             </div>
         </div>

         <div class="col-md-6 " >
            <button class="btn btn-primary btn-icon m-1 text-white float-right" id="search_btn" type="button"><span class="ul-btn__icon"><i class="i-Search-People"></i></span><span class="ul-btn__text">Search</span></button>
         </div>

    </div>


    <div class="row mb-4 append_result_div">

    </div>



    <div class="overlay"></div>

@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

    <script> var path = "{{ route('autocomplete_checkout_type_report') }}"; </script>
    <script> var passport_detail_path = "{{ route('get_autocomplete_detail_checkout_report') }}"; </script>

    <script src="{{ asset('js/custom_js/checkout_type_report.js') }}"></script>

    {{-- search started now --}}
    <script>
        $("#search_btn").click(function () {

            $("#seatch_modal").modal("show");



        });

        $("#search_form").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
            var url = $("#search_form").attr('action');
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
                    if(response=="error"){
                        tostr_display("error","please fill at least one field");
                        // alert("agreement is submitted");
                    }else if(response=="error_two"){
                        tostr_display("error","please select the end date as well");
                    }else{
                        $("#search_result_modal").modal('show');
                        make_table_search_table("search_result_datatable",response.html);

                        var table = $('#search_result_datatable').DataTable();
                        $(".display").css("width","100%");
                        $('#search_result_datatable tbody').css("width","100%");
                        $('#container').css( 'display', 'block' );
                        table.columns.adjust().draw();

                        $("#search_result_datatable thead").click();


                    }

                }
            });
        });
    </script>

    {{-- search end here --}}



    <script>
        $(document).ready(function () {
            $('#platform_id').select2({
                placeholder: 'Select an option'
            });
        });
    </script>

    <script>
        $('body').on('click', '.edit', function() {
            var  ids  = $(this).attr('id');

            $("#detail_modal").modal('show');

            $("#primary_id").val(ids);
            $.ajax({
                url: "{{ route('get_request_ajax') }}",
                method: 'get',
                data: {id_primary: ids,form_request:"checkout_type_report"},
                success: function(response) {
                    $(".append_div").empty();
                    $(".append_div").append(response.html);

                }
            });
        });

        $('body').on('change', '#platform_id', function() {
            var  ids  = $(this).val();
            $("#primary_id").val(ids);
            $.ajax({
                url: "{{ route('get_checkout_report_by_platform') }}",
                method: 'get',
                data: {id_primary: ids},
                success: function(response) {
                    $(".append_result_div").empty();
                    $(".append_result_div").append(response.html);

                    var table = $('#1-datatable').DataTable();
                    table.destroy();

                    var table = $('#1-datatable').DataTable(
                        {
                            "aaSorting": [],
                            "lengthMenu": [
                                [10, 25, 50, -1],
                                ['10 Rows', '25 Rows', '50 Rows', 'Show all']
                            ],
                            dom: 'Bfrtip',
                            buttons: [
                                {
                                    extend: 'excel',
                                    title: 'Pending Rider Fuel',
                                    text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                                    exportOptions: {
                                        modifier: {
                                            page : 'all',
                                        }
                                    }
                                },
                                'pageLength',
                            ],
                            "sScrollX": "100%",
                            "scrollX": true
                        }
                    );
                    $(".display").css("width","100%");
                    $('#1-datatable tbody').css("width","100%");
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();

                }
            });
        });
    </script>


    <script>

        $("#reject_btn").click(function(){
            $("#request_type").val("2");
            $("#checkout_form").submit();
        });

        $("#accept_btn").click(function(){
            $("#request_type").val("1");
            $("#checkout_form").submit();
        });


        $("#checkout_form").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
            $('#phone').keydown();

            var url = $("#checkout_form").attr('action');


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

            $('body').on('shown.bs.tab', 'a[data-toggle="tab"]', function (e) {

                var currentTab = $(e.target).attr('id'); // get current tab

                var platform_selected = $('#platform_id :selected').val();

                var split_ab = currentTab;

                var status = $(this).attr('data-status');

                var data_table_name = status+"-datatable";

                    make_table(data_table_name,status,platform_selected);

                    var table = $('#'+data_table_name).DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();


            });
        });
    </script>

    <script>
        function make_table(table_name,tab_name,plat_id) {
            console.log(table_name);

            $.ajax({
                url: "{{ route('get_checkout_report_type_ajax') }}",
                method: 'GET',
                data: {platform_id:plat_id,tab_name:tab_name},
                success: function(response) {

                    $('#'+table_name+' tbody').empty();

                    var table = $('#'+table_name).DataTable();
                    table.destroy();
                    $('#'+table_name+' tbody').html(response.html);
                    var table = $('#'+table_name).DataTable(
                        {
                            "aaSorting": [],
                            "lengthMenu": [
                                [10, 25, 50, -1],
                                ['10 Rows', '25 Rows', '50 Rows', 'Show all']
                            ],
                            dom: 'Bfrtip',
                            buttons: [
                                {
                                    extend: 'excel',
                                    title: 'Pending Rider Fuel',
                                    text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                                    exportOptions: {
                                        modifier: {
                                            page : 'all',
                                        }
                                    }
                                },
                                'pageLength',
                            ],
                            "sScrollX": "100%",
                            "scrollX": true
                        }
                    );
                    $(".display").css("width","100%");
                    $('#'+table_name+' tbody').css("width","100%");
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }
            });
        }
    </script>

    <script>


        $('body').on('click', '.reward_btn', function() {

            var id = $(this).attr('id');
            $('#referral_id').val(id);
            $('.ref_modal').modal('show');
        });

    </script>



    <script>
        $('.action-btn').on('click', function() {
            var token = $("input[name='_token']").val();
            var id = $(this).attr('id');
            $('#referral_id').val(id);
            $('.ref_modal').modal('show');
        });
    </script>


    <script>
        $('body').on('click', '.view-btn', function() {
            // $("tbody .view-btn").click(function(){
            var token = $("input[name='_token']").val();
            var passport_id = $(this).attr('id');
            $.ajax({
                url: "{{ route('view_referal') }}",
                method: 'POST',
                dataType: 'json',
                data: {passport_id: passport_id, _token: token},
                success: function (response) {
                    $('.view_referal').empty();
                    $('.view_referal').append(response.html);
                    $(".view_modal").modal('show')
                    var table = $('#datatable2').DataTable({
                        paging: true,
                        info: true,
                        searching: true,
                        autoWidth: false,
                        retrieve: true
                    });
                }
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
