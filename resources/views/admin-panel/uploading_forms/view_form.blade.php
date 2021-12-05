@extends('admin-panel.base.main')
@section('css')
<link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
<link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
<div class="breadcrumb">
    <h1 class="mr-2">Home</h1>
    <ul>
        <li><a href="">Forms</a></li>
        <li>View Fomrs</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="row pb-2" >
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form method="post" enctype="multipart/form-data" action="{{url('view_forms')}}"  aria-label="{{ __('Upload') }}" >
                    {!! csrf_field() !!}
                    <div class="input-group mb-3">
                        <div class="col-md-12 form-group mb-3">
                            <label for="repair_category">Select Form</label>
                            {{--                                <select id="form_type" name="form_type" class="form-control form-control-rounded">--}}
                                {{--                                    <option value="">Select Form</option>--}}

                                {{--                                    @foreach($result as $res)--}}
                                {{--                                        <option value="{{$res->id}}">{{$res->form_name}}</option>--}}
                                {{--                                    @endforeach--}}
                                {{--                                </select>--}}

                        </div>
                        <div class="input-group mb-3">
                            <select id="form_type" name="form_type" class="form-control form-control-rounded" required>
                                <option value="">Select Form</option>

                                @foreach($result as $res)

                                <option value="{{$res->id}}">{{$res->form_name}}</option>
                                @endforeach
                            </select>
                            <div class="input-group-append"> <button class="btn btn-primary" type="submit">View</button></div>
                        </div>


                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!---------Vehicle Salik---->
@if(isset($salik))
<div class="col-md-12 mb-3">
    <div class="card text-left">
        <div class="card-body">
            <div class="table-responsive">
                <h5 align="center">Vehicle Salik Details</h5>
                <table class="table" id="datatable" style="width: 100%">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Transaction ID</th>
                        <th scope="col">Trip Date</th>
                        <th scope="col">Trip Time</th>
                        <th scope="col">Transaction Post Date</th>
                        <th scope="col">Toll Gate</th>
                        <th scope="col">Direction</th>
                        <th scope="col">Tag Number</th>
                        <th scope="col">Plate</th>
                        <th scope="col">Amount(AED)</th>
                        <th scope="col">Account Number</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
<!--                    @foreach($salik as $sal)-->
<!--                    <tr>-->
<!--                        <th scope="row">1</th>-->
<!--                        <td>{{$sal->transaction_id}}</td>-->
<!--                        <td>{{$sal->trip_date}}</td>-->
<!--                        <td>{{$sal->trip_time}}</td>-->
<!--                        <td>{{$sal->transaction_post_date}}</td>-->
<!--                        <td>{{$sal->toll_gate}}</td>-->
<!--                        <td>{{$sal->direction}}</td>-->
<!--                        <td>{{$sal->tag_number}}</td>-->
<!--                        <td>{{$sal->plate}}</td>-->
<!--                        <td>{{$sal->amount}}</td>-->
<!--                        <td>{{$sal->account_number}}</td>-->
<!---->
<!--                        <td>-->
<!--                            <a class="text-success mr-2" href="{{route('view_form.edit',$sal->id)}}"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a>-->
<!--                            {{--                                                            <a class="text-danger mr-2" data-toggle="modal" onclick="deleteData({{$sal->id}})" data-target=".bd-example-modal-sm" >--}}-->
<!--                                {{--                                                                <i class="nav-icon i-Close-Window font-weight-bold">--}}-->
<!--                                    {{--                                                                </i>--}}-->
<!--                            </a>-->
<!--                        </td>-->
<!--                    </tr>-->
<!--                    @endforeach-->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endif
<!-------------Fines----->

@if(isset($fines))
<div class="col-md-12 mb-3">
    <div class="card text-left">
        <div class="card-body">
            <div class="table-responsive">
                <h5 align="center">Fines Details</h5>
                <table class="table" id="datatable">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Traffic File No</th>
                        <th scope="col">Plate Number</th>
                        <th scope="col">Plate Category</th>
                        <th scope="col">Plate Code</th>
                        <th scope="col">License Number</th>
                        <th scope="col">License From</th>
                        <th scope="col">Ticket Number</th>
                        <th scope="col">Ticket Date</th>
                        <th scope="col">Fines Source</th>
                        <th scope="col">Ticket Fee</th>
                        <th scope="col">Ticket Status</th>
                        <th scope="col">Terms of Offense</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
<!--                    @foreach($fines as $fine)-->
<!--                    <tr>-->
<!--                        <th scope="row">1</th>-->
<!--                        <td>{{$fine->traffic_file_no}}</td>-->
<!--                        <td>{{$fine->plate_number}}</td>-->
<!--                        <td>{{$fine->plate_category}}</td>-->
<!--                        <td>{{$fine->plate_code}}</td>-->
<!--                        <td>{{$fine->license_number}}</td>-->
<!--                        <td>{{$fine->license_from}}</td>-->
<!--                        <td>{{$fine->tiekcet_number}}</td>-->
<!--                        <td>{{$fine->ticket_date}}</td>-->
<!--                        <td>{{$fine->fines_source}}</td>-->
<!--                        <td>{{$fine->ticket_fee}}</td>-->
<!--                        <td>{{$fine->ticket_status}}</td>-->
<!--                        <td>{{$fine->the_terms_of_the_offense}}</td>-->
<!---->
<!--                        <td>-->
<!--                            <a class="text-success mr-2" href="{{route('fine_edit',$fine->id)}}"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a>-->
<!--                            {{--                                        <a class="text-danger mr-2" data-toggle="modal" onclick="deleteData2({{$fine->id}})" data-target=".bd-example1-modal-sm" ><i class="nav-icon i-Close-Window font-weight-bold"></i></a>--}}-->
<!--                        </td>-->
<!--                    </tr>-->
<!--                    @endforeach-->
<!--                    </tbody>-->
                </table>
            </div>
        </div>
    </div>
</div>
@endif



<!-------------Fuels----->

@if(isset($fuels))
<div class="col-md-12 mb-3">
    <div class="card text-left">
        <div class="card-body">
            <div class="table-responsive">
                <h5 align="center">Fuel Details</h5>
                <table class="table" id="datatable">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">RID</th>
                        <th scope="col">Vehicle Plate Number</th>
                        <th scope="col">License Plate Number</th>
                        <th scope="col">Sale End</th>
                        <th scope="col">UnitPrice</th>
                        <th scope="col">Volume</th>
                        <th scope="col">Total</th>
                        <th scope="col">Product Name</th>
                        <th scope="col">Receipt Number</th>
                        <th scope="col">Odometer</th>
                        <th scope="col">ID Unit Code</th>
                        <th scope="col">Station Name</th>
                        <th scope="col">Station Code</th>
                        <th scope="col">Fleet Name</th>
                        <th scope="col">P Product Name</th>
                        <th scope="col">Group Name</th>
                        <th scope="col">Vehicle Code</th>
                        <th scope="col">City Code</th>
                        <th scope="col">Cost Center</th>
                        <th scope="col">Vat Rate</th>
                        <th scope="col">VAT AMOUNT</th>
                        <th scope="col">ACTUAL AMOUNT</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
