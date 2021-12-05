@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/toastr.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/plugins/datatables.min.css') }}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <script src="{{ asset('assets/date/js/tail.datetime-full.js') }}"></script>
    <link href="{{ asset('assets/date/css/tail.datetime-default-orange.css') }}" rel="stylesheet">
    <style>
        button#add_row {
            margin-top: 20px;
        }

        .update_button_formate {
            position: absolute;
            top: 23px;
        }
        .table-header-1 {
            white-space: nowrap;
            font-size: 13px;
        }
        #loader{
            z-index: 9999;
        }
    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">User Codes</a></li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="modal fade bd-example-modal-md " id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" id="update_form" action="{{ route('usercodes.update', 1) }}">
                    @method('PUT')
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Update User Codes</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="primary_id" name="id" value="">
                        <div class="row append_div"></div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-2">
                <div class="card-body pb-0">
                    <div class="card-title mb-1">User Codes</div>
                    <form method="post" class="mb-0" enctype="multipart/form-data" aria-label="{{ __('Upload') }}" action="{{ isset($pass_edit) ? route('usercodes.update', $pass_edit->id) : route('usercodes.store') }}">
                        @csrf
                        @if (isset($parts_data))
                            @method('put')
                        @endif
                        <div class="col-md-12">
                            <div class="form-check-inline">
                                <label class="radio radio-outline-primary">
                                    <input type="radio" class="search_type_cls" checked value="2" name="search_type" /><span>ZDS Code</span><span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="form-check-inline">
                                <label class="radio radio-outline-success">
                                    <input type="radio" class="search_type_cls" value="1" name="search_type" /><span>PlatForm Code</span><span class="checkmark"></span>
                                </label>
                            </div>
                            <div class="col-md-5 form-check-inline mb-3 text-center" id="name_div" style="display: none; margin-left: 40px;">
                                <label class="radio-outline-success ">Name:</label>
                                <h6 id="name_passport" class="text-dark ml-3 ">PP52026</h6>
                            </div>
                        </div>
                        <div class="row" id="outside_div">
                            <div class="col-md-4 form-group mb-3">
                                <label for="">Select Riders (Enter Passport/PPUID)</label>
                                <select id="passport_number" name="passport_number" required
                                    class="form-control form-control-sm" {{ isset($pass_edit) ? 'disabled' : '' }}>
                                    <option value="">Select option</option>
                                    @foreach ($passport as $pas)
                                        @php
                                            $isSelected = (isset($pass_edit) ? $pass_edit->passport_no : '') == $pas->id;
                                        @endphp
                                        <option value="{{ $pas->id }}" {{ $isSelected ? 'selected' : '' }}>
                                            {{ $pas->passport_no }}  | {{ $pas->pp_uid }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 form-group mb-3 platform_div " style="display: none;">
                                <label for="">Plateform</label>
                                <select id="plateform" name="plateform" id="plateform"
                                    class="form-control form-control-sm">
                                    <option value="">Select option</option>
                                    @foreach ($plateform as $plate)
                                        <option value="{{ $plate->id }}">{{ $plate->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 form-group mb-3 plaform_code_div" style="display: none;">
                                <label for="">Plateform Code</label>
                                <input class="form-control form-control-sm" id="plateform_code" name="plateform_code" type="text" placeholder="Enter Plateform Code" />
                            </div>
                            <div class="col-md-4 form-group mb-3 zds_div ">
                                <label for="">ZDS Code</label>
                                <input class="form-control form-control-sm" id="zds_code" name="zds_code" required type="text" placeholder="Enter ZDS Code" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group mb-3">
                                <button class="btn btn-info btn-sm float-right">Register Code</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card text-left">
                <div class="card-body">
                    <div class="col-md-4 form-group mb-3 " style="float: left;">
                        <label for="start_date">Filter By</label>
                        <select id="filter_by" class="form-control form-control-sm" required>
                            <option selected disabled>Filter By</option>
                            <option value="1"> Passport Number</option>
                            <option value="2">Name</option>
                            <option value="3">PPUID</option>
                            <option value="4">ZDS Code</option>
                            <option value="5">PlatForm Code</option>
                        </select>
                    </div>
                    <div class="col-md-4 form-group mb-3 " style="float: left;">
                        <label for="end_date">Search</label>
                        <input type="text" name="keyword" class="form-control  form-control-sm" required
                            id="keyword">
                    </div>
                    <input type="hidden" name="table_name" id="table_name" value="datatable">
                    <div class="col-md-4 form-group mb-3 text-right" style="float: left; margin-top: 20px; ">
                        <label for="end_date" style="visibility: hidden;">End Date</label>
                        <button class="btn btn-sm btn-info btn-icon m-1" id="apply_filter" data="datatable" type="button"><span class="ul-btn__icon">
                                <i class="i-Magnifi-Glass1"></i> Apply Filter</span>
                        </button>
                        <button class="btn btn-sm btn-danger btn-icon m-1" id="remove_apply_filter" data="datatable" type="button"><span class="ul-btn__icon"><i class="i-Close"></i> Remove Filter</span></button>
                    </div>
                    <div class="table-responsive">
                        <table class="display table table-sm table-striped table-bordered text-11" id="datatable">
                            <thead>
                                <tr class="table-header-1">
                                    <th>ID</th>
                                    <th>Passport</th>
                                    <th>Name</th>
                                    <th>PPUID</th>
                                    <th>ZDS Code</th>
                                    <th>Current Platform</th>
                                    @foreach ($plateform as $plt)
                                        <th>{{ $plt->name }}</th>
                                    @endforeach
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

  <!-- New Platform Code Modal -->
  <div class="modal fade" id="AddNewPlatformCodeModal" tabindex="-1" role="dialog" aria-labelledby="AddNewPlatformCodeModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Add new Platform Code on <span id="platform_name">Plateform name</span></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="#" id="new_platform_code_form" method="POST">
                <div class="form-group">
                    <input type="hidden" name="passport_id" id="passport_id">
                    <input type="hidden" name="platform_id" id="platform_id">
                  <label for="platform_code">New Platform Code</label>
                  <input type="text" name="new_platform_code" class="form-control" id="new_platform_code" placeholder="Enter New Platform Code">
                </div>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="new_platform_code_btn">Save changes</button>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('js')
    <script src="{{ asset('assets/js/plugins/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/date/js/tail.datetime-full.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script>
        function newexportaction(e, dt, button, config) {
            var self = this;
            var oldStart = dt.settings()[0]._iDisplayStart;
            dt.one('preXhr', function(e, s, data) {
                // Just this once, load all data from the server...
                data.start = 0;
                data.length = 2147483647;
                dt.one('preDraw', function(e, settings) {
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
                    dt.one('preXhr', function(e, s, data) {
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
        // usercodes_load_data();
        function usercodes_load_data(keyword = '', filter_by = '') {
            var token = $("input[name='_token']").val();
            var table = $('#datatable').DataTable({
                "aaSorting": [
                    [0, 'desc']
                ],
                "language": {
                    processing: `<img id='loader' src='{{ asset('assets/images/pre-load.gif') }}'>`,
                },
                "pageLength": 10,
                "columnDefs": [
                    {
                        "targets": [0][1],
                        "width": "30%"
                    }
                ],
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'excel',
                        "action": newexportaction,
                        title: 'All Details Usercodes',
                        text: `<img src="{{ asset('assets/images/icons/excel.png') }}" width=20px; z-index:9999>`,
                        exportOptions: {
                            modifier: {
                                page: 'all',
                            }
                        }
                    },
                    'pageLength',
                ],
                "scrollY": true,
                "scrollX": true,
                fixedColumns:{
                    leftColumns: 6,
                },
                "processing": true,
                "serverSide": true,

                ajax: {
                    method: 'POST',
                    url: "{{ route('make_table_userodes') }}",
                    data: {
                        keyword: keyword,
                        filter_by: filter_by,
                        verify: "verify table",
                        _token: token
                    },
                },

                "deferRender": true,
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'passport_number',
                        name: 'passport_number'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'ppuid',
                        name: 'ppuid'
                    },
                    {
                        data: 'zds_code',
                        name: 'zds_code'
                    },
                    {
                        data: 'current_platform',
                        name: 'current_platform'
                    },
                    @foreach($plateform as $plt)
                        {data: '{{ $plt->name }}', name: '{{ $plt->name }}'},
                    @endforeach
                    {
                        data: 'action',
                        name: 'action'
                    },
                ]
            });
        }
    </script>
    <script>
        $("#apply_filter").click(function() {
            var keyword = $("#keyword").val();
            var filter_by = $("#filter_by").val();
            if (keyword != '' && filter_by != '') {
                $('#datatable').DataTable().destroy();
                usercodes_load_data(keyword, filter_by);
            } else {
                tostr_display("error", "Both field is required");
            }
        });
        $("#remove_apply_filter").click(function() {
            $("#keyword").val('');
            $("#filter_by").val('');
            var keyword = 'nothing';
            var filter_by = '6';
            if (keyword != '' && filter_by != '') {
                $('#datatable').DataTable().destroy();
                usercodes_load_data(keyword, filter_by);
            } else {
                tostr_display("error", "Both field is required");
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            // usercodes_load_data();
        });
        $('#passport_number').select2({
            placeholder: 'Select an option'
        });
        $('#plateform').select2({
            placeholder: 'Select an option'
        });
    </script>

    {{-- form update start --}}
    <script>
        $('.append_div').on('click', '.update_button_ab', function() {
            var ids = $(this).attr('id');
            var action_ab = $("#form-name_" + ids).attr('action');
            var main_url = "{{ url('usercodes') }}";
            var now_action = main_url + "/" + ids;
            $("#form-name_" + ids).attr('action', now_action);
            var platform_code = $("#name-" + ids).val();
            var token = $("input[name='_token']").val();
            var contact_html = "";
            $.ajax({
                url: now_action,
                method: 'PUT',
                data: {
                    platform_code: platform_code,
                    type_usercode: 'user_code_page',
                    _token: token
                },
                success: function(response) {
                    var arr = $.parseJSON(response);
                    if (arr !== null) {
                        if (arr['alert-type'] == "success") {
                            toastr["success"](arr['message']);
                            var passport_id = arr['passport_id'];
                            var platform_name = arr['platform_name'];
                            $("#" + passport_id + "-" + platform_name).html(platform_code);
                        } else {
                            toastr["error"](arr['message']);
                        }
                    }
                }
            });
        });

        $('.append_div').on('click', '.update_button_ab_zds', function() {
            var ids = $(this).attr('id');
            var main_url = "{{ url('update_zds_code') }}";
            var now_action = main_url + "/" + ids;
            $("#form-name_" + ids).attr('action', now_action);
            var platform_code = $("#name-" + ids).val();
            var token = $("input[name='_token']").val();
            var contact_html = "";
            $.ajax({
                url: now_action,
                method: 'POST',
                data: {
                    zds_code: platform_code,
                    _token: token
                },
                success: function(response) {
                    var arr = $.parseJSON(response);
                    if (arr !== null) {
                        if (arr['alert-type'] == "success") {
                            toastr["success"](arr['message']);
                            var passport_id = arr['passport_id'];
                            var platform_name = arr['platform_name'];
                            $("#" + passport_id + "-" + platform_name).html(platform_code);
                        } else {
                            toastr["error"](arr['message']);
                        }
                    }
                }
            });
        });
    </script>

    <script>
        $(document).on('change', '#passport_number', function() {
            var abs = $(this).val();
            $("#name_div").show();
            var token = $("input[name='_token']").val();
            $('#sub_category').empty().trigger("change");
            $.ajax({
                url: "{{ route('ajax_get_unique_passport') }}",
                method: 'POST',
                data: {
                    type: "1",
                    passport_id: abs,
                    _token: token
                },
                success: function(response) {
                    var ab = response.split("$");
                    $("#name_passport").html(ab[1]);
                }
            });
        });
    </script>
    <script>
        $(document).on('click', '.edit_cls', function() {
            var ids = $(this).attr('id');
            $(".appendend_field").remove();
            var action = $("#update_form").attr('action');
            var ab = action.split('usercodes/');
            var action_change = ab[0] + 'usercodes/' + ids;
            $("#update_form").attr('action', action_change);
            var ids = $(this).attr('id');
            var token = $("input[name='_token']").val();
            var contact_html = "";
            $.ajax({
                url: "{{ route('ajax_usercode_edit') }}",
                method: 'POST',
                dataType: 'json',
                data: {
                    passport_id: ids,
                    _token: token
                },
                success: function(response) {
                    $(".append_div").empty();
                    var len = 0;
                    if (response['data'] != null) {
                        len = response['data'].length;
                    }
                    var options = "";
                    if (len > 0) {
                        for (var i = 0; i < len; i++) {
                            var id = response['data'][i].id;
                            var name = response['data'][i].name;
                            var platform_code = response['data'][i].platform_code;
                            var zds_code = response['data'][i].zds_code;
                            var passport_id = response['data'][i].passport_id;
                            var platform_id = response['data'][i].platform_id;

                            var requird = "";
                            requird = "required";
                            if (i == 0) {
                                contact_html += append_zds_code_field(name, id, requird, platform_code,
                                    zds_code);
                            } else{
                                contact_html += append_fields(name, id, requird, platform_code,
                                    zds_code, passport_id, platform_id);
                            }
                        }
                        $(".append_div").append(contact_html);
                    }
                }
            });
            $("#edit_modal").modal('show');
        });

        function append_fields(name, primary_id, required, value, zds_code, passport_id,platform_id) {

            var add_new_btn = `<button data-toggle="modal" data-target="#AddNewPlatformCodeModal" data-passport_id = "${ passport_id }" data-platform_id = "${ platform_id }"  data-platform_name = "${ name }" class="btn btn-sm btn-success btn-icon m-1 add_new_platform_code" type="button">Add new<span class="ul-btn__icon"><i class="i-add"></i></span></button>`;

            var html = '<div class="col-md-12"><form action="{{ route('usercodes.update', 1) }}" id="form-name_' +
                primary_id + '">' +
                '<div class="col-md-9 form-group appendend_field " style="float:left;"><label for="">' +
                name + '</label>' + add_new_btn +
                '<input type="text" name="platform_code" id="name-' + primary_id + '" value="' + value +
                '" class="form-control" ' + required + ' >' +
                '</div>'

            var html_button = '<div class="col-md-3 form-group form-row appenden_field"><button id="' + primary_id +
                '" class="btn btn-sm btn-info btn-icon m-1 update_button_ab update_button_formate" type="button">Update<span class="ul-btn__icon"><i class="i-Yes"></i></span></button></div></form></div>';
            return html + html_button;
        }

        function append_zds_code_field(name, primary_id, required, value, zds_code) {
            var html = '<div class="col-md-12"><form action="{{ route('update_zds_code', 1) }}" id="form-name_' +
                primary_id + '">' +
                '<div class="col-md-9 form-group appendend_field " style="float:left;"><label for="">' +
                name + '</label>' +
                '<input type="text" name="zds_code" id="name-' + primary_id + '" value="' + value +
                '" class="form-control" ' + required + ' >' +
                '</div>'
            var html_button = '<div class="col-md-3 form-group appenden_field"><button id="' + primary_id +
                '" class="btn btn-sm btn-info btn-icon m-1 update_button_ab_zds update_button_formate" type="button">Update <span class="ul-btn__icon"><i class="i-Yes"></i></span></button></div></form></div>';
            return html + html_button;
        }
    </script>
    <script>
        $(".search_type_cls").change(function() {
            var select_v = $(this).val();
            if (select_v == "1") {
                $(".zds_div").hide();
                $("#zds_code").prop('required', false);
                $(".plaform_code_div").show();
                $("#plateform_code").prop('required', true);
                $(".platform_div").show();
                $("#plateform").prop('required', true);
                $('#plateform').select2({
                    placeholder: 'Select an option'
                });
            } else if (select_v == "2") {
                $(".zds_div").show();
                $("#zds_code").prop('required', true);
                $(".plaform_code_div").hide();
                $("#plateform_code").prop('required', false);
                $(".platform_div").hide();
                $("#plateform").prop('required', false);
            }

        });
    </script>

    <script>
        $('.append_div').on('click', '.add_new_platform_code', function() {
            // alert($(this).attr('data-passport_id')  + "/" + $(this).attr('data-platform_id') )
            $('#platform_id').val($(this).attr('data-platform_id'))
            $('#passport_id').val($(this).attr('data-passport_id'))
            $('#platform_name').html($(this).attr('data-platform_name'))
        });
    </script>
    <script>
        $('#new_platform_code_btn').click(function(){
            var _token = "{{ csrf_token() }}";
            var passport_id = $('#passport_id').val()
            var platform_id = $('#platform_id').val()
            var platform_code = $('#new_platform_code').val()
            $.ajax({
                url: "{{ route('add_new_platform_code') }}",
                type:'POST',
                data: { _token, passport_id, platform_id, platform_code },
                success: function(response) {
                    tostr_display(response['alert-type'],response['message'])
                    if(response['status'] == 200){
                        $('#platform_id').val(null)
                        $('#passport_id').val(null)
                        $('#new_platform_code').val(null)
                        $('#AddNewPlatformCodeModal').modal('hide')
                        var platform = response['PlatformCode']
                        var html  =  `<div class="col-md-12">
                                <form action="" id="form-name_${platform['id']}">
                                    <div class="col-md-9 form-group  appendend_field " style="float:left;">
                                        <label for="platform_code">${response['platform_name']}</label>
                                        <button data-toggle="modal"
                                                data-target="#AddNewPlatformCodeModal"
                                                data-passport_id="${platform['passport_id']}"
                                                data-platform_id="${platform['platform_id']}"
                                                data-platform_name="${response['platform_name']}"
                                                class="btn btn-sm btn-success btn-icon m-1 add_new_platform_code"
                                                type="button">
                                                Add new <span class="ul-btn__icon"><i class="i-add"></i></span>
                                        </button>
                                        <input type="text" name="platform_code" id="name-${platform['id']}" value="${platform['platform_code']}" class="form-control" required=""/>
                                    </div>
                                    <div class="col-md-3 form-group form-row appenden_field">
                                        <button id="${platform['id']}" class="btn btn-sm btn-info btn-icon m-1 update_button_ab update_button_formate" type="button">
                                            Update <span class="ul-btn__icon"><i class="i-Yes"></i></span>
                                        </button>
                                    </div>
                                </form>
                            </div>`;
                        $('.append_div').append(html)
                    }
                }
            });
        });
    </script>
    <script>
        @if (Session::has('message'))
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
        function tostr_display(type, message) {
            switch (type) {
                case 'info':
                    toastr.info(message, "Information!", { timeOut:10000 , progressBar : true});
                    break;
                case 'warning':
                    toastr.warning(message, "Warning!", { timeOut:10000 , progressBar : true});
                    break;
                case 'success':
                    toastr.success(message, "Success!", { timeOut:10000 , progressBar : true});
                    break;
                case 'error':
                    toastr.error(message, "Failed!", { timeOut:10000 , progressBar : true});
                    break;
            }
        }
    </script>

@endsection
