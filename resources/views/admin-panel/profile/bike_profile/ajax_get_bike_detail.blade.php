<style>
    .text-css {
        color: #000000;
        white-space: nowrap;
        font-size: 16px;
        font-weight: bold;
    }
    .text-css2 {
        color: #000000;

        font-size: 16px;
        font-weight: bold;
    }
    #datatable .table th, .table td{
        border-top : unset !important;
    }
    .table th, .table td{
        padding: 0px !important;
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
    .card-des{
        border: 1px solid #a9a1a1;
        border-radius: 8px;
    }
</style>
<div class="row">
    <div class="col-md-3">
        <div class="card mb-4">
            <div class="card-body card-des" id="bike-btn">
                <h6 class="mb-3">Bike Information</h6>
                <p class="text-20  line-height-1 mb-3 text-css"><i class="i-Motorcycle bg-primary text-white"></i> {{$BikeDetail->plate_no}}</p>

            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card mb-4">
            <div class="card-body card-des" id="checkin-btn">
                <h6 class="mb-3">Check-in/Check-out Details</h6>
                <p class="text-15 text-css line-height-1 mb-3 v"><i class="i-Bar-Code bg-success text-white"></i>
                    {{isset($assined_to->passport->personal_info->full_name)?$assined_to->passport->personal_info->full_name:'N/A'}}
                </p>

            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card mb-4">
            <div class="card-body card-des" id="fine-btn">
                <h6 class="mb-3">Fine</h6>
                <p class="text-20  line-height-1 mb-3 text-css"><i class="i-Letter-Close bg-danger text-white"></i> Fines</p>

            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card mb-4">
            <div class="card-body card-des" id="salik-btn">
                <h6 class="mb-3">Salik</h6>
                <p class="text-20  line-height-1 mb-3 text-css"><i class="i-Calendar-4 bg-warning text-white"></i> Salik</p>

            </div>
        </div>
    </div>
</div>



<!--------------modal-1------->

<!-- {{--//---------Referral modal---------}} -->
<div class="modal fade refferal_modal" id="assign_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Checkin/Checkout Details</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="primary_id" name="id" value="">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="ul-widget-app__browser-list">
                                <div class="ul-widget-app__browser-list-1 mb-4">
                                    <i class="i-Motorcycle text-white bg-primary rounded-circle p-2 mr-3 ml-4"></i>
                                    <span class="text-15">Assinged To:</span>
                                    <span class="text-12 font-weight-bold ml-1" >
                                        {{isset($assined_to->passport->personal_info->full_name)?$assined_to->passport->personal_info->full_name:'N/A'}}
                                    </span>
                                    <span>&nbsp;</span>

                                    <i class="i-Calendar-2 text-white bg-success rounded-circle p-2 mr-3 ml-4"></i>
                                    <span class="text-15">Checked In:</span>
                                    <span class="text-12 font-weight-bold  ml-1" >
                                        {{isset($assined_to->checkin)?$assined_to->checkin:"N/A"}}
                                    </span>
                                </div>
                               </div>
                           </div>

                       </div>



                            <table class="display table table-striped table-bordered" id="datatable-ref">
                                <thead class="thead-dark">
                                <tr>
                                    <th>Previously Assigned To</th>
                                    <th>Check-in Date</th>
                                    <th>Check-out Date</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($assgin_bike->where('status',0) as $row)
                                    <tr>
                                        <td>{{$row->passport->personal_info->full_name}}</td>
                                        <td>{{$row->checkin}}</td>
                                        <td>{{isset($row->checkout)?$row->checkout:"N/A"}}</td>


                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- {{--------------modal-1 ends here-------}} -->





<!-- !--------------modal-2------->

<div class="modal fade bike_modal" id="bike_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Bike Details</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="primary_id" name="id" value="">
                <div class="row">
                    <div class="col-md-12">


                    <div class="col-lg-12 col-md-4 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-title">Bike Details</div>
                                    <div class="ul-widget-app__browser-list">
                                        <div class="ul-widget-app__browser-list-1 mb-4">
                                            <i class="i-Motorcycle text-white bg-warning rounded-circle p-2 mr-3"></i>
                                            <span class="text-15">Bike Number</span>
                                            <span class="text-15 font-weight-bold" >{{$BikeDetail->plate_no}}</span></div>
                                         <div class="ul-widget-app__browser-list-1 mb-4">
                                            <i class="i-Bar-Code text-white green-500 rounded-circle p-2 mr-3"></i>
                                            <span class="text-15">Chessis Number</span>
                                            <span class="text-15 font-weight-bold">{{$BikeDetail->chassis_no}}</span></div>
                                        <div class="ul-widget-app__browser-list-1 mb-4">
                                            <i class="i-Shop text-white cyan-500 rounded-circle p-2 mr-3"></i>
                                            <span class="text-15">Insurance Company</span>
                                            <span class="text-15 font-weight-bold">{{$BikeDetail->insurance_co}} </span></div>
                                        <div class="ul-widget-app__browser-list-1 mb-4">
                                            <i class="i-Add-UserStar text-white teal-500 rounded-circle p-2 mr-3"></i>
                                            <span class="text-15">Modal </span>
                                            <span class="text-15 font-weight-bold">{{$BikeDetail->model}} </span>
                                        </div>
                                        <div class="ul-widget-app__browser-list-1 mb-4">
                                            <i class="i-Calendar-2 text-white purple-500 rounded-circle p-2 mr-3"></i>
                                            <span class="text-15">Make Year </span>
                                            <span class="text-15 font-weight-bold">{{$BikeDetail->make_year}}</span></div>
                                        <div class="ul-widget-app__browser-list-1 mb-4">
                                            <i class="i-Calendar-2 text-white bg-danger rounded-circle p-2 mr-3"></i>
                                            <span class="text-15">Issue Date</span>
                                            <span class="text-15 font-weight-bold">{{$BikeDetail->issue_date}}</span></div>
                                        <div class="ul-widget-app__browser-list-1 mb-4">
                                            <i class="i-Calendar-3 text-white green-500 rounded-circle p-2 mr-3"></i>
                                            <span class="text-15">Expiry Date</span>
                                            <span class="text-15 font-weight-bold">{{$BikeDetail->expiry_date}}</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- <div class="row">
                            <table class="display table table-striped table-bordered" id="datatable-bike">
                                <thead class="thead-dark">
                                <tr>
                                    <th>Assigned To</th>
                                    <th>Check-in Date</th>
                                    <th>Check-out Date</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($assgin_bike as $row)
                                    <tr>
                                        <td>{{$row->passport->personal_info->full_name}}</td>
                                        <td>{{$row->checkin}}</td>
                                        <td>{{isset($row->checkout)?$row->checkout:"N/A"}}</td>


                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                        </div> -->
                    </div>






                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
{{--<!--------------modal-2 ends here------->--}}



<!-- !--------------modal-3------->

<div class="modal fade fine_modal" id="fine_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Bike Details</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="primary_id" name="id" value="">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <table class="display table table-striped table-bordered" id="datatable-fine">
                                <thead class="thead-dark">
                                <tr>
                                    <th>Fine Upload Traffic Code  Id</th>
                                    <th>Ticket Number</th>
                                    <th>Ticket Date</th>
                                    <th>Ticket Time</th>
                                    <th>Fines Source</th>
                                    <th>Ticket Fee</th>
                                    <th>Offense</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($fine as $row)
                                    <tr>
                                        <td>{{isset($row->fine_upload_traffic_code_id)?$row->fine_upload_traffic_code_id:"N/A"}}</td>
                                        <td>{{isset($row->ticket_number)?$row->ticket_number:"N/A"}}</td>
                                        <td>{{isset($row->ticket_date)?$row->ticket_date:"N/A"}}</td>
                                        <td>{{isset($row->ticket_time)?$row->ticket_time:"N/A"}}</td>
                                        <td>{{isset($row->fines_source)?$row->fines_source:"N/A"}}</td>
                                        <td>{{isset($row->ticket_fee)?$row->ticket_fee:"N/A"}}</td>
                                        <td>{{isset($row->offense)?$row->offense:"N/A"}}</td>


                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!--------------modal-3 ends here------->



<!-- !--------------modal-4------->

<div class="modal fade fine_modal" id="salik_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Bike Details</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="primary_id" name="id" value="">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <table class="display table table-striped table-bordered" id="datatable-salik">
                                <thead class="thead-dark">
                                <tr>
                                    <th>Trip  Date</th>
                                    <th>Trip Time</th>
                                    <th>Transaction Post Date</th>
                                    <th>Toll Gate</th>
                                    <th>Direction</th>
                                    <th>Tag Number</th>
                                    <th>Plate</th>
                                    <th>Amount</th>
                                    <th>Account Number</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($salik as $row)
                                    <tr>
                                        <td>{{$row->trip_date}}</td>
                                        <td>{{$row->trip_time}}</td>
                                        <td>{{$row->transaction_post_date}}</td>
                                        <td>{{$row->toll_gate}}</td>
                                        <td>{{$row->direction}}</td>
                                        <td>{{$row->tag_number}}</td>
                                        <td>{{$row->plate}}</td>
                                        <td>{{$row->amount}}</td>
                                        <td>{{$row->account_number}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!--------------modal-3 ends here------->






<script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
<script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>


<!-- first script -->


<script>
    $('#checkin-btn').on('click',function() {
        $('#assign_modal').modal('show');
        var table = $('#datatable-ref').DataTable({
            paging: true,
            info: true,
            autoWidth: false,
            retrieve: true
        });
        table.columns.adjust().draw();
    });
</script>
<!-- first script ends-->

<!-- 2nd script -->

<script>
    $('#bike-btn').on('click',function() {
        $('#bike_modal').modal('show');
        var table = $('#datatable-bike').DataTable({
            paging: true,
            info: true,
            autoWidth: false,
            retrieve: true
        });
        table.columns.adjust().draw();
    });
</script>
<!-- 2nd script ends here -->


<!-- 3rd script -->

<script>
    $('#fine-btn').on('click',function() {
        $('#fine_modal').modal('show');
        var table = $('#datatable-fine').DataTable({
            paging: true,
            info: true,
            autoWidth: false,
            retrieve: true
        });
        table.columns.adjust().draw();
    });
</script>
<!-- 3rd script ends here -->




<!-- 4th script -->

<script>
    $('#salik-btn').on('click',function() {
        $('#salik_modal').modal('show');
        var table = $('#datatable-salik').DataTable({
            paging: true,
            info: true,
            autoWidth: false,
            retrieve: true
        });
        table.columns.adjust().draw();
    });
</script>
<!-- 4th script ends here -->


