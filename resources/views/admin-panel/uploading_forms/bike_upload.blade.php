@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <style>

        .btn-upload {
            margin-top: 23px;
        }
        th {
            white-space: nowrap;
            font-size: 13px;
        }
        td {
            white-space: nowrap;
            font-size: 12px;
        }
    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Bike Comparison Forms</a></li>

        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row pb-2" >
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">








                    <form method="post" enctype="multipart/form-data" action="{{ url('/form_upload4') }}"  aria-label="{{ __('Upload') }}" >
                        {!! csrf_field() !!}
                        <div class="row">




                            <div class="col-md-4 form-group mb-3">
                                <label for="repair_category">Company</label>
                                <select id="company_ids" name="company_ids[]" class="form-control cls_card_type">
                                    <option value=""  >Select option</option>
                                    @foreach($company as $lab)
                                        <option value="{{ $lab->id }}">{{ $lab->name  }}</option>
                                    @endforeach
                                </select>
                                <br>
                                <input type="checkbox"  id="checkAll"><strong>&nbsp;&nbsp;Check All</strong><br>
                                <div style="display: none">
                                    @foreach($company as $lab)
                                        <input class="append_elements"  type="checkbox" id="company_ids" name="company_ids[]" value="{{ $lab->id }}">  <label class="append_elements"  for="vehicle1">{{$lab->name}}</label>
                                        <br>
                                    @endforeach
                                </div>

                            </div>

                            {{--                        <div class="col-md-6 form-group mb-3">--}}


                            {{--                        </div>--}}


                            <div class="col-md-4 form-group mb-3">
                                <label for="repair_category">Upload File</label>
                                <div class="custom-file">

                                    <input class="custom-file-input" id="select_file" type="file" name="select_file" aria-describedby="inputGroupFileAddon01" required/>
                                    <label class="custom-file-label" for="select_file">Choose file</label>
                                </div>

                            </div>

                            <div class="col-md-4 form-group mb-3">

                                <button class="btn btn-primary btn-upload" type="submit">Upload</button>
                            </div>



                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>


    @if(isset($approval_bikes_exist))

        <div class="row">

            <div class="col-md-6 mb-3">
                <div class="card text-left">
                    <div class="card-body">
                        <h4>Existing Bike System List</h4>
                        <div class="table-responsive">

                            <table class="table" id="datatable" style="width: 100%">
                                <thead class="thead-dark">
                                <tr>

                                    <th scope="col">Plate No</th>
                                    <th scope="col">Plate Code</th>
                                    <th scope="col" >Model</th>
                                    <th scope="col">Make Year</th>
                                    <th scope="col">Chassis No</th>
                                    <th scope="col">Mortgaged_by</th>
                                    <th scope="col">Insurance co</th>
                                    <th scope="col">Expiry Date</th>
                                    <th scope="col">Issue Date</th>
                                    <th scope="col">Traffic File No</th>

                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $plate_array = array();
                                $model_array = array();
                                $make_year_array = array();
                                $chassis_array = array();
                                $insurance_array = array();
                                $company_array = array();
                                $reg_expire_array = array();
                                $reg_issue_array = array();
                                ?>



                                @foreach($approval_bikes_exist as $bike)


                                    <?php   $plate_array [] = $bike['plate_no'];  ?>
                                    <?php  $chassis_array [] =  $bike['chassis_no'];  ?>
                                    <?php  $make_year_array[] =    $bike['make_year'];  ?>
                                    <?php   $model_array [] = $bike['model'];  ?>
                                    <?php   $insurance_array [] = $bike['insurance_co'];  ?>
                                    <?php   $reg_expire_array [] = $bike['expiry_date'];  ?>
                                    <?php   $reg_issue_array [] = $bike['issue_date'];  ?>

                                            <tr>
                                                <td>{{$bike['plate_no']}}</td>
                                                <td>{{$bike['plate_code']}}</td>
                                                <td>{{$bike['model']}}</td>
                                                <td>{{$bike['make_year']}}</td>
                                                <td>{{$bike['chassis_no']}}</td>
                                                <td>{{$bike['mortgaged_by']}}</td>
                                                <td>{{$bike['insurance_co']}}</td>
                                                <td>{{$bike['expiry_date']}}</td>
                                                <td>{{$bike['issue_date']}}</td>
                                                <td>{{$bike['traffic_file']}}</td>

                                            </tr>

                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            @endif

            @if(isset($gamer_exist))

                <div class="col-md-6 mb-3">
                    <div class="card text-left">
                        <div class="card-body">
                            <h4>Existing Bike Upload List</h4>
                            <div class="table-responsive">

                                <table class="table" id="datatable4" style="width: 100%">
                                    <thead class="thead-dark">
                                    <tr>








                                        <th scope="col" id="plate_head">Plate No</th>
                                        <th scope="col" id="labour_card">Plate Code</th>
                                        <th scope="col" id="model_head">Model</th>
                                        <th scope="col" id="make_year_head">Make Year</th>
                                        <th scope="col" id="chassis_head">Chassis No</th>
                                        <th scope="col" id="nationality">Mortgaged_by</th>
                                        <th scope="col" id="insurance_head">Insurance co</th>
                                        <th scope="col" id="expiry_date_head">Expiry Date</th>
                                        <th scope="col" id="issue_head">Issue Date</th>
                                        <th scope="col">Traffic File No</th>


                                        {{--                                <th scope="col">Company</th>--}}
                                        {{--                                <th scope="col">Nationality</th>--}}
                                        {{--                            <th scope="col">Job</th>--}}


                                    </tr>
                                    </thead>
                                    <tbody>


                                    @foreach($gamer_exist as $p_exist)

                                        <?php $style_plate  = ""; ?>
                                        <?php $style_plate_code  = ""; ?>
                                        <?php $style_model  = ""; ?>
                                        <?php $style_make_year  = ""; ?>
                                        <?php $style_chassis  = ""; ?>
                                        <?php $style_morg  = ""; ?>
                                        <?php $style_insurance  = ""; ?>
                                        <?php $style_expire_date  = ""; ?>
                                        <?php $style_traffic  = ""; ?>
                                        <?php $style_company  = ""; ?>
                                        <?php $style_issue  = ""; ?>

                                        <?php
                                        if(in_array($p_exist->chassis_no,$chassis_array)){

                                            if(in_array($p_exist->plate_no,$plate_array)){
                                                $style_plate = "";
                                            }
                                            else{
                                                $counter_plate=0;
                                                $style_plate = "orange";
                                                if ($style_plate=='orange')
                                                {


                                                }
                                                $counter_plate++;
                                            }

                                            if(in_array($p_exist->chassis_no,$chassis_array)){
                                                $style_chassis = "";
                                            }
                                            else{
                                                $counter_chassis=0;
                                                $style_chassis = "orange";

                                                if ($style_chassis=='orange')
                                                {


                                                }
                                                $counter_chassis++;
                                            }

                                            if(in_array($p_exist->model,$model_array)){
                                                $style_model = "";
                                            }
                                            else{
                                                $counter_model=0;
                                                $style_model = "orange";

                                                if ($style_model=='orange')
                                                {


                                                }
                                                $counter_model++;
                                            }

                                            if(in_array($p_exist->make_year,$make_year_array)){
                                                $style_make_year = "";
                                            }
                                            else{
                                                $counter_make_year=0;
                                                $style_make_year = "orange";


                                                if ($style_make_year=='orange')
                                                {


                                                }
                                                $counter_make_year++;
                                            }

                                            if(in_array($p_exist->expiry_date,$reg_expire_array)){
                                                $style_expire_date = "";
                                            }
                                            else{
                                                $counter_expiry_date=0;
                                                $style_expire_date = "orange";
                                                if ($style_expire_date=='orange')
                                                {


                                                }
                                                $counter_expiry_date++;
                                            }

                                            if(in_array($p_exist->issue_date,$reg_issue_array)){
                                                $style_issue = "";
                                            }
                                            else{
                                                $counter_issue=0;
                                                $style_issue = "orange";
                                                if ($style_issue=='orange')
                                                {


                                                }
                                                $counter_issue++;
                                            }



                                            if(in_array($p_exist->insurance_co,$insurance_array )){
                                                $style_insurance = "";
                                            }
                                            else{
                                                $counter_insruance=0;
                                                $style_insurance = "orange";
                                                if ($style_insurance=='orange')
                                                {


                                                }
                                                $counter_insruance++;
                                            }


                                            ?>





                                        <?php
                                        if ($style_plate  == "" and $style_chassis  == "" and  $style_model  == ""  and $style_make_year == ""
                                        and $style_expire_date == "" and $style_issue == "" and $style_insurance == "" )
                                            {

                                            }
                                            else{
                                                ?>

                                        <tr>

                                            <td style="background-color: {{ $style_plate }}">{{$p_exist->plate_no}}</td>
                                            <td>{{$p_exist->plate_code}}</td>
                                            <td style="background-color: {{ $style_model }}" >{{$p_exist->model}}</td>
                                            <td style="background-color: {{ $style_make_year }}"{{$p_exist->make_year}}</td>
                                            <td style="background-color: {{ $style_chassis }}">{{$p_exist->chassis_no}}</td>
                                            <td>{{$p_exist->mortgaged_by}}</td>
                                            <td style="background-color: {{ $style_insurance }}">{{$p_exist->insurance_co}}</td>
                                            <td style="background-color: {{ $style_expire_date }}">{{$p_exist->expiry_date}}</td>
                                            <td style="background-color: {{ $style_issue }}">{{$p_exist->issue_date}}</td>
                                            <td>{{$p_exist->traffic_file}}</td>


                                        </tr>


                                        <?php

                                        }

                                        }

                                        ?>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    @endif

    @if(isset($bike_detail))
        <div class="row">

            <div class="col-md-6 mb-3">
                <div class="card text-left">
                    <div class="card-body">
                        <h4> Missing Bike System List</h4>
                        <div class="table-responsive">

                            <table class="table" id="datatable" style="width: 100%">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Plate No</th>
                                    <th scope="col">Chasis No</th>
                                    <th scope="col">Engine No</th>
                                    <th scope="col">Make Year</th>
                                    <th scope="col">Registration Issue</th>
                                    <th scope="col">Model</th>
                                    <th scope="col">Registration Expire</th>
                                    <th scope="col">Insurance Co</th>


                                </tr>
                                </thead>
                                <tbody>

                                @foreach($bike_detail as $bike)
                                    @if(isset($bike->company_name))
                                        @if(in_array($bike->company_name, $company_names))
                                            <tr>
                                                <td>{{$bike->plate_no}}</td>
                                                <td>{{$bike->chassis_no}}</td>
                                                <td>{{$bike->engine_no}}</td>
                                                <td>{{$bike->year}}</td>
                                                <td>{{$bike->reg_iss}}</td>
                                                <td>{{$bike->model}}</td>
                                                <td>{{$bike->reg_exp}}</td>
                                                <td>{{$bike->insurance_comp}}</td>

                                            </tr>
                                        @endif
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            @endif

            @if(isset($gamer))
                <div class="col-md-6 mb-3">
                    <div class="card text-left">
                        <div class="card-body">
                            <h4>Missing Bike Upload List</h4>
                            <div class="table-responsive">

                                <table class="table" id="datatable1" style="width: 100%">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th scope="col" id="person_code">Plate No</th>
                                        <th scope="col" id="labour_card">Plate Code</th>
                                        <th scope="col" id="person_name">Model</th>
                                        <th scope="col" id="job">Make Year</th>
                                        <th scope="col" id="passport">Chassis No</th>
                                        <th scope="col" id="nationality">Mortgaged_by</th>
                                        <th scope="col" id="labour_card_expiry">Insurance co</th>
                                        <th scope="col" id="card_type">Expiry Date</th>
                                        <th scope="col">Issue Date</th>
                                        <th scope="col">Traffic File No</th>

                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($gamer as $person)
                                        <tr>
                                            <td>{{$person->plate_no}}</td>
                                            <td>{{$person->plate_code}}</td>
                                            <td >{{$person->model}}</td>
                                            <td>{{$person->make_year}}</td>
                                            <td>{{$person->chassis_no}}</td>
                                            <td>{{$person->mortgaged_by}}</td>
                                            <td>{{$person->insurance_co}}</td>
                                            <td>{{$person->expiry_date}}</td>
                                            <td>{{$person->issue_date}}</td>
                                            <td>{{$person->traffic_file}}</td>

                                        </tr>

                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
        </div>

    @endif

