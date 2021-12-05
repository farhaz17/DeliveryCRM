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
            <li><a href="">Labour Comparison Forms</a></li>

        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row pb-2" >
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">








                    <form method="post" enctype="multipart/form-data" action="{{ url('/form_upload2') }}"  aria-label="{{ __('Upload') }}" >
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

                                <input class="custom-file-input" id="select_file" type="file" name="select_file" aria-describedby="inputGroupFileAddon01" required />
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


    @if(isset($approval_electronics_exist))
    <div class="row">

    <div class="col-md-6 mb-3">
        <div class="card text-left">
            <div class="card-body">
                <h4>Existing System List</h4>
                <div class="table-responsive">

                    <table class="table" id="datatable3" class="cell-border" style="width: 100%">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">Person Code</th>
                            <th scope="col">Labour Card</th>
                            <th scope="col">Person Name</th>
                            <th scope="col">Passport</th>
                            <th scope="col">Nationality</th>
                            <th scope="col">Labour Card Expiry</th>
                            <th scope="col">Card Type</th>
                            <th scope="col">Job</th>

                        </tr>
                        </thead>
                        <tbody>
                            <?php
                            $other_array = array();
                            $name_array = array();
                            $job_array = array();
                            $lab_expiry_array = array();
                            $passport_array = array();
                            $nation_array = array();
                            $card_type_array = array();
                            $person_code_array = array();
                            ?>

                        @foreach($approval_electronics_exist as $person_exist)

                            <?php  $other_array [] = trim($person_exist['labour_card_no']);  ?>
                            <?php  $name_array [] = trim($person_exist['person_name']);  ?>
                            <?php  $passport_array [] = trim($person_exist['passport_number']);  ?>
                            <?php  $nation_array [] = trim($person_exist['nation']);  ?>
                            <?php  $card_type_array [] = trim($person_exist['card_type']);  ?>
                            <?php  $lab_expiry_array [] = trim($person_exist['expiry_date']);  ?>
                            <?php  $person_code_array [] = trim($person_exist['person_code']);  ?>

                            <tr>
                                <td>{{ $person_exist['person_code']  }}</td>
                                <td>{{ $person_exist['labour_card_no']  }}</td>
                                <td>{{$person_exist['person_name']}}</td>
                                <td>{{$person_exist['passport_number']}}</td>
                                <td>{{$person_exist['nation']}}</td>
                                <td>{{$person_exist['expiry_date']}}</td>
                               <td>{{$person_exist['card_type']}}</td>
                               <td>{{$person_exist['job']}}</td>
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
                    <h4>Existing Labour Upload List</h4>
                    <div class="table-responsive">

                        <table class="table" id="datatable4" style="width: 100%">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col" id="person_code">Person Code</th>
                                <th scope="col" id="labour_card">Labour Card</th>
                                <th scope="col" id="person_name">Person Name</th>
                                <th scope="col" id="job">Job</th>
                                <th scope="col" id="passport">Passport</th>
                                <th scope="col" id="nationality">Nationality</th>
                                <th scope="col" id="labour_card_expiry">Labour Card Expiry</th>
                                <th scope="col" id="card_type">Card Type</th>
                                <th scope="col">Class</th>
                                <th scope="col">Company No</th>

                                {{--                                <th scope="col">Company</th>--}}
                                {{--                                <th scope="col">Nationality</th>--}}
                                {{--                            <th scope="col">Job</th>--}}


                            </tr>
                            </thead>
                            <tbody>


                            @foreach($gamer_exist as $p_exist)

                                <?php $style_name  = ""; ?>
                                <?php $style_pass  = ""; ?>
                                <?php $style_nation  = ""; ?>
                                <?php $style_expiry  = ""; ?>
                                <?php $style_card_type  = ""; ?>
                                <?php $style_person  = ""; ?>







                                <?php
