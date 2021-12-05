@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
@endsection
@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/user-dashboard-new') }}">All Modules</a></li>        
            <li class="breadcrumb-item"><a href="{{ route('sim_wise_dashboard',['active'=>'master-menu-items']) }}">SIM Master</a></li>
            <li class="breadcrumb-item active" aria-current="page">SIM List</li>
        </ol>
    </nav>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-body">
                    <div class="card-title mb-3">SIM Details</div>
                    <form   method="post"  action="{{isset($telecome_edit) ? action('ViewFormsController@update',$telecome_edit->id):route('sim_master_store')}}">
                        {!! csrf_field() !!}
                        @if(isset($telecome_edit))
                            {{ method_field('PUT') }}
                        @endif
                        <div class="row">
                            <div class="col-md-2 form-group mb-3">
                                <label class="col-form-label" for="recipient-name-2">SIM Number:</label>
                                <input class="form-control form-control-sm" id="id" name="id"  value="{{isset($telecome_edit)?$telecome_edit->id:""}}" type="hidden"  />
                                <input class="form-control form-control-sm" id="form_type" name="form_type"  value="9" type="hidden"  />
                                <input class="form-control form-control-sm" id="account_number" name="account_number"  value="{{isset($telecome_edit)?$telecome_edit->account_number:""}}"  required type="text"  placeholder="Enter SIM Number" />
                            </div>
                            <div class="col-md-2 form-group mb-3" >
                                <label class="col-form-label"  for="message-text-1">Network</label>
                                <select id="network" name="network" required class="form-control form-control-sm">
                                    <option value="" selected disabled>Select Category Type</option>
                                    @php
                                        $isSelected1 = (isset($telecome_edit)?$telecome_edit->network:"");
                                    @endphp
                                    <option  @if($isSelected1=='Etisalat') selected @else @endif value="Etisalat" >Etisalat</option>
                                    <option  @if($isSelected1=='DU') selected @else @endif value="DU" >DU</option>
                                </select>
                            </div>
                            <div class="col-md-3 form-group mb-3"  id="account_no_div">
                                <label class="col-form-label" for="message-text-1">Select Network First</label>
                                <input class="form-control form-control-sm" id="party_id" name="party_id" value="{{isset($telecome_edit)?$telecome_edit->party_id:""}}"  type="text"  required placeholder="Enter Party ID"  />
                            </div>
                            <div class="col-md-2 form-group mb-3">
                                <label class="col-form-label"  for="message-text-1"> Product Type</label>
                                <input class="form-control form-control-sm" id="product_type" value="{{isset($telecome_edit)?$telecome_edit->product_type:""}}" name="product_type" required type="text" placeholder="Enter Product Type"  />
                            </div>
                            <div class="col-md-2 form-group mb-3">
                                <label class="col-form-label"  for="message-text-1">Category Type</label>
                                {{-- @dd($telecome_edit->category_types) --}}
                                <select id="category_type" name="category_types" required class="form-control form-control-sm">
                                    <option value="" selected disabled>Select Category Type</option>
                                    @php
                                        $isSelected = (isset($telecome_edit)?$telecome_edit->category_types:"");
                                    @endphp
                                    <option value="0" @if($isSelected=='0') selected @else @endif>Compnay</option>
                                    <option value="1" @if($isSelected=='1') selected @else @endif>Platform</option>
                                </select>
                            </div>
                            <div class="col-md-2 form-group mb-3">
                                <label class="col-form-label"  for="contract_issue_date">Contract Issue Date</label>
                                <input class="form-control form-control-sm" id="contract_issue_date" value="{{isset($telecome_edit)?$telecome_edit->contract_issue_date:''}}" name="contract_issue_date" type="date" placeholder="Enter Product Type"  required/>
                            </div>
                            <div class="col-md-2 form-group mb-3">
                                <label class="col-form-label"  for="contract_expiry_date">Contract Expiry Date</label>
                                <input class="form-control form-control-sm" id="contract_expiry_date" value="{{isset($telecome_edit)?$telecome_edit->contract_expiry_date:''}}" name="contract_expiry_date" type="date" placeholder="Enter Product Type"  />
                            </div>
                            <div class="col-md-2 form-group mb-3">
                                <label class="col-form-label"  for="sim_sl_no">Sim Serial No</label>
                                <input class="form-control form-control-sm" id="sim_sl_no" value="{{isset($telecome_edit)?$telecome_edit->sim_sl_no:''}}" name="sim_sl_no" type="text" placeholder="Enter Sim Serial"  />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary btn-sm" > {{isset($telecome_edit) ? "Update" : "Save"}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card text-left">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-sm text-10" id="datatable" style="width:100%">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">ID</th>
                                <th scope="col">Account Number</th>
                                <th scope="col">Party ID</th>
                                <th scope="col">Product Type</th>
                                <th scope="col">Network</th>
                                <th scope="col">Category Tpes</th>
                                @if(in_array(1, Auth::user()->user_group_id))
                                    <th scope="col">Action</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($Telecom as $tel)
                                <tr>
                                    <th scope="row">1</th>
                                    <td>{{$tel->id}}</td>
                                    <td>{{$tel->account_number}}</td>
                                    <td>{{$tel->party_id}}</td>
                                    <td>{{$tel->product_type}}</td>
                                    <td>{{$tel->network}}</td>
                                    @if($tel->category_types=='0')
                                        <td>Company</td>
                                    @else
                                        <td>Platform</td>
                                    @endif

                                    @if(in_array(1, Auth::user()->user_group_id))
                                        <td>
                                            <a class="text-success mr-2" href="{{route('telecome_edit2',$tel->id)}}"><i class="nav-icon i-Pen-2 font-weight-bold"></i></a>
                                            {{--                                        <a class="text-danger mr-2" data-toggle="modal" onclick="deleteData7({{$ub->id}})" data-target=".bd-example7-modal-sm" ><i class="nav-icon i-Close-Window font-weight-bold"></i></a>--}}
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>        
    </div>

@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script>
        $('#network').change(function(){
            $.ajax({
                url: "{{ route('get_network_accounts') }}",
                data: { "network": $(this).val() },
                dataType:"json",
                type: "get",
                success: function(response){
                    $('#account_no_div').empty();
                    $('#account_no_div').prepend(response.html);
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
                    {"targets": [0],"visible": false},
                ],
                "scrollY": false,
            });

        });

    </script>

    <script>
        $(".status").change(function(){
            if($(this).prop("checked") == true){
                var id = $(this).attr('id');
                var token = $("input[name='_token']").val();
                var status = '0';
                $.ajax({
                    url: "{{ route('update_issue_dep') }}",
                    method: 'POST',
                    data: {id: id, _token:token,status:status},
                    success: function(response) {
                    }
                });
            }else{
                var id = $(this).attr('id');
                var token = $("input[name='_token']").val();
                var status = '1';
                $.ajax({
                    url: "{{ route('update_issue_dep') }}",
                    method: 'POST',
                    data: {id: id, _token:token,status:status},
                    success: function(response) {
                    }
                });
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
