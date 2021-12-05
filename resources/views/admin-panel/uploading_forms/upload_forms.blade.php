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
            <li><a href="">Upload Forms</a></li>
            <li>Upload Fomrs</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row pb-2" >
        @if(isset($gamer_array))
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="table-responsive">
                                    <div class="alert alert-card alert-danger" role="alert">
                                        <strong class="text-capitalize">Upload Failed! Following Bikes  Does Not Exist!</strong>
                                        <button class="close" type="button" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <table class="display table table-striped  table-bordered" id="datatable" style="width: 100%">
                                        <thead class="thead-dark">
                                        <tr >
                                            <th scope="col">Transaction ID</th>
                                            <th scope="col">Trip Date</th>
                                            <th scope="col">Trip Time</th>
                                            <th scope="col">Transaction Post Date</th>
                                            <th scope="col">Toll Gate</th>
                                            <th scope="col">Direction</th>
                                            <th scope="col">Tag Number</th>
                                            <th scope="col">Plate</th>
                                            <th scope="col">Amount(AED)</th>
                                            <th scope="col">Account Number</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($gamer_array as  $sal)
                                            <tr>
                                                <td>{{$sal['transaction_id']}}</td>
                                                <td>{{$sal['trip_date']}}</td>
                                                <td>{{$sal['trip_time']}}</td>
                                                <td>{{$sal['transaction_post_date']}}</td>
                                                <td>{{$sal['toll_gate']}}</td>
                                                <td>{{$sal['direction']}}</td>
                                                <td>{{$sal['tag_number']}}</td>
                                                <td>{{$sal['plate']}}</td>
                                                <td>{{$sal['amount']}}</td>
                                                <td>{{$sal['account_number']}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    @foreach($result as $res)
                        <div class="card-title sam" style="display: none;" id="{{$res->id}}"><a href="{{ URL::to( $res->sample_file)}}" target="_blank">(Download Sample File)</a></div>
                    @endforeach
                    <form method="post" class="row" enctype="multipart/form-data" action="{{ url('/form_upload') }}"  aria-label="{{ __('Upload') }}" >
                        @csrf
                            <div class="col-md-5 form-group mb-3">
                                <select id="form_type" name="form_type" class="form-control form-control-sm" required>
                                    <option value="">Select Form</option>
                                    @foreach($result as $res)
                                        <option value="{{$res->id}}">{{$res->form_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-5 form-group mb-3">
                                <input class="form-control-file form-control-sm" id="select_file" type="file" name="select_file" aria-describedby="inputGroupFileAddon01" required />
                            </div>
                            <div class="col-md-2 mb-3">
                                <button class="btn btn-primary btn-sm" type="submit">Upload</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function () {
            'use strict';
            $('#datatable').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [0],"visible": false},
                    {"targets": [1][2],"width": "30%"}
                ],
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'Missing Bikes',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                    'pageLength',
                ],
                "scrollY": false,
                "scrollX": true
            });

            $('#part_id').select2({
                placeholder: 'Select an option'
            });
        });
        function deleteData(id)
        {
            var id = id;
            var url = '{{ route('inv_parts.destroy', ":id") }}';
            url = url.replace(':id', id);
            $("#deleteForm").attr('action', url);
        }
        function deleteSubmit()
        {
            $("#deleteForm").submit();
        }
//-----------Download sample divs------------------
        $(document).ready(function() {
            $("#titles").hide();
            $(".sam").hide();
        });
        $('#form_type').change(function() {
            var id = ($('#form_type').val());
            $("#titles").show();
            $(".sam").hide();
            $("#"+id).show();
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
