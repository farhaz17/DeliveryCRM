@extends('admin-panel.base.main')
@section('css')
<link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
<link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
    button.btn.btn-primary.btn-sub {
        position: relative;
        top: 22px;
        height: 33px;
    }
    .samples {
        font-size: 16px;
        font-weight: 700;
    }
    .loader-spin {
        position: relative;
        left: 30%;
    }

    /*model talabat perfomra modal css----------------------*/
    .modal-dialog-full-width {
        width: 100% !important;
        height: 100% !important;
        margin: 0 !important;
        padding: 20px !important;
        max-width:none !important;

    }

    .modal-content-full-width  {
        height: auto !important;
        min-height: 100% !important;
        border-radius: 0 !important;
        background-color: #ffffff !important
    }

    .modal-header-full-width  {
        border-bottom: 1px solid #9ea2a2 !important;
    }

    .modal-footer-full-width  {
        border-top: 1px solid #9ea2a2 !important;
    }

    /*model talabat performa modal css ends here----------------------*/
</style>
@endsection
@section('content')
<div class="breadcrumb">
    <h1 class="mr-2">Home</h1>
    <ul>
        <li><a href="">Salary Sheet</a></li>
        <li>Salary Sheet Uplaod</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>


    <div class="row mb-4">
        <div class="col-md-12 mb-4">
            <div class="card text-left">
                <div class="card-body">
                    <h4 class="card-title mb-3">Salary Sheet Upload</h4>
                    <div class="last_upload-1" style="display: none;">

                        <div class="samples">

                            <a href="{{ asset('assets/salary_sheet_samples/talabat_sample_file.xlsx') }}" download target="_blank">(Download Sample File)</a>

                        </div>


                    <h4 class="card-title mb-3 text-center">Last Upload Sheet Dates(Talabat):
<!--                        $user->from_date->format('d/m/Y') }}-->
                        <span style="color:red">{{isset($talabat_sheet->date_from)?\Carbon\Carbon::parse($talabat_sheet->date_from)->format('d-m-Y'):""}}
                        </span>

                            <b>To:</b>
                        <span style="color:blue">
                        {{ isset($talabat_sheet->date_to)?\Carbon\Carbon::parse($talabat_sheet->date_to)->format('d-m-Y'):"" }}</h4>
                    </span>


                 </div>

                    <div class="last_upload-2" style="display: none;">
                        <div class="samples">

                            <a href="{{ asset('assets/salary_sheet_samples/deliveroo_sample_file.xlsx') }}" download target="_blank">(Download Sample File)</a>

                        </div>

                        <h4 class="card-title mb-3 text-center">Last Upload Sheet Dates(Deliveroo):
                            <span style="color:red">{{isset($del_sheet->date_from)?\Carbon\Carbon::parse($del_sheet->date_from)->format('d-m-Y'):""}}
                        </span>

                            <b>To</b>
                            <span style="color:blue">
                        {{ isset($del_sheet->date_to)?\Carbon\Carbon::parse($del_sheet->date_to)->format('d-m-Y'):""}}</h4>
                        </span>
                    </div>
                      <div class="last_upload-careem" style="display: none;">
                          <div class="samples">

                              <a href="{{ asset('assets/salary_sheet_samples/careem_sample_file.xlsx') }}" download target="_blank">(Download Sample File)</a>

                          </div>
                            <h4 class="card-title mb-3 text-center">Last Upload Sheet Dates(Careem):
                                <span style="color:red">{{isset($careem_sheet->date_from)?\Carbon\Carbon::parse($careem_sheet->date_from)->format('d-m-Y'):""}}
                            </span>

                                <b>To</b>
                                <span style="color:blue">
                            {{ isset($careem_sheet->date_to)?\Carbon\Carbon::parse($careem_sheet->date_to)->format('d-m-Y'):"" }}</h4>
                            </span>
                        </div>

