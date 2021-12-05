<div class="card text-left">
    <div class="card-body">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item"><a class="nav-link active" id="home-basic-tab" data-toggle="tab" href="#homeBasic" role="tab" aria-controls="homeBasic" aria-selected="true">Present </a></li>
            <li class="nav-item"><a class="nav-link" id="profile-basic-tab" data-toggle="tab" href="#profileBasic" role="tab" aria-controls="profileBasic" aria-selected="false">Absent</a></li>
            <li class="nav-item"><a class="nav-link" id="leave-basic-tab" data-toggle="tab" href="#leaveBasic" role="tab" aria-controls="leaveBasic" aria-selected="false">Leave</a></li>
        </ul>
      <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="homeBasic" role="tabpanel" aria-labelledby="home-basic-tab">
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
                    <th scope="col" style="width: 200px">Attendance Action</th>

                </tr>
                </thead>
                <tbody>

                @foreach($attendance as $row)
                        @if(in_array(1, auth()->user()->user_group_id))
                    <?php
                        $platform_id=$row->passport->assign_platforms_check() ? $row->passport->assign_platforms_check()->plateformdetail->id:"N/A"
                    ?>
                <tr>


                    <td>{{$row->created_at}}</td>
                    <td>{{isset($row->passport->personal_info->full_name)?$row->passport->personal_info->full_name:"N/A"}}</td>
                    <td>{{isset($row->passport->zds_code->zds_code)?$row->passport->zds_code->zds_code:"N/A"}}</td>
                    <td>{{isset($row->passport->pp_uid)?$row->passport->pp_uid:"N/A"}}</td>
                    <td>{{isset($row->passport->passport_no)?$row->passport->passport_no:"N/A"}}</td>
                    <td>{{$row->passport->assign_platforms_check() ? $row->passport->assign_platforms_check()->plateformdetail->name:"N/A"}}</td>
                    <td>{{isset($row->passport->get_the_rider_id_by_platform($platform_id)->platform_code)?$row->passport->get_the_rider_id_by_platform($platform_id)->platform_code:"N/A"}}</td>
                    <td>Present</td>
                    <td>
                        <a class="btn btn-danger present-btn" id="{{$row->id}}" data-toggle="modal"  data-created="{{$date_search}}" data-id="{{$row->passport->id}}" data-target="#leaveModal" href="javascript:void(0)">Leave</a>
                    </td>
                </tr>
                @elseif(in_array($row->passport->assign_platforms_check() ? $row->passport->assign_platforms_check()->plateform:'', auth()->user()->user_platform_id))
                    <?php
                    $platform_id=$row->passport->assign_platforms_check() ? $row->passport->assign_platforms_check()->plateformdetail->id:"N/A"
                    ?>
                    <tr>
                        <td>{{$row->created_at}}</td>
                        <td>{{isset($row->passport->personal_info->full_name)?$row->passport->personal_info->full_name:"N/A"}}</td>
                        <td>{{isset($row->passport->zds_code->zds_code)?$row->passport->zds_code->zds_code:"N/A"}}</td>
                        <td>{{isset($row->passport->pp_uid)?$row->passport->pp_uid:"N/A"}}</td>
                        <td>{{isset($row->passport->passport_no)?$row->passport->passport_no:"N/A"}}</td>
                        <td>{{$row->passport->assign_platforms_check() ? $row->passport->assign_platforms_check()->plateformdetail->name:"N/A"}}</td>
                        <td>{{isset($row->passport->get_the_rider_id_by_platform($platform_id)->platform_code)?$row->passport->get_the_rider_id_by_platform($platform_id)->platform_code:"N/A"}}</td>
                        <td>Present</td>
                        <td>
                            <a class="btn btn-danger present-btn" id="{{$row->id}}" data-toggle="modal"  data-created="{{$date_search}}" data-id="{{$row->passport->id}}" data-target="#leaveModal" href="javascript:void(0)">Leave</a>
                        </td>
                    </tr>
                    @endif
                @endforeach
                    </tbody>
                </table>

       </div>

            <div class="tab-pane fade" id="profileBasic" role="tabpanel" aria-labelledby="profile-basic-tab">


                <table class="table" id="datatable2"  style="width: 100%">
                    <thead class="thead-dark">
                    <tr>
                        <th><input id="checkAll" type="checkbox"></th>
                        <th scope="col" style="width: 100px">Date</th>
                        <th scope="col" style="width: 100px">Name</th>
                        <th scope="col" style="width: 100px">ZDS Code</th>
                        <th scope="col" style="width: 100px">PPUID</th>
                        <th scope="col" style="width: 100px">Passport No</th>
                        <th scope="col" style="width: 100px">Plat</th>
                        <th scope="col" style="width: 100px">Rider Code</th>
                        <th scope="col" style="width: 100px">Attendance Status</th>
                        <th scope="col" style="width: 200px">Attendance Action</th>

                    </tr>
                    </thead>
                    <tbody>


                    @foreach($rider_profile as $row)
                        @if(in_array(1, auth()->user()->user_group_id))
                            <?php
                            $platform_id=$row->passport->assign_platforms_check() ? $row->passport->assign_platforms_check()->plateformdetail->id:"N/A"
                            ?>
                        <tr>
                            <td><input id="selectTransfer" type="checkbox" name="checked[]" class="form-group transfer-checkbox" value="{{ $row->passport->id }}"></td>
                            <td>{{$date_search}}</td>
                            <td>{{isset($row->passport->personal_info->full_name)?$row->passport->personal_info->full_name:"N/A"}}</td>
                            <td>{{isset($row->passport->zds_code->zds_code)?$row->passport->zds_code->zds_code:"N/A"}}</td>
                            <td>{{isset($row->passport->pp_uid)?$row->passport->pp_uid:"N/A"}}</td>
                            <td>{{isset($row->passport->passport_no)?$row->passport->passport_no:"N/A"}}</td>
                            <td>{{$row->passport->assign_platforms_check() ? $row->passport->assign_platforms_check()->plateformdetail->name:"N/A"}}</td>
                            <td>{{isset($row->passport->get_the_rider_id_by_platform($platform_id)->platform_code)?$row->passport->get_the_rider_id_by_platform($platform_id)->platform_code:"N/A"}}</td>
                            <td>Absent</td>
                            <td>
                                <a class="btn btn-success present-btn" id="{{$row->id}}" data-toggle="modal"  data-created="{{$date_search}}" data-id="{{$row->passport->id}}" data-target="#presentModal" href="javascript:void(0)">Present</a>
                                <a class="btn btn-danger present-btn" id="{{$row->id}}" data-toggle="modal"  data-created="{{$date_search}}" data-id="{{$row->passport->id}}" data-target="#leaveModal" href="javascript:void(0)">Leave</a>
                            </td>
                        </tr>

                        @elseif(in_array($row->passport->assign_platforms_check() ? $row->passport->assign_platforms_check()->plateform:'', auth()->user()->user_platform_id))
                            <?php
                            $platform_id=$row->passport->assign_platforms_check() ? $row->passport->assign_platforms_check()->plateformdetail->id:"N/A"
                            ?>
                            <tr>
                                <td><input id="selectTransfer" type="checkbox" name="checked[]" class="form-group transfer-checkbox" value="{{ $row->passport->id }}"></td>
                                <td>{{$date_search}}</td>
                                <td>{{isset($row->passport->personal_info->full_name)?$row->passport->personal_info->full_name:"N/A"}}</td>
                                <td>{{isset($row->passport->zds_code->zds_code)?$row->passport->zds_code->zds_code:"N/A"}}</td>
                                <td>{{isset($row->passport->pp_uid)?$row->passport->pp_uid:"N/A"}}</td>
                                <td>{{isset($row->passport->passport_no)?$row->passport->passport_no:"N/A"}}</td>
                                <td>{{$row->passport->assign_platforms_check() ? $row->passport->assign_platforms_check()->plateformdetail->name:"N/A"}}</td>
                                <td>{{isset($row->passport->get_the_rider_id_by_platform($platform_id)->platform_code)?$row->passport->get_the_rider_id_by_platform($platform_id)->platform_code:"N/A"}}</td>
                                <td>Absent</td>
                                <td>
                                    <a class="btn btn-success present-btn" id="{{$row->id}}" data-toggle="modal"  data-created="{{$date_search}}" data-id="{{$row->passport->id}}" data-target="#presentModal" href="javascript:void(0)">Present</a>
                                    <a class="btn btn-danger present-btn" id="{{$row->id}}" data-toggle="modal"  data-created="{{$date_search}}" data-id="{{$row->passport->id}}" data-target="#leaveModal" href="javascript:void(0)">Leave</a>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
                <div>
                    <a class="btn btn-success present-btn" id="bulkTransferPresent"  data-toggle="modal" data-created="{{$date_search}}"  data-target="#presentBulkModal" href="javascript:void(0)">Present Selected</a>
                    <a class="btn btn-danger present-btn" id="bulkTransferLeave"  data-toggle="modal" data-created="{{$date_search}}"  data-target="#leaveBulkModal" href="javascript:void(0)">Leave Selected</a>
                </div>
            </div>

            <div class="tab-pane fade" id="leaveBasic" role="tabpanel" aria-labelledby="leave-basic-tab">
                <table class="table" id="datatable4"  style="width: 100%">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col" style="width: 100px">Date</th>
                        <th scope="col" style="width: 100px">Name</th>
                        <th scope="col" style="width: 100px">ZDS Code</th>
                        <th scope="col" style="width: 100px">PPUID</th>
                        <th scope="col" style="width: 100px">Passport No</th>
                        <th scope="col" style="width: 100px">Plat</th>
                        <th scope="col" style="width: 100px">Rider Code</th>
                        <th scope="col" style="width: 100px">Attendance Status</th>
                        <th scope="col" style="width: 200px">Attendance Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($leave as $row)
                        @if(in_array(1, auth()->user()->user_group_id))
                            <?php
                            $platform_id=$row->passport->assign_platforms_check() ? $row->passport->assign_platforms_check()->plateformdetail->id:"N/A"
                            ?>
                            <tr>
                                <td>{{$date_search}}</td>
                                <td>{{isset($row->passport->personal_info->full_name)?$row->passport->personal_info->full_name:"N/A"}}</td>
                                <td>{{isset($row->passport->zds_code->zds_code)?$row->passport->zds_code->zds_code:"N/A"}}</td>
                                <td>{{isset($row->passport->pp_uid)?$row->passport->pp_uid:"N/A"}}</td>
                                <td>{{isset($row->passport->passport_no)?$row->passport->passport_no:"N/A"}}</td>
                                <td>{{$row->passport->assign_platforms_check() ? $row->passport->assign_platforms_check()->plateformdetail->name:"N/A"}}</td>
                                <td>{{isset($row->passport->get_the_rider_id_by_platform($platform_id)->platform_code)?$row->passport->get_the_rider_id_by_platform($platform_id)->platform_code:"N/A"}}</td>
                                <td>Absent</td>
                                <td>
                                    <a class="btn btn-success present-btn" id="{{$row->id}}" data-toggle="modal"  data-created="{{$date_search}}" data-id="{{$row->passport->id}}" data-target="#presentModal" href="javascript:void(0)">Present</a>
                                </td>
                            </tr>
                        @elseif(in_array($row->passport->assign_platforms_check() ? $row->passport->assign_platforms_check()->plateform:'', auth()->user()->user_platform_id))
                            <?php
                            $platform_id=$row->passport->assign_platforms_check() ? $row->passport->assign_platforms_check()->plateformdetail->id:"N/A"
                            ?>
                            <tr>
                                <td>{{$date_search}}</td>
                                <td>{{isset($row->passport->personal_info->full_name)?$row->passport->personal_info->full_name:"N/A"}}</td>
                                <td>{{isset($row->passport->zds_code->zds_code)?$row->passport->zds_code->zds_code:"N/A"}}</td>
                                <td>{{isset($row->passport->pp_uid)?$row->passport->pp_uid:"N/A"}}</td>
                                <td>{{isset($row->passport->passport_no)?$row->passport->passport_no:"N/A"}}</td>
                                <td>{{$row->passport->assign_platforms_check() ? $row->passport->assign_platforms_check()->plateformdetail->name:"N/A"}}</td>
                                <td>{{isset($row->passport->get_the_rider_id_by_platform($platform_id)->platform_code)?$row->passport->get_the_rider_id_by_platform($platform_id)->platform_code:"N/A"}}</td>
                                <td>Absent</td>
                                <td>
                                    <a class="btn btn-success present-btn" id="{{$row->id}}" data-toggle="modal"  data-created="{{$date_search}}" data-id="{{$row->passport->id}}" data-target="#presentModal" href="javascript:void(0)">Present</a>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>

            </div>


    <!------------------------------------>
    </div>
