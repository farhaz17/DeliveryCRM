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

    </style>
@endsection
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/user-dashboard-new') }}">All Modules</a></li>
            <li class="breadcrumb-item"><a href="{{ route('vehicle_wise_dashboard',['active'=>'operations-menu-items']) }}">RTA Operation</a></li>
            <li class="breadcrumb-item active" aria-current="page">Vehicle info Update</li>
        </ol>
    </nav>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row mb-2">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title">Select Vehicle From Below</div>
                    <form action="" method="get" enctype="multipart/form-data"class="row" id="bike_search_form" >
                        <div class="col-md-12 form-group mb-3">
                            <select name="bike_id" id="bike_id" class="form-control form-control-sm">
                                <option value="">Select Vehicle to update</option>
                                @foreach ($bikes as $bike)
                                    <option {{ request('bike_id') == $bike->id ? 'selected' :'' }} value="{{ $bike->id }}">Plate No: {{ $bike->plate_no ?? '' }}  {{ $bike->chassis_no ? '| Chassis No: ' . $bike->chassis_no : ''}}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@if ($bike_detail_edit)

    <div class="row">
        <form action="{{route('vehicle_master_update')}}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')
            <input type="hidden" name="bike_id" value="{{ isset($bike_detail_edit) ? $bike_detail_edit->id : '' }}">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="card-title mb-3">Company Information</div>
                        <div class="row">
                            <div class="col-md-4 form-group mb-1">
                                <label class="col-form-label"  for="">Traffic File</label>
                                <select name="traffic_file" id="traffic_file" class="form-control form-control-sm">
                                    <option value="">Select One</option>
                                    @forelse ($traffics as $traffic)
                                        <option {{ $traffic->id ==  $bike_detail_edit->traffic_file ? 'selected' : '' }} value="{{ $traffic->id }}">
                                            {{ $traffic->traffic_file_no ?? "" }}
                                            @if($traffic->traffic_for == 1)
                                                {{ ' | '.$traffic->company->name }}
                                            @elseif($traffic->traffic_for == 2)
                                                {{ ' | '.$traffic->passport_info->personal_info->full_name }}
                                            @elseif($traffic->traffic_for == 3)
                                                {{ ' | '.$traffic->customer_supplier_info->contact_name}}
                                            @endif

                                        </option>
                                    @empty

                                    @endforelse
                                </select>
                            </div>
                            <div class="col-md-4 form-group mb-1">
                                <label class="col-form-label" for="category_type">Category Name</label>
                                <select name="category_type" id="category_type" class="form-control form-control-sm">
                                    <option value="" disabled selected>Select One</option>
                                    @forelse ($vehicle_categories as $vehicle_category)
                                        <option {{  $vehicle_category->id == $bike_detail_edit->category_type ? 'selected' : '' }} value="{{ $vehicle_category->id }}">{{ $vehicle_category->name ?? '' }}</option>
                                    @empty

                                    @endforelse
                                </select>
                            </div>
                            <div class="col-md-4 form-group mb-1" id="vehicle_sub_category_div">
                                <label class="col-form-label" for="vehicle_sub_category_id">Sub Category</label>
                                <select name="vehicle_sub_category_id" id="vehicle_sub_category_id" class="form-control form-control-sm">
                                    <option value="" disabled selected>Select One</option>
                                    @if($bike_detail_edit!==null && $bike_detail_edit->sub_category))
                                        @forelse ($bike_detail_edit->category->sub_categories as $vehicle_sub_category)
                                            <option {{  $bike_detail_edit->vehicle_sub_category_id == $vehicle_sub_category->id ? 'selected' : '' }} value="{{ $vehicle_sub_category->id }}">{{ $vehicle_sub_category->name ?? '' }}</option>
                                        @empty

                                        @endforelse
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-title mb-3">Vehicle Information</div>
                        <div class="row">
                            <div class="col-md-3 form-group mb-1">
                                <label class="col-form-label" for="">Plate Code</label>
                                <select name="plate_code" id="plate_code" class="form-control form-control-sm">
                                    <option value="" disabled selected>Select Plate Code</option>
                                    @forelse ($plate_codes as $plate_code)
                                        <option {{ ($bike_detail_edit->plate_code ==  $plate_code->id) ? 'selected' : '' }} value="{{ $plate_code->id ?? "" }}"> {{ $plate_code->plate_code ?? "NA" }}</option>
                                    @empty
                                        <a  href="{{ route('vehicle_masters_model.create') }}" >Register Plate Code First
                                    @endforelse
                                </select>
                            </div>
                            <div class="col-md-3 form-group mb-1">
                                <label class="col-form-label"  for="">Model</label>
                                <select name="model" id="model" class="form-control form-control-sm">
                                    <option value="" disabled selected>Select Model</option>
                                    @forelse ($vehicle_models as $model)
                                        <option {{ ($bike_detail_edit->model ==  $model->id) ? 'selected' : '' }} value="{{ $model->id ?? "" }}"> {{ $model->name ?? "NA" }}</option>
                                    @empty
                                        <a  href="{{ route('vehicle_masters_model.create') }}" >Register Vehicle Model First
                                    @endforelse
                                </select>
                            </div>
                            <div class="col-md-3 form-group mb-1">
                                <label class="col-form-label"  for="">Year</label>
                                <select name="make_year" id="make_year" class="form-control form-control-sm">
                                    <option value="" disabled selected >Select Year</option>
                                    @forelse ($years as $year)
                                        <option {{ $bike_detail_edit->make_year ==  $year->id ? 'selected' : '' }} value="{{ $year->id ?? "" }}"> {{ $year->year ?? "NA" }}</option>
                                    @empty
                                        <a  href="{{ route('vehicle_masters_model.create') }}" >Register Vehicle Year First
                                    @endforelse
                                </select>
                            </div>
                            <div class="col-md-3 form-group mb-1">
                                <label class="col-form-label" for="issue_date">Vehicle Issue Date</label>
                                <input class="form-control form-control-sm" placeholder="Enter vehicle Issue date" id="issue_date" name="issue_date" value="{{ $bike_detail_edit->issue_date ?? '' }}" type="date" required />
                            </div>
                            <div class="col-md-3 form-group mb-1">
                                <label class="col-form-label" for="expiry_date">Vehicle Expiry Date</label>
                                <input class="form-control form-control-sm" placeholder="Enter vehicle Issue date" id="expiry_date" name="expiry_date" value="{{ $bike_detail_edit->expiry_date ?? '' }}" type="date" required />
                            </div>
                            <div class="col-md-3 form-group mb-1">
                                <label class="col-form-label"  for="engine_no">Engine No</label>
                                <input class="form-control form-control-sm" placeholder="Enter Engine number" id="engine_no" name="engine_no" value="{{ $bike_detail_edit->engine_no ?? '' }}" type="text"  />
                            </div>
                            <div class="col-md-3 form-group mb-1">
                                <label class="col-form-label"  for="seat">Seats</label>
                                <input class="form-control form-control-sm" placeholder="Enter Seat" id="seat" name="seat" value="{{ $bike_detail_edit->seat ?? '' }}" type="text"  />
                            </div>
                            <div class="col-md-3 form-group mb-1">
                                <label class="col-form-label"  for="color">Color</label>
                                <input class="form-control form-control-sm" placeholder="Enter Color" id="color" name="color" value="{{ $bike_detail_edit->color ?? '' }}" type="text"  />
                            </div>
                            <div class="col-md-3 form-group mb-1">
                                <label class="col-form-label"  for="insurance_co">Insurance Co</label>
                                <select name="insurance_co" id="insurance_co" class="form-control form-control-sm">
                                    <option value="" disabled selected>{{ $vehicle_insurances->count() > 0 ? 'Select One' : 'Please Create Vehicle Insurance Master first' }}</option>
                                    @forelse ($vehicle_insurances as $vehicle_insurance)
                                    <option {{ isset($bike_detail_edit) && $bike_detail_edit->insurance_co ==  $vehicle_insurance->id ? 'selected' : '' }} value="{{ $vehicle_insurance->id }}">{{  $vehicle_insurance->name ?? "" }}</option>
                                    @empty

                                    @endforelse
                                </select>
                            </div>
                            <div class="col-md-3 form-group mb-1">
                                <label class="col-form-label"  for="insurance_no">Insurance no</label>
                                <input class="form-control form-control-sm" placeholder="Enter Insurance no" id="insurance_no" name="insurance_no" value="{{ $bike_detail_edit->insurance_no ?? '' }}" type="text" />
                            </div>
                            <div class="col-md-3 form-group mb-1">
                                <label class="col-form-label"  for="insurance_issue_date">Insurance Issue Date</label>
                                <input class="form-control form-control-sm" placeholder="Enter Issue date" id="insurance_issue_date" name="insurance_issue_date" value="{{ $bike_detail_edit->insurance_issue_date ?? '' }}" type="date"  />
                            </div>
                            <div class="col-md-3 form-group mb-1">
                                <label class="col-form-label"  for="insurance_expiry_date">Insurance Expiry Date</label>
                                <input class="form-control form-control-sm" placeholder="Enter Expiry Date" id="insurance_expiry_date" name="insurance_expiry_date" value="{{ $bike_detail_edit->insurance_expiry_date ?? '' }}" type="date"  />
                            </div>
                            <div class="col-md-3 form-group mb-1">
                                <label class="col-form-label"  for="mortgaged_by">Mortgaged by</label>
                                <select name="mortgaged_by" id="mortgaged_by" class="form-control form-control-sm">
                                    <option value="">Select One</option>
                                    @forelse ($vehicle_mortgages as $vehicle_mortgage)
                                        <option {{ isset($bike_detail_edit) && $bike_detail_edit->mortgaged_by == $vehicle_mortgage->id ?  'selected' : '' }} value="{{ $vehicle_mortgage->id }}">{{ $vehicle_mortgage->name ?? '' }}</option>
                                    @empty

                                    @endforelse
                                </select>
                            </div>
                            <div class="col-md-3 form-group mb-1">
                                <label class="col-form-label"  for="vehicle_mortgage_no">Mortgaged No</label>
                                <input class="form-control form-control-sm" placeholder="Enter Mortgaged No" id="vehicle_mortgage_no" name="vehicle_mortgage_no" value="{{ $bike_detail_edit->vehicle_mortgage_no ?? '' }}" type="text"  />
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        {{-- <div class="card-title mb-3">Attachments</div>
                        <div class="row">
                            <div class="col-md-4 form-group mb-1">
                                <label class="col-form-label"  for="attachment_reg_front">Attachment(Register Front Page)</label>
                                <input class="form-control-file form-control-sm"  id="attachment_reg_front" name="attachment_reg_front" type="file" />
                            </div>
                            <div class="col-md-4 form-group mb-1">
                                <label class="col-form-label"  for="attachment_reg_back">Attachment(Register Back Page)</label>
                                <input class="form-control-file form-control-sm"  id="attachment_reg_back" name="attachment_reg_back" type="file" />
                            </div>
                            <div class="col-md-4 form-group mb-1">
                                <label class="col-form-label"  for="attachment_insurance">Attachment(insurance)</label>
                                <input class="form-control-file form-control-sm"  id="attachment_insurance" name="attachment_insurance" type="file" />
                            </div>
                        </div> --}}
                        <div class="float-right mt-1">
                            <button class="btn btn-info btn-sm" type="submit" >Update</button>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>
@else
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title mb-3 text-center">Select Plate and Chassis no from dropdown</div>
            </div>
        </div>
    </div>
</div>
@endif
    <div class="overlay"></div>
@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

    <script>
        $('#bike_id').change(() => {
            $("body").addClass("loading");
            $(document).ready(()=>{
            $('#bike_search_form').submit();
                setTimeout(() => {
                    $("body").removeClass("loading");
                },500)
            });
        });
    </script>
    <script>
        $('#bike_id').select2({
            placeholder: 'Select Vehicle From Below'
        })
    </script>
    <script>
        $('#category_type').change(function(){
            var vehicle_category_id = $(this).val();
            $.ajax({
                url: "{{ route('get_vehicle_sub_category_list') }}?vehicle_category_id=" + vehicle_category_id,
                success: function(response){
                    $('#vehicle_sub_category_div').empty();
                    $('#vehicle_sub_category_div').append(response.html);
                }
            });
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
    <script>
        // Add remove loading class on body element depending on Ajax request status
        $(document).on({
            ajaxStart: function(){
                $("body").addClass("loading");
            },
            ajaxStop: function(){
                $("body").removeClass("loading");
            }
        });
    </script>

@endsection
