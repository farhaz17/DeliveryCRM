<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item"><a class="nav-link active" id="home-basic-tab" data-toggle="tab" href="#homeBasic" role="tab" aria-controls="homeBasic" aria-selected="true">Platform Detail </a></li>
    <li class="nav-item"><a class="nav-link" id="profile-basic-tab" data-toggle="tab" href="#profileBasic" role="tab" aria-controls="profileBasic" aria-selected="false">Bike Detail</a></li>
    <li class="nav-item"><a class="nav-link" id="sim-basic-tab" data-toggle="tab" href="#simBasic" role="tab" aria-controls="simBasic" aria-selected="false">SIM Detail</a></li>
</ul>
<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="homeBasic" role="tabpanel" aria-labelledby="home-basic-tab">

        <table class="table" id="datatable3" style="width: 100%">
            <div class="card-title">Platform Detail</div>
            <thead class="thead-dark">
            <tr>
                <th scope="col" style="width: 100px">Plate No</th>
                <th scope="col" style="width: 100px">Check In</th>
                <th scope="col" style="width: 100px">Check Out</th>
                <th scope="col" style="width: 100px">Remarks</th>

            </tr>
            </thead>
            <tbody>
            @foreach($platform_assign as $row)
                <tr>
                    <td>{{isset($row->plateformdetail->name)?$row->plateformdetail->name:"N/A"}}</td>
                    <td>{{isset($row->checkin)?$row->checkin:"N/A"}}</td>
                    <td>{{isset($row->checkout)?$row->checkout:"N/A"}}</td>
                    <td>{{isset($row->remarks)?$row->remarks:"N/A"}}</td>

                </tr>

            @endforeach
            </tbody>
        </table>

    </div>

    <div class="tab-pane fade" id="profileBasic" role="tabpanel" aria-labelledby="profile-basic-tab">


        <table class="table" id="datatable4"  style="width: 100%">
            <div class="card-title">Bike Detail</div>
            <thead class="thead-dark">
            <tr>
                <th scope="col" style="width: 100px">Plate Number</th>
                <th scope="col" style="width: 100px">Check In</th>
                <th scope="col" style="width: 100px">Check Out</th>
                <th scope="col" style="width: 100px">Remarks</th>
            </tr>
            </thead>
            <tbody>
            @foreach($platform_bike as $row)
                <tr>
                    <td>{{isset($row->bike_plate_number->plate_no)?$row->bike_plate_number->plate_no:"N/A"}}</td>
                    <td>{{isset($row->checkin)?$row->checkin:"N/A"}}</td>
                    <td>{{isset($row->checkout)?$row->checkout:"N/A"}}</td>
                    <td>{{isset($row->remarks)?$row->remarks:"N/A"}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>



    <div class="tab-pane fade" id="simBasic" role="tabpanel" aria-labelledby="profile-basic-tab">


        <table class="table" id="datatable5"  style="width: 100%">
            <div class="card-title">Sim Detail</div>
            <thead class="thead-dark">
            <tr>
                <th scope="col" style="width: 100px">SIm No</th>
                <th scope="col" style="width: 100px">Check In</th>
                <th scope="col" style="width: 100px">Check Out</th>
                <th scope="col" style="width: 100px">Remarks</th>
            </tr>
            </thead>
            <tbody>
            @foreach($platform_sim as $row)
                <tr>
                    <td>{{isset($row->telecome->account_number)?$row->telecome->account_number:"N/A"}}</td>
                    <td>{{isset($row->checkin)?$row->checkin:"N/A"}}</td>
                    <td>{{isset($row->checkout)?$row->checkout:"N/A"}}</td>
                    <td>{{isset($row->remarks)?$row->remarks:"N/A"}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>


</div>






<script>
    $(document).ready(function () {
        'use strict';
        $('#datatabl3,#datatable4,#datatable5').DataTable( {
            "aaSorting": [[0, 'desc']],
            "language": {
                processing: "<img id='loader' src='{{ asset('assets/images/pre-load.gif') }}'>",
            },
            "pageLength": 10,
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    title: 'Report',
                    text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                    exportOptions: {
                        modifier: {
                            page : 'all',
                        }
                    }
                },
                'pageLength',
            ],
            "scrollY": true,
            "scrollX": true,

        });
    });
</script>
<script>
    $(document).ready(function () {
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            var currentTab = $(e.target).attr('id'); // get current tab
            var split_ab = currentTab;
            if(split_ab=="home-basic-tab"){
                var table = $('#datatable3').DataTable({
                    paging: true,
                    info: true,
                    searching: true,
                    autoWidth: false,
                    retrieve: true
                });

                table.columns.adjust().draw();
            }

            else if(split_ab=="profile-basic-tab"){
                var table = $('#datatable4').DataTable({
                    paging: true,
                    info: true,
                    searching: true,
                    autoWidth: false,
                    retrieve: true
                });

                table.columns.adjust().draw();
            }
            else{
                var table = $('#datatable5').DataTable({
                    paging: true,
                    info: true,
                    searching: true,
                    autoWidth: false,
                    retrieve: true
                });

                table.columns.adjust().draw();
            }


        }) ;
    });

</script>
