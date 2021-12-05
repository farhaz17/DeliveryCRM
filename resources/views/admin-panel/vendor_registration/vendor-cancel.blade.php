@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
@endsection
@section('content')
<div class="breadcrumb">
    <h1 class="mr-2">Home</h1>
    <ul>
        <li><a href="">Vendor</a></li>
        <li>Report</li>
    </ul>
</div>
<div class="separator-breadcrumb border-top"></div>

    <div class="col-md-12 mb-3">
        <div class="card text-left">
            <div class="card-body">

                <div class="row mb-3">
                    <div class="col-md-3"></div>
                    <div class="col-md-6 form-group mb-3">
                        <label for="vendor_name">Vendor Name</label>
                        <select id="vendor_name" name="vendor_name" class="form-control vendor_name" required>
                            <option value=""  >Select option</option>
                            @foreach ($vendor_accept as $vendor_name)
                            <option value="{{$vendor_name->id}}"  >{{$vendor_name->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row m-auto container p-4" style="font-size: 16px; font-weight: 700; ">
                    <div class="col-md-2"></div>
                    <div class="col-md-8" id="countReport">

                    </div>
                    <div class="col-md-2" id="cancelVendor"></div>
                </div>

                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-sm table-striped table-bordered text-11 vendor_rider" id="vendor_rider" style="width:100%;">
                            <thead>
                            <tr>
                                <th scope="col">First Name</th>
                                <th scope="col">Last Name</th>
                                <th scope="col">Passport No</th>
                                <th scope="col">Platform Assigned</th>
                                <th scope="col">Bike Assigned</th>
                                <th scope="col">Sim Assigned</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="row">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="verifyModalContent_title"></h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="row container text-center">
                            <h3>Cancel Vendor<h3>
                        </div>
                    </div>

                        <div class="renew">
                            <form method="post" action="{{ route('post-vendor-cancel') }}">

                                {!! csrf_field() !!}

                                <input type="hidden" id="id" name="id" />
                                <div class="col-md-12 form-group mb-3">
                                    <label for="repair_category">Remark</label>
                                    <input class="form-control form-control" name="remarks" type="text" placeholder="Remark (optional)"  />
                                </div>

                                <div class="modal-footer">
                                    <div class="col-md-12">
                                        <input type="submit" name="cancel" class="btn btn-primary" value="Cancel Vendor">
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --}}
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script>
        $(document).ready(function () {
            load_data();
            'use strict';
            $('.vendor_name').on('change',function(){
                var id = $(this).val();
                $('.vendor_rider').DataTable().destroy();
                load_data(id);
                load_count(id);
            });

            function load_count(id){
                $.ajax({
                    url : "{{ route('ajax-vendor-assigned-count') }}",
                    method: 'GET',
                    data:{id: id},
                    success: function(result){
                        console.log(result)
                        var content = '<div><div class="row p-3" style="background-color:aqua">'
                            content += '<div class="col-4">Platform Assigned:' + result.assigned_platform +'</div>'
                            content += '<div class="col-4">Bike Assigned: ' + result.assigned_bike +'</div>'
                            content += '<div class="col-4">Sim Assigned: ' + result.assigned_sim +'</div></div>'
                        $("#countReport").html(content);
                        if(result.assigned_platform == 0 && result.assigned_bike == 0 && result.assigned_sim == 0) {
                            button = '<button class="btn btn-danger mt-2" id="cancelVendorBtn"  data-id="'+ id +'"  data-toggle="modal" data-target="#cancelModal">Cancel Vendor</button>'
                            $("#cancelVendor").html(button);
                        }
                        else {
                            button = '<button class="btn btn-danger mt-2" id="cancelVendorBtn" disabled>Cancel Vendor</button>'
                            $("#cancelVendor").html(button);
                        }
                    }
                });
            }

            function load_data(id){
            $('.vendor_rider').DataTable( {
                ajax:{
                    url : "{{ route('ajax-vendor-cancel') }}",
                    data:{id: id},
                },
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'excel',
                        title: 'PPUID Detail',
                        text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                        exportOptions: {
                            modifier: {
                                page : 'all',
                            }
                        }
                    },
                    'pageLength',
                ],
                columns: [
                    { data: 'rider_first_name' },
                    { data: 'rider_last_name' },
                    { data: 'passport_no' },
                    { data: 'assign_platform' },
                    { data: 'assign_bike' },
                    { data: 'assign_sim' },

                ],
                pageLength: 10,
            });
            }
        });
        $('.vendor_name').select2({
            placeholder: 'Select an option'
        });

        $(document).on("click", "#cancelVendorBtn", function () {
            var id = $(this).attr('data-id');
            $("input[name='id']").val(id);
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
