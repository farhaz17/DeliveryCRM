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
        th{pointer-events: none;}




    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li>Visa Proces</li>
            <li>Renew Visa Process</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>



    <div class="row pb-2" >
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">



                    <div class="col-sm-3"></div>
                    <div class="col-sm-6">

                            <div class="row">
                                <div class="col-md-12 form-group mb-3">
                                    <label for="repair_category">Search</label>
                                    <div class="input-group ">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text bg-transparent" id="basic-addon1">
                                            <i class="i-Magnifi-Glass1"></i>
                                        </span>
                                    </div>
                                        <input class="form-control form-control-sm  typeahead" id="keyword" value="{{ isset($_GET['passport_id']) ? $_GET['passport_id'] : '' }}"
                                        autocomplete="off" type="text" required  name="name" placeholder="search..." aria-label="Username" aria-describedby="basic-addon1">
                                        <div class="input-group-append">
                                            <span class="input-group-text bg-transparent" id="basic-addon2">
                                                <i class="i-Search-People"></i>
                                            </span>
                                        </div>
                                        <input class="form-control" id="passport_number" name="passport_number"
                                        value="{{ isset($_GET['passport_id']) ? $_GET['passport_id'] : '' }}" type="hidden" value="" />
                                    </div>
                                </div>
                            </div>

                    </div>
                    <div class="col-sm-3"></div>
                    </div>
                    <div class="row row_show" style="display: none">

                    </div>

                </div>
            </div>
        </div>
    </div>
    {{-- <div class="submenu" id="documents-menu-items">
        <div class="row"> --}}

            <div class="overlay"></div>
        {{-- </div>
    </div> --}}

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
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.2.7/fullcalendar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>


    <script type="text/javascript">
        var path = "{{ route('autocomplete') }}";
        $('input.typeahead').typeahead({
            source:  function (query, process) {
                return $.get(path, { query: query }, function (data) {

                    return process(data);
                });
            },
            highlighter: function (item, data) {
                var parts = item.split('#'),
                    html = '<div class="row drop-row">';
                if (data.type == 0) {
                    html += '<div class="col-lg-12 sugg-drop">';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.name+'</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name">'  + data.full_name  + '</span>';
                    html += '<div><br></div>';
                    html += '<div><hr></div>';
                    html += '</div>';
                }
                else if(data.type == 1){
                    html += '<div class="col-lg-12 sugg-drop" >';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.name + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name">' +   data.full_name  + '</span>';
                    html += '<div><br></div>'
                    html += '<div><hr></div>';
                    html += '</div>';
                }
                else if(data.type==2){
                    html += '<div class="col-lg-12 sugg-drop" >';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name">' +  data.name +  '</span>';
                    html += '<div><br></div>'
                    html += '<div><hr></div>';
                    html += '</div>';
                }  else if(data.type==2){
                    html += '<div class="col-lg-12 sugg-drop" >';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name">' +  data.name +  '</span>';
                    html += '<div><br></div>'
                    html += '<div><hr></div>';
                    html += '</div>';
                }
                else if (data.type==3){
                    html += '<div class="col-lg-12 sugg-drop" >';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.name + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span>';
                    html += '<div><br></div>'
                    html += '<div><hr></div>';
                    html += '</div>';
                }
                else if (data.type==4){
                    html += '<div class="col-lg-12 sugg-drop" >';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                    html += '<div><br></div>'
                    html += '<div><hr></div>';
                    html += '</div>';
                }
                else if (data.type==5)
                {
                    html += '<div class="col-lg-12 sugg-drop" >';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                    html += '<div><br></div>'
                    html += '<div><hr></div>';
                    html += '</div>';
                }
                else if (data.type==6) {
                    html += '<div class="col-lg-12 sugg-drop" >';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                    html += '<div><br></div>'
                    html += '<div><hr></div>';
                    html += '</div>';
                }
                else if (data.type==7) {
                    html += '<div class="col-lg-12 sugg-drop" >';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                    html += '<div><br></div>'
                    html += '<div><hr></div>';
                    html += '</div>';
                }
                else if (data.type==8) {
                    html += '<div class="col-lg-12 sugg-drop" >';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                    html += '<div><br></div>'
                    html += '<div><hr></div>';
                    html += '</div>';
                }
                else if (data.type==9) {
                    html += '<div class="col-lg-12 sugg-drop" >';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                    html += '<div><br></div>'
                    html += '<div><hr></div>';
                    html += '</div>';
                }
                else if (data.type==10) {
                    html += '<div class="col-lg-12 sugg-drop" >';
                    html += '<span id="drop-name" class="font-weight-bold">' + data.passport + '</span> <span id="drop-ppuid" class="text-success">' + data.ppuid + '</span> <span id="drop-zds_code" class="text-primary">' + data.zds_code + '</span>';
                    html += '<div><br></div>';
                    html += '<span id="drop-full_name" class="font-weight-bold">'  + data.full_name + '</span> <span id="drop-bike" class="font-weight-bold">'  + data.name + '</span>';
                    html += '<div><br></div>'
                    html += '<div><hr></div>';
                    html += '</div>';
                }

                return html;
            }
        });
    </script>







<script>
  $(document).on('click', '.sugg-drop', function(){
                    var token = $("input[name='_token']").val();
                    var keyword  =   $(this).find('#drop-name').text();
                    $.ajax({
                        url: "{{ route('visa_renew_names') }}",
                        method: 'POST',
                        dataType: 'json',
                        data:{keyword:keyword,_token:token},
                        beforeSend: function () {
                            $("body").addClass("loading");
                    },
                        success: function (response) {
                            $('.row_show').empty();

                             $("body").removeClass("loading");

                            $('.row_show').append(response.html);
                            $('.row_show').show();
                        }
                    });
                });
    </script>
<script>
    function refresh(id)
{
            var keyword=id;
            var token = $("input[name='_token']").val();
            $.ajax({
                        url: "{{ route('visa_renew_names') }}",
                        method: 'POST',
                        dataType: 'json',
                        data:{keyword:keyword,_token:token},
                        success: function (response) {
                            $('.row_show').empty();
                             $("body").removeClass("loading");
                            $('.row_show').append(response.html);
                            $('.row_show').show();
                        }
                    });
}
</script>

<?php
if(isset($_GET['passport_id'])){
    ?>
    <script>
         var php_var = "<?php echo  $_GET['passport_id'] ?>";
        //  alert(php_var);
         refresh(php_var)
    </script>


<?php

}

?>










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
