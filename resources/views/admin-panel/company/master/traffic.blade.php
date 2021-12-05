@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        
        </style>
@endsection
@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/user-dashboard-new') }}">All Modules</a></li>
        <li class="breadcrumb-item"><a href="{{ route('company_wise_dashboard',['active'=>'master-menu-items']) }}">Company Master</a></li>
        <li class="breadcrumb-item active" aria-current="page">License</li>
    </ol>
</nav>
<form action="{{ route('company_master_traffic_store') }}" method="post" enctype="multipart/form-data" id="traffic_form">
    @csrf
    <div class="card col-md-12">
        <div class="card-title mb-3 col-12">Traffic For</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 form-group mb-1">
                    <label class="radio radio-outline-primary">
                        <input type="radio"  class=""  name="traffic_for" value="1" required><span>Zone Group</span><span class="checkmark"></span>
                    </label>
                </div>
                <div class="col-md-3 form-group mb-1">
                    <label class="radio radio-outline-primary">
                        <input type="radio" class="" name="traffic_for" value="2"><span>Personal</span><span class="checkmark"></span>
                    </label>
                </div>
                <div class="col-md-3 form-group mb-1">
                    <label class="radio radio-outline-primary">
                        <input type="radio" class=""  name="traffic_for" value="3"><span>Customer Or Supplier</span><span class="checkmark"></span>
                    </label>
                </div>
                <hr>
            </div>
        </div>
        <div class="card-body" id="add-more-traffic-holder">
            <div class="row">
                <div class="col-md-3 form-group mb-1" id="traffic_company_id_holder"></div>
                <div class="col-md-3 form-group mb-1">
                    <label for="traffic_state">Traffic State</label>
                    <select class="form-control form-control-sm" name="traffic_state[]">
                        <option value="">Select One</option>
                        @forelse ($states as $state)
                            <option value="{{$state->id}}">{{ $state->name }}</option>
                        @empty
                            <p>No State found!</p>
                        @endforelse
                    </select>
                </div>
                <div class="col-md-2 form-group mb-1">
                    <label for="traffic_fle_no">Trafic file no.</label>
                    <input class="form-control form-control-sm" id="" type="text" placeholder="" name="traffic_file_no[]" id="traffic_file_no">
                </div>
                <div class="col-md-3 form-group mb-1">
                    <label for="traffic_attachment">Traffic Attachment</label>
                    <input class="form-control-file form-control-sm" name="traffic_attachment[]" id="traffic_attachment" type="file" placeholder="">
                </div>
                <div class="col-md-1">
                    <button class="btn btn-primary btn-sm" id="add_more_traffic_btn" type="button">Add more</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <button class="btn btn-primary btn-sm" type="submit">Submit</button>
                </div>
            </div>
        </div>
    </div>
</form>
<form action="{{ route('company_master_salik_store') }}" method="post" enctype="multipart/form-data" id="salik_form">
    @csrf
    <div class="card col-md-12">
        <div class="card-title mb-3 col-12">Salik For</div>
        <div class="card-body" id="add-more-salik-holder">
            <div class="row">
                <div class="col-md-3 form-group mb-1">
                    <label class="radio radio-outline-primary">
                        <input type="radio"  class=""  name="salik_for" value="1" required><span>Zone Group</span><span class="checkmark"></span>
                    </label>
                </div>
                <div class="col-md-3 form-group mb-1">
                    <label class="radio radio-outline-primary">
                        <input type="radio" class="" name="salik_for" value="2"><span>Personal</span><span class="checkmark"></span>
                    </label>
                </div>
                <div class="col-md-3 form-group mb-1">
                    <label class="radio radio-outline-primary">
                        <input type="radio" class=""  name="salik_for" value="3"><span>Customer Or Supplier</span><span class="checkmark"></span>
                    </label>
                </div>
                <hr>
            </div>
            <div class="row">
                <div class="col-md-3 form-group mb-1" id="salik_company_id_holder"></div>
                <div class="col-md-3 form-group mb-1">
                    <label for="traffic_state">State</label>
                    <select class="form-control form-control-sm" name="salik_state[]">
                        <option value="">Select One</option>
                        @forelse ($states as $state)
                            <option value="{{$state->id}}">{{ $state->name }}</option>
                        @empty
                            <p>No State found!</p>
                        @endforelse
                    </select>
                </div>
                <div class="col-md-2 form-group mb-1">
                    <label for="salik_acc">Salik no.</label>
                    <input class="form-control form-control-sm" id="" type="text" placeholder="" name="salik_acc[]" id="salik_acc">
                </div>
                <div class="col-md-3 form-group mb-1">
                    <label for="salik_attachment">Salik Attachment</label>
                    <input class="form-control-file form-control-sm" name="salik_attachment[]" id="salik_attachment" type="file" placeholder="">
                </div>
                <div class="col-md-1">
                    <button class="btn btn-primary btn-sm" id="add_more_salik_btn" type="button">Add More</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <button class="btn btn-primary btn-sm" type="submit">Submit</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
@section('js')
<script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
<script>
    $('.select2').select2();
