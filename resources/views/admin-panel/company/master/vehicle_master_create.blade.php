@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/user-dashboard-new') }}">All Modules</a></li>        
            <li class="breadcrumb-item"><a href="{{ route('vehicle_wise_dashboard',['active'=>'master-menu-items']) }}">RTA Master</a></li>
            <li class="breadcrumb-item active" aria-current="page">Vehicle Register</li>
        </ol>
    </nav>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row mb-2">
        <div class="col-md-12">
            @if(Session::has('message'))
                <!-- Modal -->
                @php 
                    $new_plate_nos = array_filter(explode(',',session()->get('new_plate_nos')));
                    $current_plate_nos = explode(',',session()->get('current_plate_nos')); // removed filter as all index no needed for loop
                @endphp
                @if($new_plate_nos)
                <div class="modal fade " id="plateReplaceModal" tabindex="-1" role="dialog" aria-labelledby="plateReplaceModalTitle" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h4 class="modal-title" id="plateReplaceModalTitle">New Plate no Requests!</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                            <p>
                                {{ count(explode(',',session()->get('new_plate_nos'))) . " plate numbers are new and requested to change after approval these will show under vehicle information"}} 
                            </p>
                            <table class="table table-sm table-hover text-10">
                                <thead>
                                    <tr>
                                        <td>Current Plate No</td>
                                        <td>New Plate No</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ( $new_plate_nos as $key => $new_plate_no)
                                        <tr>
                                            <td>{{ $current_plate_nos[$key] }}</td>
                                            <td>{{ $new_plate_no }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <hr>
                            <p class="mb-0">If you have the authority to approve click<a class="btn btn-link" href="{{ route('vehicle_plate_replace.index') }}">here</a> to go to the approval page.</p>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                    </div>
                </div>
               @endif
            @endif
            <div class="card">
                <div class="card-body">
                    <div class="card-title mb-3">Bikes Upload form excel file </div>
                    <div class="float-right text-16">Currently Total bikes Available: <span class="badge bg-success text-white">{{ $total_bikes }}</span></div>
                    @foreach($result as $res)
                        <div class="card-title sam" style="display: {{$res->id === 10 ? 'block' : 'none'}};" id="{{$res->id}}"><a href="{{ URL::to( $res->sample_file)}}" target="_blank">(Download Sample File)</a></div>
                    @endforeach
                    <form method="post" class="row" enctype="multipart/form-data" action="{{ url('/form_upload') }}"  aria-label="{{ __('Upload') }}" >
                        @csrf
                            <div class="col-md-5 form-group mb-3">
                                <input type="text" id="" name="" class="form-control form-control-sm" value="Bike" readonly required>
                                <input type="hidden" id="form_type" name="form_type" class="form-control form-control-sm" value="10" readonly required>
                            </div>
                            <div class="col-md-5 form-group mb-3">
                                <input class="form-control-file form-control-sm" id="select_file" type="file" name="select_file" aria-describedby="inputGroupFileAddon01" required />
                            </div>
                            <div class="col-md-2 mb-3">
                                <button class="btn btn-primary btn-sm" type="submit">Upload</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <form action="{{route('vehicle_master_store')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="card-title mb-3">Company Information</div>
                        <div class="row">
                            <div class="col-md-4 form-group mb-1">
                                <label class="col-form-label"  for="">Traffic File</label>
                                <select name="traffic_file" id="traffic_file" class="form-control form-control-sm" required>
                                    <option value="" disabled selected>{{ $traffics->count() > 0 ? 'Select One' : 'Please Create Traffic Master first' }}</option>
                                    @forelse ($traffics as $traffic)
                                    <option value="{{ $traffic->id }}">
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
                                    <option value="" disabled selected>{{ $vehicle_categories->count() > 0 ? 'Select One' : 'Please Create Vehicle Category Master first' }}</option>
                                    @forelse ($vehicle_categories as $vehicle_category)
                                        <option value="{{ $vehicle_category->id }}">{{ $vehicle_category->name ?? '' }}</option>
                                    @empty
                                        
                                    @endforelse
                                </select>
                            </div>
                            <div class="col-md-4 form-group mb-1" id="vehicle_sub_category_div"></div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-title mb-3">Vehicle Information</div>
                        <div class="row">
                            <div class="col-md-3 form-group mb-1">
                                <label class="col-form-label" for="recipient-name-2"> Plate No</label>
                                <input class="form-control form-control-sm" placeholder="Enter Plate No" id="plate_no" name="plate_no" value="" type="text" required>
                            </div>
                            <div class="col-md-3 form-group mb-1">
                                <label class="col-form-label" for="">Plate Code</label>
                                <select name="plate_code" id="plate_code" class="form-control form-control-sm">
                                    <option value="" disabled selected>Select Plate Code</option>
                                    @forelse ($plate_codes as $plate_code)
                                        <option {{ isset($bike_detail_edit) && ($bike_detail_edit->plate_code ==  $plate_code->id) ? 'selected' : '' }} value="{{ $plate_code->id ?? "" }}"> {{ $plate_code->plate_code ?? "NA" }}</option>
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
                                        <option {{ isset($bike_detail_edit) && ($bike_detail_edit->model ==  $model->id) ? 'selected' : '' }} value="{{ $model->id ?? "" }}"> {{ $model->name ?? "NA" }}</option>
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
                                        <option {{ isset($bike_detail_edit) && isset($bike_detail_edit->make_year) && ($bike_detail_edit->year->year ==  $year->id) ? 'selected' : '' }} value="{{ $year->id ?? "" }}"> {{ $year->year ?? "NA" }}</option>
                                    @empty
                                        <a  href="{{ route('vehicle_masters_model.create') }}" >Register Vehicle Year First
                                    @endforelse
                                </select>
                            </div>
                            <div class="col-md-3 form-group mb-1">
                                <label class="col-form-label" for="issue_date">Vehicle Issue Date</label>
                                <input class="form-control form-control-sm" placeholder="Enter vehicle Issue date" id="issue_date" name="issue_date" value="" type="date" />
                            </div>
                            <div class="col-md-3 form-group mb-1">
                                <label class="col-form-label" for="expiry_date">Vehicle Expiry Date</label>
                                <input class="form-control form-control-sm" placeholder="Enter vehicle Issue date" id="expiry_date" name="expiry_date" type="date" />
                            </div>
                            <div class="col-md-3 form-group mb-1">
                                <label class="col-form-label"  for="">Chassis No</label>
                                <input class="form-control form-control-sm" placeholder="Enter Chassis No" id="chassis_no"  name="chassis_no" value="" type="text"  required/>
                            </div>
                            <div class="col-md-3 form-group mb-1">
                                <label class="col-form-label"  for="engine_no">Engine No</label>
                                <input class="form-control form-control-sm" placeholder="Enter Engine number" id="engine_no" name="engine_no" value="" type="text"  />
                            </div>
                            <div class="col-md-3 form-group mb-1">
                                <label class="col-form-label"  for="seat">Seats</label>
                                <input class="form-control form-control-sm" placeholder="Enter Seat" id="seat" name="seat" value="" type="text"  />
                            </div>
                            <div class="col-md-3 form-group mb-1">
                                <label class="col-form-label"  for="color">Color</label>
                                <input class="form-control form-control-sm" placeholder="Enter Color" id="color" name="color" value="" type="text"  />
                            </div>
                            <div class="col-md-3 form-group mb-1">
                                <label class="col-form-label"  for="insurance_co">Insurance Co</label>
                                <select name="insurance_co" id="insurance_co" class="form-control form-control-sm">
                                    <option value="" disabled selected>{{ $vehicle_insurances->count() > 0 ? 'Select One' : 'Please Create Vehicle Insurance Master first' }}</option>
                                    @forelse ($vehicle_insurances as $vehicle_insurance)
                                    <option value="{{ $vehicle_insurance->id }}">{{  $vehicle_insurance->name ?? "" }}</option>
                                    @empty
                                        
                                    @endforelse
                                </select>
                            </div>
                            <div class="col-md-3 form-group mb-1">
                                <label class="col-form-label"  for="insurance_no">Insurance no</label>
                                <input class="form-control form-control-sm" placeholder="Enter Insurance no" id="insurance_no" name="insurance_no" value="" type="text" />
                            </div>
                            <div class="col-md-3 form-group mb-1">
                                <label class="col-form-label"  for="insurance_issue_date">Insurance Issue Date</label>
                                <input class="form-control form-control-sm" placeholder="Enter Issue date" id="insurance_issue_date" name="insurance_issue_date" type="date"  />
                            </div>
                            <div class="col-md-3 form-group mb-1">
                                <label class="col-form-label"  for="insurance_expiry_date">Insurance Expiry Date</label>
                                <input class="form-control form-control-sm" placeholder="Enter Expiry Date" id="insurance_expiry_date" name="insurance_expiry_date" value="" type="date"  />
                            </div>
                            <div class="col-md-3 form-group mb-1">
                                <label class="col-form-label"  for="mortgaged_by">Mortgaged by</label>
                                <select name="mortgaged_by" id="mortgaged_by" class="form-control form-control-sm">
                                    <option value="" disabled selected>{{ $vehicle_categories->count() > 0 ? 'Select One' : 'Please Create Vehicle Mortgage Master first' }}</option>
                                    @forelse ($vehicle_mortgages as $vehicle_mortgage)
                                        <option value="{{ $vehicle_mortgage->id }}">{{ $vehicle_mortgage->name ?? '' }}</option>
                                    @empty
                                        
                                    @endforelse
                                </select>                                
                            </div>
                            <div class="col-md-3 form-group mb-1">
                                <label class="col-form-label"  for="vehicle_mortgage_no">Mortgaged No</label>
                                <input class="form-control form-control-sm" placeholder="Enter Mortgaged By" id="vehicle_mortgage_no" name="vehicle_mortgage_no" type="text"  />
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-title mb-3">Attachments</div>
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
                        </div>
                        <div class="float-right mt-1">
                            {{-- <a href="" class="btn btn-secondary btn-sm" type="button" data-dismiss="modal">Close</a> --}}
                            <button class="btn btn-info btn-sm" type="submit" >Save</button>
                        </div>
                    </div>
                </div>
            </div>
            
        </form>
    </div>
@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
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
                        title: 'Missing Bikes',
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

            $('select').select2({
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
        $('#form_type').change(function() {
            var id = ($('#form_type').val());
            $("#titles").show();
            $(".sam").hide();
            $("#"+id).show();
        });

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
     <script type="text/javascript">
        @if(Session::has('message') && ($current_plate_nos))
            $(window).on('load', function() {
                $('#plateReplaceModal').modal('show');
            });
        @endif
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
