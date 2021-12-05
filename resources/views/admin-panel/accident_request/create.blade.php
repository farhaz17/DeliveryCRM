
@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .ul_cls_scroll{
            height: 324px;
            overflow: auto;
        }
        /*.ul_cls_scroll:hover{*/
        /*    overflow-y: scroll;*/
        /*}*/
    </style>
    <style>
        /* css for type ahead only */
        .col-lg-12.sugg-drop_checkout {
            width: 400px;
            line-height: 12px;
            font-size: 12px;
            /*border: 1px solid #775dd0;*/
            /*padding-top: 15px;*/
            /*padding-bottom: 15px;*/

        }
        span#drop-full_name {
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
            background: #ffffff;
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
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/user-dashboard-new') }}">All Modules</a></li>
            <li class="breadcrumb-item"><a href="{{ route('dc_wise_dashboard',['active'=>'operations-menu-items']) }}">DC Operations</a></li>
            <li class="breadcrumb-item active" aria-current="page">Accident Rider Request</li>
        </ol>
    </nav>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title mb-3  text-danger">Make new Request for Accident Rider</div>
                    <form method="post" action="{{ route('save_accident_request')  }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 form-check-inline mb-3 text-center" id="name_div" style="display: none;" >
                                <label class="radio-outline-success ">Name:</label>
                                <h6 id="name_passport" class="text-dark ml-3">PP52026</h6>
                                <input type="hidden" id="rider_selected_passport_id" name="rider_passport_id">
                                <label class="radio-outline-success   font-weight-bold mr-3 ml-3 ">Platform:</label>
                                <h6 id="name_passport_checkout_platform_name" class="text-dark ml-3 "></h6>
                                <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                <label class="radio-outline-success   font-weight-bold ">Chekin Date & Time:</label>
                                <h6 id="name_passport_checkout_checkin" class="text-dark ml-3 "></h6>
                            </div>
                        </div>
                        <div class="row ">
                            <div class="col-md-4 form-group mb-3 append_div">
                                <label for="keyword">Search Rider <b>(Required)</b></label>
                                <input class="form-control form-control-sm typeahead"  id="keyword" autocomplete="off"  name="search" value="" type="text"  required />
                                <div class="input-group-append"></div>
                            </div>
                            <div class="col-md-4 form-group mb-3">
                                <label for="checkout_date">Checkout Date <b>(Required)</b></label>
                                <input type="datetime-local" class="form-control form-control-sm" autocomplete="off" name="checkout_date" id="checkout_date" required>
                            </div>
                            <div class="col-md-4 form-group mb-3  " >
                                <label for="checkout_type">Select Checkout type <b>(Required)</b></label>
                                <select class="form-control form-control-sm " name="checkout_type" id="checkout_type"  required >
                                    <option value="" selected disabled >select an option</option>
                                    <option value="1"  >Complete Checkout</option>
                                    <option value="2"  >Only Bike Replacement</option>

                                </select>
                            </div>
                            <div class="col-md-12 form-group mb-3  " >
                                <label for="remarks">Enter Remarks <b>(Optional)</b></label>
                                    <textarea class="form-control form-control-sm" name="remarks" id="remarks"></textarea>
                             </div>


                        </div>
                        <div class="row">
                            <div class="col-md-12 form-group mb-3">
                                <button class="btn btn-sm btn-primary float-right" type="submit">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script>
        tail.DateTime("#expected_date",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,
        });

    </script>
    <script>
        var path_autocomplete = "{{ route('autocomplete_checkin_platform') }}";
        var get_information_path = "{{ route('get_passport_name_detail') }}";
    </script>
    <script src="{{ asset('js/custom_js/dc_request_checkout.js') }}"></script>
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
