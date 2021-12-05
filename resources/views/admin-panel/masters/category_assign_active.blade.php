@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
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

    /* typeahead css start */

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
        }        span#basic-addon2 {
            border-left: none;
        }
        hr {
            margin-top: 0rem;
            margin-bottom: 0rem;
            border: 0;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
            height: 0;
        }
    /* typeahead ends */
    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Masters</a></li>
            <li>Active/In-Active Category Assign</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    {{--    <div class="row">--}}
    <div class="col-md-12">
        <div class="card mb-12" style="background: #dedede">
            <div class="card-body">
                <div class="card-title mb-3 text-center">Categories Assign to Riders</div>
                <form method="post" action="{{url('active_category_assign_store')}}">
                    @csrf
                    <div class="row">
                        <div class="col-md-3 form-group mb-3 offset-2">
                            <label for="main_category">Select Main Category</label>
                            <select id="main_category" name="main_category" class="form-control" required>
                                <option value=""  >Select option</option>
                                @foreach($main_category as $cate)
                                    <option value="{{ $cate->id }}">{{ $cate->name  }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 form-group mb-3">
                            <label for="sub_category1">Select Sub Category</label>
                            <select id="sub_category" name="sub_category1" class="form-control" required>
                                <option value=""  >Select option</option>
                            </select>
                        </div>
                        <div class="col-md-3 form-group mb-3">
                            <label for="common_status_id">Common Statuses</label>
                            <select id="common_status_id" name="common_status_id" class="form-control" required>
                                <option value=""  >Select option</option>
                                @foreach (config('common_statuses')->where('status', 1) as $common_status)
                                    <option value="{{ $common_status['id'] }}">{{ ucFirst($common_status['name'])}}</option>
                                @endforeach
                            </select>
                        </div>

                        <table class="table table-sm table-hover table-striped text-11" id="no_assigned_riders">
                            <thead>
                                <tr>
                                    <th>
                                        {{-- <input type="checkbox" id="checked_all" name="check_all" value="1"> --}}
                                        ID
                                    </th>
                                    <th>Rider Name</th>
                                    <th>ZDS</th>
                                    <th>PPUID</th>
                                    <th>Passport No</th>
                                    <th class="filtering_column">Platform</th>
                                    <th>Rider ID</th>
                                    <th class="filtering_column" style="white-space: pre">Current DC</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($non_assigned_riders as $passport)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="rider_checbox" name="passport_ids[]" value="{{ $passport->id }}">
                                        {{ $passport->id ?? "NA" }}
                                    </td>
                                    <td>{{ $passport->personal_info->full_name ?? "NA" }}</td>
                                    <td>{{ $passport->zds_code->zds_code ?? "NA" }}</td>
                                    <td>{{ $passport->pp_uid ?? "NA" }}</td>
                                    <td>{{ $passport->passport_no ?? "NA" }}</td>
                                    <td>{{ $passport->platform_assign->where('status',1)->first()->plateformdetail->name ?? "NA" }}</td>
                                    <td>
                                        @foreach ($passport->platform_codes as $rider_code)
                                            {{ $rider_code->platform_code }}
                                                @if(!$loop->last)
                                                {{ ", " }}
                                            @endif
                                        @endforeach
                                    </td>
                                    <td style="white-space: pre">{{ ucFirst($passport->assign_to_dcs->where('status', 1)->first()->user_detail->name ?? "NA") }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="col-md-12 mt-2">
                            <button class="btn btn-sm btn-info float-right">Assign Category To Selected Rider</button>
                        </div>
                    </div>
                </form>
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
                        <form  action="{{action('Master\MasterController@active_category_checkout', '1')}}" id="sim_form" method="post">
                            @method('GET')
                            <input type="hidden" id="primary_id" name="primary_id">
                            @csrf
                            Are you sure want to checkout?
                            <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">No</button>
                                <button class="btn btn-primary">Yes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--------checkout model ends--------->

    <div class="overlay"></div>
@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
    <script>
        $(document).ready(function() {
            $('tbody tr td').on('click', function(event) {
                if (event.target.type !== 'checkbox') {
                    $(':checkbox', this).trigger('click');
                }
            });
        });
        $('#checked_all').change(function(){
            $('.rider_checbox').prop('checked', $(this).prop('checked'))
        })
    </script>
    <script>
        var path = "{{ route('get_rider_list_for_active_inactive_category') }}";
            $('input.typeahead').typeahead({
                source:  function (query, process) {
                    return $.get(path, { query: query }, function (data) {
                        return process(data);
                    });
                },
                highlighter: function (item, data) {
                    var parts = item.split('#'),
                        html = '<div class="row drop-row">';
                    if (data.type == 0) {
                        html += '<div class="col-lg-12 sugg-drop">';
                        html += '<span id="drop-name" class="font-weight-bold">' + data.name+'</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                        html += '<div><br></div>';
                        html += '<span id="drop-full_name">'  + data.full_name  + '</span>';
                        html += '<div><br></div>';
                        html += '<div><hr></div>';
                        html += '</div>';
                    }else if(data.type == 1){
                        html += '<div class="col-lg-12 sugg-drop" >';
                        html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.name + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                        html += '<div><br></div>';
                        html += '<span id="drop-full_name">' +   data.full_name  + '</span>';
                        html += '<div><br></div>'
                        html += '<div><hr></div>';
                        html += '</div>';
                    }else if(data.type==2){
                        html += '<div class="col-lg-12 sugg-drop" >';
                        html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                        html += '<div><br></div>';
                        html += '<span id="drop-full_name">' +  data.name +  '</span>';
                        html += '<div><br></div>'
                        html += '<div><hr></div>';
                        html += '</div>';
                    }else if(data.type==2){
                        html += '<div class="col-lg-12 sugg-drop" >';
                        html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                        html += '<div><br></div>';
                        html += '<span id="drop-full_name">' +  data.name +  '</span>';
                        html += '<div><br></div>'
                        html += '<div><hr></div>';
                        html += '</div>';
                    }else if (data.type==3){
                        html += '<div class="col-lg-12 sugg-drop" >';
                        html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.name + '</span>';
                        html += '<div><br></div>';
                        html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span>';
                        html += '<div><br></div>'
                        html += '<div><hr></div>';
                        html += '</div>';
                    }else if (data.type==4){
                        html += '<div class="col-lg-12 sugg-drop" >';
                        html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                        html += '<div><br></div>';
                        html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                        html += '<div><br></div>'
                        html += '<div><hr></div>';
                        html += '</div>';
                    }else if (data.type==5){
                        html += '<div class="col-lg-12 sugg-drop" >';
                        html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                        html += '<div><br></div>';
                        html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                        html += '<div><br></div>'
                        html += '<div><hr></div>';
                        html += '</div>';
                    }else if (data.type==6){
                        html += '<div class="col-lg-12 sugg-drop" >';
                        html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                        html += '<div><br></div>';
                        html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                        html += '<div><br></div>'
                        html += '<div><hr></div>';
                        html += '</div>';
                    }else if (data.type==7){
                        html += '<div class="col-lg-12 sugg-drop" >';
                        html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                        html += '<div><br></div>';
                        html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                        html += '<div><br></div>'
                        html += '<div><hr></div>';
                        html += '</div>';
                    }else if (data.type==8){
                        html += '<div class="col-lg-12 sugg-drop" >';
                        html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                        html += '<div><br></div>';
                        html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                        html += '<div><br></div>'
                        html += '<div><hr></div>';
                        html += '</div>';
                    }else if (data.type==9){
                        html += '<div class="col-lg-12 sugg-drop" >';
                        html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                        html += '<div><br></div>';
                        html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                        html += '<div><br></div>'
                        html += '<div><hr></div>';
                        html += '</div>';
                    }else if (data.type==10){
                        html += '<div class="col-lg-12 sugg-drop" >';
                        html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                        html += '<div><br></div>';
                        html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                        html += '<div><br></div>'
                        html += '<div><hr></div>';
                        html += '</div>';
                    }
                    return html;
                }
            });
    </script>
    <script>
        $(document).on('click', '.sugg-drop', function(){
            $("body").addClass("loading");
            var keyword = $(this).find('#drop-name').text();
            $.ajax({
                url: "{{ route('ajax_passport_id_for_active_inactive_category') }}",
                method: 'GET',
                data:{keyword},
                success: function (response) {
                    $('#passport_id').val(response.passport_id);
                    $("body").removeClass("loading");
                }
            });
        });
    </script>
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
        $('#main_category, #sub_category, #common_status_id').select2({
            placeholder: "Please select option"
        });
    </script>
    <script>
        $("#main_category").change(function(){
            $('body').addClass('loading')
            var var_ab = $(this).val();
            var token = $("input[name='_token']").val();
            $('#sub_category').empty().trigger("change");
            $.ajax({
                url: "{{ route('ajax_render_subcategory_active') }}",
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
                    }
                    $('body').removeClass('loading')
                }
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            'use strict';
            $('#datatable, #no_assigned_riders').DataTable( {
                initComplete: function () {
                    let filtering_columns = []
                    $(this).children('thead').children('tr').children('th.filtering_column').each(function(i, v){
                        filtering_columns.push(v.cellIndex)
                    });
                    this.api().columns(filtering_columns).every( function () {
                        var column = this;
                        var select = $(`<select class='form-control form-control-sm'><option value="">All</option></select>`)
                            .appendTo( $(column.header()) )
                            .on( 'change', function () {
                                var val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );
                                column
                                    .search( val ? '^'+val+'$' : '', true, false )
                                    .draw();
                            } );

                        column.data().unique().sort().each( function ( d, j ) {
                            select.append( '<option value="'+d+'">'+d+'</option>' )
                        } );
                    } );
                },
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [$(this).children('tr').children('td').length-1],"width": "5%"} // last column width for all tables
                ],
                // dom: 'Bfrtip',
                // buttons: [
                //     {
                //         extend: 'excel',
                //         title: 'Deliveroo Cod',
                //         text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                //         exportOptions: {
                //             modifier: {
                //                 page : 'all',
                //             }
                //         }
                //     },
                //     'pageLength',
                // ],
                "scrollY": true,
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                var currentTab = $(e.target).attr('href');
                $(currentTab +"Table").DataTable().columns.adjust().draw();
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
@endsection
