@extends('admin-panel.base.main')
@section('css')
<link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
<link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
<link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
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
<div class="breadcrumb">
    <h1 class="mr-2">Home</h1>
    <ul>
        <li><a href="">Close Month</a></li>
        <li>Close Month</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>
{{--question modal start here--}}
<div class="modal fade bd-example-modal-sm"  id="question_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle-1">Confirmation</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                Are you sure to close month.?
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">No</button>
                <button class="btn btn-primary ml-2" type="button"  id="yes_btn">Yes</button>
            </div>
        </div>
    </div>
</div>

{{--question modal end here--}}
<div class="row">
    <div class="col-md-12 mb-3">
        {{--accordian start--}}
        {{-- <div class="accordion" id="accordionRightIcon2" style="margin-bottom: 10px;">
            <div class="card">
                <div class="card-header header-elements-inline">
                    <h6 class="card-title ul-collapse__icon--size ul-collapse__right-icon mb-0 "><a class="text-default collapsed collapse_cls_pending" data-toggle="collapse" href="#accordion-item-icons-2" aria-expanded="false"><span><i class="i-Filter-2 ul-accordion__font"> </i></span>Select Platform</a></h6>
                </div>
                <div class="collapse" id="accordion-item-icons-2" data-parent="#accordionRightIcon2">
                    <div class="card-body">

                        <div class="col-md-3 form-group mb-3 " style="float: left;"  >
                            <label for="start_date_two">Select Platform</label>
                            <select class="form-control" name="platform_id" id="platform_id">
                                <option value="" selected disabled>select an option</option>
                                @foreach($platforms as $plt)
                                    <option value="{{ $plt->id }}">{{ $plt->name }}</option>
                                @endforeach
                            </select>
                        </div> --}}

{{--                        <input type="hidden" name="table_name" id="table_name" value="datatable" >--}}
{{--                        <div class="col-md-3 form-group mb-3 "  style="float: left; margin-top: 20px;"  >--}}
{{--                            <label for="end_date" style="visibility: hidden;">End Date</label>--}}
{{--                            <button class="btn btn-info btn-icon m-1" id="not_verify_apply_filter" data="datatable"  type="button"><span class="ul-btn__icon"><i class="i-Magnifi-Glass1"></i></span></button>--}}
{{--                            <button class="btn btn-danger btn-icon m-1" id="not_verify_remove_apply_filter" data="datatable"  type="button"><span class="ul-btn__icon"><i class="i-Close"></i></span></button>--}}
{{--                        </div>--}}
                    {{-- </div>
                </div>
            </div>
        </div> --}}
        <form>
            @csrf
        </form>
        <div class="append_div">
        </div>
    </div>
</div>
<div class="overlay"></div>
@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            var token = $("input[name='_token']").val();
            var platform_id = 4;
            $.ajax({
                url: "{{ route('cod_close_month_ajax') }}",
                method: 'POST',
                data: {_token:token,platform:platform_id},
                success: function(response) {
                    $('.append_div').empty();
                    $('.append_div').append(response);
                }
            });
        });
    </script>
    <script>
        $('.append_div').on('click', '#save_btn', function() {
            $("#question_modal").modal('show');
        });
        $("#yes_btn").click(function(){
            $(".append_div #form_submit_btn").click();
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
