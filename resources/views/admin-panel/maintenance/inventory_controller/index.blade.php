@extends('admin-panel.base.main')
@section('css')
    <link rel="stylesheet" href="{{asset('assets/css/plugins/toastr.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/css/plugins/datatables.min.css')}}" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container {
            width: 100% !important;
            padding: 0;
        }
        .dataTables_scrollHeadInner {
            table-layout:fixed;
            width:100% !important;
        }
        div.dataTables_scrollHead table.dataTable {
            width:100% !important;
        }

        .btn-css {
            width: 145px;
            height: 25px;
            padding: 1px;
            font-weight: bold;
        }
.form-css {
    height: 25px;
    padding: 3px;
}
#add_to_list {
    height: 25px;
    width: 33px;
    padding: 1px;
}
#del_btn {
    height: 25px;
    width: 33px;
    padding: 1px;
}
span#select2-bike_part-container {
    font-size: 9px;
    font-weight: bold;
}
button#manage_repair_add_btn {
    width: 100px;
}
button#manage_repair_start_btn {
    width: 100px;
}
button#manage_repair_complete_btn {
    width: 100px;
}

button#manage_repair_save_btn {
    width: 100px;
}
button#manage_repair_del_btn {
    /* width: 100px; */
    /* height: 23px; */
}
#datatable .table th, .table td{
        border-top : unset !important;
    }
     .table th, .table td{
        padding: 0px !important;
    }
    .table th{
        padding: 2px;
        font-size: 12px;
    }
    .table td{
        padding: 2px;
        font-size: 12px;
    }
    .table th{
        padding: 2px;
        font-size: 12px;
        font-weight: 600;
    }
    .dataTableLayout {
        table-layout:fixed;
        width:100%;
    }

    </style>
@endsection
@section('content')
    <div class="breadcrumb">
        <h1 class="mr-2">Home</h1>
        <ul>
            <li><a href="">Operation</a></li>
            <li>Parts Requests</li>
        </ul>
    </div>
    <div class="separator-breadcrumb border-top"></div>

 <div class="container-fluid">
   <div class="row main-row">
       <div class="col-md-1"></div>
   <div class="col-md-10">
        <div class="card text-left">
            <div class="card-body">
                <div class="table-responsive">
                    <table  id="datatable" class="table table-sm table-hover table-striped text-11 data_table_cls" >
                        <thead>
                        <tr>
                            <th scope="col"> <b> # </b></th>
                            <th scope="col"> <b>Entry No</b></th>
                            <th scope="col"> <b>Parts</b></th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php $count =1; ?>
                        @foreach($inv_request as $row)
                            <tr>
                                <th scope="row">{{$count}}</th>
                                <td>{{$row->manage_repair->repair_no}}</td>
                                <td><button class="btn text-success"  onclick="get_inv_parts({{$row->id}})" type="button"><i class="i-Gear-2 font-weight-bold"></i></button></td>
                            </tr>
                            <?php $count = $count+1; ?>
                        @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
</div>
<div class="col-md-1"></div>

   </div>
</div>
<audio id="myAudio" src="{{asset('assets/sounds/notify.mp3')}}" style="display: none">
</audio>

 {{-- pop models starts here --}}

 <div class="modal fade bd-example-modal-lg-1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle-1">List of Parts</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="checkup_points_pop veri"></div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary"  type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" id="presentBulkSubmit" type="submit" >Verify</button>
                </div>

        </div>
    </div>
</div>
</div>
</div>
{{-- pop models ends here --}}


@endsection
@section('js')
    <script src="{{asset('assets/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/toastr.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    {{-- <script src="https://js.pusher.com/4.2/pusher.min.js"></script> --}}
    <!-- Alert whenever a new notification is pusher to our Pusher Channel -->

    <script>
    // Enable pusher logging - don't include this in production
    // Pusher.logToConsole = true;

    var pusher = new Pusher('794af290dd47b56e7bc9', {
      cluster: 'ap2',
      encrypted: true
    });

    var channel = pusher.subscribe('notify');
    channel.bind('notify-event', function(message) {

        var x = document.getElementById("myAudio");
        function playAudio() {
        x.play();
         }

        toastr.info("You Have a New Part Request", { timeOut:10000 , progressBar : true});

        window.setTimeout(function(){
                            location.reload(true)
                        },5000);
    });

    </script>

    <script>


    </script>

    <script>

        $('#datatable').DataTable( {
                    "aaSorting": [[0, 'desc']],
                    "pageLength": 10,
                    "columnDefs": [

                    ],
                    "scrollY": false,
                });
    </script>





<script>
    function get_inv_parts(id)
    {
        var id = id;
        var url = '{{ route('get_inv_parts', ":id") }}';
        var token = $("input[name='_token']").val();
        $.ajax({
                    url: url,
                    method: 'POST',
                    dataType: 'json',
                    data: {id: id, _token: token},
                    success: function (response) {
                        $(".checkup_points_pop").empty();
                        $('.checkup_points_pop').html(response.html);
                        $('.bd-example-modal-lg-1').modal('show');
                        var table = $('#datatable_parts_modal').DataTable({
                                paging: true,
                                info: true,
                                searching: true,
                                autoWidth: false,
                                retrieve: true
                            });
                            table.columns.adjust().draw();

                    }
                });
    }
</script>

<script>


    $(document).on("click", "#presentBulkSubmit", function (e) {





            var part_id_checked =   $("input[name='checked[]']:checked").map(function(){
                                    return this.value;
                                }).get();

              var part_id =   $("input[name='part_id[]']").map(function(){
                 return this.value;
                }).get();
            var qty_verified =   $("input[name='checkeds[]']").map(function(){
                                    return this.value;
                                }).get();

              var qty_orignal =   $("input[name='qty_orignal[]']").map(function(){
                 return this.value;
                }).get();

                var company_or_own =   $("input[name='company_or_own[]']").map(function(){
                 return this.value;
                }).get();

                var comments =   $("input[name='comments[]']").map(function(){
                 return this.value;
                }).get();


             var repair_sale_id = $("input[name='repair_sale_id']").val();

             var key =   $("input[name='key[]']").map(function(){
                 return this.value;
                }).get();




                    $.ajax({
                        type: 'post',
                        url: "{{ route('very_inv') }}",
                        data: {_token: "{{ csrf_token() }}", part_id:part_id, qty_verified:qty_verified,qty_orignal:qty_orignal,repair_sale_id:repair_sale_id,key:key,company_or_own:company_or_own,comments:comments},
                        success: function (response) {
                            $(".veri").empty();
                            $('.bd-example-modal-lg-1').modal('hide');

                            toastr.success("Verified");
                        },

            });

    });

    </script>





    <script>

var options = {
autoClose: true,
progressBar: true,
enableSounds: true,
sounds: {

info: "https://res.cloudinary.com/dxfq3iotg/video/upload/v1557233294/info.mp3",
// path to sound for successfull message:
success: "https://res.cloudinary.com/dxfq3iotg/video/upload/v1557233524/success.mp3",
// path to sound for warn message:
warning: "https://res.cloudinary.com/dxfq3iotg/video/upload/v1557233563/warning.mp3",
// path to sound for error message:
error: "https://res.cloudinary.com/dxfq3iotg/video/upload/v1557233574/error.mp3",
},
};
        @if(Session::has('message'))
        var type = "{{ Session::get('alert-type', 'info') }}";
        switch(type){

            case 'info':
                toastr.info("{{ Session::get('message') }}", "Information!", { timeOut:10000 , progressBar : true});
                });
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
