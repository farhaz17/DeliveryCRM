@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <style>
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
    </style>
@endsection
@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/user-dashboard-new') }}">All Modules</a></li>        
        <li class="breadcrumb-item"><a href="{{ route('vehicle_wise_dashboard',['active'=>'operations-menu-items']) }}">RTA Operation</a></li>
        <li class="breadcrumb-item active" aria-current="page">Bike Status Update</li>
    </ol>
</nav>
<div class="col-12">
    <div class="card col-md-12 mb-2">
        <form action="{{ route('vehicle_working_status_store') }}" method="post">
            <div class="card-body row">
                <div class="col">
                    @csrf
                    <input type="hidden" name="status_change_to" id="status_change_to">
                    <div class="card-title mb-3 col-12">Vehicle Status Update</div>
                    <div class="row">
                        <div class="col-md-12 form-group mb-1"> 
                            <label for="bike_id">Plate No</label>
                            <select name="bike_id" id="bike_id" class="form-control form-control-sm select2 select2" required>
                                <option value="">All</option>
                                @forelse ($all_bike_details as $bike_detail)
                                    <option value="{{ $bike_detail->id }}">Plate: {{ $bike_detail->plate_no ?? "" }} | Chassis: {{ $bike_detail->chassis_no ?? "" }}</option>
                                @empty
                                    
                                @endforelse
                            </select>
                        </div>
                        {{-- <div class="col-md-6 form-group mb-1">
                            <label for="date_and_time">Date & Time</label>
                            <input class="form-control form-control-sm select2" id="date_and_time" name="date_and_time" type="date" required="">
                        </div> --}}
                        <div class="col-md-12 form-group mb-1">
                            <label for="remarks">Remarks</label>
                            <textarea name="remarks" id="remarks" cols="30" rows="2" class="form-control"></textarea>
                        </div>
                    </div>  
                    <div id="attachment_holder"></div>          
                </div>
                <div class="col">
                    <div class="card-title mb-3 col-12">Selected Vehicle Information</div>
                    <div class="table-responsive">
                        <table class="table table-sm table-striped text-11">
                            <thead>
                                <tr>
                                    <th>Model</th>
                                    <th>Chassis No</th>
                                    <th>Traffic File No</th>
                                    <th>Owner's Name</th>
                                    <th>Bike Working Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td id="vehicle_model"></td>
                                    <td id="vehicle_chassis_no"></td>
                                    <td id="vehicle_traffic_file_no"></td>
                                    <td id="vehicle_traffic_company_name"></td>
                                    <td id="vehicle_working_status"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-group mb-1">
                            <label for="">&nbsp;</label><br>
                            <button class="btn btn-success btn-sm float-right ml-2" style="display: none" id="working_update_button" onclick="return confirm('Are you sure to move it to Working?')" type="submit" value="2" name="status_change_to">Move To Working</button>
                            <button class="btn btn-danger btn-sm float-right ml-2" style="display: none" id="not_working_update_button" onclick="return confirm('Are you sure move it to not working?')" type="submit" value="0" name="status_change_to">Move to Not Working</button>
                            <button class="btn btn-warning btn-sm float-right ml-2" style="display: none" id="holding_button" onclick="return confirm('Are you sure move it to Holding?')" type="submit" value="3" name="status_change_to">Move to Holding</button>
                        </div>
                    </div>
                </div>  
            </div>
        </form>
    </div>
    <div class="card col-md-12 mb-2">
        <form action="{{ route('ajax_get_filtered_bikes') }}" id="bike_search_form" method="get">
            @csrf
            <div class="card-body row">
                <div class="col">
                    <div class="card-title mb-3 col-12">Search Vehicles for bulk Update</div>
                    <div class="row row-xs">
                        <div class="col-3">
                            <label for="traffic_id">Select Traffic Or Company</label>
                            <select class="form-control form-control-sm select2 filtering_field" name="traffic_id" id="traffic_id">
                                <option value="">All</option>
                                @foreach ($traffics as $traffic)
                                    <option value="{{ $traffic->id }}">
                                        {{ $traffic->traffic_file_no ?? "" }} 
                                        @if ($traffic->traffic_for == 1)
                                            {{" | " . $traffic->company->name ?? ""}}
                                        @elseif($traffic->traffic_for == 2)
                                            {{" | " . $traffic->passport_info->personal_info->full_name ?? ""}}
                                        @elseif($traffic->traffic_for == 3)
                                            {{" | " . $traffic->customer_supplier_info->contact_name ?? ""}}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-3">
                            <label for="vehicle_category_id">Category</label>
                            <select class="form-control form-control-sm select2 filtering_field" id="vehicle_category_id">
                                <option value="">All</option>
                                @foreach ($vehicle_categories as $vehicle_category)
                                    <option value="{{$vehicle_category->id}}">{{ $vehicle_category->name ?? "" }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-3">
                            <label for="vehicle_sub_category_id">Sub Category</label>
                            <select class="form-control form-control-sm select2 filtering_field" id="vehicle_sub_category_id">
                                <option value="">All</option>
                            </select>
                        </div>
                        <div class="col-3">
                            <label for="vehicle_model_id">Select Model</label>
                            <select class="form-control form-control-sm select2 filtering_field" id="vehicle_model_id" name="vehicle_model_id">
                                <option value="">All</option>
                                @foreach ($vehicle_models as $model)
                                    <option value="{{ $model->id }}">{{ $model->name ?? '' }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-3">
                            <label for="vehicle_year_id">Year</label>
                            <select class="form-control form-control-sm select2 filtering_field" id="vehicle_year_id" name="vehicle_year_id">
                                <option value="">All</option>
                                @foreach ($vehicle_years as $year)
                                    <option value="{{ $year->id }}">{{ $year->year ?? '' }}</option>
                                @endforeach
                                
                            </select>
                        </div> 
                        <div class="col-3">
                            <label for="vehicle_make_id">Make</label>
                            <select class="form-control form-control-sm select2 filtering_field" id="vehicle_make_id" name="vehicle_make_id">
                                <option value="">All</option>
                                @foreach ($vehicle_makes as $make)
                                    <option value="{{ $make->id }}">{{ $make->name ?? "" }}</option>
                                @endforeach
                                
                            </select>
                        </div>
                        <div class="col-3">
                            <label for="vehicle_plate_code_id">Plate Code</label>
                            <select class="form-control form-control-sm select2 filtering_field" id="vehicle_plate_code_id" name="vehicle_plate_code_id">
                                <option value="">All</option>
                                @foreach ($vehicle_plate_codes as $plate_code)
                                    <option value="{{ $plate_code->id }}">{{ $plate_code->plate_code ?? '' }}</option>
                                @endforeach
                                
                            </select>
                        </div>
                        <div class="col-3">
                            <label for="vehicle_status">Vehicle Status</label>
                            <select class="form-control form-control-sm select2 filtering_field" id="vehicle_status" name="vehicle_status">
                                <option value="">All</option>
                                <option value="0">Not Working Bikes</option>                         
                                <option value="2">Ready to Assign Bikes</option>                            
                                <option value="3">Holding Bikes</option>                            
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label>&nbsp;</label>
                            <button type="submit" class="btn btn-primary btn-sm float-right mt-2"><i class="i-Magnifi-Glass1"></i> Search</button>
                            <a href="{{ route('vehicle_working_status_form') }}" class="btn btn-danger btn-sm float-right mt-2 mr-2"><i class="i-Close"></i> Clear Search</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="card col-md-12 mb-2">
        <div class="card-body">
            <div class="card-title mb-3 row">Filtered Vehicle List ( Except all running bikes )</div>
            <div id="filtered_vehicle_list_holder">
                <h5 class="text-center">Please Search bikes to update status</h5>
            </div>
        </div>
    </div>
</div>
<div class="overlay"></div>
@endsection
@section('js')
<script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function(){
        $('select.select2').select2({
            allowClear: true,
        });
    });
</script>

<script>
   $('#bike_id').on('change', function(){
       var bike_id = $(this).val();
       $.ajax({
          url: "{{ route('get_bike_detail_with_bike_id') }}",
          type:"GET",
          data:{bike_id},
          success:function(response){
            $('#vehicle_model').text(response.model);
            $('#vehicle_chassis_no').text(response.chassis_no);
            $('#vehicle_traffic_file_no').text(response.traffic_file_no);
            $('#vehicle_traffic_company_name').text(response.company_name);
            var status = ['Not Working','','Working','Holding'];  // dont remove blank element form array
            var status_color = ['red','','green','#ffc107'];  // dont remove blank element form array
            var submit_button_ids = ['#not_working_update_button','','#working_update_button','#holding_button']; // dont remove blank element form array
            $('#vehicle_working_status')
                .text(status[[0,2,3].includes(response.vehicle_working_status) ? response.vehicle_working_status : 1]) // matching with status
                .css('color',status_color[response.vehicle_working_status]); // matching with status
            $('button[type=submit]').show()
            $(submit_button_ids[[0,2,3].includes(response.vehicle_working_status) ? response.vehicle_working_status : $('button[type=submit]').hide()]).hide() // matching with status
          },
          error: function(response) {
             console.log(response)
           }
         });
   });
</script>
{{-- Js for bulk update starts here --}}
<script>
    $('#vehicle_category_id').change(function(){
        var category_id = $(this).val()
        $.ajax({
            url:"{{ route('ajax_get_vehicle_sub_categories')}}",
            data: {category_id},
            success: function(response){
                var select = $('#vehicle_sub_category_id');
                response.forEach( function ( vehicle_sub_category ) {
                    select.append( '<option value="'+vehicle_sub_category.id+'">'+vehicle_sub_category.name+'</option>' )
                } );
            },
            error:function(error){
                console.log(error)
            }
        });
    });
    $('.filtering_field').change(function(){
        $('#bike_search_form').submit()
    })
    $('#bike_search_form').on('submit',function(event){
        event.preventDefault();
        let url = $(this).attr('action');
        let traffic_id = $('#traffic_id').val();
        let vehicle_category_id = $('#vehicle_category_id').val();
        let vehicle_sub_category_id = $('#vehicle_sub_category_id').val();
        let vehicle_model_id = $('#vehicle_model_id').val();
        let vehicle_year_id = $('#vehicle_year_id').val();
        let vehicle_make_id = $('#vehicle_make_id').val();
        let vehicle_plate_code_id = $('#vehicle_plate_code_id').val();
        let vehicle_status = $('#vehicle_status').val();

        $.ajax({
          url: url,
          type:"GET",
          data:{
            traffic_id,vehicle_category_id,vehicle_sub_category_id,vehicle_model_id,vehicle_year_id,vehicle_make_id,vehicle_plate_code_id,vehicle_status
          },
          success:function(response){  
            window.scroll({top: 500,behavior: 'smooth'});
            $('#filtered_vehicle_list_holder').empty();
            $('#filtered_vehicle_list_holder').append(response.html);
          },
         });
        });
</script>
{{-- Js for bulk update ends here --}}

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