<!------------------------------------last upload uber limo--------------------------->
                    <div class="last_upload_uber_limo" style="display: none;">
                        <div class="samples">

                            <a href="{{ asset('assets/salary_sheet_samples/uber_limo_sample_file.xlsx') }}" download target="_blank">(Download Sample File)</a>

                        </div>
                        <h4 class="card-title mb-3 text-center">Last Upload Sheet Dates(Uber Limo):
                            <span style="color:red">{{isset($uber_sheet->date_from)?\Carbon\Carbon::parse($uber_sheet->date_from)->format('d-m-Y'):""}}
                            </span>

                            <b>To</b>
                            <span style="color:blue">
                            {{ isset($uber_sheet->date_to)?\Carbon\Carbon::parse($uber_sheet->date_to)->format('d-m-Y'):"" }}</h4>
                        </span>
                    </div>

                    <!------------------------------------last upload careem limo--------------------------->
                    <div class="last_upload_careem_limo" style="display: none;">
                        <div class="samples">

                            <a href="{{ asset('assets/salary_sheet_samples/careem_limos_sample.xlsx') }}" download target="_blank">(Download Sample File)</a>

                        </div>
                        <h4 class="card-title mb-3 text-center">Last Upload Sheet Dates(Careem Limo):
                            <span style="color:red">{{isset($careem_limo_sheet->date_from)?\Carbon\Carbon::parse($careem_limo_sheet->date_from)->format('d-m-Y'):""}}
                            </span>

                            <b>To</b>
                            <span style="color:blue">
                            {{ isset($careem_limo_sheet->date_to)?\Carbon\Carbon::parse($careem_limo_sheet->date_to)->format('d-m-Y'):"" }}</h4>
                        </span>
                    </div>




                    <form method="post" enctype="multipart/form-data" action="{{ url('/talabat_salary_upload') }}"  aria-label="{{ __('Upload') }}" >                        {!! csrf_field() !!}
                        {!! csrf_field() !!}
                        <div class="row">



                        <div class="col-md-2  mb-3">
                            <label for="repair_category">Platform</label>
                            <select id="platform_id" name="platform_id" class="form-control" required>
                                <option value=""  >Select option</option>
                                @foreach($platform as $row)
                                <option value="{{ $row->id }}">{{ $row->name  }}</option>
                                @endforeach
                            </select>
                        </div>
                            <div class="col-md-2  mb-3">
                            <label for="repair_category">Month</label>
                            <select id="month_name" name="month_name" class="form-control">
                                <option value="" selected disabled  >Select option</option>
                                <option value="1">Janaury</option>
                                <option value='2'>February</option>
                                <option value='3'>March</option>
                                <option value='4'>April</option>
                                <option value='5'>May</option>
                                <option value='6'>June</option>
                                <option value='7'>July</option>
                                <option value='8'>August</option>
                                <option value='9'>September</option>
                                <option value='10'>October</option>
                                <option value='11'>November</option>
                                <option value='12'>December</option>
                            </select>
                        </div>

                        <div class="col-md-2  mb-3">
                            <label for="repair_category">Date From</label>
                            <input type="text" class="form-control" autocomplete="off" required name="date_from" placeholder="dd-mm-YYYY" id="date_from">
                        </div>

                        <div class="col-md-2  mb-3">
                            <label for="repair_category"> Date To</label>
                            <input type="text" class="form-control" required name="date_to" autocomplete="off" id="date_to" placeholder="dd-mm-YYYY">
                        </div>

                            <div class="col-md-2   form-group mb-3">
                                <label for="repair_category">Choose File</label>
                                <input class="form-control" id="select_file" type="file" name="select_file" aria-describedby="inputGroupFileAddon01" required />
                            </div>

                        </div>
                        <div  class="row">
                            <div class="col-md-4 input-group  form-group mb-3">
                                <button class="btn btn-primary btn-sub" type="submit">Upload</button>
                            </div>



                        </div>


                    </form>



                </div>
            </div>
    </div>

</div>


