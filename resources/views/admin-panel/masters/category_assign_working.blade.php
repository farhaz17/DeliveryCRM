@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <style>

        label{
            color: #0b192b;
        }

    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Masters</a></li>
            <li>Visa Category Assign</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    {{--    <div class="row">--}}
    <div class="col-md-12">
        <div class="card mb-12" style="background: #dedede">
            <div class="card-body">
                <div class="card-title mb-3">Categories</div>

                <form method="post" action="{{url('working_category_assign_store')}}">
                    {!! csrf_field() !!}
                    <div class="row">
                        <div class="col-md-5">

                            <div class="form-check-inline">
                                <label class="radio radio-outline-primary">
                                    <input type="radio" class="search_type_cls" value="1" name="search_type" checked /><span>PPUID</span><span class="checkmark"></span>
                                </label>
                            </div>

                            <div class="form-check-inline">
                                <label class="radio radio-outline-secondary">
                                    <input type="radio"  class="search_type_cls"  value="2" name="search_type" /><span>ZDS Code</span><span class="checkmark"></span>
                                </label>
                            </div>

                            <div class="form-check-inline">
                                <label class="radio radio-outline-success">
                                    <input type="radio" class="search_type_cls"  value="3" name="search_type" /><span>Passport Number</span><span class="checkmark"></span>
                                </label>
                            </div>

                        </div>

                        <div class="col-md-5 form-check-inline mb-3 text-center" id="name_div" style="display: none;" >
                            <label class="radio-outline-success ">Name:</label>
                            <h6 id="name_passport" class="text-dark ml-3">PP52026</h6>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-6 form-group  mb-3 append_div">
                            <label for="repair_category " class="ppuid_cls">Select PPUID</label>
                            <select id="ppui_id" name="ppui_id" class="form-control ppuid_cls" >
                                <option value=""  selected disabled >Select option</option>
                                @foreach($ppuid as $cate)
                                    <option value="{{ $cate->id }}">{{ $cate->pp_uid  }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 form-group mb-3">
                            <label for="repair_category">Select Main Category</label>
                            <select id="main_category" name="main_category" class="form-control" >
                                <option value=""  >Select option</option>
                                @foreach($main_category as $cate)
                                    <option value="{{ $cate->id }}">{{ $cate->name  }}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="col-md-6 form-group mb-3">
                            <label for="repair_category">Select Sub Category</label>
                            <select id="sub_category" name="sub_category1" class="form-control" >
                                <option value=""  >Select option</option>

                            </select>
                        </div>


                        <div class="col-md-6 form-group mb-3">
                            <label for="repair_category">Select Sub Category2</label>
                            <select id="sub_category2" name="sub_category2" class="form-control" >
                                <option value=""  >Select option</option>
                            </select>
                        </div>


                        <div class="col-md-12">
                            <button class="btn btn-primary">Add</button>
                        </div>
                    </div>
                </form>


            </div>
        </div>
    </div>


    {{--    </div>--}}


    <div class="col-md-12 mb-3">
        <div class="card text-left">
            <div class="card-body">


                <div class="table-responsive">

                    <table class="display table table-striped table-bordered" id="datatable">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">ZDS Code</th>
                            <th scope="col">PPUID</th>
                            <th scope="col">Passport No</th>
                            <th scope="col">Main Category</th>
                            <th scope="col">Sub Category 1</th>
                            <th scope="col">Sub Category 2</th>
                            <th scope="col">Checkout</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($assinged_cate as $cate)
                            <tr>
                                <td>{{ $cate->passport->personal_info->full_name }}</td>
                                <td>{{ $cate->passport->zds_code->zds_code }}</td>
                                <td>{{ $cate->passport->pp_uid }}</td>
                                <td>{{ $cate->passport->passport_no }}</td>
                                <td>{{ isset($cate->sub_cate2->subcate_one->main_cat->name) ? $cate->sub_cate2->subcate_one->main_cat->name : 'N/A' }}</td>
                                <td>{{ isset($cate->sub_cate2->subcate_one->name) ? $cate->sub_cate2->subcate_one->name : 'N/A'}}</td>
                                <td>{{ $cate->sub_cate2->name }}</td>

                                <td>
                                    @if($cate->status==1)
                                        <a class="text-success mr-2 btn_cls"  id="{{ $cate->id  }}" href="javascript:void(0)">
                                            <i class="nav-icon i-Checkout-Basket font-weight-bold"></i>
                                            @else
                                                Checked-Out
                                            @endif
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



    <!---------CheckOut Model---------->
    <div class="modal fade" id="form_update" tabindex="-1" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="row">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="verifyModalContent_title">Checkout</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <form  action="{{action('Master\MasterController@working_category_checkout', '1')}}" id="sim_form" method="post">
                            @method('GET')
                            <input type="hidden" id="primary_id" name="primary_id">
                            {!! csrf_field() !!}
                            Are you sure want to checkout?
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">No</button>

                                <button class="btn btn-primary" > Yes  </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--------checkout model ends--------->



@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script>
        $(".btn_cls").click(function(){
            var ids = $(this).attr('id');
            var  action = $("#sim_form").attr("action");
            var ab = action.split("a/");
            var action_now =  ab[0]+''+ids;
            $("#sim_form").attr('action',action_now);
            $("#primary_id").val(ids);
            $('#form_update').modal('show');
        });
    </script>
    <script>
        $(".search_type_cls").change(function(){
            var select_v = $(this).val();
            $("#name_div").hide();
            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('ajax_render_working_dropdown') }}",
                method: 'POST',
                data: {type: select_v, _token:token},
                success: function(response) {
                    $(".append_div").empty();
                    $(".append_div").append(response.html);

                    if(select_v=="1"){
                        $('#ppui_id').select2({
                            placeholder: 'Select an option'
                        });
                    }else if(select_v=="2"){
                        $('#zds_code').select2({
                            placeholder: 'Select an option'
                        });
                    }else{
                        $('#passport_id').select2({
                            placeholder: 'Select an option'
                        });
                    }

                }
            });

        });
    </script>

    <script>
        $(document).on('change', '#ppui_id', function(){
            var abs = $(this).val();

            $("#name_div").show();

            var token = $("input[name='_token']").val();
            $('#sub_category').empty().trigger("change");
            $.ajax({
                url: "{{ route('ajax_get_unique_passport') }}",
                method: 'POST',
                data: {type: "1", passport_id : abs ,  _token:token},
                success: function(response) {
                    var ab = response.split("$");

                    $("#name_passport").html(ab[1]);
                }
            });
        });

        $(document).on('change', '#zds_code', function(){
            var abs = $(this).val();

            $("#name_div").show();

            var token = $("input[name='_token']").val();
            $('#sub_category').empty().trigger("change");
            $.ajax({
                url: "{{ route('ajax_get_unique_passport') }}",
                method: 'POST',
                data: {type: "1", passport_id : abs ,  _token:token},
                success: function(response) {
                    var ab = response.split("$");

                    $("#name_passport").html(ab[1]);
                }
            });
        });

        $(document).on('change', '#passport_id', function(){
            var abs = $(this).val();

            $("#name_div").show();

            var token = $("input[name='_token']").val();
            $('#sub_category').empty().trigger("change");
            $.ajax({
                url: "{{ route('ajax_get_unique_passport') }}",
                method: 'POST',
                data: {type: "1", passport_id : abs ,  _token:token},
                success: function(response) {
                    var ab = response.split("$");

                    $("#name_passport").html(ab[1]);
                }
            });
        });

    </script>

    <script>
        $("#main_category").change(function(){
            var var_ab = $(this).val();

            var token = $("input[name='_token']").val();
            $('#sub_category').empty().trigger("change");
            $.ajax({
                url: "{{ route('ajax_render_subcategory_working') }}",
                method: 'POST',
                dataType: 'json',
                data: {type: "1", select_v : var_ab ,  _token:token},
                success: function(response) {

                    var len = 0;
                    if(response != null){
                        len = response.length;
                    }
                    if(len > 0){
                        $('#sub_category').empty().trigger("change");
                        for(var i=0; i<len; i++){
                            var newOption = new Option(response[i].name, response[i].id, true, true);
                            $('#sub_category').append(newOption);
                        }
                        $('#sub_category').val(null).trigger('change');
                    }else{

                    }
                }
            });
        });

        $("#sub_category").change(function(){
            var var_ab = $(this).val();

            var token = $("input[name='_token']").val();
            $('#sub_category2').empty().trigger("change");
            $.ajax({
                url: "{{ route('ajax_render_subcategory_visa') }}",
                method: 'POST',
                dataType: 'json',
                data: {type: "2", select_v : var_ab ,  _token:token},
                success: function(response) {

                    var len = 0;
                    if(response != null){
                        len = response.length;
                    }
                    if(len > 0){
                        $('#sub_category2').empty().trigger("change");
                        for(var i=0; i<len; i++){
                            var newOption = new Option(response[i].name, response[i].id, true, true);
                            $('#sub_category2').append(newOption);
                        }
                        $('#sub_category2').val(null).trigger('change');
                    }else{

                    }
                }
            });
        });


    </script>


    <script>
        $(document).ready(function () {
            'use strict';

            $('#datatable').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,

            });

            'use strict';

            $('#datatable2').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,

            });

            $('#ppui_id').select2({
                placeholder: 'Select an option'
            });
            $('#main_category').select2({
                placeholder: 'Select an option'
            });
            $('#sub_category').select2({
                placeholder: 'Select an option'
            });
            $('#sub_category2').select2({
                placeholder: 'Select an option'
            });
        });
    </script>

    <script>


        $(document).ready(function () {
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                var currentTab = $(e.target).attr('id'); // get current tab
                var split_ab = currentTab;

                if(split_ab=="home-basic-tab"){
                    var ab_table = $('#datatable').DataTable();
                    ab_table.destroy();

                    var table = $('#datatable').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }
                else{
                    var ab_table = $('#datatale2').DataTable();
                    ab_table.destroy();
                    var table = $('#datatale2').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
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
