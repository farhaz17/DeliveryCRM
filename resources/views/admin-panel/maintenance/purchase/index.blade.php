@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        button#add_to_list {
    margin-top: 23px;
}
button.btn.btn-danger.btn-block.btn-sm.delete_activity {
    margin-top: 22px;
}
    </style>
@endsection
@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Maintenance</a></li>
        <li class="breadcrumb-item"><a href="#">Purhcase</a></li>
      <li class="breadcrumb-item active" aria-current="page">Create A Purchase</li>
    </ol>
</nav>
<form action="{{ route('purchase.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">

     <div class="col-1  mb-2">
     </div>

            <div class="card col-10  mb-2">
                <div class="card-title mb-3 col-12">Add Purhcase</div>
                <div class="card-body" id="activity-list-holder">
                    <div class="row" id="">
                        <div class="col-md-9 form-group mb-1">
                            <label for="repair_category">Select Supplier</label>
                            <select id="supplier" name="supplier" class="form-control-sm col-md-12" required>
                                <option value=""   >Select option</option>
                                @foreach($supplier as $row)
                                    <option value="{{ $row->id }}">{{ $row->contact_name  }}</option>
                                @endforeach
                            </select>

                            {{-- <input class="form-control form-control-sm" id="activity_input" type="text" placeholder="Select Supplier" name="license_activity[]"> --}}
                        </div>
                    </div>



                    <div class="row" id="">
                        <div class="col-md-3 form-group ">
                            {{-- <input class="form-control form-control-sm" id="activity_input" type="text" placeholder="Select Part No" name="license_activity[]"> --}}

                            <label for="repair_category">Select Part</label>
                            <select id="parts" name="parts[]" class="form-control-sm col-md-12" required>
                                <option value=""   >Select option</option>
                                @foreach($parts as $row)
                                    <option value="{{ $row->id }}">{{ $row->part_name  }}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="col-md-3 form-group ">
                            <label for="repair_category">Price</label>
                            <input class="form-control form-control-sm" id="price" type="text" placeholder="Enter Price" required name="price[]">
                        </div>

                        <div class="col-md-3 form-group ">
                            <label for="repair_category">Select Quantity</label>
                            <input class="form-control form-control-sm" id="activity_input" required type="text" placeholder="Select Qty" name="qty[]">
                        </div>
                        <div class="col-md-2 form-group mb-1">
                            <button class="btn btn-primary btn-block btn-sm" id="add_to_list" type="button">Add More</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-1  mb-2">
            </div>
        </div>
        <div class="row">
            <div class="col-1  mb-2">
            </div>
            <div class="card col-10  mb-2">

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-primary btn-sm" type="submit">Submit</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-10  mb-2">
            </div>

        </div>
    <div class="col-2  mb-2">
    </div>


</form>
@endsection
@section('js')
<script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
<script>



    $("#part").select2();
    var member_row_number = 1;

    $(document).ready(function(){
        $('#add-more-member-holder').on('click', '.delete_btn', function() {
            var ids = $(this).attr('data-row_id');

        });


        $('#supplier').select2();
        $('#parts').select2();

    });
    var activity_row_number = 1;
    var count = 1;
    $('#add_to_list').click(function(){

        var new_activity_row = `<div class="row" id="activity_row`+ activity_row_number+ `">
            <div class="col-md-3 form-group mb-1">
                <label for="repair_category">Select Part</label>
                <select id="parts`+ count+ `" name="parts[]" class="form-control-sm col-md-12" required>
                        <option value=""   >Select option</option>
                        @foreach($parts as $row)
                            <option value="{{ $row->id }}">{{ $row->part_name  }}</option>
                        @endforeach
                    </select>

            </div>
            <div class="col-md-3 form-group ">
                    <label for="repair_category">Price</label>
                    <input class="form-control form-control-sm"  id="price" type="text" required placeholder="Enter Price" name="price[]">
            </div>

            <div class="col-md-3 form-group ">
                <label for="repair_category">Select Quantity</label>
                    <input class="form-control form-control-sm" id="activity_input" required type="text" placeholder="Select Qty" name="qty[]">
                </div>
            <div class="col-md-2 form-group mb-1">
                <button class="btn btn-danger btn-block btn-sm delete_activity" id="" required data-activity_row_id = "activity_row`+activity_row_number+`">Delete Activity</button>
            </div>
        </div>`;

        $('#activity-list-holder').append(new_activity_row);
        $('#parts'+count).select2();
        count++;
        $('#parts' + new_activity_row).select2();
        activity_row_number++

    });

    $(document).ready(function(){
        $('#activity-list-holder').on('click', '.delete_activity', function() {
            var ids = $(this).attr('data-activity_row_id');
            $("#"+ids).remove();
        });
    });


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