//
                                if(in_array($p_exist->labour_card,$other_array)){
//                                $counter_name=0;
                                 if(in_array($p_exist->person_name,$name_array)){
                                    $style_name = "";
                                     $name_var='';
                                  }
                                 else{
                                     $counter_name=0;
                                     $style_name = "orange";


                                     if ($style_name=='orange')
                                     {


                                     }
                                     $counter_name++;
                                 }




                                    if(in_array($p_exist->passport,$passport_array)){
                                        $style_pass = "";
                                        $pass_var = '';
                                    }
                                    else{
                                        $counter_pass=0;
                                        $style_pass = "orange";
                                        $pass_var = 'orange';

                                        if ($pass_var=='orange')
                                        {


                                    }
                                        $counter_pass++;
                                    }




                                    if(in_array($p_exist->person_code,$person_code_array)){
                                        $style_person = "";
                                        $person_var='';
                                  }
                                 else{
                                     $counter_person=0;
                                     $style_person = "orange";

                                     if ($style_person=='orange')
                                     {


                                     }
                                     $counter_person++;
                                 }


                                    //nationanlity

//                                    $cap_to_small= strtolower($p_exist->nationality);
//                                    $first_cap= ucfirst($cap_to_small);
//                                    echo $first_cap;
                                    if(in_array($p_exist->nationality,$nation_array)){

                                        $style_nation = "";
                                        $nation_var='';
                                    }
                                    else{
                                        $counter_nation=0;
                                        $style_nation = "orange";
                                        if ($style_nation=='orange')
                                        {
                                        }
                                        $counter_nation++;
                                    }
                                    //expiry
                                    if(in_array($p_exist->labour_card_expiry,$lab_expiry_array)){

                                        $style_expiry = "";
                                        $expiry_var='';
                                    }
                                    else{
                                        $counter_expiry=0;
                                        $style_expiry = "orange";

                                        if ($style_expiry=='orange')
                                        {


                                        }
                                        $counter_expiry++;
                                    }
                                    //card type

                                    if(in_array($p_exist->card_type,$card_type_array)){

                                        $style_card_type = "";
                                        $card_var='';
                                    }
                                    else{
                                        $counter_card=0;
                                        $style_card_type = "orange";

                                        if ($style_card_type=='orange')
                                        {


                                        }
                                        $counter_card++;
                                    }
                                           ?>

                                <?php if ($style_name  == "" and $style_pass  == "" and  $style_nation  == "" and  $style_expiry  == "" and $style_card_type  == "" and $style_person=="")
                                    {

                                      }
                                else{
                                    ?>

                                 <tr>

                                    <td style="background-color: {{ $style_person }}">{{$p_exist->person_code}}</td>
                                    <td>{{$p_exist->labour_card}}</td>
                                    <td style="background-color: {{ $style_name }}">{{$p_exist->person_name}}</td>
                                    <td>{{$p_exist->job}}</td>
                                    <td style="background-color: {{ $style_pass }}">{{$p_exist->passport}}</td>
                                    <td style="background-color: {{$style_nation}}">{{$p_exist->nationality}}</td>
                                    <td style="background-color: {{ $style_expiry }}">{{$p_exist->labour_card_expiry}}</td>
                                    <td style="background-color: {{ $style_card_type }}">{{$p_exist->card_type}}</td>
                                    <td>{{$p_exist->class}}</td>
                                    <td>{{$p_exist->company_no}}</td>
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

    @if(isset($approval_electronics))
    <div class="row">

    <div class="col-md-6 mb-3">
        <div class="card text-left">
            <div class="card-body">
                <h4> Missing System List</h4>
                <div class="table-responsive">

                    <table class="table" id="datatable" style="width: 100%">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">Labour Card</th>
                            <th scope="col">Person Name</th>
                            <th scope="col">Passport</th>
                            <th scope="col">Nationality</th>
                            <th scope="col">Labour Card Expiry</th>
                            <th scope="col">Card Type</th>
                            <th scope="col">Job</th>

                        </tr>
                        </thead>
                        <tbody>

                        @foreach($approval_electronics as $person)
                            @if(isset($person->passport->offer->company))
                            @if(in_array($person->passport->offer->company, $company_ids))
                            <tr>
                                <td>{{$person->labour_card_no}}</td>
                                <td>{{$person->passport->personal_info->full_name}}</td>
                                <td>{{$person->passport->passport_no}}</td>
                                <td>{{$person->passport->nation->name}}</td>
                                <td>{{$person->expiry_date}}</td>
                                <td>{{isset($person->passport->card_type->card_type_name->name)?$person->passport->card_type->card_type_name->name:""}}</td>
                                <td>{{isset($person->passport->offer->designation->name)?$person->passport->offer->designation->name:""}}</td>
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
                    <h4>Missing Labour Upload List</h4>
                    <div class="table-responsive">

                        <table class="table" id="datatable1" style="width: 100%">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">Labour Card</th>
                                <th scope="col">Labour Code</th>
                                <th scope="col">Person Name</th>
                                <th scope="col">Job</th>
                                <th scope="col">Passport</th>
                                <th scope="col">Nationality</th>
                                <th scope="col">Labour Card Expiry</th>
                                <th scope="col">Card Type</th>
                                <th scope="col">Class</th>
                                <th scope="col">Company No</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($gamer as $person)
                                    <tr>
                                    <td>{{$person->labour_card}}</td>
                                    <td>{{$person->person_code}}</td>
                                    <td>{{$person->person_name}}</td>
                                    <td>{{$person->job}}</td>
                                    <td>{{$person->passport}}</td>
                                    <td>{{$person->nationality}}</td>
                                    <td>{{$person->labour_card_expiry}}</td>
                                    <td>{{$person->card_type}}</td>
                                    <td>{{$person->class}}</td>
                                    <td>{{$person->company_no}}</td>
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


            var style_name = "<?php echo isset($counter_name); ?>";
            var style_pass = "<?php echo isset($counter_pass); ?>";
            var style_person = "<?php echo isset($counter_person) ; ?>";
            var $style_nation = "<?php echo isset($counter_nation); ?>";
            var $style_expiry = "<?php echo isset($counter_expiry) ; ?>";
            var $style_card_type = "<?php echo isset($counter_card); ?>";
           // alert(style_name)



            if (style_name>=1){
                $("#person_name").css("background", "#ef0000");
            }


            if (style_pass>=1){
                $("#passport").css("background", "#ef0000");
            }



            if (style_person>=1){
                $("#person_code").css("background", "#ef0000");
            }



            if ($style_nation>=1){
                $("#nationality").css("background", "#ef0000");
            }

            if ($style_expiry >=1){
                $("#labour_card_expiry").css("background", "#ef0000");
            }



            if ($style_card_type>=1){
                $("#card_type").css("background", "#ef0000");
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
