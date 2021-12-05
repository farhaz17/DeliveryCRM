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
.card.card-job {
    max-height: 120px;
    overflow: hidden;
    padding: 0px;
    border: none;
    cursor: pointer;
}
.ul-widget5__pic {
    max-width: 130px;
    max-height: 120px;
}
.centerDiv
    {



        display: flex;
  justify-content: center;

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




                <div class="row" >
                    <div class="col-md-2"></div>
                    <div class="col-md-8 mb-4">
                    <div class="card">
                        <div class="card-body">


                    <div class="ul-widget5 mb-1">
                        <div class="ul-widget5__item">
                            <div class="ul-widget5__content">
                                <div class="ul-widget5__pic">
                                    @if($create_job_detail->company=='100')
                                                            <img src="{{asset('assets/images/confidential.jpg')}}" alt="">
                                                            @elseif ($create_job_detail->company=='1')
                                                            <img src="{{asset('assets/logos/logo1.png')}}" alt="">


                                                            @elseif ($create_job_detail->company=='2')
                                                            <img src="{{asset('assets/logos/logo2.png')}}" alt="">


                                                            @elseif ($create_job_detail->company=='3')
                                                            <img src="{{asset('assets/logos/logo3.png')}}" alt="">


                                                            @elseif ($create_job_detail->company=='4')
                                                            <img src="{{asset('assets/logos/logo4.png')}}" alt="">


                                                            @elseif ($create_job_detail->company=='5')
                                                            <img src="{{asset('assets/logos/logo5.png')}}" alt="">


                                                            @elseif ($create_job_detail->company=='6')
                                                            <img src="{{asset('assets/logos/logo6.png')}}" alt="">


                                                            @elseif ($create_job_detail->company=='7')
                                                            <img src="{{asset('assets/logos/logo7.png')}}" alt="">


                                                            @elseif ($create_job_detail->company=='8')
                                                            <img src="{{asset('assets/logos/no_logo.png')}}" alt="">


                                                            @elseif ($create_job_detail->company=='9')
                                                            <img src="{{asset('assets/logos/logo9.png')}}" alt="">

                                                            @elseif ($create_job_detail->company=='10')
                                                            <img src="{{asset('assets/logos/logo10.png')}}" alt="">

                                                            @elseif ($create_job_detail->company=='11')
                                                            <img src="{{asset('assets/logos/no_logo.png')}}" alt="">

                                                            @elseif ($create_job_detail->company=='12')
                                                            <img src="{{asset('assets/logos/no_logo.png')}}" alt="">


                                                            @elseif ($create_job_detail->company=='13')
                                                            <img src="{{asset('assets/logos/no_logo.png')}}" alt="">

                                                            @elseif ($create_job_detail->company=='14')
                                                            <img src="{{asset('assets/logos/no_logo.png')}}" alt="">

                                                            @elseif ($create_job_detail->company=='15')
                                                            <img src="{{asset('assets/logos/logo2.png')}}" alt="">

                                                            @elseif ($create_job_detail->company=='16')
                                                            <img src="{{asset('assets/logos/logo2.png')}}" alt="">

                                                            @elseif ($create_job_detail->company=='17')
                                                            <img src="{{asset('assets/logos/logo2.png')}}" alt="">

                                                            @elseif ($create_job_detail->company=='18')
                                                            <img src="{{asset('assets/logos/logo2.png')}}" alt="">

                                                            @elseif ($create_job_detail->company=='19')
                                                            <img src="{{asset('assets/logos/logo19.png')}}" alt="">


                                                            @else
                                                            <img src="{{asset('assets/logos/logo1.png')}}" alt="">
                                                            @endif
                                </div>
                                <div class="ul-widget5__section">
                                    <a class="ul-widget4__title" href="#">{{$create_job_detail->states_detail->name}}, United Arab Emirates</a>
                                    <h4 class="ul-widget5__desc">{{$create_job_detail->job_title}}</h4>
                                    <div class="ul-widget5__info">
                                        <span>Close Date:</span><span class="text-dark">{{$create_job_detail->end_date}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="centerDiv">
                        <button class="btn btn-danger align-center"  onclick="applyJob({{$create_job_detail->id}})" > Apply</button>
                    </div>


                    </div>
                </div>
                <div class="col-md-2"></div>

                </div>





            <div class="row mb-4">

        <div class="col-md-2"></div>
        <div class="col-md-8 mb-4">
                        <div class="card">
                            <div class="card-body">


                                {!!  html_entity_decode($create_job_detail->job_description,ENT_QUOTES, 'UTF-8') !!}

                            </div>
                        </div>
        </div>





        <div class="col-md-2"></div>
    </div>








@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/date/js/tail.datetime-full.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>


    <script>
        function applyJob(id)
            {
                var id=id;
                location.replace("{{ url('apply_job') }}/"+id);
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