<div class="row">
    <div class="col-md-12">

        <div class="accordion" id="accordionRightIcon" style="margin-bottom: 10px; display:  none">
            <div class="card">
                <div class="card-header header-elements-inline">
                    <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0 "><a class="text-default collapsed collapse_cls_pending" data-toggle="collapse" href="#accordion-item-icons-1" aria-expanded="false"><span><i class="i-Filter-2 ul-accordion__font"> </i></span>Filter</a></h6>
                </div>
                <div class="collapse" id="accordion-item-icons-1" data-parent="#accordionRightIcon">
                    <div class="card-body">


                        <form method="post" action="{{ url('/salary_sheet_search') }}">
                            {!! csrf_field() !!}
                            <div class="row">
                            <div class="col-md-3  mb-3">

                                <input type="hidden" class="form-control" required name="platform_name"  id="platform_search">
                                <label for="repair_category">Date From</label>
                                <input type="date" class="form-control" required name="date_from" id="date_from_search"  autocomplete="off"  placeholder="dd-mm-YYYY">
                            </div>

                            <div class="col-md-3  mb-3">
                                <label for="repair_category"> Date To</label>
                                <input type="date" class="form-control" required name="date_to" id="date_to_search" autocomplete="off">
                            </div>
                            <div class="col-md-3 mb-3 mt-2">

                                <button class="btn btn-primary btn-sub" type="submit">Search</button>
                            </div>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="col-sm-12 loading_msg" style="display: none" >
    <div class="row">
        <div class="col-sm-4">
        </div>
        <div class="col-sm-4">
            <div class="loader-spin">
                <div class="spinner spinner-success mr-3" style=" font-size: 30px"></div>
            </div>


        </div>
        <div class="col-sm-4">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 mb-4">
        <div class="card text-left">
            <div class="card-body">

        <div class="talabat_table" style="display:  none"></div>
        </div>
        <div class="del_table"  style="display:  none">
        </div>
        <div class="careem_table"  style="display:  none">
         </div>
         <div class="careem_limo_table"  style="display:  none">
         </div>
         <div class="uber_limo_table"  style="display:  none">
         </div>
    </div>
    </div>
    </div>
    </div>


</div>


<



<!---->
<!---->
<!---->
<!---->
<!-------------talabat payment-------------
<-----------talabat payment--------------->
<!---->


<!---->


<!-------------talabat generate payment ends here--------------->
<!-------------talabat generate payment enders--------------->







