@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .cls_btn{
            color: #ffffff !important;
        }
        .hr_cls hr{
            margin-bottom: 5px;
            margin-top: 5px;
        }
        i.fa.fa-check-square {
            font-size: 20px;
            color: green;
        }
        i.fa.fa-window-close {
            font-size: 20;
            color: red;
        }

        </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Agreements</a></li>
            <li>All Agreements</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>


{{--    agrement history Modal--}}
    <div class="modal fade " id="history_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle-1">Agreement History</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body text-center" id="history_modal_body">


                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    {{--    agrement history Modal end--}}




    {{--    upload agreement signed modal--}}
    <div class="modal fade bd-example-modal-sm" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form method="post" id="edit_form" action="{{ route('upload_signed_agreement') }}" enctype="multipart/form-data">
                    {!! csrf_field() !!}



                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Upload Signed Agreement</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="primary_id" name="id" value="">
                        <div class="row">

                            <div class="col-md-12">
                                <div class="card mb-4">
                                    <div class="card-body">
                                        {!! csrf_field() !!}

                                        <div class="row ">
                                            <div class="col-md-12 form-group mb-3">
                                                <label for="repair_category">Upload Signed Agreement</label>
                                                <input type="file" class="form-control" name="image" required>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-primary ml-2" type="submit">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{--  end  upload agreement signed modal --}}




    <div class="col-md-12 mb-3">
        <div class="card text-left">
            <div class="card-body">



                    <div class=" text-left">
                        <div >
{{--                            <h4 class="card-title mb-3">Basic Tab With Icon</h4>--}}
                            <ul class="nav nav-tabs" id="myIconTab" role="tablist">
                                <li class="nav-item"><a class="nav-link active" id="home-icon-tab" data-toggle="tab" href="#not_employee" role="tab" aria-controls="not_employee" aria-selected="true"><i class="nav-icon i-Remove-User mr-1"></i>Not Employee ({{ $agreements_not_employee->count()  }})</a></li>
                                <li class="nav-item"><a class="nav-link" id="profile-icon-tab" data-toggle="tab" href="#taking_visa" role="tab" aria-controls="taking_visa" aria-selected="false"><i class="nav-icon i-Visa mr-1"></i>Full Time Employee ({{ $agreements_taking_visa->count()  }})</a></li>
                                <li class="nav-item"><a class="nav-link" id="contact-icon-tab" data-toggle="tab" href="#part_time" role="tab" aria-controls="part_time" aria-selected="false"><i class="nav-icon i-Over-Time-2 mr-1"></i>Part Time ({{ $agreements_part_time->count()  }})</a></li>
                                <li class="nav-item"><a class="nav-link" id="cancel-icon-tab" data-toggle="tab" href="#cancel_agreement" role="tab" aria-controls="cancel_agreement" aria-selected="false"><i class="nav-icon i-Over-Time-2 mr-1"></i>Cancel Visa ({{ $agreements_cencel->count()  }})</a></li>
                            </ul>
                            <div class="tab-content" id="myIconTabContent">
                                <div class="tab-pane fade show active" id="not_employee" role="tabpanel" aria-labelledby="home-icon-tab">
                                    <div class="table-responsive">
                                        <table class="display table table-striped table-bordered" id="datatable_not_employee">
                                            <thead class="thead-dark">
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Agreement Id</th>
                                                <th scope="col">Passport Number</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Dummy ID</th>
                                                <th scope="col">Action</th>


                                            </tr>
                                            </thead>
                                            <tbody>


                                            @foreach($agreements_not_employee as $agreement)
                                                <tr>
                                                    <th scope="row">1</th>
                                                    <td> {{ $agreement->agreement_no  }}</td>
                                                    <td>{{ $agreement->passport->passport_no  }}</td>
                                                    <td>{{ $agreement->passport->personal_info->full_name  }}</td>
                                                    <td>
                                                        @if($agreement->dummy_id=='1')
                                                        <span class="badge badge-success m-2">Yes</span>
                                                        @else
                                                        <span class="badge badge-danger m-2">No</span>
                                                        @endif
                                                    </td>
                                                    <td>
{{--                                                        <a href="{{ route('agreement_pdf',$agreement->id) }}" target="_blank" class="btn btn-primary btn-sm">View Detail</a>--}}
                                                        <a href="{{ route('agreement_pdf',$agreement->id) }}"    target="_blank"  class="btn btn-primary btn-icon m-1 " type="button"><span class="ul-btn__icon"><i class="i-Eye"></i></span></a>

                                                        @if($agreement->signed_agreement_pic!=null)
{{--                                                            <a href="{{ route('agreement_pdf',$agreement->id) }}" target="_blank" class="btn btn-dark btn-sm">Signed Agreement</a>--}}
                                                            <a href="{{ asset($agreement->signed_agreement_pic) }}"   target="_blank"  class="btn btn-dark btn-icon m-1 " type="button"><span class="ul-btn__icon"><i class="i-Upload"></i></span></a>
                                                        @else
{{--                                                            <a href="javascript:void(0)"  id="{{ $agreement->id  }}" class="btn btn-info btn-sm upload_agreement_cls">Upload Agreement</a>--}}
                                                            <a href="javascript:void(0)"  id="{{ $agreement->id  }}" class="btn btn-light btn-icon m-1 upload_agreement_cls" type="button"><span class="ul-btn__icon"><i class="i-Upload-Window"></i></span></a>
                                                        @endif

                                                        @if(in_array(1, Auth::user()->user_group_id))
{{--                                                            <a   href="{{ route('agreement_complete_pdf',$agreement->id) }}" target="_blank" class="btn btn-outline-success btn-sm">Complete Detail</a>--}}
{{--                                                            <a href="{{ route('agreement_complete_pdf',$agreement->id) }}" target="_blank" class="btn btn-success btn-icon m-1 amendment_modal_cls" type="button"><span class="ul-btn__icon"><i class="i-One-Window"></i></span></a>--}}
                                                            <a href="javascript:void(0)"  id="history_agreement-{{ $agreement->id  }}" class="btn btn-success btn-icon m-1 amendment_modal_cls" type="button"><span class="ul-btn__icon"><i class="i-One-Window"></i>  {{ $agreement->count_amendment() ? $agreement->count_amendment() : ''  }} </span></a>

                                                            <a href="{{ route('agreement_amendment.edit',$agreement->id) }}" target="_blank" class="btn btn-info btn-icon m-1" type="button"><span class="ul-btn__icon"><i class="i-Pen-3"></i></span></a>
                                                        @endif

                                                        <a id="{{$agreement->id}}"  class="btn btn-danger btn-cancel m-1 text-white" type="button"><span class="ul-btn__icon"><i class="i-Delete-File"></i></span></a>

                                                    </td>
                                                </tr>
                                            @endforeach

                                            </tbody>
                                        </table>
                                    </div>


                                </div>

                                <div class="tab-pane fade" id="taking_visa" role="tabpanel" aria-labelledby="profile-icon-tab">

                                    <div class="table-responsive">
                                        <table class="display table table-striped table-bordered" id="datatable_taking_visa">
                                            <thead class="thead-dark">
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Agreement Id</th>
                                                <th scope="col">Passport Number</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Dummy ID</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>


                                            @foreach($agreements_taking_visa as $agreement)
                                                <tr>
                                                    <th scope="row">1</th>
                                                    <td> {{ $agreement->agreement_no  }}</td>
                                                    <td>{{ isset($agreement->passport->passport_no)?$agreement->passport->passport_no:"n/a"  }}</td>
                                                    <td>{{ isset($agreement->passport->personal_info->full_name)?$agreement->passport->personal_info->full_name:"N/A"  }} </td>
                                                    <td>
                                                        @if($agreement->dummy_id=='1')
                                                        <span class="badge badge-success m-2">Yes</span>
                                                        @else
                                                        <span class="badge badge-danger m-2">No</span>
                                                        @endif
                                                    </td>
                                                    <td>
{{--                                                        <a href="{{ route('agreement_pdf',$agreement->id) }}" target="_blank" class="btn btn-primary btn-sm">View Detail</a>--}}
                                                        <a href="{{ route('agreement_pdf',$agreement->id) }}"    target="_blank"  class="btn btn-primary btn-icon m-1 " type="button"><span class="ul-btn__icon"><i class="i-Eye"></i></span></a>
                                                        @if($agreement->signed_agreement_pic!=null)
                                                            <a href="{{ asset($agreement->signed_agreement_pic) }}"   target="_blank"  class="btn btn-dark btn-icon m-1 " type="button"><span class="ul-btn__icon"><i class="i-Upload"></i></span></a>
                                                        @else
                                                            <a href="javascript:void(0)"  id="{{ $agreement->id  }}" class="btn btn-light btn-icon m-1 upload_agreement_cls" type="button"><span class="ul-btn__icon"><i class="i-Upload-Window"></i></span></a>
                                                        @endif

                                                        @if(in_array(1, Auth::user()->user_group_id))
{{--                                                            <a href="{{ route('agreement_complete_pdf',$agreement->id) }}" target="_blank" class="btn btn-success btn-icon m-1" type="button"><span class="ul-btn__icon"><i class="i-One-Window"></i></span></a>--}}
                                                            <a href="javascript:void(0)"  id="history_agreement-{{ $agreement->id  }}" class="btn btn-success btn-icon m-1 amendment_modal_cls" type="button"><span class="ul-btn__icon"><i class="i-One-Window"></i>  {{ $agreement->count_amendment() ? $agreement->count_amendment() : ''  }} </span></a>

                                                            <a href="{{ route('agreement_amendment.edit',$agreement->id) }}" target="_blank" class="btn btn-info btn-icon m-1" type="button"><span class="ul-btn__icon"><i class="i-Pen-3"></i></span></a>
                                                        @endif
                                                        <a id="{{$agreement->id}}"  class="btn btn-danger btn-cancel m-1 text-white" type="button"><span class="ul-btn__icon"><i class="i-Delete-File"></i></span></a>

                                                    </td>


                                                </tr>

                                            @endforeach

                                            </tbody>
                                        </table>
                                    </div>


                                </div>
                                <div class="tab-pane fade" id="part_time" role="tabpanel" aria-labelledby="contact-icon-tab">

                                    <div class="table-responsive">
                                        <table class="display table table-striped table-bordered" id="datatable_part_time">
                                            <thead class="thead-dark">
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Agreement Id</th>
                                                <th scope="col">Passport Number</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Dummy ID</th>
                                                <th scope="col">Action</th>


                                            </tr>
                                            </thead>
                                            <tbody>


                                            @foreach($agreements_part_time as $agreement)
                                                <tr>
                                                    <th scope="row">1</th>
                                                    <td> {{ $agreement->agreement_no  }}</td>
                                                    <td>{{ $agreement->passport->passport_no  }}</td>
                                                    <td>{{ $agreement->passport->personal_info->full_name  }} </td>
                                                    <td>
                                                        @if($agreement->dummy_id=='1')
                                                        <span class="badge badge-success m-2">Yes</span>
                                                        @else
                                                        <span class="badge badge-danger m-2">No</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('agreement_pdf',$agreement->id) }}" target="_blank" class="btn btn-primary btn-sm">View Detail</a>
                                                        @if($agreement->signed_agreement_pic!=null)
                                                            <a href="{{ asset($agreement->signed_agreement_pic) }}"   target="_blank"  class="btn btn-dark btn-icon m-1 " type="button"><span class="ul-btn__icon"><i class="i-Upload"></i></span></a>
                                                        @else
                                                            <a href="javascript:void(0)"  id="{{ $agreement->id  }}" class="btn btn-light btn-icon m-1 upload_agreement_cls" type="button"><span class="ul-btn__icon"><i class="i-Upload-Window"></i></span></a>
                                                        @endif

                                                        @if(in_array(1, Auth::user()->user_group_id))
{{--                                                            <a href="{{ route('agreement_complete_pdf',$agreement->id) }}" target="_blank" class="btn btn-success btn-icon m-1" type="button"><span class="ul-btn__icon"><i class="i-One-Window"></i></span></a>--}}
                                                            <a href="javascript:void(0)" id="history_agreement-{{ $agreement->id  }}"  class="btn btn-success btn-icon m-1 amendment_modal_cls" type="button"><span class="ul-btn__icon"><i class="i-One-Window"></i>  {{ $agreement->count_amendment() ? $agreement->count_amendment() : ''  }} </span></a>

                                                            <a href="{{ route('agreement_amendment.edit',$agreement->id) }}" target="_blank" class="btn btn-info btn-icon m-1" type="button"><span class="ul-btn__icon"><i class="i-Pen-3"></i></span></a>

                                                        @endif
                                                        <a id="{{$agreement->id}}"  class="btn btn-danger btn-cancel m-1 text-white" type="button"><span class="ul-btn__icon"><i class="i-Delete-File"></i></span></a>


                                                    </td>


                                                </tr>

                                            @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                </div>



                                <div class="tab-pane fade" id="cancel_agreement" role="tabpanel" aria-labelledby="contact-icon-tab">

                                    <div class="table-responsive">
                                        <table class="display table table-striped table-bordered" id="datatable_cancel_agreement">
                                            <thead class="thead-dark">
                                            <tr>
                                                <th scope="col">Agreement Id</th>
                                                <th scope="col">Passport Number</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Cancel Reason</th>
                                                <th scope="col">Cancel Date</th>
                                                <th scope="col">Remarks</th>



                                            </tr>
                                            </thead>
                                            <tbody>


                                            @foreach($agreements_cencel as $agreement)
                                                <tr>
                                                    <td> {{ $agreement->agreement->agreement_no  }}</td>
                                                    <td>{{ $agreement->agreement->passport->passport_no  }}</td>
                                                    <td>{{ $agreement->agreement->passport->personal_info->full_name}} </td>

                                                    <td>{{ $agreement->cancel_reason}} </td>
                                                    <td>{{ $agreement->cancel_date}} </td>
                                                    <td>{{ $agreement->remarks}} </td>


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
        </div>
    </div>








    <div class="modal fade agreement_cancel_modal" id="edit_modal"  data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-2" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content bike_history">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle-2">Agreement Cancel</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                                        <div id="all-check" >
                                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        </div>
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
        $(document).ready(function () {
           'use-strict'
            // datatable_cancel_agreement
            $('#datatable_not_employee ,#datatable_part_time ,#datatable_taking_visa').DataTable( {
                "aaSorting": [[0, 'desc']],
                "pageLength": 10,
                "columnDefs": [
                    {"targets": [0],"visible": false},
                    { "width": 150, "targets": [3]},
                ],

                scrollY: 300,
                responsive: true,
               // scrollX: true,
                // scroller: true
            });
        });

        $(document).ready(function () {
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                var currentTab = $(e.target).attr('href'); // get current tab

                var split_ab = currentTab.split('#');
                // alert(split_ab[1]);

                var table = $('#datatable_'+split_ab[1]).DataTable();
                        $('#container').css( 'display', 'block' );
                        table.columns.adjust().draw();
            }) ;
        });

        $(".upload_agreement_cls").click(function(){

            var ids = $(this).attr('id');

            $("#primary_id").val(ids);

            $("#edit_modal").modal('show');

        });

    </script>

    <script>
        $(".amendment_modal_cls").click(function () {
                var ab = $(this).attr('id');
                var now_id  = ab.split('-');

            var final_id = now_id[1];

            $("#history_modal").modal('show');

            var token = $("input[name='_token']").val();
            $.ajax({
                url: "{{ route('get_amendment_history_ajax') }}",
                method: 'POST',
                data: {agreement_id: final_id , _token:token},
                success: function(response) {
                    $("#history_modal_body").html('');
                    $("#history_modal_body").append(response);

                }
            });


        });
     </script>
    <script>
        $(".btn-cancel").click(function(){
            // var pass_id = $("#pass_val").val();
            var id = $(this).attr('id');
            var token = $("input[name='_token']").val();

            $.ajax({
                url: "{{ route('ajax_agreement_cancel') }}",
                method: 'POST',
                dataType: 'json',
                data: {id: id, _token: token},
                success: function (response) {
                    $('#all-check').empty();
                    $('#all-check').append(response.html);
                    $('.agreement_cancel_modal').modal('show');
                }});
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