<!--                    @foreach($fuels as $fuel)-->
<!--                    <tr>-->
<!--                        <th scope="row">1</th>-->
<!--                        <td>{{$fuel->rid}}</td>-->
<!--                        <td>{{$fuel->vehicle_plate_number}}</td>-->
<!--                        <td>{{$fuel->license_plate_nr}}</td>-->
<!--                        <td>{{$fuel->sale_end}}</td>-->
<!--                        <td>{{$fuel->unit_price}}</td>-->
<!--                        <td>{{$fuel->volume}}</td>-->
<!--                        <td>{{$fuel->total}}</td>-->
<!--                        <td>{{$fuel->product_name}}</td>-->
<!--                        <td>{{$fuel->receipt_nr}}</td>-->
<!--                        <td>{{$fuel->odometer}}</td>-->
<!--                        <td>{{$fuel->id_unit_code}}</td>-->
<!--                        <td>{{$fuel->station_name}}</td>-->
<!---->
<!--                        <td>{{$fuel->station_code}}</td>-->
<!--                        <td>{{$fuel->fleet_name}}</td>-->
<!--                        <td>{{$fuel->p_product_name}}</td>-->
<!--                        <td>{{$fuel->group_name}}</td>-->
<!--                        <td>{{$fuel->vehicle_code}}</td>-->
<!--                        <td>{{$fuel->city_code}}</td>-->
<!--                        <td>{{$fuel->cost_center}}</td>-->
<!--                        <td>{{$fuel->vat_rate}}</td>-->
<!--                        <td>{{$fuel->vat_amount}}</td>-->
<!--                        <td>{{$fuel->actual_amount}}</td>-->
<!---->
<!---->
<!--                        <td>-->
<!--                            <a class="text-success mr-2"  href="{{route('fuel_edit',$fuel->id)}}"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a>-->
<!--                            {{--                                        <a class="text-danger mr-2" data-toggle="modal" onclick="deleteData3({{$fuel->id}})" data-target=".bd-example3-modal-sm" ><i class="nav-icon i-Close-Window font-weight-bold"></i></a>--}}-->
<!--                        </td>-->
<!--                    </tr>-->
<!--                    @endforeach-->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endif


<!-------------RTA Vehicle----->

@if(isset($rta_veh))
<div class="col-md-12 mb-3">
    <div class="card text-left">
        <div class="card-body">
            <div class="table-responsive">
                <h5 align="center">RTA Vehicle Details</h5>
                <table class="table" id="datatable">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Mortgaged By</th>
                        <th scope="col">Insurance Co</th>
                        <th scope="col">Expiry Date</th>
                        <th scope="col">Issue Date</th>
                        <th scope="col">Fines Amount</th>
                        <th scope="col"> No. Of Fines</th>
                        <th scope="col">Registration Valid For Days</th>
                        <th scope="col">Make Year</th>
                        <th scope="col">Plate No</th>
                        <th scope="col">Chassis No</th>
                        <th scope="col">Model</th>
                        <th scope="col">Traffic File Number</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
<!--                    @foreach($rta_veh as $rta)-->
<!--                    <tr>-->
<!--                        <th scope="row">1</th>-->
<!--                        <td>{{$rta->mortgaged_by}}</td>-->
<!--                        <td>{{$rta->insurance_co}}</td>-->
<!--                        <td>{{$rta->expiry_date}}</td>-->
<!--                        <td>{{$rta->issue_date}}</td>-->
<!--                        <td>{{$rta->fines_amount}}</td>-->
<!--                        <td>{{$rta->number_of_fines}}</td>-->
<!--                        <td>{{$rta->registration_valid_for_days}}</td>-->
<!--                        <td>{{$rta->make_year}}</td>-->
<!--                        <td>{{$rta->plate_no}}</td>-->
<!--                        <td>{{$rta->chassis_no}}</td>-->
<!--                        <td>{{$rta->model}}</td>-->
<!--                        <td>{{$rta->traffic_file_number}}</td>-->
<!--                        <td>-->
<!--                            <a class="text-success mr-2" href="{{route('rta_edit',$rta->id)}}"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a>-->
<!--                            {{--                                        <a class="text-danger mr-2" data-toggle="modal" onclick="deleteData4({{$rta->id}})" data-target=".bd-example4-modal-sm" ><i class="nav-icon i-Close-Window font-weight-bold"></i></a>--}}-->
<!--                        </td>-->
<!--                    </tr>-->
<!--                    @endforeach-->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endif


<!-----------------------------------------Uber Eats------------------------->

@if(isset($UberEats))
<div class="col-md-12 mb-3">
    <div class="card text-left">
        <div class="card-body">
            <div class="table-responsive">
                <h5 align="center">Uber Eats Details</h5>
                <table class="table" id="datatable">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Driver UID</th>
                        <th scope="col">Trip UID</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Timestamp</th>
                        <th scope="col">Item Type</th>
                        <th scope="col">Description</th>
                        <th scope="col">Desclaimer</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
<!--                    @foreach($UberEats as $eats)-->
<!--                    <tr>-->
<!--                        <th scope="row">1</th>-->
<!--                        <td>{{$eats->driver_u_uid}}</td>-->
<!--                        <td>{{$eats->trip_u_uid}}</td>-->
<!--                        <td>{{$eats->first_name}}</td>-->
<!--                        <td>{{$eats->last_name}}</td>-->
<!--                        <td>{{$eats->amount}}</td>-->
<!--                        <td>{{$eats->timestamp}}</td>-->
<!--                        <td>{{$eats->item_type}}</td>-->
<!--                        <td>{{$eats->description}}</td>-->
<!--                        <td>{{$eats->disclaimer}}</td>-->
<!--                        <td>-->
<!--                            <a class="text-success mr-2" href="{{route('ubereats_edit',$eats->id)}}"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a>-->
<!--                            {{--                                        <a class="text-danger mr-2" data-toggle="modal" onclick="deleteData5({{$eats->id}})" data-target=".bd-example5-modal-sm" ><i class="nav-icon i-Close-Window font-weight-bold"></i></a>--}}-->
<!--                        </td>-->
<!--                    </tr>-->
<!--                    @endforeach-->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endif


<!-----------------------------------------Employee List------------------------->

@if(isset($Employee))
<div class="col-md-12 mb-3">
    <div class="card  text-left">
        <div class="card-body">
            <div class="table-responsive">
                <h5 align="center">Employee Details</h5>
                <table class="table"  id="datatable" style="width: 100%">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">No</th>
                        <th scope="col">Person Code</th>
                        <th scope="col">Person Name</th>
                        <th scope="col">Job</th>
                        <th scope="col">Passport Details</th>
                        <th scope="col">Card Details</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
