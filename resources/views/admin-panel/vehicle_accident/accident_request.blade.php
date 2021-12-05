@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <style>
        /* css for type ahead only */
        .col-lg-12.sugg-drop_checkout {
            width: 400px;
            line-height: 12px;
            font-size: 12px;
        }
        span#drop-full_name {
            font-size: 10px;
        }
        /* ul.typeahead.dropdown-menu {
            height: 400px;
            overflow: hidden;
            width: 770px;
        }
        ul.typeahead.dropdown-menu:hover {
            height: 400px;
            overflow: scroll;
        } */
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
            background: #ffffff;
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
        <li><a href="">Vehicle Accident</a></li>
        <li>Accident Requests</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="col-md-12 mb-3">
    <div class="card text-left">
        <div class="card-body">

            <div class="card-title">Accident Requests</div>
            <form action="{{ route('save_vehicle_accident_request') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-12 form-check-inline mb-3 text-center" id="name_div" style="display: none;" >
                        <label class="radio-outline-success ">Name:</label>
                        <h6 id="name_passport" class="text-dark ml-3">PP52026</h6>
                        <input type="hidden" id="rider_selected_passport_id" name="rider_passport_id">
                        <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                        <label class="radio-outline-success   font-weight-bold ">Plate No:</label>
                        <h6 id="name_passport_plate" class="text-dark ml-3 "></h6>
                        <label class="radio-outline-success   font-weight-bold mr-3 ml-3 ">Platform:</label>
                        <h6 id="name_passport_checkout_platform_name" class="text-dark ml-3 "></h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 form-group mb-0" style="float:left;" >
                        <label for="">Select Bike</label><br>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend"><span class="input-group-text bg-transparent" id="basic-addon1"><i class="i-Magnifi-Glass1"></i></span></div>
                            <input class="form-control typeahead" id="keyword" autocomplete="off" autofocus type="text" value="{{ isset($_GET['passport_id']) ? $_GET['passport_id'] : '' }}" placeholder="Search Rider..." aria-label="Rider" aria-describedby="basic-addon1">
                            <div class="input-group-append"><span class="input-group-text bg-transparent" id="basic-addon2"><i class="i-Search-People"></i></span></div>
                            <div id="clear">X</div>
                        </div>
                    </div>
                    <div class="col-md-4 form-group mb-3">
                        <label for="">Accident Date</label><br>
                        <input type="datetime-local" class="form-control" autocomplete="off" name="accident_date" id="accident_date" required>
                    </div>
                    <div class="col-md-4 form-group mb-3">
                        <label for="">Location</label><br>
                        <input type="text" name="location" class="form-control" autocomplete="off" id="location" required>
                    </div>
                    <div class="col-md-4 form-group mb-3">
                        <label for="">Rider Condition</label><br>
                        <select class="form-control" name="rider_condition" id="rider_condition" required >
                            <option value="" selected disabled >select an option</option>
                            <option value="1" >Normal</option>
                            <option value="2" >Serious</option>
                            <option value="3" >Death</option>
                        </select>
                    </div>
                    <div class="col-md-4 form-group mb-3 check_type" style="display: none">
                        <label for="">Checkout Type</label><br>
                        <select class="form-control" name="checkout_type" id="checkout" >
                            <option value="" selected disabled >select an option</option>
                            <option value="1" >Complete Checkout</option>
                            <option value="2" >Only Bike Replacement</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="">Police Report</label><br>
                        <input type="radio" name="police_report" id="recived" value="1">
                        <label for="">Received</label>&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="police_report" id="pending" value="2">
                        <label for="">Pending</label>
                    </div>
                    <div class="col-md-4 form-group upload" style="display: none">
                        <label for="">Upload Report</label>
                        <input type="file" name="attachment[]" multiple class="form-control-file" id="">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label for="">Remark</label>
                        <textarea name="remark" class="form-control" id="" cols="5" rows="3"></textarea>
                    </div>
                    <div class="col-md-12"><br>
                        <button class="btn btn-info">Save</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
    <script>
        var paths = "{{ url('location_autocomplete') }}";

        $('#location').typeahead({
            source: function(query, process){
                return $.get(paths, {query:query}, function(data){
                    return process(data);
                });
            }
        });
    </script>
    <script>
        var path_autocomplete = "{{ route('accident_autocomplete') }}";
        var get_information_path = "{{ route('get_passport_name_detail') }}";
    </script>
    <script>
        $('input[name="police_report"]').on('change',function(){
            if($(this).val() == "1"){
                $(".upload").show()
            }else if($(this).val() == "2"){
                $(".upload").hide()
            }
        });
    </script>
    <script>
        $('#rider_condition').on('change',function(){
            if($(this).val() == "1"){
                $(".check_type").show()
            }else{
                $(".check_type").hide()
            }
        });
    </script>
    <script>
    var path = path_autocomplete;
    var checked_or_not = "0";

    $('input.typeahead').typeahead({
        source:  function (query, process) {
            if($("#search_all_over").prop('checked') == true){
                checked_or_not = "1";
            }else{
                checked_or_not = "0";
            }
            return $.get(path, { query: query,checked_or_not: checked_or_not }, function (data) {

                return process(data);
            });
        },
        highlighter: function (item, data) {
            var parts = item.split('#'),
                html = '<div class="row drop-row">';
            if (data.type == 0) {
                html += '<div class="col-lg-12 sugg-drop_checkout">';
                html += '<span id="drop-name" class="font-weight-bold">' + data.name+'</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                html += '<div><br></div>';
                html += '<span id="drop-full_name">'  + data.full_name  + '</span>';
                html += '<div><br></div>';
                html += '<div><hr></div>';
                html += '</div>';
            }
            else if(data.type == 1){
                html += '<div class="col-lg-12 sugg-drop_checkout" >';
                html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.name + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                html += '<div><br></div>';
                html += '<span id="drop-full_name">' +   data.full_name  + '</span>';
                html += '<div><br></div>'
                html += '<div><hr></div>';
                html += '</div>';
            }
            else if(data.type==2){
                html += '<div class="col-lg-12 sugg-drop_checkout" >';
                html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                html += '<div><br></div>';
                html += '<span id="drop-full_name">' +  data.name +  '</span>';
                html += '<div><br></div>'
                html += '<div><hr></div>';
                html += '</div>';
            }  else if(data.type==2){
                html += '<div class="col-lg-12 sugg-drop_checkout" >';
                html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                html += '<div><br></div>';
                html += '<span id="drop-full_name">' +  data.name +  '</span>';
                html += '<div><br></div>'
                html += '<div><hr></div>';
                html += '</div>';
            }
            else if (data.type==3){
                html += '<div class="col-lg-12 sugg-drop_checkout" >';
                html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.name + '</span>';
                html += '<div><br></div>';
                html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span>';
                html += '<div><br></div>'
                html += '<div><hr></div>';
                html += '</div>';
            }
            else if (data.type==4){
                html += '<div class="col-lg-12 sugg-drop_checkout" >';
                html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                html += '<div><br></div>';
                html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                html += '<div><br></div>'
                html += '<div><hr></div>';
                html += '</div>';
            }
            else if (data.type==5)
            {
                html += '<div class="col-lg-12 sugg-drop_checkout" >';
                html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                html += '<div><br></div>';
                html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                html += '<div><br></div>'
                html += '<div><hr></div>';
                html += '</div>';
            }
            else if (data.type==6) {
                html += '<div class="col-lg-12 sugg-drop_checkout" >';
                html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                html += '<div><br></div>';
                html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                html += '<div><br></div>'
                html += '<div><hr></div>';
                html += '</div>';
            }
            else if (data.type==7) {
                html += '<div class="col-lg-12 sugg-drop_checkout" >';
                html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                html += '<div><br></div>';
                html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                html += '<div><br></div>'
                html += '<div><hr></div>';
                html += '</div>';
            }
            else if (data.type==8) {
                html += '<div class="col-lg-12 sugg-drop_checkout" >';
                html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                html += '<div><br></div>';
                html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                html += '<div><br></div>'
                html += '<div><hr></div>';
                html += '</div>';
            }
            else if (data.type==9) {
                html += '<div class="col-lg-12 sugg-drop_checkout" >';
                html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                html += '<div><br></div>';
                html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                html += '<div><br></div>'
                html += '<div><hr></div>';
                html += '</div>';
            }
            else if (data.type==10) {
                html += '<div class="col-lg-12 sugg-drop_checkout" >';
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

    $(document).on('click', '.sugg-drop_checkout', function(){
        var token = $("input[name='_token']").val();
        var keyword  =   $(this).find('#drop-name').text();
        var ids =  $(this).find('#drop-name').data("name");
        var token = $("input[name='_token']").val();

        $.ajax({
            url: get_information_path,
            method: 'POST',
            data: {passport_id: keyword ,_token:token},
            success: function(response) {

                var  array = JSON.parse(response);
                $("#name_div").show();
                $("#name_passport").html(array.name);
                $("#rider_selected_passport_id").val(array.id);
                $("#name_passport_checkout_platform_name").html(array.platform_name);
                $("#name_passport_plate").html(array.bike_number);

                $("typeahead .dropdown-menu").html("");
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
@endsection
