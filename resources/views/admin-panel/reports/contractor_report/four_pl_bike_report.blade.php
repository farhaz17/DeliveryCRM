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
        #datatable2 .table th, .table td{
            border-top : unset !important;
        }
        #datatable .table th, .table td{
            border-top : unset !important;
        }
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
            font-weight: 600;
        }
        a.btn.btn-primary.btn-sm.mr-2 {
            /* height: 21px; */
            padding: 1px;
        }
    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Report</a></li>
            <li>4 Pl Contractor Report</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>







    <!--------Passport Additional Information--------->


    <div class="card col-lg-10 offset-lg-1 mb-2">


        <table class="table table-striped" id="datatable"  style="width: 100%">
            <thead class="thead-dark">
            <tr>
                <th scope="col" style="width: 100px">Bike Assigned To 4PL</th>
                <th scope="col" style="width: 100px">Company Name</th>
                <th scope="col" style="width: 100px">Passport No</th>
                <th scope="col" style="width: 100px">PPUID</th>
                <th scope="col" style="width: 100px">ZDS Code</th>

                <th scope="col" style="width: 100px">Action</th>


            </tr>
            </thead>
            <tbody>
            @foreach($agreement as $row)
                @if(isset($row->passport->bike_checkin()->bike_plate_number->plate_no))
                <tr>

                    <td>
                        {{isset($row->passport->bike_checkin()->bike_plate_number->plate_no)?
                        ($row->passport->bike_checkin()->bike_plate_number->plate_no) : 'N/A'}}
                    </td>
                    <td> {{$row->fourpl_contractor->name}}</td>
                    <td> {{isset($row->passport)?$row->passport->passport_no:"N/A"}}</td>
                    <td> {{isset($row->passport)?$row->passport->pp_uid:"N/A"}}</td>
                    <td> {{isset($row->passport)?$row->passport->zds_code->zds_code:"N/A"}}</td>
{{--                    <td>{{isset($row->passport->sim_checkin()->telecome->account_number) ? ($row->passport->sim_checkin()->telecome->account_number) : 'N/A'}}</td>--}}
{{--                    --}}{{--------------------------------------------------------------------------------------}}

                    <td>
                        <a class="btn btn-primary btn-sm mr-2 pass_btn_cls-1" id="{{$row->passport->bike_checkin()->bike_plate_number->id}}" href="javascript:void(0)">
                            View Detail
                        </a>


                    </td>

                </tr>
                @endif
            @endforeach


            </tbody>
        </table>


    </div>



    {{--    //modal--}}

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Assigning Detail</h5>
                    <button class="close" id="close-btn" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div id="assign_detail"></div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">No</button>

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
        $(".pass_btn_cls-1").click(function(){
            var id = $(this).attr('id');
            var token = $("input[name='_token']").val();
            // alert(id)

            $.ajax({
                url: "{{ route('contractor_bike_report_show') }}",
                method: 'POST',
                dataType: 'json',
                data:{id:id,_token:token},
                success: function (response) {
                    $('#assign_detail').empty();
                    $('#assign_detail').append(response.html);
                    $('#exampleModal').modal('show');
                    var table = $('#datatable_bike').DataTable({
                        paging: true,
                        info: true,
                        searching: true,
                        autoWidth: true,
                        retrieve: true
                    });
                    table.columns.adjust().draw();


                }
            });


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
                    'pageLength'

                ],
                "scrollY": true,
                "scrollX": true,

            });
        });
    </script>






    <script>
        @if(Session::has('message'))
        var type = "{{ Session::get('alert-type', 'info') }}";
        switch(type){
            case 'info':
                toastr.info("{{ Session::get('message') }}");
                break;

            case 'warning':
                toastr.warning("{{ Session::get('message') }}");
                break;

            case 'success':
                toastr.success("{{ Session::get('message') }}");
                break;

            case 'error':
                toastr.error("{{ Session::get('message') }}");
                break;
        }
        @endif
    </script>



@endsection
