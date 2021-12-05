<div class="card text-left">
    <div class="card-body">



                <table class="table" id="datatable"  style="width: 100%">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col" style="width: 100px">Date</th>
                        <th scope="col" style="width: 100px">Name</th>
                        <th scope="col" style="width: 100px">ZDS Code</th>
                        <th scope="col" style="width: 100px">PPUID</th>
                        <th scope="col" style="width: 100px">Passport No</th>
                        <th scope="col" style="width: 100px">Platform</th>
                        <th scope="col" style="width: 100px">Rider Code</th>
                        <th scope="col" style="width: 100px">Attendance Status</th>

                    </tr>
                    </thead>
                    <tbody>

                    @foreach($attendance as $row)
                        @if(in_array(1, auth()->user()->user_group_id))
                        <tr>
                            <td>{{$row->created_at}}</td>
                            <td>{{isset($row->passport->personal_info->full_name)?$row->passport->personal_info->full_name:""}}</td>
                            <td>{{isset($row->passport->zds_code->zds_code)?$row->passport->zds_code->zds_code:""}}</td>
                            <td>{{isset($row->passport->pp_uid)?$row->passport->pp_uid:""}}</td>
                            <td>{{isset($row->passport->passport_no)?$row->passport->passport_no:""}}</td>
                            <td>

                                {{isset($row->passport->platform->plateformdetail->name)?$row->passport->platform->plateformdetail->name:"N/A"}}

                            </td>
                            <td>{{isset($row->passport->rider_id->platform_code)?$row->passport->rider_id->platform_code:""}}</td>
                            <td>Present</td>
                        </tr>
                        @elseif(in_array($row->passport->personal_info->id, auth()->user()->user_platform_id))
                            <tr>
                                <td>{{$row->created_at}}</td>
                                <td>{{isset($row->passport->personal_info->full_name)?$row->passport->personal_info->full_name:""}}</td>
                                <td>{{isset($row->passport->zds_code->zds_code)?$row->passport->zds_code->zds_code:""}}</td>
                                <td>{{isset($row->passport->pp_uid)?$row->passport->pp_uid:""}}</td>
                                <td>{{isset($row->passport->passport_no)?$row->passport->passport_no:""}}</td>
                                <td>
                                    {{isset($row->passport->platform->plateformdetail->name)?$row->passport->platform->plateformdetail->name:"N/A"}}
                                </td>
                                <td>{{isset($row->passport->rider_id->platform_code)?$row->passport->rider_id->platform_code:""}}</td>
                                <td>

                                    @if(isset($row->status)=='1')
                                    Present
                                    @else
                                    Leave
                                    @endif

                                </td>
                            </tr>
                            @endif
                    @endforeach
                    </tbody>
                </table>

            </div>
            </div>
{{--$2y$10$hoBIt2ZTwuyOozQwNMSUQe1SkcWrrRHpDXkNDwA7OS1MiqhJzfbOG--}}



<script>
    $(document).ready(function () {
        'use strict';
        $('#datatable,#datatable2,#datatable3,#datatable4,#datatable5').DataTable( {
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
                var table = $('#datatable').DataTable();
                $('#container').css( 'display', 'block' );
                table.columns.adjust().draw();
            }
            else{
                var table = $('#datatable2').DataTable();
                $('#container').css( 'display', 'block' );
                table.columns.adjust().draw()

            }


        }) ;
    });

</script>