<!--                    @foreach($Employee as $emp)-->
<!--                    <tr>-->
<!--                        <th scope="row">1</th>-->
<!--                        <td>{{$emp->no}}</td>-->
<!--                        <td>{{$emp->person_code}}</td>-->
<!--                        <td>{{$emp->person_name}}</td>-->
<!--                        <td>{{$emp->job}}</td>-->
<!--                        <td>{{$emp->passport_details}}</td>-->
<!--                        <td>{{$emp->card_details}}</td>-->
<!--                        <td>-->
<!--                            <a class="text-success mr-2" href="{{route('employee_edit',$emp->id)}}"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a>-->
<!--                            {{--                                        <a class="text-danger mr-2" data-toggle="modal" onclick="deleteData6({{$emp->id}})" data-target=".bd-example6-modal-sm" ><i class="nav-icon i-Close-Window font-weight-bold"></i></a>--}}-->
<!--                        </td>-->
<!--                    </tr>-->
<!--                    @endforeach-->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endif



<!-----------------------------------------Uber------------------------->

@if(isset($Uber))
<div class="col-md-12 mb-3">
    <div class="card text-left">
        <div class="card-body">
            <div class="table-responsive">
                <h5 align="center">Uber Details</h5>
                <table class="table" id="datatable" style="width: 100%">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Cash</th>
                        <th scope="col">Credit</th>

                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
<!--                    @foreach($Uber as $ub)-->
<!--                    <tr>-->
<!--                        <th scope="row">1</th>-->
<!--                        <td>{{$ub->name}}</td>-->
<!--                        <td>{{$ub->cash}}</td>-->
<!--                        <td>{{$ub->credit}}</td>-->
<!---->
<!--                        <td>-->
<!--                            <a class="text-success mr-2" href="{{route('uber_edit',$ub->id)}}"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a>-->
<!--                            {{--                                        <a class="text-danger mr-2" data-toggle="modal" onclick="deleteData7({{$ub->id}})" data-target=".bd-example7-modal-sm" ><i class="nav-icon i-Close-Window font-weight-bold"></i></a>--}}-->
<!--                        </td>-->
<!--                    </tr>-->
<!--                    @endforeach-->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endif

@if(isset($Telecom))
<div class="col-md-12 mb-3">
    <div class="card text-left">
        <div class="card-body">
            <div class="table-responsive">
                <h5 align="center">Telecom Details</h5>
                <table class="table" id="datatable" style="width:100%">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">ID</th>
                        <th scope="col">Account Number</th>
                        <th scope="col">Party ID</th>
                        <th scope="col">Product Type</th>
                        <th scope="col">Network</th>
                        <th scope="col">Category Tpes</th>
                        @if(in_array(1, Auth::user()->user_group_id))
                        <th scope="col">Action</th>
                        @endif
                    </tr>
                    </thead>
                    <tbody>
<!--                    @foreach($Telecom as $tel)-->
<!--                    <tr>-->
<!--                        <th scope="row">1</th>-->
<!--                        <td>{{$tel->id}}</td>-->
<!--                        <td>{{$tel->account_number}}</td>-->
<!--                        <td>{{$tel->party_id}}</td>-->
<!--                        <td>{{$tel->product_type}}</td>-->
<!--                        <td>{{$tel->network}}</td>-->
<!--                        @if($tel->category_types=='0')-->
<!--                        <td>Company</td>-->
<!--                        @else-->
<!--                        <td>Platform</td>-->
<!--                        @endif-->
<!---->
<!--                        @if(in_array(1, Auth::user()->user_group_id))-->
<!--                        <td>-->
<!--                            <a class="text-success mr-2" href="{{route('telecome_edit',$tel->id)}}"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a>-->
<!--                            {{--                                        <a class="text-danger mr-2" data-toggle="modal" onclick="deleteData7({{$ub->id}})" data-target=".bd-example7-modal-sm" ><i class="nav-icon i-Close-Window font-weight-bold"></i></a>--}}-->
<!--                        </td>-->
<!--                        @endif-->
<!--                    </tr>-->
<!--                    @endforeach-->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endif

@if(isset($bike_detail))
<div class="col-md-12 mb-3">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item"><a class="nav-link active show" id="home-basic-tab" data-toggle="tab" href="#homeBasic" role="tab" aria-controls="homeBasic" aria-selected="true">All Bikes</a></li>
        <li class="nav-item"><a class="nav-link" id="profile-basic-tab" data-toggle="tab" href="#profileBasic" role="tab" aria-controls="profileBasic" aria-selected="false">Cancelled Plate No</a></li>
    </ul>
    <div class="card text-left">
        <div class="card-body">

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade active show" id="homeBasic" role="tabpanel" aria-labelledby="home-basic-tab">

                    <div class="table-responsive">
                        <h5 align="center">Bike Details</h5>
                        <table class="table" id="datatable" style="width:100%">
                            <thead class="thead-dark">
                            <tr style="white-space: nowrap; font-size: 14px;">
                                <th scope="col">#</th>
                                <th scope="col">Plate Number</th>
                                <th scope="col">Plate Code</th>
                                <th scope="col">Model</th>
                                <th scope="col">Make Year</th>
                                <th scope="col">Chassis no</th>
                                {{--                                <th scope="col">Mortgaged by</th>--}}
                                <th scope="col">Insurance Company</th>
                                <th scope="col">Expiry Date</th>
                                <th scope="col">Issue Date</th>
                                <th scope="col">Traffic File No</th>
                                <th scope="col">Category Type</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($bike_detail as $bike)
                            <tr style="white-space: nowrap; font-size: 14px;">
                                <th scope="row">1</th>
                                <td>{{$bike->plate_no}}</td>
                                <td>{{$bike->plate_code}}</td>
                                <td>{{$bike->model}}</td>
                                <td>{{$bike->make_year}}</td>
                                <td>{{$bike->chassis_no}}</td>
                                {{--                                    <td>{{$bike->mortgaged_by}}</td>--}}
                                <td>{{$bike->insurance_co}}</td>
                                <td>{{$bike->expiry_date}}</td>
                                <td>{{$bike->issue_date}}</td>
                                <td>{{$bike->traffic_file}}</td>
                                @if($bike->category_type == '0')
                                <td>Company</td>
                                @elseif($bike->category_type == '1')
                                <td>Lease</td>
                                @elseif($bike->category_type == '2')
                                <td>Click Deliver</td>
                                @elseif($bike->category_type == '3')
                                <td>Deliveroo</td>
                                @else
                                <td>Other</td>
                                @endif

                                <td style="white-space: nowrap">
                                    <a class="text-success mr-2" href="{{route('bikedetail_edit',$bike->id)}}"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a>
                                    {{--                                        <a class="text-success mr-2 bike_history" id="{{$bike->id}}" href="#"><i class="nav-icon i-File font-weight-bold"></i></a>--}}
                                    <a class="text-primary mr-2 renew_btn_cls" id="{{$bike->id}}" href="javascript:void(0)"><i class="nav-icon i-Add-Window font-weight-bold"></i></a>
                                    <a class="text-danger mr-2 renew_btn_cls-1" id="{{$bike->id}}" href="javascript:void(0)"><i class="nav-icon i-Close-Window font-weight-bold"></i></a>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!----------->
                <div class="tab-pane fade" id="profileBasic" role="tabpanel" aria-labelledby="profile-basic-tab">
                    <table class="table" id="datatable2" style="width:100%">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Plate Number</th>
                            <th scope="col">Date & Time</th>
                            <th scope="col">Remarks</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($bike_cencel as $cencel)
                        <tr>
                            <th scope="row">1</th>
                            <td>{{$cencel->plate_no}}</td>
                            <td>{{$cencel->date_and_time}}</td>
                            <td>{{$cencel->remarks}}</td>
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

