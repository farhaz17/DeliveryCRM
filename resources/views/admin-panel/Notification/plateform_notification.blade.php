@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .append_elements {
            white-space: nowrap;
        }
    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Notification</a></li>
            <li>Plateform Notification</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>

    <div class="row mb-4">
        <div class="col-md-6 mb-4">
            <div class="card text-left">
                <div class="card-body">
                    <h4 class="card-title mb-3">Plateform</h4>

                    <form enctype="multipart/form-data" action ="{{ route('plateform_notification.store') }}" method="POST" >
                        {!! csrf_field() !!}
                        <div class="col-md-12  mb-3">
                            <label for="repair_category">Plateform</label>
                            <select id="plateform" name="plateform" class="form-control" required>
                                <option value=""  >Select option</option>
                                @foreach($plateform as $plate)
                                    <option value="{{ $plate->id }}">{{ $plate->name  }}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="all-check">
                            <input type="checkbox" id="checkAll"><strong>&nbsp;&nbsp;Check All</strong><br>
                        </div>
                <div class="append_div_result">
                    <div class="col-md-6 form-group mb-6 " id="names_div">


                    </div>
                </div>




                </div>
            </div>
        </div>


        <div class="col-md-6 mb-4">
            <div class="card text-left">
                <div class="card-body">
                    <h4 class="card-title mb-2">Notification Message</h4>

                        <div class="row">
                        <div class="col-md-12 form-group mb-3">
                            <label for="repair_category">Enter Text Message</label><br>
                            <textarea class="form-control" id="text_msg" name="text_notif" rows="4"  required></textarea>
                        </div>

                        <div class="col-md-12 form-group mb-3">
                            <label for="repair_category" id="copy_label">Select Voice Message</label>
                            <div class="custom-file">
                                <input class="form-control custom-file-input"   accept="audio/*" capture id="recorder"  type="file" name="voice_notif"  />
                                <label class="custom-file-label" for="select_file">Select Voice Message</label>

                            </div>
                        </div>
                        <div class="col-md-12 form-group mb-3">
                            <label for="repair_category" id="copy_label">Select Image</label>
                            <div class="custom-file">
                                <input class="form-control custom-file-input" id="img_notif" type="file" name="img_notif"  />
                                <label class="custom-file-label" for="select_file">Select Image</label>
                            </div>
                        </div>
                        <div class="col-md-12 form-group mb-3">
                            <label for="repair_category" id="copy_label">Select File</label>
                            <div class="custom-file">
                                <input class="form-control custom-file-input"  accept="application/pdf" id="file_notif" type="file" name="file_notif"  />
                                <label class="custom-file-label" for="select_file">Select File</label>
                            </div>
                        </div>

                        <div class="col-md-6 form-group mb-3">
                            <button class="btn btn-primary">Send</button>
                        </div>
{{--                        <div class="col-md-6 form-group mb-3">--}}
{{--                            <button class="btn btn-primary">Share</button>--}}
{{--                        </div>--}}
{{--                        </div>--}}

                    </form>


                </div>
            </div>
        </div>







    </div>




        <div class="col-md-12 mb-4">
            <div class="card text-left">
                <div class="card-body">
                    <h4 class="card-title mb-2">Notification Messages</h4>


                    <div class="row">
                        <div class="col-md-12">
                            <div class="card text-left">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table  class="table" id="datatable">
                                            <thead class="thead-dark">
                                            <tr>
                                                <th scope="col">Plateform</th>
                                                <th scope="col">Text</th>
                                                <th scope="col">Voice</th>
                                                <th scope="col">Image</th>
                                                <th scope="col">File</th>
                                                <th scope="col">Date & Time</th>

                                            </tr>
                                            </thead>
                                            <tbody>
                                         @foreach($notifications as $row)

                                                                                    <tr class="data-row">

                                                                                        <td>{{$row->plateforms_name->name}}</td>
                                                                                        <td>{{$row->text_notif}}</td>
                                                                                        @if(!empty($row->voice_notif))
                                                                                        <td>

                                                                                            <a href="{{$row->voice_notif}}" target="_blank"> Voice Note</a>
                                                                                        </td>
                                                                                        @else
                                                                                            <td>Voice Note Not Found</td>

                                                                                        @endif
                                                                                        @if(!empty($row->img_notif))
                                                                                        <td>

                                                                                            <a href="{{$row->img_notif}}" target="_blank">View Image</a></td>
                                                                                        </td>
                                                                                        @else
                                                                                            <td>Image Note Not Found</td>

                                                                                        @endif


                                                                                        @if(!empty($row->file_notif))
                                                                                            <td><a href="{{$row->file_notif}}" target="_blank">View File</a></td>
                                                                                        </td>
                                                                                        @else
                                                                                            <td>File Note Not Found</td>

                                                                                        @endif

                                                                                        <td>{{$row->created_at}}</td>



                                                                                    </tr>
                                                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    </div>
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



        $("#plateform").change(function () {
            $("#unique_div").css('display','block');
            var plateform_id = $(this).val();
            var token = $("input[name='_token']").val();


            $.ajax({

                url: "{{ route('get_plateform_detail') }}",
                method: 'POST',
                dataType: 'json',
                data: {plateform_id: plateform_id, _token:token},

                order: [[ 1, 'desc' ]],
                pageLength: 10,


                success: function(response) {


                    var len = 0;
                    if(response['data'] != null){
                        len = response['data'].length;
                    }
                    // $(".append_div_result").remove();
                    var options = "";

                    options += '<table  class="table" id="datatable2"> ' +
                        '<thead class="thead-dark" style="display: none">' +
                        '<tr>' +
                        '<th scope="col">Check</th>' +
                        '<th scope="col">Employee Name</th>' +
                        '</tr>' +
                        '</thead>';
                    if(len > 0){
                        for(var i=0; i<len; i++){
                            var given_name = response['data'][i].given_name;
                            var sur_name = response['data'][i].sur_name;
                            var id = response['data'][i].id;
                            var user_id = response['data'][i].user_id;
                            var f_name = response['data'][i].full_name;

                            var full_name =  given_name+' '+sur_name;


                            // options += '<option value="'+id+'" data="'+plateform_count+'">'+given_name+'</option>';


                            options +=  '<div class="append_elements">' +
                                '<tr>' +
                                '<td>' +
                                '<input class="append_elements" type="checkbox" id="user_ids" name="user_ids[]" value="'+user_id+'"> ' +
                                '</td>' +

                                '<td>' +
                                ' <label class="append_elements"  for="vehicle1">'+f_name+'</label>' +
                                '<br>' +
                                '</td>'+
                                '</tr>';

                        }
                        options += '</table >';
                        $("#names_div").empty();
                        $("#names_div").append(options);
                        $("#all-check").show();
                        $('#datatable2').DataTable(
                            {
                                    language: { search: "",
                                    sLengthMenu: "Show _MENU_",
                                    searchPlaceholder: "Search..."
                                },

                            });

                    }else{

                        $("#names_div").empty();
                    }

                }


            });

            $("#checkAll").click(function () {
                $('input:checkbox').not(this).prop('checked', this.checked);
            });
        });

        // $("#checkAll").click(function () {
        //     $('input:checkbox').not(this).prop('checked', this.checked);
        // });

    </script>

    <script>
        $('#plateform').select2({
            placeholder: 'Select an option'
        });
    </script>
            <script>  $(document).ready(function () {
                    'use strict';

                    $('#datatable').DataTable( {

                        "aaSorting": [[0, 'desc']],
                        "pageLength": 10,
                        "columnDefs": [
                            {"targets": [1],"width": "20%"
                            }

                        ],
                        "scrollY": false,
                    });

                });
            </script>
{{--    <script>--}}

