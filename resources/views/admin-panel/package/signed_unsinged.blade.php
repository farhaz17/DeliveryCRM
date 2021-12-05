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
        .dataTables_filter{
        display: none;
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
        #first-tab {
    background: black;
}
.btn-s {
    padding: 0px;
    font-size: 12px;

}
    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Package</a></li>
            <li>List of signed and unsiged packages</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <!--------Passport Additional Information--------->
    <div class="col-md-12 mb-3">
        <div class="card text-left">
            <div class="card-body">



                <ul class="nav nav-tabs containter mt-4" id="dropdwonTab1">
                    <li class="nav-item"><a  class="nav-link active show tab-btn btn-info   text-white ml-2 mr-2 mt-1" style="padding:4px" id="first-tab" data-toggle="tab" href="#first" aria-controls="first" aria-expanded="true" >Signed Packages({{count($package_sign)}})</a></li>
                    <li class="nav-item"><a class="nav-link tab-btn btn-info text-white ml-2 mr-2  mt-1" style="padding:4px" id="second-tab" data-toggle="tab" href="#second" aria-controls="second" aria-expanded="false">Unsiged Packages ({{count($package_unsign)}})</a></li>
                </ul>

                <div class="tab-content px-1 pt-1" id="dropdwonTabContent1">

                    <div class="tab-pane active show" id="first" role="tabpanel" aria-labelledby="first-tab" aria-expanded="true">

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
                            @foreach($package_sign as $res)


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
                                        class="btn btn-info btn-sm btn-file" onclick="offertLetterStartProcess({{$res->id}})" type="button">
                                                Upload
                                    </button>
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
                    <div class="tab-pane" id="second" role="tabpanel" aria-labelledby="second-tab" aria-expanded="true">
                        <table class="table" id="datatable2" style="width: 100%">
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
                            @foreach($package_unsign as $res)
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
                                        class="btn btn-info btn-sm btn-file" onclick="offertLetterStartProcess({{$res->id}})" type="button">
                                                Upload
                                    </button>
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

                </div> <!----main tab------->

            </div>
        </div>
    </div>
    </div>






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
                        <button class="btn btn-primary">Save</button>
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
    <div class="modal fade bd-example-modal-lg_checkout"  role="dialog" aria-labelledby="exampleModalCenterTitle">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle-1">Package Checkout</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">


                    <form method="post" enctype="multipart/form-data" id="package_assign_checkout">
                        {!! csrf_field() !!}
                    <div class="card card-profile-1 mb-4">
                        <div class="card-body text-center">
                            <input type="hidden" name="passport_id_modal_checkout" id="passport_id_modal_checkout">
                            {{-- <div class="custom-file"> --}}

                                <strong>
                                    <h5> Are you sure want to <strong>Checkout</strong> the package?
                                    </h5>
                               </strong>


                               <div class="col-md-12 form-group mb-3 mt-4">
                                <label for="repair_category">Checkout Date & Time</label>
                                <input class="form-control"id="checkout_time" autocomplete="off" type="datetime-local" placeholder="Enter Checkout" required>

                            </div>

                            {{-- </div> --}}
                        </div>
                    </div>
                    {{-- <div class="col-md-12">
                        <button class="btn btn-primary">Checkout</button>
                    </div> --}}


                </div>
                <div class="modal-footer">

                    <button class="btn btn-primary ml-2" type="submit">Checkout</button>
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                </div>

            </form>
            </div>
        </div>
    </div>
    <div class="overlay"></div>


@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

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
        $(document).ready(function () {
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                var currentTab = $(e.target).attr('id'); // get current tab
                var split_ab = currentTab;
                if(split_ab=="first-tab"){

                    var table = $('#datatable').DataTable();
                    $('#container').css( 'display', 'block' );
                    searching:true;
                    table.columns.adjust().draw();

                }

                else{
                    var table = $('#datatable2').DataTable();
                    $('#container').css( 'display', 'block' );
                    searching:true;
                    table.columns.adjust().draw()
                }
            }) ;
        });
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
        $(document).ready(function () {
            'use strict';
            $('#datatable').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                filter: true,
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
           $('#state').select2({
                placeholder: 'Select an option'
            });
            $('#platform').select2({
                placeholder: 'Select an option'
            });
    </script>


<script>
    $(document).on('click', '#second-tab', function(){

                     var token = $("input[name='_token']").val();
                     $("#second-tab").css("background-color", "black");
                     $("#first-tab").css("background-color", "#663399");

                  });
      </script>

<script>
    $(document).on('click', '#first-tab', function(){

                     $("#second-tab").css("background-color", "#663399");
                     $("#first-tab").css("background-color", "black");

                  });
      </script>

<script>
    function startVisa(id)
                   {
                       var id = id;
                       var url = '{{ route('deactive_packages', ":id") }}';
                       url = url.replace(':id', id);
                       $("#startForm").attr('action', url);
                   }

                   function visaSubmit()
                   {
                       $("#startForm").submit();

                   }
</script>


<script>
    function startVisa2(id)
                   {
                       var id = id;
                       var url = '{{ route('active_packages', ":id") }}';
                       url = url.replace(':id', id);
                       $("#startForm2").attr('action', url);
                   }

                   function visaSubmit2()
                   {
                       $("#startForm2").submit();

                   }
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
