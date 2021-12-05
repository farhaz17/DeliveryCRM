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
        .dataTables_length{
        display: none;
    }
    .hide_cls{
        display: none;
    }
    #datatable .table th, .table td{
        border-top : unset !important;
    }
    .table th, .table td{
        padding: 2px !important;
    }
    .table th{
        padding: 2px;
        font-size: 12px;
    }
    .table td{
        padding: 2px;
        font-size: 12px;
    }
    .table th{
        padding: 2px;
        font-size: 12px;
        font-weight: 600;
    }
    .btn-file {
    padding: 1px;
    font-size: 10px;
    color: #ffffff;
}

.btn-checkout {
    padding: 1px;
    font-size: 10px;
    color:rgb(0, 0, 255);

}
.submenu{
            display: none;
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
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Package</a></li>
            <li>Assign Package</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>

    <div class="row">

        <div class="col-md-2">
        </div>
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title mb-3">Package Assignment</div>
                    <form method="post" enctype="multipart/form-data" id="package_assign_form">
                        {!! csrf_field() !!}


                        <div class="row">

                            <div class="col-md-3 form-group mb-3">
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Passport</label>
                                <input class="form-control typeahead"     id="keyword" autocomplete="off" type="text" placeholder="search..." aria-label="Username" aria-describedby="basic-addon1">
                                <input type="hidden"   name="passport_id" id="passport_id" >
                            </div>
                            <div class="col-md-3 form-group mb-3">
                            </div>

                            <div class="col-md-12 form-group mb-3" id="info_div" style="display: none">
                            <div class="card card-profile-1 mb-4">
                                <div class="card-body text-center">
                                    <div class="avatar box-shadow-2 mb-3">
                                    <img id="image_show" src="" alt="">
                                    </div>

                                    <h5 class="m-0" id="name_list"></h5>
                                    <p class="mt-0"><span class="badge badge-secondary m-2" id="ppuid"></span></p>
                                    <p class="mt-0" id="passport_no"></p>


                                </div>
                            </div>

                            </div>
                            <div class="col-md-3 form-group mb-3">
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Package</label>
                                <select id="package_val" name="package_val" class="form-control select" required>
                                    <option value="" selected disabled>Select Package</option>
                                    @foreach($packages as $res)
                                        @php
                                            $isSelected=(isset($visa_application_data)?$visa_application_data->id:"")==$res->id;
                                        @endphp
                                        <option value="{{$res->id}}" {{ $isSelected ? 'selected': '' }}>{{$res->package_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 form-group mb-3">
                            </div>



                            <div class="col-md-12 form-group mb-3" id="package_info_div" style="display: none">
                                <div class="row">
                                    <div class="col-md-4 mb-4">
                                    </div>


                                <div class="col-md-4 mb-4">
                                    <div class="card text-left">
                                        <div class="card-body ">
                                            <h4 class="card-title mb-2">Package Information</h4>

                                            <ul class="list-group">

                                                <li class="list-group-item list-group-item-primary font-weight-bold">Limited :<span id="limit_show" class="font-weight-bold" ></span></li>
                                                <li class="list-group-item list-group-item-warning font-weight-bold" style="display: none" id="qty_li">Qunatity :<span id="qty_show" class="font-weight-bold" ></span></li>
                                                <li class="list-group-item list-group-item-danger font-weight-bold">Salary Package :<span  class="font-weight-bold" id="salary_package_show"></span></li>
                                                <li class="list-group-item list-group-item-success font-weight-bold"> Platform :<span id="platform_show"  class="font-weight-bold"></span></li>

                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4 mb-4">
                                </div>

                            </div>

                                {{-- <div class="card card-profile-1 mb-4">
                                    <div class="card-body text-center">
                                        <p class="mt-0 font-weight-bold"> </p>
                                        <p class="mt-0 font-weight-bold" ></p>
                                        <p class="mt-0 font-weight-bold"></p>
                                    </div>
                                </div> --}}

                                </div>


                                <div class="col-md-12 form-group mb-3" id="upload_info_div" style="display: none">
                                    <div class="card card-profile-1 mb-4">
                                        <div class="card-body text-center">
                                            <label  for="select_file">Signed Document(Optional)</label>
                                            {{-- <div class="custom-file"> --}}
                                                <input class="form-control" id="file_attachments" multiple type="file" name="file_attachments[]" />

                                            {{-- </div> --}}
                                        </div>
                                    </div>

                                    </div>


                                    <div class="col-md-12 form-group mb-3" id="checkin_info_div" style="display: none">
                                        <div class="card card-profile-1 mb-4">
                                            <div class="alert alert-danger text-center" id="stop_message1"  role="alert" style="display: none">
                                                <strong class="text-capitalize">Stop! </strong> You cannot select checkin time less than  previous  checkin date. Previous Checkin=<span id="date_span" class="font-weight-bold"></span>.
                                            </div>

                                            <div class="alert alert-danger text-center" id="stop_message102"  role="alert" style="display: none">
                                                <strong class="text-capitalize">Stop! You cannot checkout the package </strong> You need to checkout the package first.
                                            </div>
                                            <div class="card-body text-center">
                                                <label  for="select_file">Checkin Date and Time</label>
                                                {{-- <div class="custom-file"> --}}
                                                    <input value="{{Carbon\Carbon::now()->format('Y-m-d')."T".Carbon\Carbon::now()->format('H:i')}}" class="form-control" id="checkin"  type="datetime-local" name="checkin_time" onchange="handler(event);" required />

                                                {{-- </div> --}}
                                            </div>
                                        </div>

                                        </div>






                            <div class="col-md-12">
                                <button class="btn btn-primary" id='checkout_btn1'>Save</button>
                            </div>

                        </div>






                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-2">
        </div>

    </div>







    <!--------Passport Additional Information--------->


    <div class="col-md-12 mb-3">
        <div class="card text-left">
            <div class="card-body">
                <table class="table" id="datatable" style="width: 100%">
                    <thead>
                    <tr>

                        <th scope="col">Name</th>
                        <th scope="col">Passport No</th>
                        <th scope="col">PPUID</th>
                        <th scope="col">Checkin Time</th>
                        <th scope="col">Checkin Time</th>
                        <th scope="col">Package No</th>
                        <th scope="col">Package Name</th>
                        <th scope="col">Platform</th>
                        <th scope="col">Signed Document Required</th>
                        <th scope="col">Signed Doc</th>
                        <th scope="col">Checkout</th>
                        <th scope="col">Checkout Status</th>

                        {{--  --}}
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($package_assign as $res)

                        <tr>
                            <td>{{isset($res->passport->personal_info->full_name)?$res->passport->personal_info->full_name:""}}</td>
                            <td>{{isset($res->passport->passport_no)?$res->passport->passport_no:""}}</td>
                            <td>{{isset($res->passport->pp_uid)?$res->passport->pp_uid:""}}</td>
                            <td>{{isset($res->checkin_time)?date('d-m-Y H:i:s', strtotime($res->checkin_time)):"N/A"}}</td>
                            <td>{{isset($res->checkout_time)?date('d-m-Y H:i:s', strtotime($res->checkin_out)):"N/A"}}</td>

                            <td><span class="badge badge-pill badge-info">{{isset($res->package->package_no)?$res->package->package_no:""}}</span></td>
                            <td>{{isset($res->package->package_name)?$res->package->package_name:""}}</td>
                            <td>{{isset($res->package->platform_detail->name)?$res->package->platform_detail->name:""}}</td>
                            <td>
                                @if (isset($res->ammentment_package_sign) && $res->ammentment_package_sign=='1' )
                                <span class="badge badge-pill badge-success">Yes</span>
                                @else
                                <span class="badge badge-pill badge-danger">No</span>
                                @endif
                                </td>

                            <td>
                                @if(isset($res->signed_file) && $res->ammentment_package_sign !='1' )
                                @foreach (json_decode($res->signed_file) as $visa_attach)
                                <a class="btn btn-success btn-file" href="{{Storage::temporaryUrl('assets/upload/packages_assign/'.$visa_attach, now()->addMinutes(5))}}"  target="_blank">
                                  View Attachment
                                </a>
                                    <span>|</span>
                                @endforeach
                                @else


                                <button
                                    class="btn btn-info btn-sm btn-file"
                                    @if(isset($res->status) && $res->status=='1' )
                                    disabled
                                    @endif
                                     onclick="offertLetterStartProcess({{$res->id}})" type="button">Upload</button>
                                @endif

                            </td>
                            <td>
                                <button
                                class="btn btn-warning btn-sm btn-checkout"
                                @if (isset($res->status) && $res->status=='1' )
                                disabled
                                @endif
                                onclick="checkout_rider({{$res->id}})" type="button">
                                        Checkout
                            </button>
                            </td>

                            <td>
                                @if (isset($res->status) && $res->status=='1' )
                                <span class="badge badge-pill badge-success">Yes</span>
                                @else
                                <span class="badge badge-pill badge-danger">No</span>
                                @endif
                                </td>
                        </tr>
                    @endforeach


                    </tbody>
                </table>

            </div>
        </div>
    </div>
    </div>

    <div class="overlay"></div>

    <div class="modal fade bd-example-modal-lg"  role="dialog" aria-labelledby="exampleModalCenterTitle">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">

                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <form method="post" enctype="multipart/form-data" id="package_assign_form_file">
                        {!! csrf_field() !!}
                    <div class="card card-profile-1 mb-4">
                        <div class="card-body text-center">
                            <input type="hidden" name="passport_id_modal" id="passport_id_modal">
                            {{-- <div class="custom-file"> --}}
                                <label for="select_file">Signed Document</label>
                                <input class="form-control" id="file_attachments2" required multiple type="file" name="file_attachments2[]" />

                            {{-- </div> --}}
                        </div>
                    </div>
                    <div class="col-md-12">
                        <button class="btn btn-primary" id="checkout_btn1">Save</button>
                    </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    {{-- <button class="btn btn-primary ml-2" type="button">Save changes</button> --}}
                </div>
            </div>
        </div>
    </div>


    {{-- -------------------------------------------- --}}

    <div class="modal fade bd-example-modal-lg_checkout"  role="dialog" aria-labelledby="exampleModalCenterTitle">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle-1">Package Checkout</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">

                    <div class="alert alert-danger text-center" id="stop_message2" style="display: none"  role="alert">
                        <strong class="text-capitalize">Stop! </strong> You cannot select checkin time less than  previous  checkin date. Previous Checkin=<span id="date_span2" class="font-weight-bold"></span>.
                    </div>
                    <form method="post" enctype="multipart/form-data" id="package_assign_checkout">
                        {!! csrf_field() !!}
                    <div class="card card-profile-1 mb-4">
                        <div class="card-body text-center">

                            <input type="hidden" name="passport_id_modal_checkout" id="passport_id_modal_checkout">
                            {{-- <div class="custom-file"> --}}

                                <strong>
                                    <h5> Are you sure want to <strong>Checkout</strong> the package?</h5>
                               </strong>


                               <div class="col-md-12 form-group mb-3 mt-4">
                                <label for="repair_category">Checkout Date & Time</label>
                                <input value="{{Carbon\Carbon::now()->format('Y-m-d')."T".Carbon\Carbon::now()->format('H:i')}}" onchange="handler2(event);" class="form-control" id="checkout_time" name="checkout_time" autocomplete="off" type="datetime-local" placeholder="Enter Checkout" required>

                            </div>

                            {{-- </div> --}}
                        </div>
                    </div>
                    {{-- <div class="col-md-12">
                        <button class="btn btn-primary">Checkout</button>
                    </div> --}}


                </div>
                <div class="modal-footer">

                    <button class="btn btn-primary ml-2" id="checkout_btn" type="submit">Checkout</button>
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                </div>

            </form>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
<script>
    function offertLetterStartProcess(id)
        {
            var id=id;
            var token = $("input[name='_token']").val();
            $('#passport_id').val("");
            $('#passport_id_modal').val(id);
            $('.bd-example-modal-lg').modal('show');

        }
</script>

<script>
    function checkout_rider(id)
        {
            var id=id;
            var token = $("input[name='_token']").val();
            $('#passport_id_checout').val("");
            $('#passport_id_modal_checkout').val(id);
            $('.bd-example-modal-lg_checkout').modal('show');

        }
</script>

<script>
    $(document).ready(function (e){
    $("#package_assign_form_file").on('submit',(function(e){
        e.preventDefault();
        $.ajax({

            url: "{{ route('package_assign_save_file') }}",
            type: "POST",
            data:  new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function () {
                            $("body").addClass("loading");
                    },
            success: function(response){
                $("#package_assign_form_file").trigger("reset");
                if(response.code == 100) {
                    toastr.success("File Uploaded Successfully!", { timeOut:10000 , progressBar : true});
                    $("body").removeClass("loading");
                    location.reload();
                }


                else {
                    toastr.error("Something Went Wrong!", { timeOut:10000 , progressBar : true});
                    $("body").removeClass("loading");
                }
            },
            error: function(){}
        });
    }));
});
</script>

<script>
    $(document).ready(function (e){
    $("#package_assign_form").on('submit',(function(e){
        e.preventDefault();
        $.ajax({

            url: "{{ route('package_assign_save') }}",
            type: "POST",
            data:  new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function () {
                            $("body").addClass("loading");
                    },
            success: function(response){
                $("#package_assign_form").trigger("reset");
                if(response.code == 100) {
                    toastr.success("Package Assigned Successfully!", { timeOut:10000 , progressBar : true});

                    $("body").removeClass("loading");
                    location.reload();
                }
                else if(response.code == 105){
                    toastr.error("Package is already assigned to this rider!", { timeOut:10000 , progressBar : true});
                    $("body").removeClass("loading");

                }

                else {
                    toastr.error("Something Went Wrong!", { timeOut:10000 , progressBar : true});
                    $("body").removeClass("loading");
                }
            },
            error: function(){}
        });
    }));
});
</script>



<script>
    $(document).ready(function (e){
    $("#package_assign_checkout").on('submit',(function(e){
        e.preventDefault();
        $.ajax({

            url: "{{ route('package_assign_checkout') }}",
            type: "POST",
            data:  new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function () {
                            $("body").addClass("loading");
                    },
            success: function(response){
                $("#package_assign_checkout").trigger("reset");
                if(response.code == 105) {
                    toastr.success("Package Checkout Successfull", { timeOut:10000 , progressBar : true});
                    $("body").removeClass("loading");
                    location.reload();
                }
                else if(response.code == 101){

                    toastr.error("Checkout date cannot be less than checkin date", { timeOut:10000 , progressBar : true});
                    $("body").removeClass("loading");
                    location.reload();

                }
                else if(response.code == 102){
                    toastr.error("Please checkout first", { timeOut:10000 , progressBar : true});
                    $("body").removeClass("loading");
                    location.reload();

                }


                else {
                    toastr.error("Something Went Wrong!", { timeOut:10000 , progressBar : true});
                    $("body").removeClass("loading");
                }
            },
            error: function(){}
        });
    }));
});
</script>



    <script type="text/javascript">
        var path = "{{ route('autocomplete') }}";
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
                }
                else if(data.type == 1){
                    html += '<div class="col-lg-12 sugg-drop" >';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.name + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name">' +   data.full_name  + '</span>';
                    html += '<div><br></div>'
                    html += '<div><hr></div>';
                    html += '</div>';
                }
                else if(data.type==2){
                    html += '<div class="col-lg-12 sugg-drop" >';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name">' +  data.name +  '</span>';
                    html += '<div><br></div>'
                    html += '<div><hr></div>';
                    html += '</div>';
                }  else if(data.type==2){
                    html += '<div class="col-lg-12 sugg-drop" >';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name">' +  data.name +  '</span>';
                    html += '<div><br></div>'
                    html += '<div><hr></div>';
                    html += '</div>';
                }
                else if (data.type==3){
                    html += '<div class="col-lg-12 sugg-drop" >';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.name + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span>';
                    html += '<div><br></div>'
                    html += '<div><hr></div>';
                    html += '</div>';
                }
                else if (data.type==4){
                    html += '<div class="col-lg-12 sugg-drop" >';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                    html += '<div><br></div>'
                    html += '<div><hr></div>';
                    html += '</div>';
                }
                else if (data.type==5)
                {
                    html += '<div class="col-lg-12 sugg-drop" >';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                    html += '<div><br></div>'
                    html += '<div><hr></div>';
                    html += '</div>';
                }
                else if (data.type==6) {
                    html += '<div class="col-lg-12 sugg-drop" >';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                    html += '<div><br></div>'
                    html += '<div><hr></div>';
                    html += '</div>';
                }
                else if (data.type==7) {
                    html += '<div class="col-lg-12 sugg-drop" >';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                    html += '<div><br></div>'
                    html += '<div><hr></div>';
                    html += '</div>';
                }
                else if (data.type==8) {
                    html += '<div class="col-lg-12 sugg-drop" >';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                    html += '<div><br></div>'
                    html += '<div><hr></div>';
                    html += '</div>';
                }
                else if (data.type==9) {
                    html += '<div class="col-lg-12 sugg-drop" >';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                    html += '<div><br></div>'
                    html += '<div><hr></div>';
                    html += '</div>';
                }
                else if (data.type==10) {
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
  function handler(e){

            var passport_id= $("input[name='passport_id']").val();
            var datee= $("input[name='checkin_time']").val();
            var token = $("input[name='_token']").val();
            $('#checkout_btn1').removeAttr('disabled');
            $('#checkout_btn').removeAttr('disabled');

            $.ajax({
                url: "{{ route('get_date_detail') }}",
                method: 'POST',
                dataType: 'json',
                data:{passport_id:passport_id,datee:datee,_token:token},

                success: function(response){
                if(response.code == 100) {
                    $('#date_span').empty();
                    $('#stop_message102').hide();
                    $('#stop_message1').show();
                    $('#checkout_btn1').attr('disabled','disabled');
                    $('#date_span').append(response.date);

                }
                else if(response.code == 101){

                    $('#date_span').empty();
                    $('#stop_message102').show();
                    $('#stop_message1').hide();
                    $('#checkout_btn1').attr('disabled','disabled');

                }
                else{

                }

            },
            error: function(){}

            });

}
        </script>

<script>
    function handler2(e){

              var passport_id= $("input[name='passport_id_modal_checkout']").val();
              var datee= $("input[name='checkout_time']").val();
              var token = $("input[name='_token']").val();
              $('#stop_message2').hide();
              $('#checkout_btn').removeAttr('disabled');
              $.ajax({
                  url: "{{ route('get_checkout_date_detail') }}",
                  method: 'POST',
                  dataType: 'json',
                  data:{passport_id:passport_id,datee:datee,_token:token},

                  success: function(response){
                  if(response.code == 100) {
                    //
                    $('#checkout_btn').attr('disabled','disabled');
                      $('#date_span2').empty();
                      $('#stop_message2').show();
                      $('#date_span2').append(response.date);


                  }

              },

              });

  }
          </script>
<script>
$('.bd-example-modal-lg_checkout').on('hidden.bs.modal', function () {

    $('#checkout_btn').removeAttr('disabled');
                      $('#date_span2').empty();
                      $('#stop_message2').hide();

  })
</script>



    <script>
        $(document).on('click', '.sugg-drop', function(){
            var token = $("input[name='_token']").val();
            var keyword  =   $(this).find('#drop-name').text();
                    $('#date_span').empty();
                    $('#stop_message102').hide();
                    $('#stop_message1').hide();
                    $('#checkout_btn1').removeAttr('disabled');
                    $('#checkout_btn').removeAttr('disabled');
            $.ajax({
                url: "{{ route('get_rider_detail') }}",
                method: 'POST',
                dataType: 'json',
                data:{keyword:keyword,_token:token},

                success: function(response){
                if(response.code == 100) {
                    $('#name_list').empty();
                    $('#ppuid').empty();
                    $('#passport_no').empty();


                    $('#info_div').show();
                    $('#passport_id').val(response.passport_id);
                    $('#name_list').append(response.name);
                    $('#ppuid').append(response.ppuid);
                    $('#passport_no').append(response.passport_no);
                    if(response.image==''){

                    $("#image_show").attr("src",asset('assets/images/user_avatar.jpg'));
                    }else{
                        $("#image_show").attr("src",response.image);
                    }
                }

            },

            });
        });
        </script>

<script>
    $("#package_val").change(function(){
        var val = $(":selected",this).val();
        var token = $("input[name='_token']").val();


        $.ajax({
                    url: "{{ route('get_package_detail') }}",
                    method: 'POST',
                    dataType: 'json',
                    data:{val:val,_token:token},
                    success: function(response){
                    if(response.code == 100) {
                        $('#package_info_div').show();
                        $('#upload_info_div').show();
                        $('#checkin_info_div').show();


                        $('#limit_show').empty();
                        $('#salary_package_show').empty();
                        $('#platform_show').empty();
                        $('#qty_show').empty();

                        $('#limit_show').append(response.limit);
                        $('#salary_package_show').append(response.salary_package);
                        $('#platform_show').append(response.platform);

                        $('input[name=checkin]').val(datetime);


                        if(response.limitation=='0'){
                            $('#qty_show').append(response.qty);
                            $('#qty_li').show();
                        }
                        else{
                            $('#qty_li').hide();
                        }



                    }

                },

                });
        })
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
                        title: 'Report',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
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
    if(Session::has('message')){
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
    }
</script>


<script>
    $('#package_val').select2({
         placeholder: 'Select an option'
     });

</script>



@endsection
