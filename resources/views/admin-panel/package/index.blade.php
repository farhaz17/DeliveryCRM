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
            <li>Package List/Add Package</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>

    <div class="row">

        <div class="col-md-2">
        </div>
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title mb-3">Package Details</div>
                    <form method="post" enctype="multipart/form-data" action="{{isset($visa_application_data)?route('packages.update',$visa_application_data->id):route('packages.store')}}">
                        {!! csrf_field() !!}
                        @if(isset($visa_application_data))
                            {{ method_field('PUT') }}
                        @endif
                        <input type="hidden" id="id" name="id" value="{{isset($visa_application_data)?$visa_application_data->id:""}}">
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Package Name</label>
                                <input class="form-control" id="package_name" name="package_name" value="{{isset($visa_application_data)?$visa_application_data->file_number:""}}" type="text" placeholder="Enter the package name" required />
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">State</label>
                                <select id="state" name="state" required class="form-control select">
                                    <option value="">Select State</option>
                                    @foreach($states as $state)
                                        @php
                                            $isSelected=(isset($visa_application_data)?$visa_application_data->state_id:"")==$state->id;
                                        @endphp
                                        <option value="{{$state->id}}" {{ $isSelected ? 'selected': '' }}>{{$state->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Platform</label>
                                <select id="platform" name="platform" class="form-control select" required>
                                    <option value="">Select State</option>
                                    @foreach($platform as $row)
                                        @php
                                            $isSelected=(isset($visa_application_data)?$visa_application_data->state_id:"")==$state->id;
                                        @endphp
                                        <option value="{{$row->id}}" {{ $isSelected ? 'selected': '' }}>{{$row->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                                <div class="col-md-6 form-group mb-3">
                                    <label for="repair_category">Limitation</label>
                                    <select id="limitation" name="limitation" class="form-control select" required>
                                        <option value="">Select State</option>
                                        <option value="0">Yes</option>
                                        <option value="1">No</option>
                                    </select>
                                </div>
                                <div class="col-md-6 form-group mb-3" id="qty_div" style="display: none">
                                    <label for="repair_category">Qty</label>
                                    <input class="form-control" id="qty" name="qty" value="{{isset($visa_application_data)?$visa_application_data->file_number:""}}" type="text" placeholder="Enter QTY"  />
                                </div>
                                <div class="col-md-6 form-group mb-3">
                                    <label for="repair_category">Salary Package</label>
                                    <input class="form-control form-control" id="salary_package" value="{{isset($visa_application_data)?$visa_application_data->issue_date:""}}" name="salary_package" type="text" placeholder="Enter salary package" />
                                </div>



                            @if(isset($visa_application_data))
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category">Scanned Visa Copy</label><br>

                                    <br>

                                    <input class="form-control form-control" value="{{isset($visa_application_data)?$visa_application_data->attachment:""}}" id="temp_file" name="temp_file" type="hidden"   />

                                    <a class="attachment_display" href="{{ isset($visa_application_data->attachment) ? url($visa_application_data->attachment) : ''  }}" id="passport_image" target="_blank"><strong style="color: blue">Scanned Visa Copy</strong></a>
                            </div>
                            @endif
                            <div class="col-md-6 form-group mb-3">
                                <label for="repair_category" id="copy_label"> Attachment</label>
                                {{-- <div class="custom-file"> --}}
                                    <input class="form-control" id="file_attachments" multiple type="file" name="file_attachments[]" />

                                {{-- </div> --}}
                            </div>
                            <div class="col-md-12">
                                <button class="btn btn-primary">Save Package</button>
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



                <ul class="nav nav-tabs containter mt-4" id="dropdwonTab1">
                    <li class="nav-item"><a  class="nav-link active show tab-btn btn-info   text-white ml-2 mr-2 mt-1" style="padding:4px" id="first-tab" data-toggle="tab" href="#first" aria-controls="first" aria-expanded="true" >Active Packages</a></li>
                    <li class="nav-item"><a class="nav-link tab-btn btn-info text-white ml-2 mr-2  mt-1" style="padding:4px" id="second-tab" data-toggle="tab" href="#second" aria-controls="second" aria-expanded="false">Inactive Packages</a></li>
                </ul>

                <div class="tab-content px-1 pt-1" id="dropdwonTabContent1">

                    <div class="tab-pane active show" id="first" role="tabpanel" aria-labelledby="first-tab" aria-expanded="true">

                <table class="table" id="datatable" style="width: 100%">
                    <thead>
                    <tr>
                        <th scope="col">Package No</th>
                        <th scope="col">Package Name</th>
                        <th scope="col">Platform</th>
                        <th scope="col">State</th>
                        <th scope="col">Salary Package</th>
                        <th scope="col">Limitation</th>
                        <th scope="col">Qty</th>
                        <th scope="col">File</th>
                        <th scope="col">No Of Riders</th>
                        <th scope="col">View Riders List</th>
                        <th scope="col">Ammendment</th>
                        <th scope="col">Ammend</th>
                        <th scope="col">No Of Ammendments</th>
                        <th scope="col">Amendment By</th>
                        <th scope="col">Action</th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($packages as $res)
                        <tr>
                            <td> <a class="badge badge-primary" href="#">{{isset($res->package_no)?$res->package_no:""}}</a></td>
                            <td>{{isset($res->package_name)?$res->package_name:""}}</td>
                            <td>{{$res->state_detail->name}}</td>
                            <td>{{$res->platform_detail->name}}</td>
                            <td>{{ isset($res->salary_package)?$res->salary_package:""}}</td>
                            <td>
                                @if(isset($res->limitation) && $res->limitation=='0' )

                                <span class="badge badge-pill badge-success">Yes</span>
                                @else
                                <span class="badge badge-pill badge-danger">No</span>

                                @endif
                            </td>
                            <td>{{isset($res->qty)?$res->qty:""}}</td>

                            <td>
                                @if(isset($res->file_attachments))
                                @foreach (json_decode($res->file_attachments) as $visa_attach)
                                <a class="btn btn-success btn-file" href="{{Storage::temporaryUrl('assets/upload/packages/'.$visa_attach, now()->addMinutes(5))}}"  target="_blank">
                                    View Attachment
                                </a>
                                    <span>|</span>
                                @endforeach
                                @else
                                N/A
                                @endif

                            </td>

                                <td><span class="badge badge-round-secondary">{{count($package_assign->where('package_id',$res->id))}}</span></td>

                                <td>

                                    <a class="text-success mr-2" href="{{route('view_riders',$res->id)}}" target="_blank"><i class="text-20 i-Full-View-Window"></i></a>

                                </td>
                                <td>
                                    @if(isset($res->amendment) && $res->amendment=='0' )

                                    <span class="badge badge-pill badge-success">Yes</span>
                                    @else
                                    <span class="badge badge-pill badge-danger">No</span>

                                    @endif
                                </td>

                                <td>
                                <button
                                class="btn btn-info btn-sm btn-file" onclick="offertLetterStartProcess({{$res->id}})" type="button">
                                        Ammend
                                </button>
                                </td>
                                <td>
                                    <span class="badge badge-round-secondary"> {{isset($res->amendment_times)?$res->amendment_times:"0"}}
                                    </span>
                                </td>
                                <td>

                                    {{isset($res->user_ammend->name)?$res->user_ammend->name:"N/A"}}
                                </td>


                                <td>

                                    <button class="btn btn-danger btn-s  btn-icon"  data-toggle="modal"
                                     data-target=".bd-example-modal-lg" onclick="startVisa({{$res->id}})"
                                      type="button">
                                      Deactivate
                                    </button>


                                </td>



                        </tr>
                    @endforeach


                    </tbody>
                </table>

                    </div>
                    <div class="tab-pane" id="second" role="tabpanel" aria-labelledby="second-tab" aria-expanded="true">
                    <div class="div-2"></div>
                    </div>

                </div> <!----main tab------->

            </div>
        </div>
    </div>
    </div>






    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="" id="startForm" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle-1">Deactivation Confirmation</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    {{-- <div class="alert alert-warning" role="alert">
                        <strong class="text-capitalize">Warning!</strong> File deleted once, uploaded data will be deleted permanently!.

                    </div> --}}
                    <div class="modal-body">
                        {{csrf_field()}}
                        {{method_field('GET')}}
                      <strong>
                           <h5> Are you sure want to Deactivate the package?
                           </h5>
                      </strong>
                    </div>



                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-danger ml-2" type="submit" onclick="visaSubmit()">Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade bd-example-modal-lg2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="" id="startForm2" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle-1">Deactivation Confirmation</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    {{-- <div class="alert alert-warning" role="alert">
                        <strong class="text-capitalize">Warning!</strong> File deleted once, uploaded data will be deleted permanently!.

                    </div> --}}
                    <div class="modal-body">
                        {{csrf_field()}}
                        {{method_field('GET')}}
                      <strong>
                           <h5> Are you sure want to Activate the package?
                           </h5>
                      </strong>
                    </div>



                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-success ml-2" type="submit" onclick="visaSubmit2()">Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <div class="modal fade bd-example-modal-lg-upload"  role="dialog" aria-labelledby="exampleModalCenterTitle">
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
                                <label for="select_file">Ammended Document</label>
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
                $('.bd-example-modal-lg-upload').modal('show');

            }
    </script>

<script>
    $(document).ready(function (e){
    $("#package_assign_form_file").on('submit',(function(e){
        e.preventDefault();
        $.ajax({

            url: "{{ route('package_ammend_save_file') }}",
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
                    toastr.success("Package Ammended Successfully!", { timeOut:10000 , progressBar : true});
                    $("body").removeClass("loading");
                    location.reload();
                }

                else {
                    toastr.error("Something Went Wrong! Try Again or Contact Admin", { timeOut:10000 , progressBar : true});
                    $("body").removeClass("loading");
                }
            },
            error: function(){}
        });
    }));
});
</script>

   <script>
        $(document).ready(function(e) {
    $("#limitation").change(function(){
        var val = $(":selected",this).val();
        if(val=='0'){

        $('#qty_div').show();
        }
        else{
            $('#qty_div').hide();
        }
    })
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

                      $.ajax({
                          url: "{{ route('get_inactive') }}",
                          method: 'POST',
                          dataType: 'json',
                          data:{_token:token},
                          beforeSend: function () {
                              $("body").addClass("loading");
                      },
                          success: function (response) {
                                $('.div-2').empty();
                                $('.div-2').empty();
                              $('.div-2').append(response.html);
                              $('.div-2').show();
                              $("body").removeClass("loading");

                              var table1 = $('#datatable1').DataTable({
                                  "autoWidth": true,
                              });
                              table1.columns.adjust().draw();
                          }
                      });
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