</script>
<script>
     var traffic_row_number = 1;
    $('#add_more_traffic_btn').click(function(){
        var new_traffic_row = `<div class="row" id="row`+traffic_row_number+`">
                <div class="col-md-3 form-group mb-1"></div>
                <div class="col-md-3 form-group mb-1">
                    <label for="traffic_state">State</label>
                    <select class="form-control form-control-sm" name="traffic_state[]">
                        <option value="">Select One</option>
                        @forelse ($states as $state)
                            <option value="{{$state->id}}">{{ $state->name }}</option>
                        @empty
                            <p>No State found!</p>
                        @endforelse
                    </select>
                </div>
                <div class="col-md-2 form-group mb-1">
                    <label for="traffic_fle_no">Trafic file no.</label>
                    <input class="form-control form-control-sm" id="" type="text" placeholder="" name="traffic_file_no[]" id="traffic_file_no">
                </div>
                <div class="col-md-3 form-group mb-1">
                    <label for="traffic_attachment">Traffic Attachment</label>
                    <input class="form-control-file form-control-sm" id="traffic_attachment" type="file" placeholder="" name="traffic_attachment[]">
                </div>
                <div class="col-md-1 form-group mb-1">
                        <label for="">&nbsp;</label>
                        <button class="btn btn-danger btn-sm delete_btn" data-row_id = "row`+traffic_row_number+`">Delete</button>
                    </div>
            </div>`;
        $('#add-more-traffic-holder').append(new_traffic_row);
        traffic_row_number++
    });

    $(document).ready(function(){
        $('#add-more-traffic-holder').on('click', '.delete_btn', function() {
            var ids = $(this).attr('data-row_id');
            $("#"+ids).remove();
        });
    });

</script>

<script>
    $(document).ready(function(){
        $('#add-more-salik-holder').on('click', '.delete_btn', function() {
            var ids = $(this).attr('data-row_id');
            $("#"+ids).remove();
        });
    });
    var salik_row_number = 1;
    $('#add_more_salik_btn').click(function(){
        var new_salik_row = `<div class="row"id="row`+salik_row_number+`">
                <div class="col-md-3 form-group mb-1"></div>
                <div class="col-md-3 form-group mb-1">
                    <label for="traffic_state">State</label>
                    <select class="form-control form-control-sm" name="salik_state[]">
                        <option value="">Select One</option>
                        @forelse ($states as $state)
                            <option value="{{$state->id}}">{{ $state->name }}</option>
                        @empty
                            <p>No State found!</p>
                        @endforelse
                    </select>
                </div>
                <div class="col-md-2 form-group mb-1">
                    <label for="salik_acc">Salik no.</label>
                    <input class="form-control form-control-sm" id="" type="text" placeholder="" name="salik_acc[]" id="salik_acc">
                </div>
                <div class="col-md-3 form-group mb-1">
                    <label for="salik_attachment">Salik Attachment</label>
                    <input class="form-control-file form-control-sm" id="salik_attachment" type="file" placeholder="" name="salik_attachment[]">
                </div>
                <div class="col-md-1">
                    <button class="btn btn-danger btn-sm delete_btn" data-row_id = "row`+salik_row_number+`">Delete</button>
                </div>
            </div>`;
        $('#add-more-salik-holder').append(new_salik_row);
        salik_row_number++
    });
    $(document).ready(function(){
        $('#add-more-salik-holder').on('click', '.delete_btn', function() {
            var ids = $(this).attr('data-row_id');
            $("#"+ids).remove();
        });
    });
    $(document).ready(function(){
        $('input[name=traffic_for]').change(function(){
            var traffic_for = $(this).val();
            $.ajax({
                url: "{{ route('get_ajax_traffic_for_data') }}"+"?traffic_for="+traffic_for,
                success: function(response){
                    $('#traffic_company_id_holder').empty()
                    $('#traffic_company_id_holder').append(response.html)
                    $('#traffic_company_id_holder select').select2({
                        placeholder: 'Select One'
                    });
                }
            })
        })
    });
    $(document).ready(function(){
        $('input[name=salik_for]').change(function(){
            var salik_for = $(this).val();
            $.ajax({
                url: "{{ route('get_ajax_salik_for_data') }}"+"?salik_for="+salik_for,
                success: function(response){
                    $('#salik_company_id_holder').empty()
                    $('#salik_company_id_holder').append(response.html)
                    $('#salik_company_id_holder select').select2({
                        placeholder: 'Select One'
                    });
                }
            })
        })
    });
    
</script>
<script>
    function tostr_display(type,message){
        switch(type){
            case 'info':
                toastr.info(message, "Information!", { timeOut:10000 , progressBar : true});
                break;
            case 'warning':
                toastr.warning(message, "Warning!", { timeOut:10000 , progressBar : true});
                break;
            case 'success':
                toastr.success(message, "Success!", { timeOut:10000 , progressBar : true});
                break;
            case 'error':
                toastr.error(message, "Failed!", { timeOut:10000 , progressBar : true});
                break;
            }
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
@endsection