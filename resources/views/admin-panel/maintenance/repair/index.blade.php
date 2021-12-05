@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container {
            width: 100% !important;
            padding: 0;
        }
        .dataTables_scrollHeadInner {
            table-layout:fixed;
            width:100% !important;
        }
        div.dataTables_scrollHead table.dataTable {
            width:100% !important;
        }

        .btn-css {
            width: 145px;
            height: 25px;
            padding: 1px;
            font-weight: bold;
        }


.form-css {
    height: 25px;
    padding: 3px;
}
#add_to_list {
    height: 25px;
    width: 33px;
    padding: 1px;
}
#del_btn {
    height: 25px;
    width: 33px;
    padding: 1px;
}
span#select2-bike_part-container {
    font-size: 9px;
    font-weight: bold;
}
button#manage_repair_add_btn {
    width: 100px;
}
button#manage_repair_start_btn {
    width: 100px;
}
button#manage_repair_complete_btn {
    width: 100px;
}

button#manage_repair_save_btn {
    width: 100px;
}
button#manage_repair_del_btn {
    /* width: 100px; */
    /* height: 23px; */
}
/* .modal-content.parts_model_content {
    width: 1200px;
    position: absolute;
    left: -25%;
} */

 #datatable .table th, .table td{
        border-top : unset !important;
    }
     .table th, .table td{
        padding: 0px !important;
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
    .dataTableLayout {
        table-layout:fixed;
        width:100%;
    }
    .card.card-left {
    max-height: 400px;
height: 309px;
}

.card.card-right {
    max-height: 300px;
    height: 309px;
}



        /* .row.row2 {
            border: 1px solid #d6d6d6;
        } */

    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Operation</a></li>
            <li>Manage Repair</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>


 <div class="container-fluid">
   <div class="row main-row">
          <div class="col-md-2">
            <div class="card card-left" style="display: none">
                <div class="card-body">
                    <div class="card-title mb-3">Manage Repair</div>
                    <form method="post" action="{{isset($manage_repair_data)?route('manage_repair.update',$manage_repair_data->id):route('manage_repair.store')}}">
                        {!! csrf_field() !!}
                        @if(isset($manage_repair_data))
                            {{ method_field('PUT') }}
                        @endif
                        <input type="hidden" id="c" name="id" value="{{isset($manage_repair_data)?$manage_repair_data->id:""}}">
                        <div class="row">
                            <div class="col-md-12 form-group mb-3">
                                <label for="repair_category">Plate Number</label>
                                <select id="chassis_no_id" name="chassis_no_id" class="form-control form-control-rounded">
                                    <option value="">Select Plate No</option>
                                    @foreach($bikes as $bike)
                                        @php
                                            $isSelected=(isset($manage_repair_data)?$manage_repair_data->chassis_no:"")==$bike->id;
                                        @endphp
                                        <option value="{{$bike->id}}" {{ $isSelected ? 'selected': '' }}>{{$bike->plate_no}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12 form-group mb-3">

                                    <h5 class="m-0 font-weight-bold" id="checkup_name" style="color:#f44336"></h5>

                                    <p class="mt-0 font-weight-bold" style="color:#663399" id="checkup_chassis"></p>
                                    <p style="color:#4caf50" class=" mt-0 font-weight-bold" id="checkup_bike"></p>
                                </div>
                            </div>

                            {{-- <ul class="list-group">
                                <li class="list-group-item border-0 text-11 font-weight-bold" style="color:#f44336" id="checkup_name"></li>
                                <li class="list-group-item border-0 text-11 font-weight-bold" style="color:#ded3e9" id="checkup_bike"></li>
                                <li class="list-group-item border-0 text-11 font-weight-bold" style="color:#4caf50"  id="checkup_chassis"></li>
                            </ul> --}}

                        </div>
                    </form>
                </div>
            </div>

        
     <div class="col-md-8">
        <div class="card text-left">
         <div class="card-body">
          <div class="row row1">
            <div class="col-md-12">
                    <div class="row row-1-inner">
                        <div class="col-md-2">
                            <button class="btn btn-raised ripple btn-raised-primary m-1 btn-css" id="add-btn" type="button">Add</button>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-raised ripple btn-raised-secondary m-1 btn-css" id="checkup-btn" type="button">Checkup</button>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-raised ripple btn-raised-success m-1 btn-css" id="manage_repair_btn" type="button">Manage Repair</button>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-raised ripple btn-raised-danger m-1 btn-css" type="button">Search</button>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-raised ripple btn-raised-warning m-1 btn-css" style="color: #000" id="manage_invoice_btn" type="button">Manage Invoice</button>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-raised ripple btn-raised-info m-1 btn-css" type="button">Reopen</button>
                        </div>
                    </div>
             </div>
             {{-- main row1 ends --}}
         </div>
        <div class="row row2"  style="display: none;border:1px solid gainsboro">
             <div class="col-md-4" style="border-right: 1px solid gainsboro;">
               {{-- <form action=""> --}}
                        <div class="col-md-12 form-group">
                            <label for="repair_category"> Entry No</label>
                            <input class="form-control form-css"  type="text" id="entry_no" value="{{$entry_no}}" name="date_time" required readonly />
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="repair_category"> Date/Time</label>

                            <input class="form-control form-control form-css"  value="{{Carbon\Carbon::now()->format('Y-m-d')."T".Carbon\Carbon::now()->format('H:i')}}" type="datetime-local" id="date_time" name="date_time" required />
                        </div>
                        <div class="col-md-12  mb-3">
                                <label for="repair_category">Type</label>
                                <select id="type" name="type" class="form-control form-css" required>
                                    <option value="" selected disabled >Select option</option>
                                    <option value="1">Walk In</option>
                                    <option value="2">Break Down</option>
                                </select>
                         </div>
                        <div class="col-md-12  mb-3">
                            <label for="repair_category">Priorty</label>
                            <select id="priorty" name="priorty" class="form-control form-css" required>
                                <option value="" selected disabled >Select option</option>
                                <option value="1">Low</option>
                                <option value="2">Medium</option>
                                <option value="3">High</option>
                            </select>
                        </div>
                        <div class="col-md-12 form-group mb-3">
                            <label for="repair_category">Plate Number</label>
                            <select id="bike_plate_no" name="bike_plate_no" class="form-control form-css">
                                <option value="">Select Plate No</option>
                                @foreach($bikes as $bike)
                                    @php
                                        $isSelected=(isset($manage_repair_data)?$manage_repair_data->chassis_no:"")==$bike->id;
                                    @endphp
                                    <option value="{{$bike->id}}" {{ $isSelected ? 'selected': '' }}>{{$bike->plate_no}} | {{$bike->chassis_no}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12  mb-3">
                            <button class="btn btn-info" id="save_btn"> Save</button>
                        </div>
                {{-- </form> --}}
        </div>
        {{-- col md 4 ends here --}}
            <div class="col-md-4" style="border-right: 1px solid gainsboro;" id="show_personal_detail">
            </div>
        {{-- col md 4 ends here --}}
            <div class="col-md-4" id="alert_div" style="display: none">
                <div class="col-md-12  mb-3">
                    <span>Alert Type</span>
                </div>
                <div class="col-md-12  mb-3">
                    <label for="repair_category">Remarks</label>
                    <textarea class="form-control" name="remarks" id="remarks" cols="30" rows="10"></textarea>
                </div>
            </div>
       </div>
     {{-- row2 ends here --}}

     <div class="row row4" style="display: none;border:1px solid gainsboro">
        <form action="" id="checkupForm">
            {!! csrf_field() !!}
        <div class="col-md-12">
            <h5 class="card-title ml-3">Checkup</h5>
        </div>
        <div class="row">
            <div class="col-md-3">
            </div>
        <div class="col-md-7">
                <div class="user-profile mb-4 ml-4">
                    {{-- <div class="ul-widget-card__user-info">
                        <span class="m-0 text-11 font-weight-bold" style="color:#f44336" id="checkup_name"></span>
                        <span class="m-0 text-11 font-weight-bold" style="color:#663399" id="checkup_bike"></span>
                        <span class="m-0 text-11 font-weight-bold" style="color:#4caf50" id="checkup_chassis"></span>
                    </div> --}}
                </div>
            </div>
        </div>

        <div class="row checkup_row1">
        <div class="col-md-4" style="border-right: 1px solid gainsboro;">
            {{-- <form action=""> --}}
                <div class="row ml-2" id="activity-list-holder">

                    <label for="repair_category" class="ml-3">Checkup Point</label>
                    <div class="col-md-10 form-group">
                        <input class="form-control form-css"  type="text" id="checkup_points"  name="checkup_points[]" required />
                        <input class="form-control form-css"  type="hidden" id="repair_id_checkup"  name="repair_id_checkup" required />
                    </div>
                    <div class="col-md-2 form-group mb-1">
                       <button class="btn btn-success btn-block btn-sm" id="add_to_list" type="button">
                           <i class="text-20 i-Add"></i>
                        </button>
                   </div>
            </div>
        </div>
     {{-- col md 4 ends here --}}
     <div class="col-md-4" style="border-right: 1px solid gainsboro;" id="show_personal_detail">
        <div class="col-md-12  mb-3">
            <label for="repair_category">Remarks</label>
            <textarea class="form-control" name="remarks" id="remarks" cols="30" rows="10"></textarea>
        </div>
     </div>
     {{-- col md 4 ends here --}}
     <div class="col-md-4">
        <div class="col-md-12">
            <label for="repair_category">Days/Hours</label>
            <input type="text" class="form-control" placeholder="Example 2 Days or 3 Hours"  id="days_hours" name="days_hours">
         </div>
         <div class="col-md-12">
            <button class="btn btn-info mt-3" id="save_btn_checkup"> Save</button>
         </div>
     </div>
     </form>


     </div>


     {{-- checkup accordian starts here --}}
     <div class="col-md-12 mb-2" id="accoridan">
        <div class="accordion accordian-btn" id="accordionRightIcon">
            <div class="card">
                <div class="card-header header-elements-inline">
                    <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0 font-weight-bold">
                        <a class="text-default collapsed" data-toggle="collapse" href="#accordion-item-icons-1" aria-expanded="false">
                            <span>
                            <i class="fa fa-list ul-accordion__font"> </i>
                        </span>Recent Checkups</a></h6>
                </div>
                <div class="collapse" id="accordion-item-icons-1" data-parent="#accordionRightIcon" style="">
                    <div class="card-body checkup_body">
                    </div>
                </div>
            </div>

        </div>
     </div>

     {{-- checkup accordian ends here --}}






     </div>
     {{-- row 4 ends here --}}


     <div class="row row5"  style="display: none;border:1px solid gainsboro">
        <form action="" id="manageRepairForm">
            {!! csrf_field() !!}
            <div class="row ml-1" id="activity-list-holder_manage">


            <div class="col-md-6">

                <div class="row">


                <button class="btn btn-success btn-block btn-sm mt-4 mr-2 ml-2" id="manage_repair_add_btn" type="button">
                    Add More
                 </button>
                 <button class="btn btn-info btn-block btn-sm mt-4 mr-2" id="manage_repair_start_btn" type="button">
                    Start Work
                 </button>
                 <button class="btn btn-primary btn-block btn-sm mt-4 mr-2" id="manage_repair_complete_btn" type="button">
                    Complete Work
                 </button>

                 <button class="btn btn-warning  btn-block btn-sm mt-4 mr-2" id="manage_repair_save_btn" type="submit">
                   Save
                 </button>


                </div>
            </div>



            <div class="col-md-6 mt-4">
                {{-- <span class="m-0 text-11 font-weight-bold" style="color:#f44336" id="checkup_name2"></span>
                <span class="m-0 text-11 font-weight-bold" style="color:#663399" id="checkup_bike2"></span>
                <span class="m-0 text-11 font-weight-bold" style="color:#4caf50" id="checkup_chassis2"></span>
                 --}}
                 <input class="form-control form-css"  type="hidden" id="repair_id_checkup2"  name="repair_id_manage_repair" required />
            </div>
        <div class="col-md-4 mt-4">
            <div class="col-md-12 form-group mb-3">
                <label for="repair_category" class="font-weight-bold">Part</label>
                <select id="parts_id" required name="parts_id[]" class="form-control form-css">
                    <option value="" disabled selected>Select Plate No</option>
                    @foreach($parts as $row)
                        @php
                            $isSelected=(isset($parts_data)?$parts_data->id:"")==$row->id;
                        @endphp

                    @if(in_array($row->id, $price))
                        <option value="{{$row->id}}" {{ $isSelected ? 'selected': '' }}>
                             {{$row->part_name}} | {{$row->part_number}}
                        </option>
                            @else
                            <option  style="color:red" disabled value="{{$row->id}}" {{ $isSelected ? 'selected': '' }}>
                                {{$row->part_name}} | {{$row->part_number}} | <span > Price Not Available</span>
                            </option>

                            @endif

                    @endforeach
                </select>
            </div>
        </div>
        {{--1 col md 2 ends here --}}

        <div class="col-md-2 mt-4">
            <div class="col-md-12 form-group mb-3">
                <label for="repair_category" class="font-weight-bold">Quantity</label>
                <input type="number" class="form-control" name="qty[]" id="part_qty">
            </div>
       </div>
       <div class="col-md-2 mt-4">
        <div class="col-md-12 form-group mb-3">
            <label for="repair_category" class="font-weight-bold">Chargeable</label>
            <label class="radio radio-outline-primary">
                <input type="checkbox"  name="radio[]" value="0" ><span>Comapny</span><span class="checkmark"></span>
            </label>
            <label class="radio radio-outline-success">
                <input type="checkbox" name="radio[]" value="1"><span>Own</span><span class="checkmark"></span>
            </label>
        </div>
   </div>
        {{-- 2 col md 2 ends here --}}
        <div class="col-md-3 mt-4">
            <div class="col-md-12  mb-3">
                <label for="repair_category" class="font-weight-bold">Comments</label>
                <textarea class="form-control" name="comments[]" id="comments" cols="10" rows="3"></textarea>
            </div>
     </div>
        {{--3 col md 2 ends here --}}
        <div class="col-md-1 mt-4">
            <button class="btn btn-danger btn-block btn-sm mt-4" id="manage_repair_del_btn" type="button">
                Delete
             </button>
        </div>
        {{--4 col md 2 ends here --}}


        {{--5 col md 2 ends here --}}

        {{-- <div class="col-md-1 mt-4">
            <button class="btn btn-info btn-block btn-sm mt-4" id="manage_repair_edit_btn" type="button">
                Edit
             </button>
        </div> --}}
        {{-- 6 col md 2 ends here --}}
    </form>

  {{-- checkup accordian starts here --}}


 </div>






  <div class="col-md-12 mb-2" id="accoridan">
    <div class="accordion accordian-reapair-btn" id="accordionRightIcon">
        <div class="card">
            <div class="card-header header-elements-inline">
                <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0 font-weight-bold">
                    <a class="text-default collapsed" data-toggle="collapse" href="#accordion-item-icons-1 " aria-expanded="false">
                        <span><i class="i-Gear-2 ul-accordion__font"> </i></span>
                         Recent Manage Repair</a></h6>
            </div>
            <div class="collapse" id="accordion-item-icons-1" data-parent="#accordionRightIcon" style="">
                <div class="card-body manage_repair_body">
                </div>
            </div>
        </div>
    </div>
    </div>

    {{-- checkup accordian ends here --}}
        </div>
        {{-- row 5 ends here --}}

        <div class="row row6"  style="display: none;border:1px solid gainsboro">
            <div class="col-md-12 ajax_invoice_view" id="ajax_invoice_view"></div>
        </div>


        <div  class="row row3">
            <div class="col-md-12">
                <div class="ajax_table_load">
                </div>
            </div>
        {{-- row3 ends here --}}
        </div>

        {{-- colmd8 ends --}}
        </div>
     </div>
        {{-- cards ends here --}}
    </div>

    <div class="col-md-2">
        <div class="card card-right" style="display: none">
            <div class="card-body">
                <div class="pr-3 pb-3"><i class="todo-sidebar-close i-Close pb-3 text-right" data-sidebar-toggle="main"></i>
                    <!-- Large modal-->
                    <button class="btn btn-primary btn-block mb-4" type="button" readonly data-toggle="modal" data-target=".bd-example-modal-lg">Status Information</button>
                    <div>
                        <div class="card card-profile-1 mb-4">
                            <div class="card-body text-center">

                                <h5 class="m-0 font-weight-bold" id="checkup_statuss" style="color:#f44336"></h5>
                                <p class="mt-0 font-weight-bold" style="color:#663399" id="manage_repair_current_status"></p>

                            </div>
                        </div>
                        {{-- <ul class="list-group">
                            <li class="list-group-item border-0 text-11 font-weight-bold" style="color:#f44336" id="checkup_statuss"></li>
                            <li class="list-group-item border-0 text-11 font-weight-bold" style="color:rgb(4, 126, 4)" id="manage_repair_current_status"></li>

                        </ul> --}}
                    </div>
                </div>
            </div>
        </div>


    </div>


    {{-- main row ends here --}}
 </div>
    {{-- main containter --}}
    </div>




    {{-- pop models starts here --}}

    <div class="modal fade bd-example-modal-lg-1" id="responsive" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle-1">List of Check Up Points</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="checkup_points_pop"></div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    </div>

            </div>
        </div>
    </div>
    </div>
    </div>
    {{-- pop models ends here --}}


     {{-- pop models starts here --}}

     <div class="modal fade bd-example-modal-lg-2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content parts_model_content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle-1">List of Parts</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="parts_pop"></div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    </div>

            </div>
        </div>
    </div>
</div>

    {{-- pop models ends here --}}


    {{-- return qty modal --}}
<div class="modal fade bd-example-modal-sm-return" id="return_part_modal" tabindex="-1" role="dialog"  >
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle-1">Return Quantity</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <form action="" id="part_return_form">
                {!! csrf_field() !!}
            <div class="modal-body">


                <input type="hidden" name="row_id" id="row_id">
                <input type="hidden" name="json_data_id" id="json_data_id">
                <input type="text" name="return_qty" class="form-control" id="return_qty" placeholder="Enter Return Quantity">
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                <button class="btn btn-primary ml-2" type="submit">Save changes</button>
            </div>
        </form>
        </div>
    </div>
</div>
{{-- return qty modal ends here --}}







@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
           // $('.add_div').hide();
               $('#add-btn').click(function() {
                       $('.row4').hide();
                       $('.row2').slideToggle("fast");
               });
           });

       </script>

<script>
    $(document).ready(function() {
       // $('.add_div').hide();
           $('#checkup-btn').click(function() {
            var x=$('input[name="checked"]:checked').val();
            if (x == null){
                toastr.error("Please Select The Repair To Add Checkup", { timeOut:10000 , progressBar : true});
            }
            else{
                $('.row2').hide();
                $('.row5').hide();
                $('.row6').hide();
                $('.row4').slideToggle("fast");
            }
           });
       });
   </script>


   <script>
    $(document).ready(function() {
       // $('.add_div').hide();
           $('#manage_repair_btn').click(function() {
                var x=$('input[name="checked"]:checked').val();
                if (x == null){
                toastr.error("Please Select The Repair For Manage Repair", { timeOut:10000 , progressBar : true});
                    }
                    else
                    {
                    $('.row2').hide();
                    $('.row4').hide();
                    $('.row6').hide();
                   $('.row5').slideToggle("fast");
}
           });
       });

   </script>


<script>
    $(document).ready(function() {
       // $('.add_div').hide();
           $('#manage_invoice_btn').click(function() {

                var x=$('input[name="checked"]:checked').val();
                if (x == null){
                toastr.error("Please Select The Repair For Manage Invoice", { timeOut:10000 , progressBar : true});
                    }
                    else
                    {
                    $('.row2').hide();
                    $('.row4').hide();
                    $('.row5').hide();
                    $.ajax({
                        url: "{{ route('rapair_invoice_view') }}",
                        dataType: 'json',
                        success: function (response) {
                            $(".ajax_invoice_view").empty();
                            $('.ajax_invoice_view').append(response.html);
                        }
                    });




                   $('.row6').slideToggle("fast");
}
           });
       });

   </script>




<script>
    $(document).ready(function(e) {
    $("#bike_plate_no").change(function(){
            var bike_id = $(":selected",this).val();
           var token = $("input[name='_token']").val();
            var url = '{{ route('get_add_form') }}';
            $.ajax({
                        url: url,
                        method: 'POST',
                        dataType: 'json',
                        data: {_token: token,bike_id:bike_id},
                        success: function (response) {
                            $('#show_personal_detail').empty();
                            $('#show_personal_detail').append(response.html);

                            $("#alert_div").show();
                        }

                    });
    })
});
</script>





<script>
      function get_parts_detail(id)
        {



            var url = '{{ route('get_repair_sale_detail') }}';
                var token = $("input[name='_token']").val();

                 $.ajax({
                        url: url,
                        method: 'POST',
                        dataType: 'json',
                        data: {id: id, _token: token},
                        success: function (response) {



                            $('#datatable_parts').empty(); // empty in case the columns change
                            $('.result').empty(); // empty in case the columns change
                            $('.result').append(response.html);
                            $('#parts_model').modal('show');
                            var table = $('#datatable_parts').DataTable({
                                paging: true,
                                info: true,
                                searching: true,
                                autoWidth: false,
                                retrieve: true
                            });
                            table.columns.adjust().draw();




                        }

                    });

        }
</script>



    <script>
        $( document ).ready(function() {
                $.ajax({
                        url: "{{ route('rapair_view') }}",
                        dataType: 'json',
                        success: function (response) {
                            $(".ajax_table_load").empty();
                            $('.ajax_table_load').append(response.html);
                        }
                    });
    });
    function refresh(){
        $.ajax({
                        url: "{{ route('rapair_view') }}",
                        dataType: 'json',
                        success: function (response) {
                            $(".ajax_table_load").empty();
                            $('.ajax_table_load').append(response.html);
                        }
                    });
    }
    </script>
<script>
$('#chassis_no_id').on('change', function() {
        var plate_id = $(":selected",this).val();
        var token = $("input[name='_token']").val();
        $.ajax({
            url: "{{ route('get_rider_repair_detail') }}",
                    method: 'POST',
                    dataType: 'json',
                    data: {plate_id: plate_id, _token: token},
                    success: function (response) {
                        $(".veri").empty();
                        $('.veri').html(response.html);
                        $(".veri").show();

                    }
                });

});

</script>

<script>
    $(document).ready(function(){
  $("#save_btn").click(function(){
    var repair_no = $("#entry_no").val();
    var duration = $("#date_time").val();
    var type = $("#type").val();
    var priorty = $("#priorty").val();
    var bike_id = $('#bike_plate_no').val();
    var token = $("input[name='_token']").val();
    var passport_id = $("#passport_id").val();
    $.ajax({
            url: "{{ route('manage_repair.store') }}",
                    method: 'POST',
                    dataType: 'json',
                    data: {repair_no:repair_no,duration:duration, _token: token,type:type,priorty:priorty,bike_id:bike_id,passport_id:passport_id},
                    success: function (response) {
                        refresh();
                        toastr.success("Added Successfully", { timeOut:10000 , progressBar : true});
                        $(".row2").hide();
                    }
                });
  });
});
</script>

<script>
     $(document).ready(function(){
        $('#add-more-member-holder').on('click', '.delete_btn', function() {
            var ids = $(this).attr('data-row_id');

        });


        $('#bike_plate_no').select2();
        $('#parts').select2();

    });
    var activity_row_number = 1;
    var count = 1;
    $('#add_to_list').click(function(){

        var new_activity_row = `<div class="row ml-2" id="activity_row`+ activity_row_number+ `">
            <label for="repair_category">Checkup Points</label>
                    <div class="col-md-10  form-group">
                        <input class="form-control form-css"  type="text" id="checkup_points"  name="checkup_points[]" required />
                    </div>
                    <div class="col-md-2 form-group mb-1">
                <button class="btn btn-danger btn-block btn-sm delete_activity" id="del_btn" required data-activity_row_id = "activity_row`+activity_row_number+`"><i class="text-20 i-Remove"></i></button>
            </div>
        </div>`;

        $('#activity-list-holder').append(new_activity_row);
        count++;

    });

    $(document).ready(function(){
        $('#activity-list-holder').on('click', '.delete_activity', function() {
            var ids = $(this).attr('data-activity_row_id');
            $("#"+ids).remove();
        });
    });
</script>


<script>
    $(document).ready(function(){



       $('#bike_part').select2();
       $('#parts_id').select2();

   });
   var activity_row_number2 = 1;
   var count = 1;
   $('#manage_repair_add_btn').click(function(){

       var new_activity_row2 = `<div class="row ml-1 appended" style="width: 1150px" id="activity_row2`+ activity_row_number2+`">
        <div class="col-md-4">
            <div class="col-md-12 form-group mb-3">
                <label for="repair_category" class="font-weight-bold">Part</label>
                <select id="parts_id`+ count+ `" name="parts_id[]" class="form-control form-css">

                    <option value="" disabled selected>Select Plate No</option>
                    @foreach($parts as $row)
                        @php
                            $isSelected=(isset($parts_data)?$parts_data->id:"")==$row->id;
                        @endphp

                    @if(in_array($row->id, $price))
                        <option value="{{$row->id}}" {{ $isSelected ? 'selected': '' }}>
                             {{$row->part_name}} | {{$row->part_number}}
                        </option>
                            @else
                            <option  style="color:red" disabled value="{{$row->id}}" {{ $isSelected ? 'selected': '' }}>
                                {{$row->part_name}} | {{$row->part_number}} | <span > Price Not Available</span>
                            </option>

                            @endif

                    @endforeach
                </select>
            </div>
        </div>
        {{--1 col md 2 ends here --}}

        <div class="col-md-2 mt-4" >
            <div class="col-md-12 form-group mb-3">
                <label for="repair_category" class="font-weight-bold">Quantity</label>
                <input type="number" class="form-control" name="qty[]" id="part_qty">
            </div>
       </div>

        <div class="col-md-2">
            <div class="col-md-12 form-group mb-3">
                <label for="repair_category" class="font-weight-bold">Chargeable</label>
                <label class="radio radio-outline-primary">
                    <input type="checkbox" name="radio[]" value="0"><span>Comapny</span><span class="checkmark"></span>
                </label>


                <label class="radio radio-outline-success">
                    <input type="checkbox" name="radio[]" value="1"><span>Own</span><span class="checkmark"></span>
                </label>

            </div>
       </div>
        {{-- 2 col md 2 ends here --}}

        <div class="col-md-3">
            <div class="col-md-12  mb-3">
                <label for="repair_category" class="font-weight-bold">Comments</label>
                <textarea class="form-control" name="comments[]" id="comments" cols="10" rows="3"></textarea>
            </div>
     </div>
        {{--3 col md 2 ends here --}}

        <div class="col-md-1">
             <button class="btn btn-danger btn-block btn-sm mt-4 delete_activity" id="manage_repair_del_btn" required data-activity_row_id = "activity_row2`+activity_row_number2+`">Delete</button>

        </div>
        {{--4 col md 2 ends here --}}


        {{--5 col md 2 ends here --}}


        {{-- 6 col md 2 ends here --}}

           </div>
       </div>`;

       $('#activity-list-holder_manage').append(new_activity_row2);
       $('#parts_id'+count).select2();

       count++;
   });

   $(document).ready(function(){
       $('#activity-list-holder_manage').on('click', '.delete_activity', function() {
           var ids = $(this).attr('data-activity_row_id');
           $("#"+ids).remove();
       });
   });
</script>
<script>
    $(document).ready(function (e){
    $("#checkupForm").on('submit',(function(e){
        e.preventDefault();
        $.ajax({
            url: "{{ route('save_repair_checkup') }}",
            type: "POST",
            data:  new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            success: function(response){
                $("#checkupForm").trigger("reset");
                if(response.code == 100) {
                    toastr.success("CheckUp Points Saved Successfully!", { timeOut:10000 , progressBar : true});
                }
                else if(response.code == 102){
                    toastr.info("New CheckUp Points Added Successfully!", { timeOut:10000 , progressBar : true});

                }
                else {
                    toastr.error("Something Went Wrong! Try Again", { timeOut:10000 , progressBar : true});

                }
            },
            error: function(){}
        });
    }));
});
        </script>
<script>
    $(document).ready(function (e){
    $("#manageRepairForm").on('submit',(function(e){
        e.preventDefault();
        $.ajax({
            url: "{{ route('repair_sale_save') }}",
            type: "POST",
            data:  new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            success: function(response){
                $("#manageRepairForm").trigger("reset");
                $('.appended').remove();
                // $('#feedback').remove();
                if(response.code == 100) {
                    toastr.success("Added  Saved Successfully!", { timeOut:10000 , progressBar : true});
                }

                else if(response.code == 102) {
                    toastr.info("More Parts Added Successfully!", { timeOut:10000 , progressBar : true});
                }
                else {
                    toastr.error("Something Went Wrong! Try Again", { timeOut:10000 , progressBar : true});
                }
            },
            error: function(){}
        });
    }));
});
        </script>
   <script>
    $(document).ready(function() {
       // $('.add_div').hide();
           $('.accordian-btn').click(function() {
            var url = '{{ route('get_repair_checkup_detail') }}';
                var token = $("input[name='_token']").val();
                 $.ajax({
                        url: url,
                        method: 'POST',
                        dataType: 'json',
                        data: { _token: token},
                        success: function (response) {
                            $('.checkup_body').empty(); // empty in case the columns change
                            $('.checkup_body').append(response.html);
                            var table = $('#datatable_checkups').DataTable({
                                paging: true,
                                info: true,
                                searching: true,
                                autoWidth: false,
                                retrieve: true
                            });
                            table.columns.adjust().draw();
                        }

                    });

        });
        });
   </script>



<script>
    $(document).ready(function() {
       // $('.add_div').hide();
           $('.accordian-reapair-btn').click(function() {
            var url = '{{ route('get_repair_manage_detail') }}';
            var token = $("input[name='_token']").val();

                 $.ajax({
                        url: url,
                        method: 'POST',
                        dataType: 'json',
                        data: { _token: token},
                        success: function (response) {
                            $('.manage_repair_body').empty(); // empty in case the columns change
                            $('.manage_repair_body').append(response.html);
                            var table = $('#datatable_manage_repair').DataTable({
                                paging: true,
                                info: true,
                                searching: true,
                                autoWidth: false,
                                retrieve: true
                            });
                            table.columns.adjust().draw();




                        }

                    });

        });
        });
   </script>

<script>
    function get_checkup_points(id)
    {
        var id = id;
        var url = '{{ route('get_checkup_points', ":id") }}';
        var token = $("input[name='_token']").val();
        $.ajax({
                    url: url,
                    method: 'POST',
                    dataType: 'json',
                    data: {id: id, _token: token},
                    success: function (response) {
                        $(".checkup_points_pop").empty();
                        $('.checkup_points_pop').html(response.html);
                        $('.bd-example-modal-lg-1').modal('show');
                        var table = $('#datatable_checkup_modal').DataTable({
                                paging: true,
                                info: true,
                                searching: true,
                                autoWidth: false,
                                retrieve: true
                            });
                            table.columns.adjust().draw();

                    }
                });
    }
</script>


<script>
    function get_manage_parts(id)
    {

        var id = id;
        var url = '{{ route('get_manage_parts', ":id") }}';
        var token = $("input[name='_token']").val();
        $.ajax({
                    url: url,
                    method: 'POST',
                    dataType: 'json',
                    data: {id: id, _token: token},
                    success: function (response) {
                        $(".parts_pop").empty();
                        $('.parts_pop').html(response.html);
                        $('.bd-example-modal-lg-2').modal('show');
                        var table = $('#datatable_parts_modal').DataTable({
                                paging: true,
                                info: true,
                                searching: true,
                                autoWidth: true,
                                retrieve: true
                            });
                            table.columns.adjust().draw();

                    }
                });
    }
</script>


<script>
    $(document).ready(function() {
       // $('.add_div').hide();
           $('#manage_repair_start_btn').click(function() {
       var repair_id = $("input[name='repair_id_manage_repair']").val();
       var url = '{{ route('start_manage_repair') }}';
                var token = $("input[name='_token']").val();
                 $.ajax({
                    url: url,
                        method: 'POST',
                        dataType: 'json',
                        data: { _token: token,repair_id:repair_id},
                        success: function(response){
                if(response.code == 100) {
                    toastr.success("Work Started Successfully!", { timeOut:10000 , progressBar : true});
                }
                else if(response.code == 102){
                    toastr.error("Repair Has Not Added Yet!", { timeOut:10000 , progressBar : true});

                }
                else {
                    toastr.error("Working is Already in Start Mood!", { timeOut:10000 , progressBar : true});
                }
            },
                    });

        });
        });
   </script>


<script>
    $(document).ready(function() {
           $('#manage_repair_complete_btn').click(function() {
       var repair_id = $("input[name='repair_id_manage_repair']").val();
       var url = '{{ route('complete_manage_repair') }}';
                var token = $("input[name='_token']").val();
                 $.ajax({
                    url: url,
                        method: 'POST',
                        dataType: 'json',
                        data: { _token: token,repair_id:repair_id},
                        success: function(response){
                if(response.code == 100) {
                    toastr.success("Work Completed Successfully!", { timeOut:10000 , progressBar : true});
                }
                else if(response.code == 102){
                    toastr.error("Repair Has Not Added Yet!", { timeOut:10000 , progressBar : true});

                }

                else if(response.code == 103){
                    toastr.error("Repair Has Not Started Yet!", { timeOut:10000 , progressBar : true});

                }
                else {
                    toastr.error("Working Has Already Been Completed!", { timeOut:10000 , progressBar : true});
                }
            },
                    });

        });
        });
   </script>




<script>
    // Enable pusher logging - don't include this in production
    // Pusher.logToConsole = true;

    var pusher = new Pusher('794af290dd47b56e7bc9', {
      cluster: 'ap2',
      encrypted: true
    });

    var channel = pusher.subscribe('notify');
    channel.bind('notify-parts-ver', function(message) {
        toastr.info("New Repair Parts Request Verified", { timeOut:10000 , progressBar : true});
        window.setTimeout(function(){
                            location.reload(true)
                        },5000);
    });

    </script>



    <script>
        @if(Session::has('message'))
        var type = "{{ Session::get('alert-type', 'info') }}";
        switch(type){
            case 'info':
                toastr.info("{{ Session::get('message') }}", "Information!", { timeOut:10000 , progressBar : true});
                });
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
