@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/sweetalert2.min.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Masters</a></li>
            <li>Designaiton</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-body">
                <div class="card-title mb-3">Designaiton Details</div>
                <form method="post" action="{{isset($designation_data)?route('designation_update',$designation_data->id):route('designation_store')}}" method="POST">
                    @csrf
                    @if(isset($designation_data))
                        @method('put')
                    @endif
                    <input type="hidden" id="id" name="id" value="{{ isset($designation_data) ? $designation_data->id:''}}">
                    <div class="row">
                        <div class="col-md-5 form-group mb-3 offset-2">
                            <input class="form-control form-control-sm" id="name" name="name" value="{{isset($designation_data) ? $designation_data->name:''}}" type="text" placeholder="Enter the Designation" />
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-sm btn-primary">{{ isset($designation_data) ? 'Update Designation':'Register Designation '}}</button>
                            @if(isset($designation_data)) <a href="{{ route('designation') }}" class="btn btn-sm btn-danger">Cancel Update</a> @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-12 mb-3">
        <div class="card text-left">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered table-sm text-10" id="datatable">
                        <thead class="thead-dark">
                            <tr>
                                <th>SL</th>
                                <th>Designation</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($designation as $com)
                            <tr>
                                <th scope="row">1</th>
                                <td>{{ucFirst($com->name)}}</td>
                                <td>
                                    <a href="#" class="badge btn-{{ $com->status == 1 ? 'success' : 'danger' }} mr-2 status_update-confirm"
                                        data-designation_id="{{ $com->id }}"
                                        title="Update Status">
                                        <span  data-designation_id="{{ $com->id }}">{{ $com->status == 1 ? 'Active' : 'Inactive' }}</span>
                                    </a>
                                </td>
                                <td class="text-center">
                                    <a class="text-success mr-2" href="{{route('designation_edit', $com->id)}}" title="Edit Designation">
                                        <i class="nav-icon i-Pen-2 font-weight-bold"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/sweetalert2.min.js')}}"></script>
    <script src="{{asset('assets/js/scripts/sweetalert.script.min.js')}}"></script>
    <script>
        $(document).on('click','.status_update-confirm',function (e) {
            var designation_id = e.target.getAttribute('data-designation_id')
            var _token = "{{ csrf_token() }}"
            var _method = "put"
            swal({
            title: 'Are you sure to change status?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#0CC27E',
            cancelButtonColor: '#FF586B',
            confirmButtonText: 'Yes, Change it!',
            cancelButtonText: 'No, cancel!',
            confirmButtonClass: 'btn btn-sm btn-success mr-5',
            cancelButtonClass: 'btn btn-sm btn-danger',
            buttonsStyling: false
            }).then(function (){
                $.ajax({
                    url: "{{ route('designation_status_update') }}",
                    type: "POST",
                    data: { designation_id, _token , _method},
                    dataType: "json",
                    success: function (response) {
                        swal("Done!", "It was succesfully updated!", "success").then(function(){
                            window.location.reload();
                        });
                        setTimeout(() => {
                            window.location.reload()
                        }, 2000);
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        swal("Error updating!", "Please try again", "error");
                        setTimeout(() => {
                            window.location.reload()
                        }, 2000);
                    }
                });
            }, function (dismiss) {
            // dismiss can be 'overlay', 'cancel', 'close', 'esc', 'timer'
            if (dismiss === 'cancel') {
                swal('Cancelled', 'Designation update cancelled :)', 'error');
            }
          });
      });
    </script>
    <script>
        $(document).ready(function () {
            'use strict';
            $('#datatable').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "columnDefs": [
                    { "targets": [0],"visible": false},
                ],
                "columns": [
                    { "width": "10%" },
                    { "width": "80%" },
                    { "width": "5%" },
                    { "width": "5%" },
                ],
                "scrollY": false,
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