<!----------------------------------Delete----------->
<div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form action="" id="deleteForm" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle-1">Deletion Confirmation</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    Are you sure want to delete the data?
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary ml-2" type="submit" onclick="deleteSubmit()">Delete it</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade bd-example1-modal-sm" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form action="" id="deleteForm2" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle-1">Deletion Confirmation</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    {{ csrf_field() }}
                    {{ method_field('GET') }}
                    Are you sure want to delete the data?
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary ml-2" type="submit" onclick="deleteSubmit2()">Delete it</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-------Fuel Delete--------------------------------->
<div class="modal fade bd-example3-modal-sm" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form action="" id="deleteForm3" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle-1">Deletion Confirmation</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    {{ csrf_field() }}
                    {{ method_field('GET') }}
                    Are you sure want to delete the data?
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary ml-2" type="submit" onclick="deleteSubmit3()">Delete it</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-------RTA Vehicle D Delete--------------------------------->
<div class="modal fade bd-example4-modal-sm" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form action="" id="deleteForm4" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle-1">Deletion Confirmation </h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    {{ csrf_field() }}
                    {{ method_field('GET') }}
                    Are you sure want to delete the data?
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary ml-2" type="submit" onclick="deleteSubmit4()">Delete it</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-------Uber Eats  Delete--------------------------------->
<div class="modal fade bd-example5-modal-sm" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form action="" id="deleteForm5" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle-1">Deletion Confirmation</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    {{ csrf_field() }}
                    {{ method_field('GET') }}
                    Are you sure want to delete the data?
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary ml-2" type="submit" onclick="deleteSubmit5()">Delete it</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-------Employee List Delete--------------------------------->
<div class="modal fade bd-example6-modal-sm" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form action="" id="deleteForm6" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle-1">Deletion Confirmation</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    {{ csrf_field() }}
                    {{ method_field('GET') }}
                    Are you sure want to delete the data?
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary ml-2" type="submit" onclick="deleteSubmit6()">Delete it</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-------Uber Delete--------------------------------->
<div class="modal fade bd-example7-modal-sm" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form action="" id="deleteForm7" method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle-1">Deletion Confirmation</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    {{ csrf_field() }}
                    {{ method_field('GET') }}
                    Are you sure want to delete the data?
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary ml-2" type="submit" onclick="deleteSubmit7()">Delete it</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--------Update Modals Section------>
<!-------Salik Modal---------------------------------->
<div class="modal fade" id="salik_update" data-modal="salik_update-modal-window" tabindex="-1" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="row">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="verifyModalContent_title">Edit</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    @if(isset($salik_edit))
                    <form  action="{{action('ViewFormsController@update', $salik_edit->id)}}"  method="post">




                        {!! csrf_field() !!}
                        @if(isset($salik_edit))

                        {{ method_field('PUT') }}

                        @endif



                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label" for="recipient-name-2">Transaction ID:</label>
                                <input class="form-control" id="id" name="id"  value="{{isset($salik_edit)?$salik_edit->id:""}}" type="hidden"  />
                                <input class="form-control" id="form_type" name="form_type"  value="1" type="hidden"  />
                                <input class="form-control" id="transaction_id" name="transaction_id"  value="{{isset($salik_edit)?$salik_edit->transaction_id:""}}" type="text"  />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label" for="message-text-1">Trip Date:</label>
                                <input class="form-control" id="trip_date" name="trip_date" value="{{isset($salik_edit)?$salik_edit->trip_date:""}}" type="text"  />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label"  for="message-text-1">Trip Time:</label>
                                <input class="form-control" id="trip_time" name="trip_time" value="{{isset($salik_edit)?$salik_edit->trip_time:""}}" type="text"  />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label" for="message-text-1">Transaction Post Date:</label>
                                <input class="form-control" id="transaction_post_date" name="transaction_post_date" value="{{isset($salik_edit)?$salik_edit->transaction_post_date:""}}" type="text"   />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label" for="message-text-1">Toll Gate:</label>
                                <input class="form-control" id="toll_gate" name="toll_gate" value="{{isset($salik_edit)?$salik_edit->toll_gate:""}}" type="text"  />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label"  for="message-text-1">Direction:</label>
                                <input class="form-control" id="direction" name="direction" value="{{isset($salik_edit)?$salik_edit->direction:""}}" type="text"  />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label" for="message-text-1">Tag Number:</label>
                                <input class="form-control" id="tag_number" name="tag_number" value="{{isset($salik_edit)?$salik_edit->tag_number:""}}" type="text" />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label" for="message-text-1">Plate</label>
                                <input class="form-control" id="plate" name="plate" value="{{isset($salik_edit)?$salik_edit->plate:""}}" type="text"  />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label" for="message-text-1">Amount(AED)</label>
                                <input class="form-control" id="amount" name="amount" value="{{isset($salik_edit)?$salik_edit->amount:""}}" type="text"  />
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label" for="message-text-1">Account Number:</label>
                                <input class="form-control" id="account_number" name="account_number" value="{{isset($salik_edit)?$salik_edit->account_number:""}}" type="text"  />
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>

                            <button class="btn btn-primary" > Save  </button>
                        </div>
                    </form>
                    @endif
                    <!------------------------Fines form---------->
                    @if(isset($fines_edit))
                    <form  action="{{action('ViewFormsController@update', $fines_edit->id)}}"   method="post">

                        {!! csrf_field() !!}
                        @if(isset($fines_edit))

                        {{ method_field('PUT') }}

                        @endif


                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label" for="recipient-name-2">Traffic File No:</label>
                                <input class="form-control" id="id" name="id"  value="{{isset($fines_edit)?$fines_edit->id:""}}" type="hidden"  />
                                <input class="form-control" id="form_type" name="form_type"  value="2" type="hidden"  />
                                <input class="form-control" id="traffic_file_no" name="traffic_file_no"  value="{{isset($fines_edit)?$fines_edit->traffic_file_no:""}}" type="text"  />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label" for="message-text-1">Plate Number:</label>
                                <input class="form-control" id="plate_number" name="plate_number" value="{{isset($fines_edit)?$fines_edit->plate_number:""}}" type="text"  />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label"  for="message-text-1">Plate Category:</label>
                                <input class="form-control" id="plate_category" name="plate_category" value="{{isset($fines_edit)?$fines_edit->plate_category:""}}" type="text"  />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label" for="message-text-1">Plate Code:</label>
                                <input class="form-control" id="plate_code" name="plate_code" value="{{isset($fines_edit)?$fines_edit->plate_code:""}}" type="text"   />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label" for="message-text-1">License Number:</label>
                                <input class="form-control" id="license_number" name="license_number" value="{{isset($fines_edit)?$fines_edit->license_number:""}}" type="text"  />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label"  for="message-text-1">License From:</label>
                                <input class="form-control" id="license_from" name="license_from" value="{{isset($fines_edit)?$fines_edit->license_from:""}}" type="text"  />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label" for="message-text-1">Ticket Number:</label>
                                <input class="form-control" id="ticket_number" name="ticket_number" value="{{isset($fines_edit)?$fines_edit->ticket_number:""}}" type="text" />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label" for="message-text-1">Ticket Date</label>
                                <input class="form-control" id="ticket_date" name="ticket_date" value="{{isset($fines_edit)?$fines_edit->ticket_date:""}}" type="text"  />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label" for="message-text-1">Fines Source</label>
                                <input class="form-control" id="fines_source" name="fines_source" value="{{isset($fines_edit)?$fines_edit->fines_source:""}}" type="text"  />
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label" for="message-text-1">Ticket Fee:</label>
                                <input class="form-control" id="ticket_fee" name="ticket_fee" value="{{isset($fines_edit)?$fines_edit->ticket_fee:""}}" type="text"  />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label" for="message-text-1">Ticket Status</label>
                                <input class="form-control" id="ticket_status" name="ticket_status" value="{{isset($fines_edit)?$fines_edit->ticket_status:""}}" type="text"  />
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label" for="message-text-1">Terms of Offense:</label>
                                <input class="form-control" id="the_terms_of_the_offense" name="the_terms_of_the_offense" value="{{isset($fines_edit)?$fines_edit->the_terms_of_the_offense:""}}" type="text"  />
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>

                            <button class="btn btn-primary" > Save  </button>
                        </div>
                    </form>
                    @endif
                    <!------------------------Fuel form---------->
                    @if(isset($fuel_edit))
                    <form  action="{{action('ViewFormsController@update', $fuel_edit->id)}}"  method="post">

                        {!! csrf_field() !!}
                        @if(isset($fuel_edit))

                        {{ method_field('PUT') }}

                        @endif

                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label" for="recipient-name-2">RID No:</label>
                                <input class="form-control" id="id" name="id"  value="{{isset($fuel_edit)?$fuel_edit->id:""}}" type="hidden"  />
                                <input class="form-control" id="form_type" name="form_type"  value="3" type="hidden"  />
                                <input class="form-control" id="rid" name="rid"  value="{{isset($fuel_edit)?$fuel_edit->rid:""}}" type="text"  />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label" for="message-text-1">Vehicle Plate Number:</label>
                                <input class="form-control" id="vehicle_plate_number" name="vehicle_plate_number" value="{{isset($fuel_edit)?$fuel_edit->vehicle_plate_number:""}}" type="text"  />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label"  for="message-text-1">License Plate Number:</label>
                                <input class="form-control" id="license_plate_nr" name="license_plate_nr" value="{{isset($fuel_edit)?$fuel_edit->license_plate_nr:""}}" type="text"  />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label" for="message-text-1">Sale End:</label>
                                <input class="form-control" id="sale_end" name="sale_end" value="{{isset($fuel_edit)?$fuel_edit->sale_end:""}}" type="text"   />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label" for="message-text-1">Unit Price:</label>
                                <input class="form-control" id="unit_price" name="unit_price" value="{{isset($fuel_edit)?$fuel_edit->unit_price:""}}" type="text"  />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label"  for="message-text-1">Volume:</label>
                                <input class="form-control" id="volume" name="volume" value="{{isset($fuel_edit)?$fuel_edit->volume:""}}" type="text"  />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label" for="message-text-1">Total:</label>
                                <input class="form-control" id="total" name="total" value="{{isset($fuel_edit)?$fuel_edit->total:""}}" type="text" />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label" for="message-text-1">Product Name:</label>
                                <input class="form-control" id="product_name" name="product_name" value="{{isset($fuel_edit)?$fuel_edit->product_name:""}}" type="text"  />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label" for="message-text-1">Receipt Number</label>
                                <input class="form-control" id="receipt_nr" name="receipt_nr" value="{{isset($fuel_edit)?$fuel_edit->receipt_nr:""}}" type="text"  />
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label" for="message-text-1">Odemeter:</label>
                                <input class="form-control" id="odometer" name="odometer" value="{{isset($fuel_edit)?$fuel_edit->odometer:""}}" type="text"  />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label" for="message-text-1">ID Unit Code</label>
                                <input class="form-control" id="id_unit_code" name="id_unit_code" value="{{isset($fuel_edit)?$fuel_edit->id_unit_code:""}}" type="text"  />
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label" for="message-text-1">Station Name:</label>
                                <input class="form-control" id="station_name" name="station_name" value="{{isset($fuel_edit)?$fuel_edit->station_name:""}}" type="text"  />
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label" for="message-text-1">Station Code:</label>
                                <input class="form-control" id="station_code" name="station_code" value="{{isset($fuel_edit)?$fuel_edit->station_code:""}}" type="text"  />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label" for="message-text-1">Fleet Name:</label>
                                <input class="form-control" id="fleet_name" name="fleet_name" value="{{isset($fuel_edit)?$fuel_edit->fleet_name:""}}" type="text"  />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label" for="message-text-1">P Product Name:</label>
                                <input class="form-control" id="p_product_name" name="p_product_name" value="{{isset($fuel_edit)?$fuel_edit->p_product_name:""}}" type="text"  />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label" for="message-text-1">Group Name:</label>
                                <input class="form-control" id="group_name" name="group_name" value="{{isset($fuel_edit)?$fuel_edit->group_name:""}}" type="text"  />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label" for="message-text-1">Vehicle Code:</label>
                                <input class="form-control" id="vehicle_code" name="vehicle_code" value="{{isset($fuel_edit)?$fuel_edit->vehicle_code:""}}" type="text"  />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label" for="message-text-1">City Code:</label>
                                <input class="form-control" id="city_code" name="city_code" value="{{isset($fuel_edit)?$fuel_edit->city_code:""}}" type="text"  />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label" for="message-text-1">Cost Center:</label>
                                <input class="form-control" id="cost_center" name="cost_center" value="{{isset($fuel_edit)?$fuel_edit->cost_center:""}}" type="text"  />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label" for="message-text-1">VAT Rate</label>
                                <input class="form-control" id="vat_rate" name="vat_rate" value="{{isset($fuel_edit)?$fuel_edit->vat_rate:""}}" type="text"  />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label" for="message-text-1">VAT Amount</label>
                                <input class="form-control" id="vat_amount" name="vat_amount" value="{{isset($fuel_edit)?$fuel_edit->vat_amount:""}}" type="text"  />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label" for="message-text-1">Actual Amount</label>
                                <input class="form-control" id="actual_amount" name="actual_amount" value="{{isset($fuel_edit)?$fuel_edit->actual_amount:""}}" type="text"  />
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>

                            <button class="btn btn-primary" > Save  </button>
                        </div>
                    </form>
                    @endif
                    <!-------------------RTA Vehicle---------->

                    @if(isset($rta_edit))
                    <form  action="{{action('ViewFormsController@update', $rta_edit->id)}}"  method="post">

                        {!! csrf_field() !!}
                        @if(isset($rta_edit))

                        {{ method_field('PUT') }}

                        @endif



                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label" for="recipient-name-2">Mortgaged By:</label>
                                <input class="form-control" id="id" name="id"  value="{{isset($rta_edit)?$rta_edit->id:""}}" type="hidden"  />
                                <input class="form-control" id="form_type" name="form_type"  value="4" type="hidden"  />
                                <input class="form-control" id="mortgaged_by" name="mortgaged_by"  value="{{isset($rta_edit)?$rta_edit->mortgaged_by:""}}" type="text"  />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label" for="message-text-1">Insurance Co:</label>
                                <input class="form-control" id="insurance_co" name="insurance_co" value="{{isset($rta_edit)?$rta_edit->insurance_co:""}}" type="text"  />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label"  for="message-text-1">Expiry Date:</label>
                                <input class="form-control" id="expiry_date" name="expiry_date" value="{{isset($rta_edit)?$rta_edit->expiry_date:""}}" type="text"  />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label" for="message-text-1">Issue Date:</label>
                                <input class="form-control" id="issue_date" name="issue_date" value="{{isset($rta_edit)?$rta_edit->issue_date:""}}" type="text"   />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label" for="message-text-1">Fines Amount:</label>
                                <input class="form-control" id="fines_amount" name="fines_amount" value="{{isset($rta_edit)?$rta_edit->fines_amount:""}}" type="text"  />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label"  for="message-text-1"> No of Fines:</label>
                                <input class="form-control" id="number_of_fines" name="number_of_fines" value="{{isset($rta_edit)?$rta_edit->number_of_fines:""}}" type="text"  />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label" for="message-text-1">Registration Valid For Days:</label>
                                <input class="form-control" id="registration_valid_for_days" name="registration_valid_for_days" value="{{isset($rta_edit)?$rta_edit->registration_valid_for_days:""}}" type="text" />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label" for="message-text-1">Make Year:</label>
                                <input class="form-control" id="make_year" name="make_year" value="{{isset($rta_edit)?$rta_edit->make_year:""}}" type="text"  />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label" for="message-text-1">Plate No</label>
                                <input class="form-control" id="plate_no" name="plate_no" value="{{isset($rta_edit)?$rta_edit->plate_no:""}}" type="text"  />
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label" for="message-text-1">Chassis No:</label>
                                <input class="form-control" id="chassis_no" name="chassis_no" value="{{isset($rta_edit)?$rta_edit->chassis_no:""}}" type="text"  />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label" for="message-text-1">Model</label>
                                <input class="form-control" id="model" name="model" value="{{isset($rta_edit)?$rta_edit->model:""}}" type="text"  />
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label" for="message-text-1">Traffic File No:</label>
                                <input class="form-control" id="traffic_file_number" name="traffic_file_number" value="{{isset($rta_edit)?$rta_edit->traffic_file_number:""}}" type="text"  />
                            </div>



                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>

                            <button class="btn btn-primary" > Save  </button>
                        </div>
                    </form>
                    @endif
                    <!-------------UberEats-------->


                    @if(isset($ubereats_edit))
                    <form   action="{{action('ViewFormsController@update', $ubereats_edit->id)}}"   method="post">

                        {!! csrf_field() !!}
                        @if(isset($ubereats_edit))

                        {{ method_field('PUT') }}

                        @endif

                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label" for="recipient-name-2">Driver UID:</label>
                                <input class="form-control" id="id" name="id"  value="{{isset($ubereats_edit)?$ubereats_edit->id:""}}" type="hidden"  />
                                <input class="form-control" id="form_type" name="form_type"  value="5" type="hidden"  />
                                <input class="form-control" id="driver_u_uid" name="driver_u_uid"  value="{{isset($ubereats_edit)?$ubereats_edit->driver_u_uid:""}}" type="text"  />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label" for="message-text-1">Trip UID:</label>
                                <input class="form-control" id="trip_u_uid" name="trip_u_uid" value="{{isset($ubereats_edit)?$ubereats_edit->trip_u_uid:""}}" type="text"  />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label"  for="message-text-1">First Name:</label>
                                <input class="form-control" id="first_name" name="first_name" value="{{isset($ubereats_edit)?$ubereats_edit->first_name:""}}" type="text"  />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label" for="message-text-1">Last Name:</label>
                                <input class="form-control" id="last_name" name="last_name" value="{{isset($ubereats_edit)?$ubereats_edit->last_name:""}}" type="text"   />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label" for="message-text-1">Amount:</label>
                                <input class="form-control" id="amount" name="amount" value="{{isset($ubereats_edit)?$ubereats_edit->amount:""}}" type="text"  />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label"  for="message-text-1">Timestamp:</label>
                                <input class="form-control" id="timestamp" name="timestamp" value="{{isset($ubereats_edit)?$ubereats_edit->timestamp:""}}" type="text"  />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label" for="message-text-1">Item Type:</label>
                                <input class="form-control" id="item_type" name="item_type" value="{{isset($ubereats_edit)?$ubereats_edit->item_type:""}}" type="text" />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label" for="message-text-1">Description</label>
                                <input class="form-control" id="description" name="description" value="{{isset($ubereats_edit)?$ubereats_edit->description:""}}" type="text" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label" for="message-text-1">Disclaimer</label>
                                <input class="form-control" id="disclaimer" name="disclaimer" value="{{isset($ubereats_edit)?$ubereats_edit->disclaimer:""}}" type="text" />
                            </div>



                        </div>

                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>

                            <button class="btn btn-primary" > Save  </button>
                        </div>
                    </form>
                    @endif
                    <!-----------Employee List-------------------------->
                    @if(isset($emp_edit))
                    <form   action="{{action('ViewFormsController@update', $emp_edit->id)}}"   method="post">

                        {!! csrf_field() !!}
                        @if(isset($emp_edit))

                        {{ method_field('PUT') }}

                        @endif



                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label" for="recipient-name-2">No:</label>
                                <input class="form-control" id="id" name="id"  value="{{isset($emp_edit)?$emp_edit->id:""}}" type="hidden"  />
                                <input class="form-control" id="form_type" name="form_type"  value="6" type="hidden"  />
                                <input class="form-control" id="no" name="no"  value="{{isset($emp_edit)?$emp_edit->no:""}}" type="text"  />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label" for="message-text-1">Person Code:</label>
                                <input class="form-control" id="person_code" name="person_code" value="{{isset($emp_edit)?$emp_edit->person_code:""}}" type="text"  />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label"  for="message-text-1">Person Name:</label>
                                <input class="form-control" id="person_name" name="person_name" value="{{isset($emp_edit)?$emp_edit->person_name:""}}" type="text"  />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label" for="message-text-1">Job:</label>
                                <input class="form-control" id="job" name="job" value="{{isset($emp_edit)?$emp_edit->job:""}}" type="text"   />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label" for="message-text-1">Passport Details:</label>
                                <input class="form-control" id="passport_details" name="passport_details" value="{{isset($emp_edit)?$emp_edit->passport_details:""}}" type="text"  />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label"  for="message-text-1">Card Details:</label>
                                <input class="form-control" id="card_details" name="card_details" value="{{isset($emp_edit)?$emp_edit->card_details:""}}" type="text"  />
                            </div>
                        </div>






                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>

                            <button class="btn btn-primary" > Save  </button>
                        </div>
                    </form>
                    @endif
                    <!----------Uber----------->
                    @if(isset($uber_edit))
                    <form   action="{{action('ViewFormsController@update', $uber_edit->id)}}"   method="post">

                        {!! csrf_field() !!}
                        @if(isset($uber_edit))

                        {{ method_field('PUT') }}

                        @endif



                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label" for="recipient-name-2">Name:</label>
                                <input class="form-control" id="id" name="id"  value="{{isset($uber_edit)?$uber_edit->id:""}}" type="hidden"  />
                                <input class="form-control" id="form_type" name="form_type"  value="7" type="hidden"  />
                                <input class="form-control" id="name" name="name"  value="{{isset($uber_edit)?$uber_edit->name:""}}" type="text"  />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label" for="message-text-1">Cash:</label>
                                <input class="form-control" id="cash" name="cash" value="{{isset($uber_edit)?$uber_edit->cash:""}}" type="text"  />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label"  for="message-text-1">Credit:</label>
                                <input class="form-control" id="credit" name="credit" value="{{isset($uber_edit)?$uber_edit->credit:""}}" type="text"  />
                            </div>
                        </div>






                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>

                            <button class="btn btn-primary" > Save  </button>
                        </div>
                    </form>
                    @endif

                    @if(isset($telecome_edit))
                    <form   action="{{action('ViewFormsController@update', $telecome_edit->id)}}"   method="post">

                        {!! csrf_field() !!}
                        @if(isset($telecome_edit))

                        {{ method_field('PUT') }}

                        @endif



                        <div class="row">


                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label" for="recipient-name-2">SIM:</label>
                                <input class="form-control" id="id" name="id"  value="{{isset($telecome_edit)?$telecome_edit->id:""}}" type="hidden"  />
                                <input class="form-control" id="form_type" name="form_type"  value="9" type="hidden"  />
                                <input class="form-control" id="account_number" name="account_number"  value="{{isset($telecome_edit)?$telecome_edit->account_number:""}}" type="text"  />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label" for="message-text-1">Party ID:</label>
                                <input class="form-control" id="party_id" name="party_id" value="{{isset($telecome_edit)?$telecome_edit->party_id:""}}" type="text"  />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label"  for="message-text-1"> Product Type</label>
                                <input class="form-control" id="product_type" name="product_type" value="{{isset($telecome_edit)?$telecome_edit->product_type:""}}" type="text"  />
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label"  for="message-text-1"> Network</label>
                                <input class="form-control" id="network" name="network" value="{{isset($telecome_edit)?$telecome_edit->network:""}}" type="text"  />
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label"  for="message-text-1">Category Type</label>
                                <select id="category_type" name="category_type" class="form-control form-control-rounded">
                                    <option value="" selected disabled>Select Category Type</option>

                                    @php
                                    $isSelected = (isset($telecome_edit)?$telecome_edit->category_types:"");
                                    @endphp

                                    <option value="0" @if($isSelected=='0') selected @else @endif>Compnay</option>
                                    <option value="1" @if($isSelected=='1') selected @else @endif>Platform</option>

                                </select>
                            </div>
                        </div>


                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>

                            <button class="btn btn-primary" > Save  </button>
                        </div>
                    </form>
                    @endif


                    @if(isset($bike_detail_edit))
                    <form   action="{{action('ViewFormsController@update', $bike_detail_edit->id)}}"   method="post">

                        {!! csrf_field() !!}
                        @if(isset($bike_detail_edit))

                        {{ method_field('PUT') }}

                        @endif



                        <div class="row">


                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label" for="recipient-name-2"> Plate No</label>
                                <input class="form-control" id="id" name="id"  value="{{isset($bike_detail_edit)?$bike_detail_edit->id:""}}" type="hidden"  />
                                <input class="form-control" id="form_type" name="form_type"  value="10" type="hidden"  />
                                <input class="form-control" id="plate_no" name="plate_no"  value="{{isset($bike_detail_edit)?$bike_detail_edit->plate_no:""}}" type="text"  />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label" for="message-text-1">Plate Code</label>
                                <input class="form-control" id="plate_code " name="plate_code" value="{{isset($bike_detail_edit)?$bike_detail_edit->plate_code:""}}" type="text"  />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label"  for="message-text-1">Model</label>
                                <input class="form-control" id="model" name="model" value="{{isset($bike_detail_edit)?$bike_detail_edit->model:""}}" type="text"  />
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label"  for="message-text-1">Make Year</label>
                                <input class="form-control" id="make_year" name="make_year" value="{{isset($bike_detail_edit)?$bike_detail_edit->make_year:""}}" type="text"  />
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label"  for="message-text-1">Chassis No</label>
                                <input class="form-control" id="chassis_no" readonly name="chassis_no" value="{{isset($bike_detail_edit)?$bike_detail_edit->chassis_no	:""}}" type="text"  />
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label"  for="message-text-1"> Mortgaged by</label>
                                <input class="form-control" id="mortgaged_by" name="mortgaged_by" value="{{isset($bike_detail_edit)?$bike_detail_edit->mortgaged_by:""}}" type="text"  />
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label"  for="message-text-1">Insurance Co</label>
                                <input class="form-control" id="insurance_co" name="insurance_co" value="{{isset($bike_detail_edit)?$bike_detail_edit->insurance_co:""}}" type="text"  />
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label"  for="message-text-1">Expiry Date</label>
                                <input class="form-control" id="expiry_date" name="expiry_date" value="{{isset($bike_detail_edit)?$bike_detail_edit->expiry_date:""}}" type="text"  />
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label"  for="message-text-1">Issue Date</label>
                                <input class="form-control" id="issue_date" name="issue_date" value="{{isset($bike_detail_edit)?$bike_detail_edit->issue_date:""}}" type="text"  />
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label"  for="message-text-1">Traffic File</label>
                                <input class="form-control" id="traffic_file" name="traffic_file" value="{{isset($bike_detail_edit)?$bike_detail_edit->traffic_file:""}}" type="text"  />
                            </div>



                            <div class="col-md-6 form-group mb-3">
                                <label class="col-form-label"  for="message-text-1">Category Type</label>
                                <select id="category_type" name="category_type" class="form-control form-control-rounded">
                                    <option value="">Select Category Type</option>

                                    @php
                                    $isSelected = (isset($bike_detail_edit)?$bike_detail_edit->category_type:"");
                                    @endphp

                                    <option value="0" @if($isSelected=='0') selected @else @endif>Compnay</option>
                                    <option value="1" @if($isSelected=='1') selected @else @endif>Lease</option>

                                </select>
                            </div>

                        </div>


                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>

                            <button class="btn btn-primary" > Save  </button>
                        </div>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>


