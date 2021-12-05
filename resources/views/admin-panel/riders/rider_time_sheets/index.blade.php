@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <style>

         /* loading image css starts */
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
        /* loading image css ends */

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
    </style>
@endsection
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/user-dashboard-new') }}">All Modules</a></li>
            <li class="breadcrumb-item"><a href="{{ route('dc_wise_dashboard',['active'=>'operations-menu-items']) }}">DC Operations</a></li>
            <li class="breadcrumb-item active" aria-current="page">Talabat Rider Time Sheet</li>
        </ol>
    </nav>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row pb-2" >
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="row ticket-row">
                               <div class="col-md-2">
                                  <div class="card card-icon ticket-card">
                                     <div class="card-body text-center bg-info" style="display: grid;grid-template-columns: auto auto auto;align-items: center; padding:10px 0">
                                        <i class="text-white i-Cool-Guy"></i>
                                        <p class="text-white m-0" id="total_rider">0</p>
                                        <p class="text-white mt-2 mb-2">Riders</p>
                                     </div>
                                  </div>
                               </div>
                               <div class="col-md-2">
                                  <div class="card card-icon ticket-card">
                                     <div class="card-body text-center bg-success" style="display: grid;grid-template-columns: auto auto auto;align-items: center; padding:10px 0">
                                        <i class="text-white i-Gift-Box"></i>
                                        <p class="text-white m-0" id="orders">0</p>
                                        <p class="text-white mt-2 mb-2">Orders</p>
                                     </div>
                                  </div>
                               </div>
                               <div class="col-md-2">
                                  <div class="card card-icon ticket-card">
                                     <div class="card-body text-center bg-danger" style="display: grid;grid-template-columns: auto auto auto;align-items: center; padding:10px 0">
                                        <i class="text-white i-Gift-Box"></i>
                                        <p class="text-white m-0" id="deliveries">0</p>
                                        <p class="text-white mt-2 mb-2">Deliveries</p>
                                     </div>
                                  </div>
                               </div>
                               <div class="col-md-2">
                                  <div class="card card-icon ticket-card">
                                     <div class="card-body text-center bg-info" style="display: grid;grid-template-columns: auto auto auto;align-items: center; padding:10px 0">
                                        <i class="text-white i-Ticket"></i>
                                        <p class="text-white m-0" id="distance">0</p>
                                        <p class="text-white mt-2 mb-2">Distance</p>
                                     </div>
                                  </div>
                               </div>
                               <div class="col-md-2">
                                  <div class="card card-icon ticket-card">
                                     <div class="card-body text-center bg-primary" style="display: grid;grid-template-columns: auto auto auto;align-items: center; padding:10px 0">
                                        <i class="text-white i-Ticket"></i>
                                        <p class="text-white m-0 " id="total_delivery_pay">0</p>
                                        <p class="text-white mt-2 mb-2">Total Delivery Pay</p>
                                     </div>
                                  </div>
                               </div>

                               <div class="col-md-2">
                                  <div class="card card-icon ticket-card">
                                     <div class="card-body text-center bg-info" style="display: grid;grid-template-columns: auto auto auto;align-items: center; padding:10px 0">
                                        <div class="col-md-2" id="download_files_holder">
                                            <div class="dropdown dropleft text-right w-50 float-right">
                                                <button class="btn btn-link text-white"
                                                    id="dropdownMenuButton1"
                                                    type="button"
                                                    data-toggle="dropdown"
                                                    aria-haspopup="true"
                                                    aria-expanded="false"
                                                    ><i class="nav-icon i-Download"></i>
                                                </button>
                                                <div class="dropdown-menu"
                                                    aria-labelledby="dropdownMenuButton1"
                                                    x-placement="left-start"
                                                    style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(241px, 0px, 0px);">
                                                    <a class="dropdown-item" href="#">No file Available</a>
                                                </div>
                                            </div>
                                       </div>
                                        <p class="text-white mt-2 mb-2">
                                            <a href="#" id="download_btn" target="_blank" class="text-white download_link">Orignal Files</a>
                                        </p>
                                        <p class="text-white m-0"></p>
                                     </div>
                                  </div>
                               </div>
                            </div>
                        </div>
                        <hr class="m-1">
                        <div class="col-12">
                            <div class="form-group col-3 offset-1 float-left">
                                <label for="start_date">Start Date</label>
                                <input name="start_date" id="start_date" class="form-control form-control-sm" type="text"
                                value="{{ $last_time_sheet !== null ? date('Y-m-d', strtotime($last_time_sheet->start_date)) : '' }}"/>
                            </div>
                            <div class="form-group col-3 float-left">
                                <label for="end_date">End Date</label>
                                <input name="end_date" id="end_date" class="form-control form-control-sm" type="text"
                                value="{{ $last_time_sheet !== null ? date('Y-m-d', strtotime($last_time_sheet->end_date)) : '' }}"/>
                            </div>
                            <div class="form-group col-3 float-left">
                                <label for="dc_id">Filter By DC</label>
                                <select name="dc_id" id="dc_id" class="form-control form-control-sm select2">
                                    <option value=""></option>
                                    @if(!auth()->user()->hasRole(['DC_roll']))
                                    <option value="all">All</option>
                                    @endif
                                    @foreach ($dc_users as $user)
                                        <option {{ $dc_users->count() == 1 ? "selected" : ""}} value="{{ $user->id }}">{{ ucFirst($user->name ?? "") }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-1 float-left">
                                <label for=""></label><br><br>
                                <button class="btn btn-info btn-sm" id="show_time_sheet_btn">Search</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body" id="talabat_rider_time_sheet_holder"></div>
            </div>
        </div>
    </div>
    <div class="overlay"></div>
@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
    <script>
         tail.DateTime("#end_date",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,
        })
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
    <script>
        $(document).ready(function(){
            $('#show_time_sheet_btn').on('click',function(){
                $("body").addClass("loading");
                var start_date = $('#start_date').val()
                var end_date = $('#end_date').val()
                var dc_id = $('#dc_id').val() == 'all' ? '' : $('#dc_id').val();
                $.ajax({
                    url: "{{ route('talabat_rider_time_sheet_view') }}",
                    data: { dc_id , start_date, end_date},
                    success: function(response){
                        $('#talabat_rider_time_sheet_holder').empty();
                        $('#talabat_rider_time_sheet_holder').append(response.html);
                        $('#download_files_holder').empty()
                        $('#download_files_holder').append(response.file_path_dropdowns)
                        $('#total_rider').text(response.rider_count)
                        $('#orders').text(response.orders)
                        $('#deliveries').text(response.deliveries)
                        $('#distance').text(response.distance)
                        $('#total_delivery_pay').text(response.total_delivery_pay)
                        $("body").removeClass("loading");
                    }
                });
            });
        });
    </script>
    <script>
        $('#start_date').change(function(){
            $('#end_date').val('');
        });
        $('#dc_id, #end_date').change(function(){
            if($('#end_date').val() != ''){
                $('#show_time_sheet_btn').click();
            }
        });
        setTimeout(function(){
            if($('#start_date').val() != '' && $('#end_date').val() != ''){
                $('#show_time_sheet_btn').click();
            }
        }, 500);
    </script>
    <script>
        $('#dc_id').select2({
            'placeholder' : "Select Dc to filter"
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
