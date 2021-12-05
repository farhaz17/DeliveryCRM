@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
@endsection
@section('content')
    <style>
        div.dataTables_wrapper div.dataTables_processing {

            position: fixed;
            top: 50%;
            -ms-transform: translateY(-50%);
            transform: translateY(-50%);
            /*top: 50%;*/
        }
    </style>




    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Users</a></li>
            <li>Manage Rider</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>




    <div class="col-md-12 mb-3">
        <div class="card text-left">
            <div class="card-body">

                {{--accordian start--}}
                <div class="accordion" id="accordionRightIcon" style="margin-bottom: 10px;">
                    <div class="card">
                        <div class="card-header header-elements-inline">
                            <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0 "><a class="text-default collapsed collapse_cls_pending" data-toggle="collapse" href="#accordion-item-icons-1" aria-expanded="false"><span><i class="i-Filter-2 ul-accordion__font"> </i></span>Filter</a></h6>
                        </div>
                        <div class="collapse" id="accordion-item-icons-1" data-parent="#accordionRightIcon">
                            <div class="card-body">

                                <div class="col-md-3 form-group mb-3 " style="float: left;"  >
                                    <label for="start_date">Start Date</label>
                                    <input type="text" name="start_date"  autocomplete="off" class="form-control form-control-rounded" id="start_date">

                                </div>

                                <div class="col-md-3 form-group mb-3 "  style="float: left;"  >
                                    <label for="end_date">End Date</label>
                                    <input type="text" name="end_date" autocomplete="off"  class="form-control form-control-rounded" id="end_date">
                                </div>




                                <input type="hidden" name="table_name" id="table_name" value="datatable" >

                                <div class="col-md-3 form-group mb-3 "  style="float: left; margin-top: 20px;"  >
                                    <label for="end_date" style="visibility: hidden;">End Date</label>
                                    <button class="btn btn-info btn-icon m-1" id="apply_filter" data="datatable"  type="button"><span class="ul-btn__icon"><i class="i-Magnifi-Glass1"></i></span></button>
                                    <button class="btn btn-danger btn-icon m-1" id="remove_apply_filter" data="datatable"  type="button"><span class="ul-btn__icon"><i class="i-Close"></i></span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- accordian end here--}}

                <div class="table-responsive">
                    <table class="table" id="datatable">
                        <thead class="thead-dark">
                        <tr>

                            <th scope="col">Rider Name</th>
                            <th scope="col">Date</th>
                            <th scope="col">Time</th>
                            <th scope="col">Slip Number</th>
                            <th scope="col">Machine Number</th>
                            <th scope="col">Location At Machine</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Status</th>
                            <th scope="col">picture</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>


    <script>
        tail.DateTime("#start_date",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,

        }).on("change", function(){
            tail.DateTime("#end_date",{
                dateStart: $('#start_date').val(),
                dateFormat: "YYYY-mm-dd",
                timeFormat: false

            }).reload();

        });
    </script>

    <script type="text/javascript">
        function load_data(from_date= '', end_date= ''){

            var table = $('#datatable').DataTable({
                "aaSorting": [[0, 'desc']],
                "language": {
                    processing: "<img id='loader' src='{{ asset('assets/images/pre-load.gif') }}'>",
                },


                "pageLength": 10,
                "columnDefs": [
                    // {"targets": [0],"visible": false},
                    {"targets": [0][1],"width": "30%"}
                ],
                "scrollY": false,
                "processing": true,
                "serverSide": true,

                ajax:{
                  url : "{{ route('bank_paid_detail',Request::segment(2)) }}",
                  data:{from_date:from_date, end_date:end_date},
                },

                "deferRender": true,
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'date', name: 'date'},
                    {data: 'time', name: 'time'},
                    {data: 'slip_number', name: 'slip_number'},
                    {data: 'machine_number', name: 'machine_number'},
                    {data: 'location_at_machine', name: 'location_at_machine'},
                    {data: 'amount', name: 'amount'},
                    {data: 'status', name: 'status'},
                    {data: 'picture', name: 'picture' , orderable: false, searchable: false},

                ]
            });

        }
    </script>


    <script>
        $(document).ready(function () {
            load_data();

            $("#apply_filter").click(function(){

                var start_date  =   $("#start_date").val();
                var end_date  =   $("#end_date").val();

                if(start_date != '' &&  end_date != '')
                {
                    $('#datatable').DataTable().destroy();
                    load_data(start_date, end_date);
                }
                else
                {
                    tostr_display("error","Both date is required");
                }

            });

            $('#remove_apply_filter').click(function(){
                $('#start_date').val('');
                $('#end_date').val('');
                $('#datatable').DataTable().destroy();
                load_data();
            });


        });

        function deleteData(id)
        {
            var id = id;
            var url = '{{ route('rider_profile.destroy', ":id") }}';
            url = url.replace(':id', id);
            $("#deleteForm").attr('action', url);
        }

        function deleteSubmit()
        {
            $("#deleteForm").submit();
        }

        function resetPassportFile() {
            $('#passport-change').hide();
            $('.passport-div').show();
        }
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

    <script>
        function tostr_display(type,message){
            switch(type){
                case 'info':
                    toastr.info(message);
                    break;
                case 'warning':
                    toastr.warning(message);
                    break;
                case 'success':
                    toastr.success(message);
                    break;
                case 'error':
                    toastr.error(message);
                    break;
            }

        }
    </script>

@endsection