<!--------Update Modals Section Ends Here------>


<!---------Bike History model----------->
<div class="modal fade bike_history" id="edit_modal"  data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-2" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bike_history">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle-2">Bike History</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="card mb-12">
                        <div class="card-body">
                            <div class="row">
                                <div id="names_div">
                                    <div id="all-check" >
                                    </div>
                                </div>
                            </div>
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



<div class="modal fade bike_cencel"  data-backdrop="static" data-keyboard="false" id="cencel_plate-model" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content bike_cencel">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle-1">Cancel Plate Number</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="card mb-12">
                        <div class="card-body">
                            <div class="row">
                                <div id="names_div-2">
                                    <div id="plate-cencel" >

                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                    {{--                        <div class="modal-footer">--}}
                        {{--                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>--}}
                        {{--                        </div>--}}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
<script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function () {
        'use strict';

        $('#datatable').DataTable( {
            "aaSorting": [[0, 'desc']],
            "pageLength": 10,
            "columnDefs": [
                {"targets": [0],"visible": false},
                {"targets": [1][2],"width": "30%"}
            ],

            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    title: 'All SIMS',
                    text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                exportOptions: {
            modifier: {
                page : 'all',
            }
        }
    },
        'pageLength',
    ],
        "scrollY": false,
            "scrollX": true
    });



        'use strict';

        $('#datatable2').DataTable( {
            "aaSorting": [[0, 'desc']],
            "pageLength": 10,
            "columnDefs": [
                {"targets": [0],"visible": false},
            ],

        });



        $('#part_id').select2({
            placeholder: 'Select an option'
        });



    });




    function deleteData(id)
    {
        var id = id;
        var url = '{{ route('view_form.destroy', ":id") }}';
        url = url.replace(':id', id);
        $("#deleteForm").attr('action', url);
    }

    function deleteSubmit()
    {
        $("#deleteForm").submit();
    }
    //delete fine----------------
    function deleteData2(id)
    {
        var id = id;
        var url = '{{ route('fine_destroy', ":id") }}';
        url = url.replace(':id', id);
        $("#deleteForm2").attr('action', url);
    }

    function deleteSubmit2()
    {
        $("#deleteForm2").submit();
    }

    //delete fine----------------
    function deleteData3(id)
    {
        var id = id;
        var url = '{{ route('fuel_destroy', ":id") }}';
        url = url.replace(':id', id);
        $("#deleteForm3").attr('action', url);
    }

    function deleteSubmit3()
    {
        $("#deleteForm3").submit();
    }
    //delete rta vehicle----------------
    function deleteData4(id)
    {
        var id = id;
        var url = '{{ route('rta_destroy', ":id") }}';
        url = url.replace(':id', id);
        $("#deleteForm4").attr('action', url);
    }

    function deleteSubmit4()
    {
        $("#deleteForm4").submit();
    }
    //Uber Eats rta vehicle----------------
    function deleteData5(id)
    {
        var id = id;
        var url = '{{ route('ubereats_destroy', ":id") }}';
        url = url.replace(':id', id);
        $("#deleteForm5").attr('action', url);
    }

    function deleteSubmit5()
    {
        $("#deleteForm5").submit();
    }
    //Employee List ----------------
    function deleteData6(id)
    {
        var id = id;
        var url = '{{ route('employee_destroy', ":id") }}';
        url = url.replace(':id', id);
        $("#deleteForm6").attr('action', url);
    }

    function deleteSubmit6()
    {
        $("#deleteForm6").submit();
    }
    function deleteData7(id)
    {
        var id = id;
        var url = '{{ route('uber_destroy', ":id") }}';
        url = url.replace(':id', id);
        $("#deleteForm7").attr('action', url);
    }

    function deleteSubmit7()
    {
        $("#deleteForm7").submit();
    }

