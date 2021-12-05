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
</style>
@endsection
@section('content')
<div class="breadcrumb">
    <h1 class="mr-2">Home</h1>
    <ul>
        <li><a href="">Salary Sheet</a></li>
        <li>Rider Rate</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>


<div class="row mb-4">
    <div class="col-md-12 mb-4">
        <div class="card text-left">
            <div class="card-body">
                <h4 class="card-title mb-3">Company Rate</h4>

                <div class="card-body">








                    <form method="post" action="{{ url('/salary_sheet_search') }}">
                        {!! csrf_field() !!}
                        <div class="row">
                            <div class="col-md-6  mb-3">

                                <input type="hidden" class="form-control" required name="platform_name"  id="platform_search">
                                <label for="repair_category">Field 1</label>
                                <input type="text" class="form-control" required name="date_from" id="date_from_search"  autocomplete="off">
                            </div>
                            <div class="col-md-6  mb-3">

                                <input type="hidden" class="form-control" required name="platform_name"  id="platform_search">
                                <label for="repair_category">Field 2</label>
                                <input type="text" class="form-control" required name="date_from" id="date_from_search"  autocomplete="off">
                            </div>
                            <div class="col-md-6  mb-3">

                                <input type="hidden" class="form-control" required name="platform_name"  id="platform_search">
                                <label for="repair_category">Field 3</label>
                                <input type="text" class="form-control" required name="date_from" id="date_from_search"  autocomplete="off" >
                            </div>
                            <div class="col-md-6  mb-3">

                                <input type="hidden" class="form-control" required name="platform_name"  id="platform_search">
                                <label for="repair_category">Field 4</label>
                                <input type="text" class="form-control" required name="date_from" id="date_from_search"  autocomplete="off"  >
                            </div>
                            <div class="col-md-6  mb-3">

                                <input type="hidden" class="form-control" required name="platform_name"  id="platform_search">
                                <label for="repair_category">Field 5</label>
                                <input type="text" class="form-control" required name="date_from" id="date_from_search"  autocomplete="off" >
                            </div>


                            <div class="col-md-5 mb-3 mt-2">

                                <button class="btn btn-primary btn-sub" type="submit">Save</button>
                            </div>
                        </div>
                    </form>
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

            var table = $('#datatable').DataTable({
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
        }
        else if(id=='4'){
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

        }
        else if(id=='1'){
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
        }

        else if(id=='31'){
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
        }
        else if(id=='32'){
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
    $(document).ready(function () {
        'use strict';

        $('#datatable').DataTable( {
            "aaSorting": [[0, 'desc']],
            "pageLength": 10,
            "columnDefs": [
                {"targets": [0],"visible": true},
                {"targets": [1][2],"width": "40%"}
            ],
            "scrollY": false,
        });
        $('#datatable-1').DataTable( {
            "aaSorting": [[0, 'desc']],
            "pageLength": 10,
            "columnDefs": [
                {"targets": [0],"visible": true},
                {"targets": [1][2],"width": "40%"}
            ],
            "scrollY": false,
        });



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


    });


</script>

<script>
    $('#next-btn').click(function(){
        $("#profile-basic-tab").click();
    });


    $('#next-btn-2').click(function(){
        $("#contact-basic-tab").click();
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