{{--                    'use strict';--}}

{{--                    $('#datatable2').DataTable( {--}}
{{--                        "aaSorting": [[0, 'desc']],--}}
{{--                        "pageLength": 10,--}}

{{--                        "scrollY": false,--}}
{{--                    });--}}


{{--            </script>--}}


{{--    <script>--}}
{{--        $(function () {--}}
{{--            let dtOverrideGlobals = {--}}
{{--                processing: true,--}}
{{--                serverSide: true,--}}
{{--                retrieve: true,--}}
{{--                ajax: "{{ route('admin.employees.index') }}",--}}
{{--                columns: [--}}
{{--                    { data: 'id', name: 'id' },--}}
{{--                    { data: 'name', name: 'name' },--}}
{{--                    { data: 'actions', name: 'actions' }--}}
{{--                ],--}}
{{--                order: [[ 1, 'desc' ]],--}}
{{--                pageLength: 100,--}}
{{--            };--}}
{{--            $('.datatable-Employee').DataTable(dtOverrideGlobals);--}}
{{--        });--}}
{{--    </script>--}}



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
{{--        $("#plateform").change(function () {--}}
{{--            $("#unique_div").css('display','block');--}}
{{--            var plateform_id = $(this).val();--}}
{{--            var token = $("input[name='_token']").val();--}}

{{--            $.ajax({--}}
{{--                url: "{{ route('get_plateform_detail') }}",--}}
{{--                method: 'POST',--}}
{{--                data: {plateform_id: plateform_id, _token:token},--}}
{{--                success: function(response) {--}}

{{--                    var res = response.split('$');--}}
{{--                    $("#plateform_id").html(res[0]);--}}
{{--                    $("#sur_name").html(res[1]);--}}
{{--                    $("#unique_div").show();--}}
{{--                }--}}
{{--            });--}}

{{--        });--}}
{{--    </script>--}}



@endsection