</div>

<!---------Present---------->
<div class="modal fade" id="presentModal" tabindex="-1" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="row">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="verifyModalContent_title"></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="row container text-center">
                        <h3>Are You Sure<h3>
                    </div>
                </div>

                <div class="renew">
                    <form id="presentForm"  method="" action="">

                        <input type="hidden" id="id" name="passport_id" />
                        <input type="hidden" id="createdAt" name="created_at" />

                        <div class="modal-footer">
                            <div class="col-md-12">
                                <input id="presentSubmit" type="submit" name="present" class="btn btn-success" value="Yes" onclick="return false;">
                                <button class="btn btn-danger" type="button" data-dismiss="modal" aria-label="Close">Noo</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

    <!---------PresentBulk---------->
<div class="modal fade" id="presentBulkModal" tabindex="-1" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="row">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="verifyModalContent_title"></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="row container text-center">
                        <h3>Are You Sure<h3>
                    </div>
                </div>

                    <div class="renew">
                        <form id="presentForm"  method="" action="">

                            <div id="passport_ids">
                            </div>
                            <input type="hidden" id="createdAt" name="created_at" />

                            <div class="modal-footer">
                                <div class="col-md-12">
                                    <input id="presentBulkSubmit" type="submit" name="present" class="btn btn-success" value="Yes" onclick="return false;">
                                    <button class="btn btn-danger" type="button" data-dismiss="modal" aria-label="Close">Noo</button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

