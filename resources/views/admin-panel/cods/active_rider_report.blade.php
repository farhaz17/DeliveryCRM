@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
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
        <li><a href="">Riders</a></li>
        <li>Riders Report</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>

<div class="col-md-12 mb-3">
    <div class="card text-left">
        <div class="card-body">

            <div class="row">
                <div class="col-md-12">
                    <button type="button" class="btn btn-primary mr-1 filter" style="float: left;">Filter</button>
                    <button type="button" class="btn btn-lg btn-danger removefilter" style="float: left;display: none;"><span class="ul-btn__icon"><i class="i-Close"></i></span></button>
                </div>
            </div>
            <div class="row">
                <div class="append_div" style="width: 100%"></div>
            </div>

        </div>
    </div>
</div>

<!--  add note Modal-->
<div class="modal fade"  id="followup_model"tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle-1">Add Follow Up</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <form action="{{ route('add_remark_rider') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="passport_id" id="passport_id">
                        <div class="col-md-12 form-group">
                            <label for="">Follow Up</label>
                            <select class="form-control follow_up_status" id="follow_up_status" name="follow_up_status" required>
                                <option value="" selected disabled>select an option</option>
                                @foreach($followup as $follow)
                                    <option value="{{ $follow->id }}">{{ $follow->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="">Remarks</label>
                            <textarea class="form-control" rows="4" name="note" placeholder="Enter Follow Up Remark" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary ml-2" type="submit">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Follow ups list -->
<div class="modal fade" id="followups"  role="dialog" aria-labelledby="CODFollowUpListModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form>
                <div class="modal-header">
                    <h5 class="modal-title" id="CODFollowUpListModalCenterTitle">Rider Follow Up List</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Follow Up List</p>
                    <div class="table-responsive" id="followUpCallListHolder">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--  add note Modal-->
<div class="modal fade"  id="filter_model" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle-1">Add Filter</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <form action="{{ route('filter_rider_report') }}" method="POST" id="filter_form">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <label for="">Category</label><br>
                            <select class="form-control" id="category" name="category" required>
                                <option value="" selected disabled>select an option</option>
                                    <option value="1">COD</option>
                                    <option value="2">Orders</option>
                                    <option value="3">Attendance</option>
                                    <option value="4">Passport Handler</option>
                            </select>
                        </div>
                        <div class="col-md-12 form-group ok">
                            <label for="">Status</label><br>
                            <select class="form-control" id="status" name="status">
                                <option value="" selected disabled>select an option</option>
                                    <option value="1">Last Two Days</option>
                                    <option value="2">Last Week</option>
                            </select>
                        </div>
                        <div class="col-md-12 form-group">
                            <label for="">Platform</label><br>
                            <select class="form-control" id="platform" name="platform" required>
                                <option value="" selected disabled>select an option</option>
                                @foreach ($platforms as $platform)
                                    <option value="{{$platform->id}}">{{$platform->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary ml-2" type="submit">Search</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="overlay"></div>
@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script>
        $('#category').change(function(){
            var id = $(this).val();
            if(id == 4){
                $('.ok').css( 'display', 'none' );
            }else{
                $('.ok').css( 'display', 'block' );
            }
        });
    </script>
    <script>
        $("#filter_form").submit(function(e) {
            e.preventDefault();
            var url = $("#filter_form").attr('action');
            $.ajax({
                url: url,
                type: "POST",
                data: new FormData(this),
                cache: false,
                contentType: false,
                processData: false,
                success: function(response){
                    if(response.message){
                        toastr.error(response.message);
                    }else{
                        $("#filter_model").modal('hide');
                        $('.removefilter').css( 'display', 'block' );
                        $('#status').val(null).trigger("change");
                        $('#category').val(null).trigger("change");
                        $('#platform').val(null).trigger("change");
                        $('.append_div').empty();
                        $('.append_div').append(response);
                    }
                }
            });
        });
    </script>
    <script>
        $(document).ready(function(){
            $.ajax({
                url: "{{ route('render_riders') }}",
                method: 'GET',
                success:function(response){
                    $('.append_div').empty();
                    $('.append_div').append(response);
                }
            });
        });
    </script>
    <script>
        $('.removefilter').click(function(){
            $.ajax({
                url: "{{ route('render_riders') }}",
                method: 'GET',
                success:function(response){
                    $('.removefilter').css( 'display', 'none' );
                    $('.append_div').empty();
                    $('.append_div').append(response);
                }
            });
        });
    </script>
    <script>
        $('.filter').on('click',function(){
            $("#filter_model").modal('show');
        });
    </script>
    <script>
        $('#status,#category,#platform').select2({
            placeholder: 'select an option ',width: '100%'
        });
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
