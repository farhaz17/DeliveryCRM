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
        <li class="breadcrumb-item"><a href="{{ route('vehicle_wise_dashboard',['active'=>'operations-menu-items']) }}">LPO Operation</a></li>
      <li class="breadcrumb-item active" aria-current="page">Create Lpo Vehicle</li>
    </ol>
</nav>

<form method="post" action="{{ route('store-lpo-vehicle')}}" enctype="multipart/form-data">
    @csrf
    <div class="card container m-auto p-3">
        <div>
            <a href="{{asset('assets/docs/vehicle-info.xlsx')}}" class="btn btn-primary mb-2" download="vehicle-info.xlsx">Vehicle Sample</a>
            <a href="{{asset('assets/docs/spare-parts.xlsx')}}" class="btn btn-primary mb-2" download="spare-parts.xlsx">Spare Parts Sample</a>
        </div>
        <div class="row">
            <div class="col-md-4">
                <label for="repair_category">Select Inventory</label><br>
                <input type="radio" id="vehicle" name="inventory_type" value="1" required>
                <label for="vehicle">Vehicle</label><br>
                <input type="radio" id="spare" name="inventory_type" value="2" required>
                <label for="spare">Spare Parts</label><br>
            </div>
            {{-- <div class="col-md-4 contract-type" style="display: none">
                <label for="repair_category">Select Type</label>
                <select id="contractType" class="form-control" name="contract_type">
                    <option value="" disabled selected>Select Type</option>
                    <option value="1">Rental</option>
                    <option value="2">Company</option>
                    <option value="3">Lease To Own</option>
                </select>
            </div> --}}
            <div class="col-md-4 lpo-no" style="display: none">
                <label for="repair_category">Select LPO Number</label>
                <select id="lpoId" class="form-control" name="lpo_no">
                    <option value="" disabled selected>Select LPO</option>
                </select>
            </div>
            <div class="col-md-4 vehicle" style="display: none">
                <label>Upload Vehicle Info</label>
                <div class="custom-file mb-3">
                <input type="file" class="custom-file-input" id="customFile" name="vehicle_info">
                <label class="custom-file-label" for="customFile">Choose file</label>
                </div>
            </div>
            <div class="col-md-12 mt-3 text-center">
                <input type="submit" class="btn btn-primary" value="Add">
            </div>
        </div>
    </div>
</form>

@endsection

@section('js')

<script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

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

    $('#selectState').select2({
        placeholder: 'Select the state',
        width: '100%'
    });

    $("input[name='inventory_type']").on('change',function(){
        var token = $("input[name='_token']").val();
        var inventoryType  =  $(this).val();
        $(".lpo-no").show()
        $('.appended-lpo').remove('.appended-lpo')
        $.ajax({
            url: "{{ route('ajax-filter-lpo-vehicle-info') }}",
            method: 'POST',
            data:{inventory_type:inventoryType,_token:token},
            success: function (response) {
                $.each(response, function(key,value){
                    $("#lpoId").append('<option class="appended-lpo" value="'+value.id+'">'+value.lpo_no+'</option>');
                });
            }
        });
    });

    $(document).on("change", ".lpo-no", function(){
        $(".vehicle").show()
    })

</script>


@endsection
