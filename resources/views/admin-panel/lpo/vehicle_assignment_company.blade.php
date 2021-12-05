@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <style>
    </style>
@endsection
@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/user-dashboard-new') }}">All Modules</a></li>
        <li class="breadcrumb-item"><a href="">LPO Operation</a></li>
      <li class="breadcrumb-item active" aria-current="page">Create Lpo Contract</li>
    </ol>
</nav>

<div class="container card selected_passport p-3" style="">
    <div class="mt-3 font-weight-bold">Vehicle</div>
    <table class="table table-sm table-hover text-14 data_table_cls" id="datatable_passport">
        <thead class="thead-dark">
        <tr>
            <th scope="col">LPO No</th>
            <th scope="col">Model</th>
            <th scope="col">Chassis No</th>
            <th scope="col">Contract Type</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
            <tr>
                <td id="pp_uid">12</td>
                <td id="passport_no">Pulsar</td>
                <td id="full_name">H7666HHH</td>
                <td id="passport_no">Rental</td>
                <td id="zds_code"><a href="javascript:void(0)" data-toggle="modal" class="btn btn-success btn-sm" data-target="#attachVcc">Assign Company</td>
            </tr>
            <tr>
                <td id="pp_uid">12</td>
                <td id="passport_no">Pulsar</td>
                <td id="full_name">H7666HHH</td>
                <td id="passport_no">Company</td>
                <td id="zds_code"><a href="" class="btn btn-success btn-sm">Assign Company</td>
            </tr>

        </tbody>
    </table>
</div>

 <!---------Assign Company---------->
 <div class="modal fade" id="attachVcc" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="row">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="verifyModalContent_title"></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="row container text-center">
                        <h3>VCC Attachment<h3>
                    </div>
                </div>

                <div class="renew p-3">
                    <form   method="post" action="">
                        @csrf
                        <div class="">
                            <label for="repair_category">Select Company</label>
                            <select id="cardMethod" class="form-control" name="supplier">
                                <option value="" disabled selected>Select Company</option>
                                <option value="1">Company 1</option>
                                <option value="2">Company 2</option>
                            </select>
                        </div>

                        <div class="modal-footer">
                            <div class="col-md-12">
                                <input type="submit" class="btn btn-primary" value="Add">
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
<script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

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

    $('#selectState').select2({
        placeholder: 'Select the state',
        width: '100%'
    });

</script>


@endsection