<!---------Leave---------->
<div class="modal fade" id="leaveModal" tabindex="-1" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="row">

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="verifyModalContent_title"></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <div class="row container text-center">
                        <h3>Are You Sure<h3>
                    </div>
                </div>

                    <div class="renew">
                        <form   method="" action="">

                            <input type="hidden" id="id" name="passport_id" />
                            <input type="hidden" id="createdAt" name="created_at" />

                            <div class="modal-footer">
                                <div class="col-md-12">
                                    <input id="leaveSubmit" type="submit" name="leave" class="btn btn-success" value="Yes">
                                    <button class="btn btn-danger" type="button" data-dismiss="modal" aria-label="Close">No</button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="leaveBulkModal" tabindex="-1" role="dialog" aria-labelledby="verifyModalContent" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="row">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="verifyModalContent_title"></h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="row container text-center">
                            <h3>Are You Sure<h3>
                        </div>
                    </div>

                        <div class="renew">
                            <form method="" action="">

                                <div id="leave_passport_ids">
                                </div>
                                <input type="hidden" id="createdAt" name="created_at" />

                                <div class="modal-footer">
                                    <div class="col-md-12">
                                        <input id="leaveBulkSubmit" type="submit" name="present" class="btn btn-success" value="Yes" onclick="return false;">
                                        <button class="btn btn-danger" type="button" data-dismiss="modal" aria-label="Close">Noo</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    <script>
        $(document).ready(function () {
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                var currentTab = $(e.target).attr('id'); // get current tab
                var split_ab = currentTab;
                if(split_ab=="home-basic-tab"){
                    var table = $('#datatable').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }  if(split_ab=="profile-basic-tab"){
                    var table = $('#datatable2').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }if(split_ab=="leave-basic-tab"){
                    var table = $('#datatable4').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw();
                }
                else{
                    var table = $('#datatable6').DataTable();
                    $('#container').css( 'display', 'block' );
                    table.columns.adjust().draw()

                }


            }) ;
        });

        $('#checkAll').click(function(e) {
            $(':checkbox', $('#datatable2').DataTable().rows().nodes()).prop('checked', this.checked);
        });

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
            "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
            "scrollY": true,
            "scrollX": true,

        });
    });

    </script>