@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            'use strict';

            $('#datatable,#datatable1,#datatable3,#datatable4').DataTable( {

                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [0],"visible": true},
                    {"targets": [1][2],"width": "30%"}
                ],


                dom: "<'row'<'col-sm-4'l><'col-sm-4 text-center'B><'col-sm-4'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7'p>>",
                buttons: [

                    {
                        extend: 'excel',
                        title: 'Labour Uploads',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },

                ],

                // select: true,
                "scrollY": false,
                "scrollX": true
            });



            $('#part_id').select2({
                placeholder: 'Select an option'
            });



        });




        function deleteData(id)
        {
            var id = id;
            var url = '{{ route('inv_parts.destroy', ":id") }}';
            url = url.replace(':id', id);
            $("#deleteForm").attr('action', url);
        }

        function deleteSubmit()
        {
            $("#deleteForm").submit();
        }
        //-----------Download sample divs------------------
    </script>
    @if(isset($gamer_exist))
        <script>
            $(document).ready(function() {

                // $counter_chassis
                // $counter_model
                // $counter_make_year
                // $counter_expiry_date
                // $counter_issue
                // $counter_company
                // $counter_insruance

                var style_plate = "<?php echo isset($counter_plate); ?>";
                var style_chasis = "<?php echo isset($counter_chassis); ?>";
                var style_model = "<?php echo isset($counter_model); ?>";
                var style_make_year = "<?php echo isset($counter_make_year) ; ?>";
                var $style_expiry_date = "<?php echo isset($counter_expiry_date); ?>";
                var $style_issue = "<?php echo isset($counter_issue) ; ?>";
                var $style_company = "<?php echo isset($counter_company); ?>";
                var $style_insurance = "<?php echo isset($counter_insruance); ?>";
                // alert(style_name)



                if (style_plate>=1){
                    $("#plate_head").css("background", "#ef0000");
                }


                if (style_chasis>=1){
                    $("#chassis_head").css("background", "#ef0000");
                }



                if (style_model>=1){
                    $("#model_head").css("background", "#ef0000");
                }



                if (style_make_year>=1){
                    $("#make_year_head").css("background", "#ef0000");
                }

                if ($style_expiry_date >=1){
                    $("#expiry_date_head").css("background", "#ef0000");
                }
                if ($style_issue>=1){
                    $("#issue_head").css("background", "#ef0000");
                }
                if ($style_company>=1){
                    $("#company_head").css("background", "#ef0000");
                }
                if ($style_insurance>=1){
                    $("#insurance_head").css("background", "#ef0000");
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

    <script>
        $("#checkAll").click(function () {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
    </script>

@endsection
