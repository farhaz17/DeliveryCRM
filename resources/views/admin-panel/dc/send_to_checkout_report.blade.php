
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
            <li><a href="">Send To Checkout Report</a></li>
            <li>Send Rider To Checkout Report</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>



    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="card-title mb-3">Send To checkout Report</div>
                    <form method="post" action="{{ route('send_to_direct_checkout_save')  }}" enctype="multipart/form-data">
                        {!! csrf_field() !!}


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
                            <div class="col-md-3 form-group mb-3 append_div">
                                <label for="repair_category">Search Rider <b>(Required)</b></label>
                                <input class="form-control form-control-rounded typeahead"  id="keyword" autocomplete="off"  name="search" value="" type="text"  required />
                                <div class="input-group-append"></div>
                            </div>

                            <div class="col-md-3 form-group mb-3">
                                <label for="repair_category">Checkout Date <b>(Required)</b></label>
                                <input type="datetime-local" class="form-control" autocomplete="off" name="checkout_date" id="checkout_date" required>
                            </div>

                            <div class="col-md-3 form-group mb-3  " >
                                <label for="repair_category">Select Checkout type <b>(Required)</b></label>
                                <select class="form-control  " name="checkout_type" id="checkout_type"  >
                                    <option value="" selected disabled >select an option</option>
                                    @foreach(get_checkout_type_names() as $key => $v)
                                        <option value="{{ $key }}">{{ $v }}</option>
                                    @endforeach
                                </select>
                            </div>




                            <div class="col-md-3 form-group mb-3  " >
                                <label for="repair_category">Enter Remarks <b>(Optional)</b></label>
                                <textarea class="form-control" name="remarks"></textarea>
                            </div>


                            <div class="col-md-3 expected_div_cls mb-3" style="display: none">
                                <label for="repair_category">Expected Date To Return</label>
                                <input type="text" autocomplete="off" id="expected_date" name="expected_date" readonly class="form-control">
                            </div>

                            <div class="col-md-3 form-group mb-3 shuffle_div_cls " style="display: none;" >
                                <label for="repair_category">Select Shuffle type <b>(Required)</b></label>
                                <select class="form-control  " name="shuffle_type" id="shuffle_type"  >
                                    <option value="" selected disabled >select an option</option>
                                    <option value="1">Immediate Shuffle</option>
                                    <option value="2" >Until Interview pass</option>
                                </select>
                            </div>


                        </div>






                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <button class="btn btn-primary " type="submit">Save</button>
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
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

    <script>
        tail.DateTime("#expected_date",{
            dateFormat: "YYYY-mm-dd",
            timeFormat: false,

        });


        $("#checkout_type").change(function () {
            var selected_val = $(this).val();

            if(selected_val=="2" || selected_val=="1" || selected_val=="10" || selected_val=="11" || selected_val=="6" || selected_val=="5"){
                $(".expected_div_cls").show();
                $("#expected_date").attr("required",true);
            }else{
                $(".expected_div_cls").hide();
                $("#expected_date").attr("required",false);
            }

            if(selected_val=="1"){
                $(".shuffle_div_cls").show();
                $("#shuffle_type").prop('required',true);
            }else{
                $(".shuffle_div_cls").hide();
                $("#shuffle_type").prop('required',false);
            }


        });



    </script>



    <script>
        var path_autocomplete = "{{ route('autocomplete_send_checkout_report') }}";
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
