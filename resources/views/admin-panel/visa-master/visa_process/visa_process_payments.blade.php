@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.css"/>

<style>
        .fc .fc-col-header-cell-cushion {
            display: inline-block !important;
            padding: 2px 4px !important;
        }
        .fc .fc-col-header-cell-cushion {
            padding-top: 5px;
            padding-bottom: 5px;
        }

        .fc-day .fc-widget-content  {
            height: 2.5em !important;
        }
        .fc-agendaWeek-view tr {
            height: 40px !important;
        }

        .fc-agendaDay-view tr {
            height: 40px !important;
        }
        .fc-agenda-slots td div {
            height: 40px !important;
        }
        .fc-event-vert {
            min-height: 25px;
        }
        .calendar-parent {
            height: 100vh;
        }

        .fc-toolbar {
            padding: 15px 20px 10px;
        }
        .fc-title{
            color :white;
        }
        .fc-rigid{
            height: 70px !important;;
        }
        /* #datatable2 .table th, .table td{
            border-top : unset !important;
        }
        #datatable .table th, .table td{
            border-top : unset !important;
        } */
        .table th, .table td{
            padding: 0px !important;
        }
        .table th{
            padding: 2px;
            font-size: 14px;
        }
        .table td{
            /*padding: 2px;*/
            font-size: 14px;
        }
        .table th{
            padding: 2px;
            font-size: 14px;
            font-weight: 700;
        }
        input#keyword {
            border-right: none;
            background: #ffffff;
            border-left: none;
        }
        span#basic-addon2 {
            border-left: none;
        }
        hr {
             margin-top: 0rem;
             margin-bottom: 0rem;
            border: 0;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
            height: 0;
        }
        #drop-full_name {
            font-weight: 700;
        }
        #drop-bike {
            font-weight: 700;
            color: #FF0000;
        }
        span#drop-name {
            color: #010165;
        }
        .col-lg-12.sugg-drop {
            width: 400px;
            line-height: 12px;
            font-size: 12px;
            /*border: 1px solid #775dd0;*/
            /*padding-top: 15px;*/
            /*padding-bottom: 15px;*/

        }
        .btn-start {
       padding: 1px;
        }

        .submenu{
            display: none;
        }
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
        tr:hover {background-color:#d8d6d6;}
        th{  pointer-events: none;}

        .page-item.active .page-link {
    z-index: 1;
    color: #fff;
    background-color: #f44336;
    border-color: #f44336;
}

.step_name-text {

/* white-space: nowrap; */

}

.card.mb-4.step-cards {
max-height: 100px;
border: 1px solid gainsboro;
}


    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Visa Process</a></li>
            <li>Visa Process Payments!</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>




<div class="col-md-12">
    <div class="card">
        <div class="card-body">
            <div class="card-title">
            <div class="row">

                <div class="col-md-10">
                    <span class="badge badge-primary">Process Pending Payment Details  </span>
                </div>
                <div class="col-md-2">
                    <span class="badge badge-danger ml-5">Total Amount Pending: {{$total_amount_pending}} </span>
                </div>
              </div>

            </div>
    <div class="row">
    @foreach ($current_steps as $row)
    <div class="col-lg-2 col-md-2 col-sm-2 steps_stages" id="{{$row['step_id']}}">
        <div class="card mb-4 step-cards">
            <div class="card-body">
                <div class="content">
                    {{-- <input type="hidden" name="step_name" value="{{$row['step_name']}}"> --}}
                    <p class="step_name-text font-weight-bold ml-0 mb-0"  style="white-space:nowrap">{{$row['step_name']}}</p>
                    <p class="step_name-text text-danger font-weight-bold ml-0 mb-0" >Amount Pending: {{$row['sum_amount']}}</p>

                    <p class="lead text-primary font-weight-bold text-24 mb-2">{{$row['no']}}</p>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
</div>
</div>

</div>

            <div class="overlay"></div>
{{-- -------------- visa process modals----------------- --}}

 <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Pending Payments At <span id="step_title" class="font-weight-bold"></span></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body" id="add_details">
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>

            </div>
        </div>
    </div>
</div>


@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>


<script>
    $('.steps_stages').click(function() {
//   console.log(this.id);

        var step_id=this.id;
        var token = $("input[name='_token']").val();
        var step_name = $("input[name='step_name']").val();

        // console.log(step_name);

        $.ajax({
                        url: "{{ route('get_visa_payment_detail') }}",
                        method: 'POST',
                        dataType: 'json',
                        data:{step_id:step_id,_token:token},
                        beforeSend: function () {
                            $("body").addClass("loading");
                    },
                        success: function (response) {
                            $('#add_details').empty();
                            $('#step_title').empty();
                            $("body").removeClass("loading");
                            $('#add_details').append(response.html);
                            $('#step_title').append(response.step_name);

                            $('.bd-example-modal-lg').modal('show');


                            var table1 = $('#datatable').DataTable({
                                "autoWidth": true,
                            });
                            table1.columns.adjust().draw();
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
