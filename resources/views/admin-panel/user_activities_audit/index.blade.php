@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />

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
            <li class="breadcrumb-item"><a href="#">User Reports</a></li>
            <li class="breadcrumb-item active" aria-current="page">User Activity Reports</li>
        </ol>
    </nav>
    <div class="separator-breadcrumb border-top"></div>

    <div class="row">
        <div class="col-md-12 mb-4">
            <h4 class="mb-3 text-center">User Activities Log</h4>
            <div class="row">
                <div class="col-md-3 offset-1" id="">
                    <div class="form-group">
                        <label for="start_date">Start Date</label>
                        <input class="form-control form-control-sm" autocomplete="off" type="text" name="start_date" id="start_date" value="{{ date('m-01-Y') }}">
                    </div>
                </div>
                <div class="col-md-3" id="">
                    <div class="form-group">
                        <label for="end_date">End Date</label>
                        <input class="form-control form-control-sm" autocomplete="off" type="text" name="end_date" id="end_date"  value="{{ date('m-t-Y') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class=" form-group">
                        <label for="start_date">Select User</label>
                        <select name="user_id" id="user_id" class="form-control form-control-sm select2">
                            <option value="">Select User</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name ?? "NA" }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-1">
                    <br>
                    <button id="search_activity" class="btn btn-info btn-sm">Search Log</button>
                </div>
            </div>
            <div class="col-sm-12 mb-3">
                <div id="statement_holder"></div>
            </div>
        </div>
        <div class="overlay"></div>
    </div>
@endsection
@section('js')
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script>
        $('.select2').select2({
            placeholder: "Select user"
        });
    </script>
    <script>
        tail.DateTime("#end_date",{
           dateFormat: "YYYY-mm-dd",
           timeFormat: false
       })
        tail.DateTime("#start_date",{
           dateFormat: "YYYY-mm-dd",
           timeFormat: false,
       }).on("change", function(){
           tail.DateTime("#end_date",{
               dateStart: $('#start_date').val(),
               dateFormat: "YYYY-mm-dd",
               timeFormat: false
           }).reload();
       });
   </script>
    <script>
        $(document).ready(function(){
            $('#search_activity').click();
        });
        $('#search_activity').on('click', function() {
            $('body').addClass('loading')
            var start_date = $("input[name='start_date']").val();
            var end_date = $("input[name='end_date']").val();
            var user_id = $("select[name='user_id']").val();
            $.ajax({
                url: "{{ route('ajax_get_user_activities_report') }}",
                method: 'GET',
                dataType: 'json',
                data:{start_date, end_date, user_id},
                success: function (response) {
                    $('#statement_holder').empty();
                    $('#statement_holder').append(response.audit_reports);
                    $('body').removeClass('loading')
                }
            });
        });
    </script>
@endsection
