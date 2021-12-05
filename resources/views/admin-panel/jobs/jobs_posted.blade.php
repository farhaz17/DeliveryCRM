@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('assets/date/css/tail.datetime-default-orange.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .hide_cls{
            display: none;
        }
        p.ul-widget5__desc {
            margin: 0;
            padding: 0.4rem 0;
            font-size: 1rem;
            font-weight: 400;
            color: #000000;
        }
        table.dataTable thead th {
    border-bottom: none;
    border-top: none;
}
th.sorting {
    display: none;
}
div.dataTables_wrapper div.dataTables_paginate ul.pagination {
    margin: 2px 0;
    white-space: nowrap;
    justify-content: flex-start;

}
div.dataTables_wrapper div.dataTables_filter {
    text-align: left;

}
div.dataTables_wrapper div.dataTables_filter input {

    display: inline-block;
    width: 300px;
    position: relative;
    right: 50%;
}
span.badge.badge-pill.badge-success.m-2 {
    cursor: pointer;
}
.ul-widget5__stats{
    cursor: pointer;
}



@media only screen
        and (min-device-width : 300px)
        and (max-device-width : 600px) {
            div.dataTables_wrapper div.dataTables_filter input {
                display: inline-block;
                width: 300px;
                position: relative;
                right: 0%;
}
}
        </style>

@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Jobs</a></li>
            <li>Create Job</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>


    <div class="row mb-4">
        <div class="col-md-2"></div>
        <div class="col-md-8 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="ul-widget__head">
                                    <div class="ul-widget__head-label">
                                        <h3 class="ul-widget__head-title">Jobs Posted</h3>
                                    </div>
                                </div>
                                <div class="ul-widget__body">
                                    <table width="100%" id="datatable">
                                        <thead>
                                            <tr>
                                                <td>&nbsp</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                    @foreach ($jobs_created as $row )
