@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <style>
        .submit-btn {
    margin-top: 24px;
        }
    #datatable .table th, .table td{
        border-top : unset !important;
    }
    .table th, .table td{
        padding: 0px !important;
    }
    .table th{
        padding: 2px;
        font-size: 14px;
    }
    .table td{
        /*padding: 2px;*/
        font-size: 14px;
    }
    .table th{
        padding: 2px;
        font-size: 14px;
        font-weight: 600;
    }


    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Masters</a></li>
            <li>Parts</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title mb-3">Parts Details</div>
                    <form method="post" action="{{isset($parts_data)?route('parts.update',$parts_data->id):route('parts.store')}}">
                        {!! csrf_field() !!}
                        @if(isset($parts_data))
                            {{ method_field('PUT') }}
                        @endif
                        <input type="hidden" id="id" name="id" value="{{isset($parts_data)?$parts_data->id:""}}">

                        <div class="row">
                            <div class="col-md-6 form-group mb-1">
                                <label for="repair_category">Part Name</label>
                                <input class="form-control" id="part_name" name="part_name"
                                 value="{{isset($parts_data)?$parts_data->part_name:""}}" type="text"
                                  placeholder="Enter the part name" />
                            </div>
                            <div class="col-md-6 form-group mb-1">
                                <label for="repair_category">Part Number</label>
                                <input class="form-control" id="part_number"
                                 name="part_number" value="{{isset($parts_data)?$parts_data->part_number:""}}" type="text"
                                 placeholder="Enter the part number" required />
                            </div>

                            <div class="col-md-6 form-group mb-1">
                                <label for="repair_category">OEM</label>
                                <input class="form-control" id="oem"
                                 name="oem" value="{{isset($parts_data)?$parts_data->oem:""}}" type="text"
                                 placeholder="Enter the part number" required />
                            </div>

                            <div class="col-md-6 form-group mb-1">
                                <label for="repair_category">Counter Fit</label>
                                <input class="form-control" id="counter_fit"
                                 name="counter_fit" value="{{isset($parts_data)?$parts_data->counter_fit:""}}" type="text"
                                 placeholder="Enter the Counter Fit" required />
                            </div>


                            <div class="col-md-6 form-group mb-1">
                                <label for="repair_category">Super Seed</label>
                                <input class="form-control" id="super_seed"
                                 name="super_seed" value="{{isset($parts_data)?$parts_data->super_seed:""}}" type="text"
                                 placeholder="Enter the Super Seed" required />
                            </div>

                            <div class="col-md-6 form-group mb-1">
                                <label for="repair_category">Other </label>
                                <input class="form-control" id="other"
                                 name="other" value="{{isset($parts_data)?$parts_data->other:""}}" type="text"
                                 placeholder="Other" required />
                            </div>

                            <div class="col-md-6 form-group mb-1">
                                <label for="repair_category">Category </label>
                                <input class="form-control" id="category"
                                 name="category" value="{{isset($parts_data)?$parts_data->category:""}}" type="text"
                                 placeholder="category" required />
                            </div>

                            <div class="col-md-6 form-group mb-1">
                                 <button class="btn btn-primary submit-btn">@if(isset($parts_data)) Edit @else Create  @endif Part</button>
                            </div>
                        </div>



                        <div class="row">
                            <div class="col-md-6 form-group mb-1">
                                <label for="repair_category">Fixed Price </label>
                                <input class="form-control" id="price_fixed"
                                 name="price_fixed" value="{{isset($parts_data)?$parts_data->category:""}}" type="text"
                                 placeholder="Fixed" />
                            </div>

                            <div class="col-md-6 form-group mb-1">
                                <label for="repair_category">Average Price </label>
                                <input class="form-control" id="price_avg"
                                 name="price_avg" value="{{isset($parts_data)?$parts_data->category:""}}" type="text"
                                 placeholder="Average Price"  />
                            </div>
                        </div>



                        {{-- <div class="row">
                            <div class="col-md-12 form-group mb-3">

                            </div>
                            <div class="col-md-12 form-group mb-3">

                            </div>
                            <div class="col-md-12">

                            </div>
                        </div> --}}
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-12 loading_msg" style="display: none">
        <div class="row">
            <div class="col-sm-4">
            </div>
            <div class="col-sm-4">
                <div class="loader-bubble loader-bubble-primary m-5"></div>
                <div class="loader-bubble loader-bubble-danger m-5" ></div>
                <div class="loader-bubble loader-bubble-success m-5" ></div>
            </div>
            <div class="col-sm-4">
            </div>
        </div>
    </div>

    <div class="col-md-12 mb-3">
    <div class="ajax_table_load">

    </div>
    </div>



@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
<script>
    $( document ).ready(function() {
            $.ajax({
                    url: "{{ route('get_parts_ajax_table') }}",
                    dataType: 'json',
                    success: function (response) {
                        $(".ajax_table_load").empty();
                        $('.ajax_table_load').append(response.html);
                    }
                });
});
</script>
<script>

$(document).ready(function (e){
    $("#careerForm").on('submit',(function(e){
        e.preventDefault();
        $.ajax({
            url: "http://localhost/zone_repair/public/vendor_registration",
            type: "POST",
            data:  new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            success: function(response){
                $("#careerForm").trigger("reset");
                if(response.code == 100) {
                    Swal.fire(
                        'Thank You',
                        'Your Application Successfully Sent!',
                        'success'
                    )
                }
                else {
                    Swal.fire(
                        'Oops',
                        response.message.message,
                        'error'
                    )
                }
            },
            error: function(){}
        });
    }));
});
</script>

    <script>
        $(document).ready(function () {
            'use strict';

            $('#datatable').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [0],"visible": false},
                    {"targets": [1][2],"width": "40%"}
                ],
                "scrollY": false,
            });

        });

        // {{--function deleteData(id)--}}
        // {{--{--}}
        //     {{--var id = id;--}}
        //     {{--var url = '{{ route('parts.destroy', ":id") }}';--}}
        //     {{--url = url.replace(':id', id);--}}
        //     {{--$("#deleteForm").attr('action', url);--}}
        // {{--}--}}

        // {{--function deleteSubmit()--}}
        // {{--{--}}
        //     {{--$("#deleteForm").submit();--}}
        // {{--}--}}
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