@endsection
@section('js')
<script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
<script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
<script>

    $('#platform_id').select2({
        placeholder: 'Select an option'
    });
    $('#month_name').select2({
        placeholder: 'Select an option'
    });

     $(".last_upload-2").hide();
     $(".last_upload-1").hide();
     $(".last_upload-careem").hide();
     $(".last_upload_uber_limo").hide();
     $(".last_upload_careem_limo").hide();
    $(".accordion").hide();



    $( "#platform_id" ).change(function() {
        var id = $("#platform_id option:selected").val();

        $('input[name=platform_name]').val('');
        // var talabat_last_date= $('#talabat_last_date_to').val();




        if (id=='15'){
            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('talabat_table') }}",
                method: 'POST',
                dataType: 'json',
                data:{_token:token},
                beforeSend: function () {
                        $(".loading_msg").show();
                    },
                success: function (response) {
                    $('.talabat_table').empty();
                    $('.talabat_table').append(response.html);
                    $(".last_upload-1").show();

                     $(".last_upload-2").hide();
                     $(".last_upload-careem").hide();
                     $(".last_upload_uber_limo").hide();
                     $(".last_upload_careem_limo").hide();
                     $(".uber_limo_table").hide();

                     $(".accordion").show();
                     $(".del_table").hide();
                     $(".talabat_table").show();
                     $(".careem_table").hide();
                     $(".careem_limo_table").hide();

                    var table = $('#datatable_talabat').DataTable({
                        paging: true,
                        info: true,
                        searching: true,
                        autoWidth: true,
                        retrieve: true
                    });
                    table.columns.adjust().draw();


                    $('input[name=platform_name]').val(id);
                    var val = $('#talabat_last_date_to').text();
                    var val2 = $('#talabat_last_date_month').text();
                    $('input[name=date_from]').val(val);
                    $('input[name=date_to]').val(val2);
                    $(".loading_msg").hide();

        tail.DateTime("#date_from",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,
        }).on("change", function(){
            tail.DateTime("date_from",{
                dateStart: $('#start_tail').val(),
                dateFormat: "YYYY-mm-dd",
                timeFormat: false
            }).reload();

        });
        tail.DateTime("#date_to",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,
        }).on("change", function(){
            tail.DateTime("#date_to",{
                dateStart: $('#date_issue').val(),
                dateFormat: "YYYY-mm-dd",
                timeFormat: false
            }).reload();
        });
                    $(".new_sheet").click(function(){
                        var ab_table = $('#datatable_tab1_modal').DataTable();
                        ab_table.destroy();
                        $("#exampleModalPreview").modal('show');
                        $('#datatable_tab1_modal').DataTable( {
                        });
                    });

                    $(".performa-tal").click(function(){
                        var ab_table = $('#datatable_tab2_modal').DataTable();
                        ab_table.destroy();
                    $("#talabat_performa").modal('show');
                        $('#datatable_tab2_modal').DataTable( {
                        });
                    });

                    $(".confirm-invoice-tal").click(function(){
                    $("#talabal_invoice_confirm").modal('show');
                    });
                    $(".confirm-inv-tal").click(function(){
                        var ab_table = $('#datatable_tab3_con_modal').DataTable();
                        ab_table.destroy();
                    $("#talabal_invoice_confirm_mdl").modal('show');
                        $('#datatable_tab3_con_modal').DataTable( {
                        });
                    });

                    $(".transfert_to_payment").click(function(){
                        var ab_table = $('#datatable_tab5_modal').DataTable();
                        ab_table.destroy();
                     $("#talabal_show_slips").modal('show');
                        $('#datatable_tab5_modal').DataTable( {
                        });
                    });

                    $(".confirm-mdl").click(function(){
                    $("#talabal_confirmed").modal('show');
                    });
                    $(".show-confirm-tal").click(function(){
                    $("#talabal_show_confirm_inv_mdl").modal('show');
                    });

                    $(".show_slip-tal").click(function(){
                    $("#talabal_show_slips").modal('show');
                    });
                    talabat_transfer_payment

                    $(".transfer_payment-tal").click(function(){
                    $("#talabat_transfer_payment").modal('show');
                    });

                    $(".generate_payment-tal").click(function(){
                        var ab_table = $('#datatable_tab6_modal').DataTable();
                        ab_table.destroy();
                        $("#generate_payment-tal").modal('show');
                        $('#datatable_tab6_modal').DataTable( {
                        });
                    });

                    $(".payment-btn").click(function(){
                        var ab_table = $('#datatable_tab7_modal').DataTable();
                        ab_table.destroy();
                        $("#talabat_transfer_payment").modal('show');
                        $('#datatable_tab7_modal').DataTable( {
                        });
                    });
                    $(".done_btn").click(function(){
                        var ab_table = $('#datatable_tab8_modal').DataTable();
                        ab_table.destroy();
                        $("#talabat_transfer_payment_done").modal('show');
                        $('#datatable_tab8_modal').DataTable( {
                        });
                    });




                }
            });




         }
         else if(id=='4'){

            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('deliveroo_table') }}",
                method: 'POST',
                dataType: 'json',
                data:{_token:token},
                beforeSend: function () {
                        $(".loading_msg").show();
                    },
                success: function (response) {
                    $('.del_table').empty();
                    $('.del_table').append(response.html);
                    $(".del_table").show();
                    $(".last_upload-2").show();
             $(".last_upload-1").hide();
            $(".last_upload-careem").hide();
            $(".last_upload_careem_limo").hide();
            $(".last_upload_uber_limo").hide();
            $(".uber_limo_table").hide();


             $(".del_table").show();
             $(".talabat_table").hide();
            $(".careem_table").hide();
            $(".careem_limo_table").hide();

            $(".accordion").show();
             var table = $('#datatable-1').DataTable({
                 paging: true,
                 info: true,
                 searching: true,
                 autoWidth: true,
                 retrieve: true
             });
             table.columns.adjust().draw();
             $('input[name=platform_name]').val(id);
            var val = $('#del_last_date_to').text();
            var val2 = $('#del_last_date_month').text();
            $('input[name=date_from]').val(val);
            $('input[name=date_to]').val(val2);
            $(".loading_msg").hide();

        tail.DateTime("#date_from",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,

        }).on("change", function(){
            tail.DateTime("date_from",{
                dateStart: $('#start_tail').val(),
                dateFormat: "YYYY-mm-dd",
                timeFormat: false

            }).reload();

        });


        tail.DateTime("#date_to",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,

        }).on("change", function(){
            tail.DateTime("#date_to",{
                dateStart: $('#date_issue').val(),
                dateFormat: "YYYY-mm-dd",
                timeFormat: false

            }).reload();

        });

                }
            });



         }
         else if(id=='1'){

            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('careem_table') }}",
                method: 'POST',
                dataType: 'json',
                data:{_token:token},
                beforeSend: function () {
                        $(".loading_msg").show();
                    },
                success: function (response) {
                    $('.careem_table').empty();
                    $('.careem_table').append(response.html);


             $(".last_upload-2").hide();
             $(".last_upload-1").hide();
            $(".last_upload_careem_limo").hide();
            $(".last_upload-careem").show();
            $(".last_upload_uber_limo").hide();

             $(".del_table").hide();
             $(".careem_table").show();
             $(".talabat_table").hide();
            $(".careem_limo_table").hide();
            $(".uber_limo_table").hide();

            $(".accordion").show();
             var table = $('#datatable-careem').DataTable({
                 paging: true,
                 info: true,
                 searching: true,
                 autoWidth: true,
                 retrieve: true
             });
             table.columns.adjust().draw();
             $('input[name=platform_name]').val(id);

            var val = $('#careem_last_date_to').text();
            var val2 = $('#careem_last_date_month').text();
            $('input[name=date_from]').val(val);
            $('input[name=date_to]').val(val2);
            $(".loading_msg").hide();

        tail.DateTime("#date_from",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,

        }).on("change", function(){
            tail.DateTime("date_from",{
                dateStart: $('#start_tail').val(),
                dateFormat: "YYYY-mm-dd",
                timeFormat: false

            }).reload();

        });


        tail.DateTime("#date_to",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,

        }).on("change", function(){
            tail.DateTime("#date_to",{
                dateStart: $('#date_issue').val(),
                dateFormat: "YYYY-mm-dd",
                timeFormat: false

            }).reload();

        });

                }
            });


         }

        else if(id=='31'){

            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('uber_limo_table') }}",
                method: 'POST',
                dataType: 'json',
                data:{_token:token},
                beforeSend: function () {
                        $(".loading_msg").show();
                    },
                success: function (response) {
                    $('.uber_limo_table').empty();
                    $('.uber_limo_table').append(response.html);
                    $(".last_upload-2").hide();
                    $(".last_upload-1").hide();
                    $(".last_upload-careem").hide();
                    $(".last_upload_careem_limo").hide();
                    $(".last_upload_uber_limo").show();

                    $(".del_table").hide();
                    $(".careem_table").hide();
                    $(".talabat_table").hide();
                    $(".uber_limo_table").show();
                    $(".careem_limo_table").hide();

            $(".accordion").show();
            var table = $('#datatable_uber_limo').DataTable({
                aaSorting: [],
                paging: true,
                info: true,
                searching: true,
                autoWidth: true,
                retrieve: true
            });
            table.columns.adjust().draw();

            $('input[name=platform_name]').val(id);
            var val = $('#uber_limo_last_date_to').text();
            var val2 = $('#uber_limo_last_date_month').text();
            $('input[name=date_from]').val(val);
            $('input[name=date_to]').val(val2);
            $(".loading_msg").hide();


        tail.DateTime("#date_from",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,
        }).on("change", function(){
            tail.DateTime("date_from",{
                dateStart: $('#start_tail').val(),
                dateFormat: "YYYY-mm-dd",
                timeFormat: false
            }).reload();
        });
        tail.DateTime("#date_to",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,
        }).on("change", function(){
            tail.DateTime("#date_to",{
                dateStart: $('#date_issue').val(),
                dateFormat: "YYYY-mm-dd",
                timeFormat: false
            }).reload();
        });}});}
        else if(id=='32'){
            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('careem_limo_table') }}",
                method: 'POST',
                dataType: 'json',
                data:{_token:token},
                beforeSend: function () {
                        $(".loading_msg").show();
                    },
                success: function (response) {
                    $('.careem_limo_table').empty();
                    $('.careem_limo_table').append(response.html);

                    $(".last_upload-2").hide();
            $(".last_upload-1").hide();
            $(".last_upload-careem").hide();
            $(".last_upload_uber_limo").hide();
            $(".last_upload_careem_limo").show();
            $(".last_upload_uber_limo").hide();

            $(".del_table").hide();
            $(".careem_table").hide();
            $(".talabat_table").hide();
            $(".uber_limo_table").hide();
            $(".careem_limo_table").show();

            $(".accordion").show();
            var table = $('#datatable_uber_limo').DataTable({
                paging: true,
                info: true,
                searching: true,
                autoWidth: true,
                retrieve: true
            });
            table.columns.adjust().draw();
            $('input[name=platform_name]').val(id);
            var val = $('#careem_limo_last_date_to').text();
            var val2 = $('#careem_limo_last_date_month').text();
            $('input[name=date_from]').val(val);
            $('input[name=date_to]').val(val2);
            $(".loading_msg").hide();

        tail.DateTime("#date_from",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,

        }).on("change", function(){
            tail.DateTime("date_from",{
                dateStart: $('#start_tail').val(),
                dateFormat: "YYYY-mm-dd",
                timeFormat: false

            }).reload();

        });


        tail.DateTime("#date_to",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,

        }).on("change", function(){
            tail.DateTime("#date_to",{
                dateStart: $('#date_issue').val(),
                dateFormat: "YYYY-mm-dd",
                timeFormat: false

            }).reload();

        });
                }
            });

        }




         else{
             $(".last_upload-1").hide();
             $(".last_upload-2").hide();
             $(".last_upload-careem").hide();
             $(".last_upload_uber_limo").hide();
             $(".last_upload_careem_limo").hide();
             $(".accordion").hide();
             $(".del_table").hide();
             $(".talabat_table").hide();
             $(".careem_table").hide();
             $(".uber_limo_table").hide();
             $(".careem_limo_table").hide();
         }
    });