<tr>
                                        <td>
                                            <div class="ul-widget5">
                                                <div class="ul-widget5__item">
                                                    <div class="ul-widget5__content">

                                                        <div class="ul-widget5__pic">
                                                            @if($row->company=='100')
                                                            <img src="{{asset('assets/images/confidential.jpg')}}" alt="">
                                                            @elseif ($row->company=='1')
                                                            <img src="{{asset('assets/logos/logo1.png')}}" alt="">


                                                            @elseif ($row->company=='2')
                                                            <img src="{{asset('assets/logos/logo2.png')}}" alt="">


                                                            @elseif ($row->company=='3')
                                                            <img src="{{asset('assets/logos/logo3.png')}}" alt="">


                                                            @elseif ($row->company=='4')
                                                            <img src="{{asset('assets/logos/logo4.png')}}" alt="">


                                                            @elseif ($row->company=='5')
                                                            <img src="{{asset('assets/logos/logo5.png')}}" alt="">


                                                            @elseif ($row->company=='6')
                                                            <img src="{{asset('assets/logos/logo6.png')}}" alt="">


                                                            @elseif ($row->company=='7')
                                                            <img src="{{asset('assets/logos/logo7.png')}}" alt="">


                                                            @elseif ($row->company=='8')
                                                            <img src="{{asset('assets/logos/no_logo.png')}}" alt="">


                                                            @elseif ($row->company=='9')
                                                            <img src="{{asset('assets/logos/logo9.png')}}" alt="">

                                                            @elseif ($row->company=='10')
                                                            <img src="{{asset('assets/logos/logo10.png')}}" alt="">

                                                            @elseif ($row->company=='11')
                                                            <img src="{{asset('assets/logos/no_logo.png')}}" alt="">

                                                            @elseif ($row->company=='12')
                                                            <img src="{{asset('assets/logos/no_logo.png')}}" alt="">


                                                            @elseif ($row->company=='13')
                                                            <img src="{{asset('assets/logos/no_logo.png')}}" alt="">

                                                            @elseif ($row->company=='14')
                                                            <img src="{{asset('assets/logos/no_logo.png')}}" alt="">

                                                            @elseif ($row->company=='15')
                                                            <img src="{{asset('assets/logos/logo2.png')}}" alt="">

                                                            @elseif ($row->company=='16')
                                                            <img src="{{asset('assets/logos/logo2.png')}}" alt="">

                                                            @elseif ($row->company=='17')
                                                            <img src="{{asset('assets/logos/logo2.png')}}" alt="">

                                                            @elseif ($row->company=='18')
                                                            <img src="{{asset('assets/logos/logo2.png')}}" alt="">

                                                            @elseif ($row->company=='19')
                                                            <img src="{{asset('assets/logos/logo19.png')}}" alt="">


                                                            @else
                                                            <img src="{{asset('assets/logos/logo1.png')}}" alt="">
                                                            @endif


                                                        </div>
                                                        <div class="ul-widget5__section">
                                                            <a class="ul-widget4__title" href="#">{{$row->states_detail->name}}, United Arab Emirates</a>
                                                            <p class="ul-widget5__desc">{{$row->job_title}}</p>
                                                            <div class="ul-widget5__info"><span>Start Date:</span>
                                                                <span class="text-primary">{{$row->start_date}}</span>
                                                                <span>Close Date:</span><span class="text-primary">{{$row->end_date}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="ul-widget5__content">
                                                        <div class="ul-widget5__stats">
                                                            @if ($row->status=='1' || $current_date < $row->end_date)
                                                            <span class="badge badge-success">Active</span>
                                                            @else
                                                            <span class="badge badge-danger">Deactive</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="ul-widget5__content">
                                                        <div class="ul-widget5__stats" onclick="view_jobs_wise({{$row->id}})">
                                                            <span class="ul-widget5__number text-center">{{count($total_applicants->where('job_id',$row->id))}}</span>
                                                            <span class="ul-widget5__sales text-mute">Applicants</span>
                                                        </div>
                                                        <div class="ul-widget5__stats">

                                     <span class="badge badge-pill badge-success m-2"  onclick="viewJobDetail({{$row->id}})" >View Detail</span>

                                                          </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                            @endforeach
                                        </tbody>


                                        </table>
                                    </div>
                                </div>
                            </div>



                    </div>







                <div class="col-md-2"></div>
            </div>

{{-- -------------- visa process modals----------------- --}}

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">

                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body row_show_offer">


            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" type="button" data-dismiss="modal">Close</button>
                {{-- <button class="btn btn-primary ml-2" type="button">Save changes</button> --}}
            </div>
        </div>
    </div>
</div>
{{-- -------------- visa process modals ends here----------------- --}}








@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>




    <script>
        function viewJobDetail(id)
            {
                var id=id;
                var token = $("input[name='_token']").val();
                $.ajax({
                            url: "{{ route('get_job_detail') }}",
                            method: 'POST',
                            dataType: 'json',
                            data:{id:id,_token:token},
                            beforeSend: function () {
                                $("body").addClass("loading");
                        },
                            success: function (response) {
                                $('.row_show_offer').empty();
                                $("body").removeClass("loading");
                                $('.row_show_offer').append(response.html);
                                $('.bd-example-modal-lg').modal('show');
                            }
                        });
            }
    </script>



<script>
    function view_jobs_wise(id)
        {
            var id=id;
            location.replace("{{ url('view_jobs_title_sort') }}/"+id);
        }
</script>


<script>
    $(document).ready(function () {
  $('.dataTables_filter input[type="search"]').css(
     {'width':'350px','display':'inline-block'}
  );
});
</script>

<script>
       $(document).ready(function () {
            'use strict';

            $('#datatable').DataTable( {
                "aaSorting": [],
                "pageLength": 15,
                "columnDefs": [
                    {"targets": [0],"visible": true},


                ],
                language: { search: "" ,
                searchPlaceholder: "Search....."},
                "scrollY": true,
                "scrollX": true,
                "bPaginate": true,
                "bLengthChange": false,
                "bFilter": true,
                "bInfo": false,
                "bAutoWidth": false,
                    responsive: true

            });


        });
</script>

<script>
     $('#company').select2({
        placeholder: 'Select an option'
    });
    $('#state').select2({
        placeholder: 'Select an option'
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
