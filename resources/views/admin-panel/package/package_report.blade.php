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
.card.mb-4.step-cards {
max-height: 100px;
border: 1px solid gainsboro;
}
.heading-card {
    white-space: nowrap;
    text-align: center;
}
.bg-primary-gradient {
    background-image: linear-gradient(to left, #0db2de 0%, #005bea 100%) !important;
}
.bg-primary-gradient2 {
    background-image: linear-gradient(45deg, #f93a5a, #f7778c) !important;
}
.bg-primary-gradient3 {
    background-image: linear-gradient(to left, #48d6a8 0%, #029666 100%) !important;
}
.bg-primary-gradient4 {
    background-image: linear-gradient(to left, #efa65f, #f76a2d) !important;
}
.bg-primary-gradient5 {
    background-image: linear-gradient(to left, #1b2022 0%, #005bea 100%) !important;
}
.bg-primary-gradient6 {
    background-image: linear-gradient(to left, #8b0000 0%, #350003 100%) !important;
}
    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Package</a></li>
            <li>Package Report</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row">


        <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="card bg-primary-gradient  o-hidden mb-4">
                <div class="card-body text-center">
                    <div class="content">
                        <p class="text-white font-weight-bold text-16 mt-2 mb-0 heading-card">Active Packages</p>
                        <p class="text-white font-weight-bold text-24 line-height-1 mb-2">{{count($active_packages)}}</p>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="card bg-primary-gradient2  o-hidden mb-4">
                <div class="card-body text-center">
                    <div class="content">
                        <p class="text-white font-weight-bold text-16 mt-2 mb-0 heading-card">Deactive Packages</p>
                        <p class="text-white font-weight-bold text-24 line-height-1 mb-2">{{count($deactive_packages)}}</p>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-lg-4 col-md-6 col-sm-6">
            <div class="card bg-primary-gradient3  o-hidden mb-4">
                <div class="card-body text-center">
                    <div class="content">
                        <p class="text-white font-weight-bold text-16 mt-2 mb-0 heading-card">All Packages</p>
                        <p class="text-white font-weight-bold text-24 line-height-1 mb-2">{{count($packages)}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="row">
        @foreach($active_packages as $res)
        <div class="col-lg-2 col-md-12 mb-4">
            <div class="p-4 rounded d-flex align-items-center bg-primary text-white"><i class="i-Gift-Box text-32 mr-3"></i>
                <div>
                    <h4 class="text-18 mb-1 text-white"><strong style="color: #f87388">In</strong> {{$res->package_name}}</h4><span>Total: {{count($package_assign->where('package_id',$res->id))}}</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="card text-left">
                <div class="card-body">
                    <h4 class="card-title mb-2">List Packages in Each Platform </h4>

                    <ul class="list-group">
                        <div class="row">
                            <p style="display: none">
                        {{$count=1}}
                    </p>
                        @foreach ($platform as $res )

                        <?php
                         $value=$count;

                         ?>
                            <div class="col-md-2">
                        <li class="list-group-item d-flex justify-content-between align-items-center">{{$res['name']}}
                            <span @if($value % 2) class="badge badge-primary badge-pill"

                            @else class="badge badge-danger badge-pill" @endif>
                                {{$res['count']}}</span>
                            </li>
                        </div>
                        <?php $count=$count+1 ;?>

                        @endforeach
                    </div>


                    </ul>
                </div>
            </div>
        </div>
    </div>
<hr>
    <div class="row">

        <div class="col-md-6">


        <h5> <span class="badge badge-pill badge-outline-success p-2 m-1"> Active Packages</span></h5>

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
                <th scope="col">Files</th>
                <th scope="col">No Of Rider</th>


            </tr>
            </thead>
            <tbody>
            @foreach($active_packages as $res)
                <tr>
                    <td><a class="badge badge-success" href="#">{{isset($res->package_no)?$res->package_no:""}}</a></td>
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
                            <i class="text-20 i-Download"></i>
                        </a>
                            <span>|</span>
                        @endforeach
                        @else
                        N/A
                        @endif
                    </td>

                    <td><span class="badge badge-round-secondary">{{count($package_assign->where('package_id',$res->id))}}</span></td>


                </tr>
            @endforeach


            </tbody>
        </table>

    </div>

    <div class="col-md-6">
        <h5> <span class="badge badge-pill badge-outline-danger p-2 m-1">Deactive  Packages</span></h5>
        <table class="table" id="datatable2" style="width: 100%">
            <thead>
            <tr>
                <th scope="col">Package No</th>
                <th scope="col">Package Name</th>
                <th scope="col">Platform</th>
                <th scope="col">State</th>
                <th scope="col">Salary Package</th>
                <th scope="col">Limitation</th>
                <th scope="col">Qty</th>
                <th scope="col">Files</th>
                <th scope="col">No Of Rider</th>
            </tr>
            </thead>
            <tbody>
            @foreach($deactive_packages as $res)
                <tr>
                    <td><a class="badge badge-danger" href="#">{{isset($res->package_no)?$res->package_no:""}}</a></td>
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
                            <i class="text-20 i-Download"></i>
                        </a>
                            <span>|</span>
                        @endforeach
                        @else
                        N/A
                        @endif

                    </td>
                    <td><span class="badge badge-round-secondary">{{count($package_assign->where('package_id',$res->id))}}</span></td>


                </tr>
            @endforeach


            </tbody>
        </table>
    </div>


    <hr>

    <div class="col-md-6 mt-5">
        <h5> <span class="badge badge-pill badge-outline-primary p-2 m-1"> All Packages</span></h5>
        <table class="table" id="datatable3" style="width: 100%">
            <thead>
            <tr>
                <th scope="col">Package No</th>
                <th scope="col">Package Name</th>
                <th scope="col">Platform</th>
                <th scope="col">State</th>
                <th scope="col">Salary Package</th>
                <th scope="col">Limitation</th>
                <th scope="col">Qty</th>
                <th scope="col">Files</th>
                <th scope="col">No of Riders</th>

            </tr>
            </thead>
            <tbody>
            @foreach($packages as $res)
                <tr>
                    <td><a class="badge badge-primary" href="#">{{isset($res->package_no)?$res->package_no:""}}</a></td>
                    <td>{{isset($res->package_name)?$res->package_name:""}}</td>
                    <td>{{$res->state_detail->name}}</td>
                    <td>{{$res->platform_detail->name}}</td>
                    <td>{{ isset($res->salary_package)?$res->salary_package:""}}</td>
                    <td>
                        @if(isset($res->limitation) && $res->limitation=='0')
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
                            <i class="text-20 i-Download"></i>
                        </a>
                            <span>|</span>
                        @endforeach
                        @else
                        N/A
                        @endif

                    </td>
                    <td><span class="badge badge-round-secondary">{{count($package_assign->where('package_id',$res->id))}}</span></td>

                </tr>
            @endforeach


            </tbody>
        </table>
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

                "scrollY": true,
                "scrollX": true,
            });
        });


        $(document).ready(function () {
            'use strict';
            $('#datatable2').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,

                "scrollY": true,
                "scrollX": true,
            });
        });


        $(document).ready(function () {
            'use strict';
            $('#datatable3').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,

                "scrollY": true,
                "scrollX": true,
            });
        });


        $(document).ready(function () {
            'use strict';
            $('#datatable4').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,

                "scrollY": true,
                "scrollX": true,
            });
        });

        $(document).ready(function () {
            'use strict';
            $('#datatable5').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,

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
                else if(split_ab=="zds-basic-tab"){
                    var table = $('#datatable5').DataTable();
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
    if(Session::has('message')){
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
    }
</script>



@endsection