</script>

<script>

    $( "#month_name" ).change(function() {

        var month_id = $("#month_name option:selected").val();

        var jan_start = "<?php echo date("Y-01-01"); ?>";
        var fab_start = "<?php echo date("Y-02-01"); ?>";
        var mar_start = "<?php echo date("Y-03-01"); ?>";
        var april_start = "<?php echo date("Y-04-01"); ?>";
        var may_start = "<?php echo date("Y-05-01"); ?>";
        var jun_start = "<?php echo date("Y-06-01"); ?>";
        var jul_start = "<?php echo date("Y-07-01"); ?>";
        var aug_start = "<?php echo date("Y-08-01"); ?>";
        var sep_start = "<?php echo date("Y-09-01"); ?>";
        var oct_start = "<?php echo date("Y-10-01"); ?>";
        var nov_start = "<?php echo date("Y-11-01"); ?>";
        var dec_start = "<?php echo date("Y-12-01"); ?>";



        var jan_end = "<?php echo date("Y-01-31"); ?>";
        var fab_end = "<?php echo date("Y-02-28"); ?>";
        var mar_end = "<?php echo date("Y-03-31"); ?>";
        var april_end = "<?php echo date("Y-04-30"); ?>";
        var may_end = "<?php echo date("Y-05-31"); ?>";
        var jun_end = "<?php echo date("Y-06-30"); ?>";
        var jul_end = "<?php echo date("Y-07-31"); ?>";
        var aug_end = "<?php echo date("Y-08-31"); ?>";
        var sep_end = "<?php echo date("Y-09-30"); ?>";
        var oct_end = "<?php echo date("Y-10-31"); ?>";
        var nov_end = "<?php echo date("Y-11-30"); ?>";
        var dec_end = "<?php echo date("Y-12-31"); ?>";




        // var year = currentTime.getFullYear()
        //alert(year)

        if (month_id=='1'){
            $('input[name=date_from]').val(jan_start);
            $('input[name=date_to]').val(jan_end);


        }
        if (month_id=='2'){
            $('input[name=date_from]').val(fab_start);
            $('input[name=date_to]').val(fab_end);
        }
        if (month_id=='3'){
            $('input[name=date_from]').val(mar_start);
            $('input[name=date_to]').val(mar_end);
        }
        if (month_id=='4'){
            $('input[name=date_from]').val(april_start);
            $('input[name=date_to]').val(april_end);
        }
        if (month_id=='5'){
            $('input[name=date_from]').val(may_start);
            $('input[name=date_to]').val(may_end);
        }
        if (month_id=='6'){
            $('input[name=date_from]').val(jun_start);
            $('input[name=date_to]').val(jun_end);
        }
        if (month_id=='7'){
            $('input[name=date_from]').val(jul_start);
            $('input[name=date_to]').val(jul_end);
        }
        if (month_id=='8'){
            $('input[name=date_from]').val(aug_start);
            $('input[name=date_to]').val(aug_end);
        }
        if (month_id=='9'){
            $('input[name=date_from]').val(sep_start);
            $('input[name=date_to]').val(sep_end);
        }
        if (month_id=='10'){
            $('input[name=date_from]').val(oct_start);
            $('input[name=date_to]').val(oct_end);
        }
        if (month_id=='11'){
            $('input[name=date_from]').val(nov_start);
            $('input[name=date_to]').val(nov_end);
        }
        if (month_id=='12'){
            $('input[name=date_from]').val(dec_start);
            $('input[name=date_to]').val(dec_end);
        }



    });
</script>

<script>








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
