@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
    <style>
        .fc .fc-col-header-cell-cushion {
            display: inline-block !important;
            padding: 2px 4px !important;
        }
        .fc .fc-col-header-cell-cushion {
            padding-top: 5px;
            padding-bottom: 5px;
        }

        .fc-day .fc-widget-content  {
            height: 2.5em !important;
        }
        .fc-agendaWeek-view tr {
            height: 40px !important;
        }

        .fc-agendaDay-view tr {
            height: 40px !important;
        }
        .fc-agenda-slots td div {
            height: 40px !important;
        }
        .fc-event-vert {
            min-height: 25px;
        }
        .calendar-parent {
            height: 100vh;
        }

        .fc-toolbar {
            padding: 15px 20px 10px;
        }
        .fc-title{
            color :white;
        }
        .fc-rigid{
            height: 70px !important;;
        }
        /* #datatable2 .table th, .table td{
            border-top : unset !important;
        }
        #datatable .table th, .table td{
            border-top : unset !important;
        } */
        .table th, .table td{
            padding: 0px !important;
        }
        .table th{
            padding: 2px;
            font-size: 14px;
        }
        .table td{
            /*padding: 2px;*/
            font-size: 14px;
        }
        .table th{
            padding: 2px;
            font-size: 14px;
            font-weight: 700;
        }
        input#keyword {
            border-right: none;
            background: #ffffff;
            border-left: none;
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
        .col-lg-12.sugg-drop {
            width: 400px;
            line-height: 12px;
            font-size: 12px;
            /*border: 1px solid #775dd0;*/
            /*padding-top: 15px;*/
            /*padding-bottom: 15px;*/

        }
        .btn-start {
       padding: 1px;
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
        tr:hover {background-color:#d8d6d6;}
        th{pointer-events: none;}
        .btn-cancel {
    background: #800000;
    border-color: #800000;
}



    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Visa Proces</a></li>
            <li><a href="">Takaful Emarat</a></li>
            {{-- <li>Upload Ar Balance  Sheet</li> --}}
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>



    <div class="row pb-2" >
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    @if(isset($edit_takaful))
                    <form id="takaful_edit">
                        @else
                        <form id="takaful_form">
                        @endif
                    <div class="row">
                            {!! csrf_field() !!}
                            {{-- @if(isset($edit_takaful))
                            {{ method_field('PUT') }}
                        @endif --}}
                        <div class="col-sm-12">
                        <div class="alert alert-card alert-danger visa_val" id="message_div" style="display: none" role="alert">
                            <strong class="text-capitalize">Visa Process Not Competed!</strong> Visa Process Has Not been Compeleted Yet!
                        </div>
                        </div>
                            <div class="col-sm-6">

                                <div class="row">
                                    <div class="col-md-12 form-group mb-3">
                                        <label for="repair_category">Search</label>


                                        <div class="input-group ">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text bg-transparent" id="basic-addon1">
                                                <i class="i-Magnifi-Glass1"></i>
                                            </span>
                                        </div>
                                            <input class="form-control form-control-sm  typeahead" id="keyword" value="{{isset($passport_no)?$passport_no:""}}" autocomplete="off" type="text" required  name="name" placeholder="search..." aria-label="Username" aria-describedby="basic-addon1">
                                            <div class="input-group-append">
                                                <span class="input-group-text bg-transparent" id="basic-addon2">
                                                    <i class="i-Search-People"></i>
                                                </span>
                                            </div>
                                            <input class="form-control" id="passport_number" value="{{isset($passport_no)?$passport_no:""}}" name="passport_number" type="hidden" value="" />
                                        </div>
                                    </div>
                                </div>

                        </div>

                        <div class="col-md-6">
                            <label for="repair_category">Insurance</label>
                            <select id="insurance_company"  name="insurance_company" class="form-control">
                                <option selected disabled >Select option</option>
                                @foreach($insurance as $ins)
                                @php
                                $isSelected=(isset($edit_takaful)?$edit_takaful->insurance_company:"")==$ins->id;
                            @endphp

                                    <option  value="{{$ins->id}}" {{ $isSelected ? 'selected': '' }}>{{ $ins->name  }}</option>
                                @endforeach
                            </select>
                        </div>
                                <div class="col-md-6">
                                    <label for="repair_category">Member ID</label>

                                    <input value="{{isset($edit_takaful)?$edit_takaful->id:""}}" name="id" type="hidden" />

                                    <input class="form-control form-control"  value="{{isset($edit_takaful)?$edit_takaful->member_id:""}}"

                                           id="member_id" name="member_id" type="text" placeholder="Enter Member ID" required />
                                </div>
                                <div class="col-md-6">
                                    <label for="repair_category">Company</label>
                                    <select id="company"  name="company" class="form-control">
                                        <option value=""  >Select option</option>
                                        @foreach($company as $com)
                                        @php
                                        $isSelected=(isset($edit_takaful)?$edit_takaful->company_id:"")==$com->id;
                                    @endphp

                                            <option  value="{{$com->id}}" {{ $isSelected ? 'selected': '' }}>{{ $com->name  }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="repair_category">Card No</label>
                                    <input class="form-control form-control"  value="{{isset($edit_takaful)?$edit_takaful->card_no:""}}"
                                           id="card_no" name="card_no" type="text" placeholder="Enter Card No (Optional)" />
                                </div>
                                <div class="col-md-6">
                                    <label for="repair_category">Emirates ID </label>
                                    <input class="form-control form-control"  value="{{isset($edit_takaful)?$edit_takaful->emirates_id:""}}"
                                          id="emirates_id" name="emirates_id" type="text" placeholder="Enter Emirates ID" />
                                </div>

                                <div class="col-md-6">
                                    <label for="repair_category">Network Type </label>
                                    <div id="network_div">

                                    </div>
                                    {{-- <label for="repair_category">Network Type </label>
                                    <input class="form-control form-control"  value="{{isset($edit_takaful)?$edit_takaful->network_type:""}}"
                                   id="network_type" name="network_type" type="text" placeholder="Enter Network Type" /> --}}

                                </div>

                                <div class="col-md-6">
                                    <label for="repair_category">P.ID </label>
                                    <input class="form-control form-control"  value="{{isset($edit_takaful)?$edit_takaful->pid:""}}"
                                          id="pid" name="pid" type="text" placeholder="Enter P.ID" />
                                </div>


                                <div class="col-md-6">
                                    <label for="repair_category">Effective Date</label>
                                    <input class="form-control form-control"  value="{{isset($edit_takaful)?$edit_takaful->effective_date:""}}"
                                          id="effective_date" name="effective_date" type="date" placeholder="Enter Effective Date" />
                                </div>

                                <div class="col-md-6">
                                    <label for="repair_category">Expiry  Date</label>
                                    <input class="form-control form-control"  value="{{isset($edit_takaful)?$edit_takaful->expiry_date:""}}"
                                          id="expiry_date" name="expiry_date" type="date" placeholder="Enter Expiry Date" />
                                </div>



                            <div class="col-md-6 mt-2">
                            <input   type="submit" name="btn" value="Save" id="submitBtn15" data-toggle="modal" data-target="#confirm-submit15" class="btn btn-primary btn-save" />
                            </div>

                    </div>
                </form>


                </div>
            </div>
        </div>
    </div>


    <div class="row pb-2" >
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                                <div class="takaful_view">

                                </div>
                </div>
                </div>
                </div>
            </div>
    {{-- <div class="submenu" id="documents-menu-items">
        <div class="row"> --}}

            <div class="overlay"></div>
        {{-- </div>
    </div> --}}




@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
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
    $(document).on('click', '.sugg-drop', function(){
                      var token = $("input[name='_token']").val();
                      var keyword  =   $(this).find('#drop-name').text();
                      $.ajax({
                          url: "{{ route('visa_process_names') }}",
                          method: 'POST',
                          dataType: 'json',
                          data:{keyword:keyword,_token:token},
                          beforeSend: function () {
                              $("body").addClass("loading");
                      },
                          success: function (response) {
                              $('.row_show').empty();

                               $("body").removeClass("loading");

                              $('.row_show').append(response.html);
                              $('.row_show').show();
                          }
                      });
                  });
      </script>

{{-- if(response.code == 100) {
    toastr.success("In-out Change Added Successfully!", { timeOut:10000 , progressBar : true});
    $('.bd-example-modal-lg').modal('hide');
    $("body").removeClass("loading");
    refresh(response.passport_no)
}
else {
    toastr.error("Something Went Wrong!", { timeOut:10000 , progressBar : true});
    $("body").removeClass("loading");
} --}}
<script>
    $(document).on('click', '.sugg-drop', function(){

        var passport_no = $(this).find('#drop-name').text();
        $('input[name=passport_number]').val(passport_no);
        var token = $("input[name='_token']").val();


        $.ajax({
                          url: "{{ route('takaful_check') }}",
                          method: 'POST',
                          dataType: 'json',
                          data:{passport_no:passport_no,_token:token},
                          beforeSend: function () {
                              $("body").addClass("loading");
                      },
                          success: function (response) {

                          if(response.code == 100) {
                            $("body").removeClass("loading");


                            $('#member_id').attr('disabled', 'disabled');
                            $('#card_no').attr('disabled', 'disabled');
                            $('#emirates_id').attr('disabled', 'disabled');
                            $('#network_type').attr('disabled', 'disabled');
                            $('#pid').attr('disabled', 'disabled');
                            $('#effective_date').attr('disabled', 'disabled');
                            $('#expiry_date').attr('disabled', 'disabled');
                            $('#submitBtn15').attr('disabled', 'disabled');
                            $('#company').attr('disabled', 'disabled');
                            $('#message_div').hide();
                            $('#message_div').show();;
                            }
                            else{
                              $("body").removeClass("loading");
                              $('#message_div').hide();



                              $('#member_id').removeAttr('disabled');
                            $('#card_no').removeAttr('disabled');
                            $('#emirates_id').removeAttr('disabled');
                            $('#network_type').removeAttr('disabled');
                            $('#pid').removeAttr('disabled');
                            $('#effective_date').removeAttr('disabled');
                            $('#expiry_date').removeAttr('disabled');
                            $('#submitBtn15').removeAttr('disabled');
                            $('#company').removeAttr('disabled');

                                    }

                          }
                      });


    });
    </script>


<script>
    $('#company').select2({
        placeholder: 'Select an option'
    });
</script>
<script>
    $('#insurance_company').select2({
        placeholder: 'Select an option'
    });


</script>





<script>
    $(document).ready(function (e){
    $("#takaful_form").on('submit',(function(e){
        e.preventDefault();
        $.ajax({

            url: "{{ route('takaful_save') }}",
            type: "POST",
            data:  new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function () {
                            $("body").addClass("loading");
                    },
            success: function(response){

                $("#takaful_form").trigger("reset");
                $("#takaful_edit").trigger("reset");
                if(response.code == 100) {
                    toastr.success("Added Successfully!", { timeOut:10000 , progressBar : true});
                    refresh();
                    //
                    // alert();
                    // $('.bd-example-modal-lg').modal('hide');
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
    $("#takaful_edit").on('submit',(function(e){
        e.preventDefault();
        $.ajax({

            url: "{{ route('takaful_update') }}",
            type: "POST",
            data:  new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function () {
                            $("body").addClass("loading");
                    },
            success: function(response){

                $("#takaful_form").trigger("reset");
                $("#takaful_edit").trigger("reset");
                if(response.code == 100) {
                    toastr.success("Updated Successfully!", { timeOut:10000 , progressBar : true});
                    refresh();
                    $("body").removeClass("loading");
                    window.location.href = "{{ url('takaful_emarat')}}";
                }
                else {
                    toastr.error("Something Went Wrong!", { timeOut:10000 , progressBar : true});
                    $("body").removeClass("loading");
                    window.location.href = "{{ url('takaful_emarat')}}";
                }
            },
            error: function(){}
        });
    }));
});
</script>

<script>
    $(document).ready(function () {
$(window).on("load", function () {
    var token = $("input[name='_token']").val();

    $.ajax({
                          url: "{{ route('load_takaful') }}",
                          method: 'POST',
                          dataType: 'json',
                          data:{_token:token},
                          beforeSend: function () {
                              $("body").addClass("loading");
                      },
                          success: function (response) {
                              $('.takaful_view').empty();
                              $('.takaful_view').append(response.html);
                              $("body").removeClass("loading");



                              var table1 = $('#takaful_table').DataTable({
                                "autoWidth": true,
                            });
                            table1.columns.adjust().draw();
                          }
                      });
});
});

</script>


<script>
    function refresh()
{

            var token = $("input[name='_token']").val();


$.ajax({
                      url: "{{ route('load_takaful') }}",
                      method: 'POST',
                      dataType: 'json',
                      data:{_token:token},
                      beforeSend: function () {
                          $("body").addClass("loading");
                  },
                      success: function (response) {
                          $('.takaful_view').empty();
                          $('.takaful_view').append(response.html);
                          $("body").removeClass("loading");


                          var table1 = $('#takaful_table').DataTable({
                            "autoWidth": true,
                        });
                        table1.columns.adjust().draw();
                      }
                  });
}
</script>

<script>
    $(document).ready(function(e) {
    $("#insurance_company").change(function(){
        var token = $("input[name='_token']").val();

        var company = $(":selected",this).val();
        $.ajax({
                      url: "{{ route('load_company_network') }}",
                      method: 'POST',
                      dataType: 'json',

                      data:{ company:company, _token:token},

                      success: function (response) {
                          $('#network_div').empty();
                          $('#network_div').append(response.html);




                      }
                  });
    })
});
</script>

@if (isset($edit_takaful))
<?php $var = $edit_takaful->insurance_company;?>
<?php $var2 = $edit_takaful->id;?>

<script>
     var token = $("input[name='_token']").val();
     var company = '<?php echo $var ;?>';
     var edit_takaful = '<?php echo $var2 ;?>';


       $.ajax({
              url: "{{ route('load_company_network') }}",
              method: 'POST',
              dataType: 'json',
              data:{ company:company, _token:token,edit_takaful:edit_takaful},
              success: function (response) {
                  $('#network_div').empty();
                  $('#network_div').append(response.html);
              }
          });
</script>

@endif


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
