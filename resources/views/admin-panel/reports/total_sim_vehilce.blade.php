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
    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Report</a></li>
            <li>Total Current Vehilce</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>







    <!--------Passport Additional Information--------->


    <div class="col-md-12 mb-3">
        <div class="card text-left">
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item"><a class="nav-link active" id="home-basic-tab" data-toggle="tab" href="#homeBasic" role="tab" aria-controls="homeBasic" aria-selected="true">Total Current SIMS</a></li>
                    <li class="nav-item"><a class="nav-link" id="profile-basic-tab" data-toggle="tab" href="#profileBasic" role="tab" aria-controls="profileBasic" aria-selected="false">Total SIMs in Use</a></li>
                    <li class="nav-item"><a class="nav-link" id="zds-basic-tab" data-toggle="tab" href="#zdsBasic" role="tab" aria-controls="zdsBasic" aria-selected="false">Free SIMs</a></li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="homeBasic" role="tabpanel" aria-labelledby="home-basic-tab">
                        <table class="table" id="datatable" style="width: 100%">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Account Number</th>
                                <th scope="col">Party ID</th>
                                <th scope="col">Product Type</th>
                                <th scope="col">Network</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($total_current_sim as $row)
                                <tr>
                                    <td>{{$row->id}}</td>
                                    <td>{{$row->account_number}}</td>
                                    <td>{{$row->party_id}}</td>
                                    <td>{{$row->product_type}}</td>
                                    <td>{{$row->network}}</td>
                                </tr>
                            @endforeach


                            </tbody>
                        </table>

                    </div>

                    {{--tab2--}}
                    <div class="tab-pane fade show" id="profileBasic" role="tabpanel" aria-labelledby="profile-basic-tab">

                        <table class="table" id="datatable2"  style="width: 100%">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">Passport Number</th>
                                <th scope="col">PPUID</th>
                                <th scope="col">ZDS Code</th>
                                <th scope="col">Name</th>
                                <th scope="col">SIM</th>
                                <th scope="col">Assigned To</th>
                                <th scope="col">Platform</th>
                                <th scope="col">Checkin</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($total_in_use as $row)
                                <tr>
                                    <td>{{$row->passport->passport_no}}</td>
                                    <td>{{$row->passport->pp_uid}}</td>
                                    <td>{{ isset($row->passport->zds_code->zds_code)?$row->passport->zds_code->zds_code:""}}</td>
                                    <td>{{$row->passport->personal_info->full_name}}</td>
                                    <td>{{$row->telecome->account_number}}</td>
                                    <td>{{isset($row->assign_to)? $row->assign_to->name:""}}</td>
                                    <?php  $platform = $row->plateform->where('status','=','1')->first(); ?>
                                    <td>{{isset($platform->plateformdetail->name)? $platform->plateformdetail->name:""}}</td>
                                    <td>{{$row->checkin}}</td>

                                </tr>
                            @endforeach


                            </tbody>
                        </table>
                    </div>
                    {{--                    tab3--}}
                    <div class="tab-pane fade show" id="zdsBasic" role="tabpanel" aria-labelledby="zds-basic-tab">

                        <table class="table" id="datatable3" style="width: 100%">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Account Number</th>
                                <th scope="col">Party ID</th>
                                <th scope="col">Product Type</th>
                                <th scope="col">Network</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($free_sims as $res_bike)
                                <tr>
                                    <td>{{isset($res_bike->id)?$res_bike->id:""}}</td>
                                    <td>{{isset($res_bike->account_number)?$res_bike->account_number:""}}</td>
                                    <td>{{isset($res_bike->party_id)?$res_bike->party_id:""}}</td>
                                    <td>{{ isset($res_bike->product_type)?$res_bike->product_type:""}}</td>
                                    <td>{{ isset($res_bike->network)?$res_bike->network:""}}</td>

                                </tr>
                            @endforeach


                            </tbody>
                        </table>
                    </div>












                </div>
            </div>
        </div>
    </div>


{{--    <td>{{isset($res_bike["id"])?$res_bike["id"]:""}}</td>--}}
{{--    <td>{{isset($res_bike["sim_number"])?$res_bike["sim_number"]:""}}</td>--}}
{{--    <td>{{isset($res_bike["party_id"])?$res_bike["party_id"]:""}}</td>--}}
{{--    <td>{{ isset($res_bike["product_type"])?$res_bike["product_type"]:""}}</td>--}}
{{--    <td>{{ isset($res_bike["network"])?$res_bike["network"]:""}}</td>--}}


@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            'use strict';
            $('#datatable,#datatable2,#datatable3,#datatable4,#datatable5').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'SIMs Report',
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
        $(document).ready(function () {
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                var currentTab = $(e.target).attr('id'); // get current tab

                var split_ab = currentTab;
                // alert(split_ab[1]);

                if(split_ab=="home-basic-tab"){

                    var table = $('#datatable').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();

                }

                else if(split_ab=="profile-basic-tab"){
                    var table = $('#datatable2').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();

                }

                else{
                    var table = $('#datatable3').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw()

                }


            }) ;
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
