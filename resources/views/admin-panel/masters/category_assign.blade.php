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
    <style>
        .col-lg-12.sugg-drop {
            width: 400px;
            line-height: 12px;
            font-size: 12px;
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
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Masters</a></li>
            <li>Employee Designation Management</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-md-9">
            <div class="card mb-12" style="background: #dedede">
                <div class="card-body">
                    <div class="card-title mb-3 text-center text-capitalize">Employee Designation Management Form</div>
                    <form method="post" action="{{ route('category_assign_store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label class="radio radio-outline-success">
                                    <input type="radio" name="transfer_or_permanent" id="transfer_or_permanent" value="0" checked>
                                    <span>Transfer Or new position</span>
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label class="radio radio-outline-danger">
                                    <input type="radio" name="transfer_or_permanent" id="transfer_or_permanent" value="1">
                                    <span>Parmanently remove position</span>
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 form-group  mb-3">
                                <label class="radio-outline-success ">Search Employee</label>
                                <input class="form-control form-control-sm typeahead " id="keyword" autocomplete="off" type="text" name="search_value" placeholder="Enter Name or Passport or ZDS Code" aria-label="Passport" required aria-describedby="basic-addon1">
                                <input type="hidden" name="passport_id" id="passport_id">
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="">Select Main Category</label>
                                <select id="main_category" name="main_category" class="form-control form-control-sm" required>
                                    <option value=""  >Select option</option>
                                    @foreach($main_category as $cate)
                                        <option value="{{ $cate->id }}">{{ $cate->name  }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="">Select Sub Category</label>
                                <select id="sub_category1" name="sub_category1" class="form-control form-control-sm" required>
                                    <option value=""  >Select option</option>
                                </select>
                            </div>
                            <div class="col-md-3 form-group mb-3">
                                <label for="">Select Sub Category2</label>
                                <select id="sub_category2" name="sub_category2" class="form-control form-control-sm" required>
                                    <option value=""  >Select option</option>
                                </select>
                            </div>
                            {{-- <div class="col-md-12 form-group mb-3">
                                <label for="">Remarks</label>
                                <textarea name="remarks" class="form-control form-control-sm" placeholder="Enter Remarks" id="" cols="30" rows="3"></textarea>
                            </div> --}}
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-info btn-sm float-right">Assign Employee Position</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card mb-12" style="background: #dedede">
                <div class="card card-profile-1 border border-secondary mb-2" style="min-height: 25em;">
                    <div class="card-body text-left p-2">
                        <div class="avatar box-shadow-2 mb-3" style="width: 140px; height:140px"><img src="http://localhost/zone_repair/public/assets/images/user_avatar.jpg" alt=""></div>
                        <h5 class="m-0 text-center"><span id="full_name"></span></h5>
                        <br>
                        {{-- <h5 class="text-center">Other Information</h5> --}}
                        <p class="m-1 border-bottom"><b>PPUID: </b><span id="pp_uid" class="float-right"></span></p>
                        <p class="m-1 border-bottom"><b>Passport: </b><span id="passport_no" class="float-right"></span></p>
                        <p class="m-1 border-bottom"><b>Phone: </b> <span id="sim_card" class="float-right"></span></p>
                        <p class="m-1 border-bottom"><b>Current Designation: </b>
                            <span id="main_cate"></span>
                            <i class="i-Arrow-Right-2" id="main_cate_arrow" style="display: none"></i>
                            <span id="sub_cate1"></span>
                            <i class="i-Arrow-Right-2" id="sub_cate1_arrow" style="display: none"></i>
                            <span id="sub_cate2"></span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3">
            <div class="card text-left">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="display table table-striped table-hover table-sm table-bordered text-11" id="datatable">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Employee Details</th>
                                    <th scope="col">Category Details</th>
                                    <th scope="col">Assigned On</th>
                                    <th scope="col">Revoked On</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($assinged_cate as $cate)
                                <tr>
                                    <td><b>Name: </b>{{ isset($cate->passport) ? $cate->passport->personal_info->full_name : 'N/A' }} |
                                        <b>Passport:  </b>{{ isset($cate->passport) ?  $cate->passport->passport_no :'N/A' }} |
                                        <b>PPUID:  </b>{{  isset($cate->passport) ? $cate->passport->pp_uid : 'N/A' }}</td>
                                    <td>
                                        {{ isset($cate->sub_cate2->subcate_one->main_cat->name) ? $cate->sub_cate2->subcate_one->main_cat->name : 'N/A' }}
                                        <i class="i-Arrow-Right-2"></i>
                                        {{ isset($cate->sub_cate2->subcate_one->name) ? $cate->sub_cate2->subcate_one->name : 'N/A'}}
                                        <i class="i-Arrow-Right-2"></i>
                                        {{ $cate->sub_cate2->name ?? "NA"}}
                                    </td>
                                    <td>{{ dateToRead($cate->assign_started_at) }}</td>
                                    <td>{{ $cate->assign_ended_at ?  dateToRead($cate->assign_ended_at) : "Not Revoked Yet"  }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
    <script src="{{asset('/js/custom_js/category_assign_form.js')}}"></script>
    <script>
        $(document).ready(function(){
            $('input[name=transfer_or_permanent]').change(function(){
                if($(this).val() == 1){
                    hide_input(['#main_category','#sub_category1','#sub_category2'])
                }else{
                    show_input(['#main_category','#sub_category1','#sub_category2'])
                }
            });
            function show_input(ids){
                ids.forEach(function(id){
                    $(id).prop('required',true); $(id).parent().show(300);
                });
            }
            function hide_input(ids){
                ids.forEach(function(id){
                    $(id).prop('required',false); $(id).parent().hide(300);
                });
            }
        });
    </script>
    <script>
        $("#main_category").change(function(){
            var var_ab = $(this).val();

            var token = $("input[name='_token']").val();
            $('#sub_category1').empty().trigger("change");
            $.ajax({
                url: "{{ route('ajax_render_subcategory') }}",
                method: 'POST',
                dataType: 'json',
                data: {type: "1", select_v : var_ab ,  _token:token},
                success: function(response) {

                    var len = 0;
                    if(response != null){
                        len = response.length;
                    }
                    if(len > 0){
                        $('#sub_category1').empty().trigger("change");
                        for(var i=0; i<len; i++){
                            var newOption = new Option(response[i].name, response[i].id, true, true);
                            $('#sub_category1').append(newOption);
                         }
                        $('#sub_category1').val(null).trigger('change');
                    }else{

                    }
                }
            });
        });

        $("#sub_category1").change(function(){
            var var_ab = $(this).val();
            var token = $("input[name='_token']").val();
            $('#sub_category2').empty().trigger("change");
            $.ajax({
                url: "{{ route('ajax_render_subcategory') }}",
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
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'Employee List with categories',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=10px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all'
                            }
                        }
                    },
                    // 'pageLength',
                ],
            });
            $('#main_category').select2({
                placeholder: 'Select an option'
            });
            $('#sub_category1').select2({
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