</script>

<script>




    // $(document).ready(function () {

    $(".renew_btn_cls").click(function(){
        // var pass_id = $("#pass_val").val();
        var id = $(this).attr('id');
        var token = $("input[name='_token']").val();


        $.ajax({
            url: "{{ route('ajax_bike_history') }}",
            method: 'POST',
            dataType: 'json',
            data: {id: id, _token: token},
            success: function (response) {
                $('#all-check').empty();
                $('#all-check').append(response.html);
                $('.bike_history').modal('show');
            }});
    });
    // });


</script>
<script>
    // $(document).ready(function () {
    $(".renew_btn_cls-1").click(function(){
        var id = $(this).attr('id');
        var token = $("input[name='_token']").val();

        $.ajax({
            url: "{{ route('ajax_bike_cencel') }}",
            method: 'POST',
            dataType: 'json',
            data: {id: id, _token: token},
            success: function (response) {
                $('#plate-cencel').empty();
                $('#plate-cencel').append(response.html);
                $('.bike_cencel').modal('show');
            }


        });


    });
    // });

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


<?php
if(isset($modal)){ ?>
    <script>

        $(function(){
            $('#salik_update').modal('show')
        });
    </script>
    <?php
}
?>

<?php
if(isset($msg)){ ?>
    <script>
        toastr.success("Plate No Cencelled Successfully!!");
    </script>
    <?php
}
?>




@endsection
