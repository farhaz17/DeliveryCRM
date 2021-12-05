<div class="col-md-12 mb-4">
    <div class="card text-left">
        <div class="card-body">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item"><a class="nav-link active" id="{{ str_replace(' ', '', $checkout_type_array['1']) }}-tab" data-toggle="tab" href="#{{  str_replace(' ', '', $checkout_type_array['1']) }}" role="tab" aria-controls="{{  str_replace(' ', '', $checkout_type_array['1']) }}" data-status="{{ "1" }}" aria-selected="true">{{ $checkout_type_array['1'] }} ({{ $all_dc_request_checkouts->where('checkout_type','=','1')->count() }})</a></li>
                <?php $isFirst = true; ?>
                @foreach($checkout_type_array as $key => $checkout)
                    <?php
                    if ($isFirst) {
                        $isFirst = false;
                        continue;
                    }

                    $id_names = str_replace(' ', '', $checkout);

                    $identifier = preg_replace('/[0-9]+/', '', $id_names);
                    ?>
                    <li class="nav-item"><a class="nav-link" id="{{ $identifier }}-tab" data-toggle="tab" href="#{{ $identifier }}" role="tab" aria-controls="{{ $identifier }}" data-status="{{  $key }}"  aria-selected="true">{{ $id_names }}({{ $all_dc_request_checkouts->where('checkout_type','=',$key)->count() }})</a></li>
                @endforeach
            </ul>


            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="{{ str_replace(' ', '', $checkout_type_array['1']) }}" role="tabpanel" aria-labelledby="{{ str_replace(' ', '', $checkout_type_array['1']) }}-tab">
                    <table class="display table table-striped table-bordered" id="1-datatable" style="width: 100%">
                        <thead>
                        <tr>
                            <th>Checkout Date & time</th>
                            <th>Rider Name</th>
                            <th>Passport No</th>
                            <th>Checkout Type</th>
                            <th>Status</th>
                            <th>Requested By</th>
                            <th>Approved</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($checkout_requests as $req)
                        <?php
                        $check_defaulter  = isset($req->defaulter_rider_details) ? $req->defaulter_rider_details : null;
                        $is_defaulte_now = null;

                        if(isset($check_defaulter)){

                                if(count($check_defaulter)>0){
                                    $is_defaulte_now  =  $check_defaulter[0]->check_defaulter_rider() ? $check_defaulter[0]->check_defaulter_rider() : null;

                               }


                        }
                        ?>

                            <tr
                            @isset($is_defaulte_now)
                                style="background-color: #ff18004a;"
                            @endisset
                            >
                                <td>{{ $req->checkout_date_time }}</td>
                                <td>{{ $req->rider_name->personal_info->full_name }}</td>
                                <td>{{ $req->rider_name->passport_no }}</td>
                                <td>{{ $checkout_type_array[$req->checkout_type] }}</td>
                                <?php  $class = ($req->request_status=="1") ? 'success' : 'danger'; ?>
                                <td><h4 class="badge badge-{{ $class }}">{{ $status_array[$req->request_status]  }}</h4></td>
                                <td>{{ $req->request_by->name }}</td>
                                <td>{{ $req->request_approved_by->name }}</td>
                                <td>
                                    @if($req->is_action_approve_status_id=="0")
                                    <?php  $req_rejoin_check = $req->rider_name->check_rejoin_in_waitlist(); ?>
                                                @if($req->rider_name->cancel_status=="1")
                                                <h4 class="badge badge-danger">PPUID Cancelled</h4>

                                                @elseif(isset($req_rejoin_check))
                                                <h4 class="badge badge-primary">Wait List</h4>
                                                @else

                                                <a class="text-primary mr-2 edit" id="{{ $req->id }}" href="javascript:void(0)"><i class="nav-icon i-Pen-6 font-weight-bold"></i></a>
                                                @endif
                                    @else
                                        @if($req->is_action_approve_status_id=="5")
                                            <h4 class="badge badge-primary">Wait List</h4>
                                        @elseif($req->is_action_approve_status_id=="1")
                                            <h4 class="badge badge-info">Onboard</h4>
                                        @endif
                                    @endif

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-------tab1 ends here--------------->


                <?php $isFirst = true; ?>
                @foreach($checkout_type_array as $key => $checkout)
                    <?php
                    if ($isFirst) {
                        $isFirst = false;
                        continue;
                    }
                    $id_names = str_replace(' ', '', $checkout);

                    $identifier = preg_replace('/[0-9]+/', '', $id_names);
                    ?>
                    <div class="tab-pane fade show" id="{{ $identifier }}" role="tabpanel" aria-labelledby="{{ $identifier }}-tab">
                        <table class="display table table-striped table-bordered" id="{{ $key }}-datatable" style="width: 100%">
                            <thead>
                            <tr>
                                <th>Checkout Date & time</th>
                                <th>Rider Name</th>
                                <th>Passport No</th>
                                <th>Checkout Type</th>
                                <th>Status</th>
                                <th>Requested By</th>
                                <th>Approved</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>

                    </div>
            @endforeach



            <!---------------main tab------->
            </div>


        </div>
    </div>
</div>
