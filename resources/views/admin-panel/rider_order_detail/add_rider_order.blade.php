@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        .col-lg-12.sugg-drop {
            width: 550px;
            line-height: 12px;
            font-size: 12px;
            /*border: 1px solid #775dd0;*/
            /*padding-top: 15px;*/
            /*padding-bottom: 15px;*/

        }
        .col-lg-12.sugg-drop_checkout {
            width: 550px;
            line-height: 12px;
            font-size: 12px;
            /*border: 1px solid #775dd0;*/
            /*padding-top: 15px;*/
            /*padding-bottom: 15px;*/

        }

        span#full_name_drop {
            font-size: 10px;
        }
        ul.typeahead.dropdown-menu {
            height: 400px;
            overflow: hidden;
            width: 770px;

        }
        ul.typeahead.dropdown-menu:hover {
            height: 400px;
            overflow: scroll;

        }
        #clear {
            position: relative;
            float: right;
            height: 20px;
            width: 21px;
            top: 7px;
            right: 28px;
            border-radius: 20px;
            background: #f1f1f1;
            color: white;
            font-weight: bold;
            text-align: center;
            cursor: pointer;
            font-size: 14px;
        }
        #clear:hover {
            background: #ccc;
        }
        .input-group-prepend {
            border-left: none;
        }
        input#keyword {
            border-right: none;
            background: #ffffff;
            border-left: none;
        }
        span#basic-addon2 {
            border-left: none;
        }
        hr {
            margin-top: 0rem;
            margin-bottom: 0rem;
            border: 0;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
            height: 0;
        }
        #drop-full_name {
            font-weight: 700;
        }
        #drop-bike {
            font-weight: 700;
            color: #FF0000;
        }
        span#drop-name {
            color: #010165;
        }
    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Masters</a></li>
            <li>Rider Order</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>


    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="col-md-5 form-check-inline mb-3 text-center" id="name_div" style="display: none;" >
                        <label class="radio-outline-success ">Name:</label>
                        <h6 id="name_passport" class="text-dark ml-3 font-weight-bold text-primary"></h6>
                    </div>

                    <div class="card-title mb-3">Add Rider Order</div>
                    <form method="post" action="{{ route('save_rider_order') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="id" name="id" value="">
                        <div class="row ">
                            <div class="col-md-4 form-group mb-3 append_div">
                                <label for="repair_category">Search Passport/PPUID/ZDS Code</label><br>
                                <div class="input-group ">
                                    <div class="input-group-prepend"><span class="input-group-text bg-transparent" id="basic-addon1"><i class="i-Magnifi-Glass1"></i></span></div>
                                    <input class="form-control form-control-sm typeahead " id="keyword" autocomplete="off" type="text" name="search_value" placeholder="search..." aria-label="Username" required aria-describedby="basic-addon1">
                                    <div class="input-group-append"><span class="input-group-text bg-transparent" id="basic-addon2"><i class="i-Search-People"></i></span></div>
                                    <div id="clear">
                                        X
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-4 form-group mb-3">
                                <input type="hidden" name="user_passport_id" />
                                <label for="start_date_time">Start data and time</label>
                                <input class="form-control form-control-sm" id="start_date_time" name="start_date_time" value="  "  type="datetime-local" required />
                            </div>

                            <div class="col-md-4 form-group mb-3">
                                <label for="end_date_time">End date and time</label>
                                <input class="form-control form-control-sm" id="end_date_time" name="end_date_time" value="  "  type="time"  required />
                            </div>

                            <div class="col-md-4 form-group mb-3">
                                <label for="total_order">Enter Order</label>
                                <input class="form-control form-control-sm" id="total_order" name="total_order" value="" type="number" required />
                            </div>

                            <div class="col-md-4 form-group mb-3">
                                <label for="image">Upload Image</label>
                                <input class="form-control-file form-control-sm" id="image" name="image" type="file" required />
                            </div>

                            <div class="col-md-12">
                                <button class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    {{--<div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">--}}
    {{--<div class="modal-dialog modal-sm">--}}
    {{--<div class="modal-content">--}}
    {{--<form action="" id="deleteForm" method="post">--}}
    {{--<div class="modal-header">--}}
    {{--<h5 class="modal-title" id="exampleModalCenterTitle-1">Deletion Confirmation</h5>--}}
    {{--<button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>--}}
    {{--</div>--}}
    {{--<div class="modal-body">--}}
    {{--{{ csrf_field() }}--}}
    {{--{{ method_field('DELETE') }}--}}
    {{--Are you sure want to delete the data?--}}
    {{--</div>--}}
    {{--<div class="modal-footer">--}}
    {{--<button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>--}}
    {{--<button class="btn btn-primary ml-2" type="submit" onclick="deleteSubmit()">Delete it</button>--}}
    {{--</div>--}}
    {{--</form>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}

@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>

    <script>
            @if(Session::has('message'))
        var type = "{{ Session::get('alert-type', 'info') }}";
        switch(type){
            case 'info':
                toastr.info("{{ Session::get('message') }}");
                break;

            case 'warning':
                toastr.warning("{{ Session::get('message') }}");
                break;

            case 'success':
                toastr.success("{{ Session::get('message') }}");
                break;

            case 'error':
                toastr.error("{{ Session::get('message') }}");
                break;
        }
        @endif
    </script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>

    <script src="{{ asset('js/custom_js/rider_order_passport.js') }}"></script>

    <script>
        $(document).ready(function () {


            $('#platform_id').select2({
                placeholder: 'Select an option'
            });

        });

    </script>


@endsection
