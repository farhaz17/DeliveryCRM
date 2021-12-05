@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
<div class="breadcrumb">
    <h1 class="mr-2">Home</h1>
    <ul>
        <li><a href="">Careem</a></li>
        <li>Cash Cod</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>
<div class="row pb-2" >
    <div class="col-md-12">
        @if(Session::has('message'))
            <!-- Modal -->
            @php
                $missing_rider_ids = array_filter(explode(',',session()->get('missing_rider_ids')));
                $date_exists = array_filter(explode(',',session()->get('date_exists')));
                $amount_exists = array_filter(explode(',',session()->get('amount_exists')));
                $messages = array_filter(explode(',',session()->get('messages')));
            @endphp
            @if($missing_rider_ids)
            <div class="modal fade" id="CareemCashCodUploadErrorModal" tabindex="-1" role="dialog" aria-labelledby="ModalTitle" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h4 class="modal-title" id="ModalTitle">Careem Cash Cod Upload Error Messages</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                            {{-- <div class="alert alert-danger">
                            <p class="m-0">{{ count(explode(',',session()->get('missing_rider_ids'))) . " rider ids are requested to register first before upload the sheet after registering you can upload the sheet. "}}
                                If you have the authority to register click <a class="btn btn-link" target="_blank" href="{{ route('usercodes') }}">here</a> to go to the registration page.
                            </p>
                            </div> --}}
                            <div class="responsive">
                                <table class="table table-sm table-hover text-10" id="CareemCashCodUploadErrorModadatatable" width='100%'>
                                    <thead>
                                        <tr>
                                            <td>RiderID</td>
                                            <td>Date</td>
                                            <td>Amount</td>
                                            <td>Message</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ( $missing_rider_ids as $key => $missing_rider_id)
                                            <tr>
                                                <td>{{ $missing_rider_ids[$key] }}</td>
                                                <td>{{ $date_exists[$key] ?? "NA"}}</td>
                                                <td>{{ $amount_exists[$key] ?? "NA"}}</td>
                                                <td>{{ $messages[$key] ?? "NA"}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        @endif
    </div>
</div>
<div class="col-md-12 mb-3">
    <div class="card text-left">
        <div class="card-body border-bottom">
            <div class="card-title">Careem Cash COD Upload Form</div>
            <form method="post" enctype="multipart/form-data" action="{{ route('careem_cash_cod_upload') }}"  aria-label="{{ __('Upload') }}" >
                @csrf
                <div class="col-md-4 form-group mb-3" style="float: left;"  >
                    {{-- <label for="start_date">Start Date</label>
                    <input type="text" name="start_date"  autocomplete="off" class="form-control form-control-sm" id="start_date" required> --}}
                </div>
                <div class="col-md-4 form-group"  style="float: left;" >
                    <label for="end_date">File for Cod Upload</label>
                    <input class="form-control-file form-control-sm" id="select_file" type="file" name="select_file" />
                </div>
                <div class="col-md-4 form-group"  style="float: right;" >
                    <a href="{{ asset('assets/sample/Cod/careem_cod/careem_cash_cod_sample.xlsx') }}" class="float-right" target="_blank">( Download Sample File )</a>
                </div>
                <div class="col-md-12 form-group mb-3">
                    <button class="btn btn-sm btn-info float-right" name="upload_or_delete" type="submit" value="upload">Upload</button>
                    {{-- <button class="btn btn-sm btn-danger float-right mr-2" onclick="return confirm('Are you sure to delete the date cod?')" name="upload_or_delete" type="submit" value="delete">Delete</button> --}}
                </div>
            </form>
        </div>
        {{-- we will use this snipped if we need individual missing rider id list --}}
        @if(Session::has('message') && ($missing_rider_ids))
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <button type ='button' class="btn btn-block btn-sm btn-danger mt-2 mr-3 float-right" data-toggle="modal" data-target="#CareemCashCodUploadErrorModal">Show missing Rider Ids</button>
                </div>
            </div>
        </div>
        @endif
        <div class="card-body">
            <div class="card-title">Add Single Cash COD</div>
            <form method="post" enctype="multipart/form-data" action="{{ route('careem_store_cash') }}">
                @csrf
                <div class="row">
                    <div class="col-md-4 form-group mb-3">
                        <label for="">Rider id</label>
                        <select id="zds_code" name="zds_code" class="form-control form-control-sm cod_zds_code" required>
                            <option value="">Select option</option>
                            @foreach ($rider_ids as $rider_id)
                                <option value="{{ $rider_id->passport_id }}" >
                                    RiderID: {{ $rider_id->platform_code }} |
                                    PPUID: {{ $rider_id->passport->pp_uid }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 form-group mb-3" id="unique_div1" >
                        <label for="">Name</label><br>
                        <h6><span id="sur_name1" ></span>  <span id="given_names1" ></span></h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 form-group mb-3">
                        <label for="">Date</label>
                        <input class="form-control form-control-sm" id="date" name="date" type="date" placeholder="Enter Date" max="<?php echo date("Y-m-d"); ?>" required />
                    </div>
                    <div class="col-md-4 form-group mb-3">
                        <label for="">Time</label>
                        <input class="form-control form-control-sm" id="time" name="time"type="time" placeholder="Enter Time" required />
                    </div>

                    <div class="col-md-4 form-group mb-3">
                        <label for="">Amount </label>
                        <input class="form-control" id="amount" name="amount" type="number" placeholder="Enter Amount" step="0.01" required/>
                    </div>

                    <div class="col-md-12">
                        <button class="btn btn-primary">Add</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function(){
       var date = new Date();
       var time = date.getHours() + ":" + date.getMinutes();
       document.getElementById('time').value = time;
       document.getElementById('date').valueAsDate = date;
       });
   </script>
    <script>
        $('.cod_zds_code').select2({
            placeholder: 'Select an option'
        });
    </script>
    @if(Session::has('message') && ($missing_rider_ids))
    <script>
        $(window).on('load', function() {
            $('#CareemCashCodUploadErrorModal').modal('show');
            $('#CareemCashCodUploadErrorModadatatable').DataTable( {
                "aaSorting": [[0, 'desc']],
                responsive: true,
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'Careem Cash Cod Upload Errors',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=10px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                ],
            });
        });
    </script>
    @endif
     <script>
        $('#zds_code').on('change', function(){
            var zds_code = $(this).val();

            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('cod_get_passport_detail') }}",
                method: "POST",
                data:{zds_code: zds_code,_token: token},
                success:function(response){
                    var res = response.split('$');
                    $("#sur_name1").html(res[0]);
                }
            });
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
