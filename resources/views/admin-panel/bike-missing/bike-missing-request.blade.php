@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        /* css for type ahead only */
        .col-lg-12.sugg-drop_checkout {
            width: 400px;
            line-height: 12px;
            font-size: 12px;
            /*border: 1px solid #775dd0;*/
            /*padding-top: 15px;*/
            /*padding-bottom: 15px;*/

        }
        span#drop-full_name {
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

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/user-dashboard-new') }}">All Modules</a></li>
        <li class="breadcrumb-item"><a href="">LPO Master</a></li>
      <li class="breadcrumb-item active" aria-current="page">Bike Missing Request</li>
    </ol>
</nav>

<form method="post" action="{{ route('store-bike-missing') }}" enctype="multipart/form-data">
    @csrf
    <div class="card container m-auto p-3">
        <div class="bike-details">
        </div>
        <div class="col-md-12 form-check-inline mb-3 text-center " id="name_div" style="display: none;" >
            <label class="radio-outline-success ">Name:</label>
            <h6 id="name_passport" class="text-dark ml-3">PP52026</h6>
            <input type="hidden" id="rider_selected_passport_id" name="rider_passport_id">
            <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
            <label class="radio-outline-success   font-weight-bold ">Plate No:</label>
            <h6 id="name_passport_plate" class="text-dark ml-3 "></h6>
            <label class="radio-outline-success   font-weight-bold mr-3 ml-3 ">Platform:</label>
            <h6 id="name_passport_checkout_platform_name" class="text-dark ml-3 "></h6>
        </div>
        <div class="row">
            <div class="col-md-12 form-check-inline ml-2">
                <label class="radio radio-outline-success">
                    <input type="radio"  class=""  value="1" name="search" checked><span>Search By Bike</span><span class="checkmark"></span>
                </label>
                <label class="radio radio-outline-success ml-2">
                    <input type="radio"  class=""  value="2" name="search" ><span>Search By Person</span><span class="checkmark"></span>
                </label>
            </div>
            <div class="col-md-4 bike-search">
                <label for="repair_category">Select Bike</label>
                <select id="selectBike" name="bike_id" class="form-control select">
                    <option value="">Select Bike</option>
                    @foreach($bikes as $row)
                        <option value="{{ $row->id }}">{{$row->plate_no}} | {{$row->chassis_no}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 form-group mb-0 person-search" style="display:none" >
                <label for="">Search Person</label><br>
                <div class="input-group mb-3">
                    <div class="input-group-prepend"><span class="input-group-text bg-transparent" id="basic-addon1"><i class="i-Magnifi-Glass1"></i></span></div>
                    <input class="form-control typeahead" id="keyword" autocomplete="off" autofocus type="text" value="{{ isset($_GET['passport_id']) ? $_GET['passport_id'] : '' }}" placeholder="Search Rider..." aria-label="Rider" aria-describedby="basic-addon1">
                    <div class="input-group-append"><span class="input-group-text bg-transparent" id="basic-addon2"><i class="i-Search-People"></i></span></div>
                    <div id="clear">X</div>
                </div>
            </div>
            <input type="hidden" id="passportId" name="passport_id">
            <div class="col-md-4">
                <label for="repair_category">Missing Date</label>
                <input id="" name="missing_date" class="form-control" type="datetime-local">
            </div>
            <div class="col-md-4">
                <label for="repair_category">Remarks</label>
                <textarea class="form-control" name="remarks" id="remarks" cols="30" rows="5"></textarea>
            </div>
            <input type="hidden" name="rta" value="1">
            <div class="col-md-4 mt-4">
                <input type="submit" class="btn btn-primary mt-1" value="Add">
            </div>
        </div>
    </div>
</form>

@endsection

@section('js')

<script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>

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

    $('#selectBike').select2({
        placeholder: 'Select the Bike',
        width: '100%'
    });

    $(document).on("change", "#selectBike", function () {
        var id = $("#selectBike").val()
        console.log("hello")
        $.ajax({
            url: "{{ route('get-missing-bike-details') }}",
            method: 'GET',
            dataType: 'json',
            data: {bike_id: id},
            success: function(response) {
                $(".bike-details").show();
                $('.bike-details').html(response);
            }
        });
    });

    $('input[name=search]').change(function() {
        if (this.value == 1) {
            $(".bike-search").show();
            $(".person-search").hide();
        }
        else if (2) {
            $(".bike-search").hide();
            $(".person-search").show();
        }
    });

    var path_autocomplete = "{{ route('accident_autocomplete') }}";
    var get_information_path = "{{ route('get_passport_name_detail') }}";
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
                $(".bike-details").hide();
                $("#name_passport").html(array.name);
                $("#passportId").val(array.id);
                $("#name_passport_checkout_platform_name").html(array.platform_name);
                $("#name_passport_plate").html(array.bike_number);

                $("typeahead .dropdown-menu").html("");
            }
        });
    });

</script>


@endsection
