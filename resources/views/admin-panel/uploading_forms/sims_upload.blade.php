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
            <li><a href="">SIM Comparison Forms</a></li>

        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row pb-2" >
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">








                    <form method="post" enctype="multipart/form-data" action="{{ url('/form_upload3') }}"  aria-label="{{ __('Upload') }}" >
                        {!! csrf_field() !!}
                        <div class="row">




                            <div class="col-md-4 form-group mb-3">
                                <label for="repair_category">Company</label>
                                <select id="company_ids" name="company_ids[]" class="form-control cls_card_type">
                                    <option value="" readonly="" >Select option</option>
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




    @if(isset($sims_exist))

        <div class="row">

            <div class="col-md-6 mb-3">
                <div class="card text-left">
                    <div class="card-body">
                        <h4>Existing System SIMs List</h4>
                        <div class="table-responsive">

                            <table class="table" id="datatable3" class="cell-border" style="width: 100%">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Account Number</th>
                                    <th scope="col">Party ID</th>
                                    <th scope="col">Product Type</th>
                                    <th scope="col">Network</th>
                                    {{--                            <th scope="col">Company</th>--}}

                                </tr>
                                </thead>
                                <tbody>

                                <?php
                                $account_array = array();
                                $party_array = array();
                                $product_array = array();
                                $network_array = array();
                                ?>
                                @foreach($sims_exist as $sim)

                                    <?php  $account_array [] = $sim['account_no'];  ?>
                                    <?php  $party_array [] = $sim['party_id'];  ?>
                                    <?php  $product_array [] = $sim['product_type'];  ?>
                                    <?php  $network_array [] = $sim['network'];  ?>
                                    <tr>
                                        <td>{{ $sim['account_no'] }}</td>
                                        <td>{{ $sim['party_id'] }}</td>
                                        <td>{{ $sim['product_type'] }}</td>
                                        <td>{{ $sim['network'] }}</td>
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
                            <h4>Existing  Upload SIMs List</h4>
                            <div class="table-responsive">

                                <table class="table" id="datatable4" style="width: 100%">
                                    <thead class="thead-dark">
                                    <tr>



                                        <th scope="col">Account Number</th>
                                        <th scope="col" id="party_head">Party ID</th>
                                        <th scope="col" id="product_head">Product Type</th>
                                        <th scope="col" id="network_head">Network</th>



                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($gamer_exist as $sim)

                                        <?php $style_party  = ""; ?>
                                        <?php $style_product  = ""; ?>
                                        <?php $style_network  = ""; ?>

                                    <?php
//
                                if(in_array($sim->account_number,$account_array)){

                                    if(in_array($sim->party_id,$party_array)){
                                        $style_party = "";
                                    }
                                    else{
                                        $counter_party=0;
                                        $style_party = "orange";

                                        if ($style_party=='orange')
                                        {


                                        }
                                        $counter_party++;
                                    }

                                    if(in_array($sim->product_type,$product_array)){
                                        $style_product = "";
                                    }
                                    else{
                                        $counter_product=0;
                                        $style_product = "orange";

                                        if ($style_product=='orange')
                                        {


                                        }
                                        $counter_product++;
                                    }

                                    if(in_array($sim->network,$network_array)){
                                        $style_network = "";
                                    }
                                    else{
                                        $counter_network=0;
                                        $style_network = "orange";
                                        if ($style_network=='orange')
                                        {


                                        }
                                        $counter_network++;
                                    }
                                    ?>


                                        <?php if ($style_party  == "" and $style_product  == "" and  $style_network  == "")
                                        {

                                        }
                                        else{
                                        ?>



                                        <tr>
                                            <td>{{ $sim->account_number }}</td>
                                            <td style="background-color: {{ $style_party }}">{{ $sim->party_id }}</td>
                                            <td style="background-color: {{ $style_product }}">{{ $sim->product_type }}</td>
                                            <td style="background-color: {{ $style_network }}">{{ $sim->network }}</td>
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

    @if(isset($missing_sims))
        <div class="row">

            <div class="col-md-6 mb-3">
                <div class="card text-left">
                    <div class="card-body">
                        <h4> Missing System SIMs List</h4>
                        <div class="table-responsive">

                            <table class="table" id="datatable" style="width: 100%">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Account Number</th>
                                    <th scope="col">Party ID</th>
                                    <th scope="col">Product Type</th>
                                    <th scope="col">Network</th>

                                </tr>
                                </thead>
                                <tbody>

                                @foreach($missing_sims as $ab)
                                    @if($ab->network=="Etisalat")
                                        <?php if(isset($ab->get_party_etisalat->company_id)){
                                        if (in_array($ab->get_party_etisalat->company_id, $company_ids)){ ?>

                                    <tr>
                                        <td>{{ $ab->account_number }}</td>
                                        <td>{{ $ab->party_id }}</td>
                                        <td>{{ $ab->product_type }}</td>
                                        <td>{{ $ab->network }}</td>
                                    </tr>
                                        <?php }
                                        }?>
                                    @elseif($ab->network=="DU")
                                        <?php if(isset($ab->get_du->company_id)){
                                        if (in_array($ab->get_du->company_id, $company_ids)){ ?>

                                        <tr>
                                            <td>{{ $ab->account_number }}</td>
                                            <td>{{ $ab->party_id }}</td>
                                            <td>{{ $ab->product_type }}</td>
                                            <td>{{ $ab->network }}</td>
                                        </tr>
                                        <?php }
                                        }?>

                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        @endif

            @if(isset($missing_uploads))
                <div class="col-md-6 mb-3">
                    <div class="card text-left">
                        <div class="card-body">
                            <h4>Missing  Upload SIMs List</h4>
                            <div class="table-responsive">

                                <table class="table" id="datatable1" style="width: 100%">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">Account Number</th>
                                        <th scope="col">Party ID</th>
                                        <th scope="col">Product Type</th>
                                        <th scope="col">Network</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($missing_uploads as $ab)

                                            <tr>
                                                <td>{{ $ab->account_number }}</td>
                                                <td>{{ $ab->party_id }}</td>
                                                <td>{{ $ab->product_type }}</td>
                                                <td>{{ $ab->network }}</td>
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
        $(document).ready(function() {
            $("#titles").hide();
            $(".sam").hide();
        });
        $('#company_ids').change(function() {
            // alert('asdf')


        });

    </script>


    @if(isset($gamer_exist))
        <script>
            $(document).ready(function() {


                var style_party = "<?php echo isset($counter_party); ?>";
                var style_product = "<?php echo isset($counter_product); ?>";
                var style_network = "<?php echo isset($counter_network) ; ?>";

                // alert(style_name)



                if (style_party>=1){
                    $("#party_head").css("background", "#ef0000");
                }


                if (style_product>=1){
                    $("#product_head").css("background", "#ef0000");
                }



                if (style_network>=1){
                    $("#network_head").css("background", "#ef0000");
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
