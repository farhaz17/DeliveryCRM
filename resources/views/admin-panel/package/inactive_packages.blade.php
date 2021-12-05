
                <table class="table" id="datatable1" style="width: 100%">
                    <thead>
                    <tr>
                        <th scope="col">Package No</th>
                        <th scope="col">Package Name</th>
                        <th scope="col">Platform</th>
                        <th scope="col">State</th>
                        <th scope="col">Salary Package</th>
                        <th scope="col">Limitation</th>
                        <th scope="col">Qty</th>
                        <th scope="col">File</th>
                        <th scope="col">No Of Riders</th>
                        <th scope="col">View Riders List</th>
                        <th scope="col">Ammendment</th>
                        <th scope="col">Ammend</th>
                        <th scope="col">No Of Ammendments</th>
                        <th scope="col">Amendment By</th>
                        <th scope="col">Action</th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($inactive_packages as $res)
                        <tr>
                            <td> <a class="badge badge-primary" href="#">{{isset($res->package_no)?$res->package_no:""}}</a></td>
                            <td>{{isset($res->package_name)?$res->package_name:""}}</td>
                            <td>{{$res->state_detail->name}}</td>
                            <td>{{$res->platform_detail->name}}</td>
                            <td>{{ isset($res->salary_package)?$res->salary_package:""}}</td>
                            <td>
                                @if(isset($res->limitation) && $res->limitation=='0' )

                                <span class="badge badge-pill badge-success">Yes</span>
                                @else
                                <span class="badge badge-pill badge-danger">No</span>

                                @endif
                            </td>
                            <td>{{isset($res->qty)?$res->qty:""}}</td>

                            <td>
                                @if(isset($res->file_attachments))
                                @foreach (json_decode($res->file_attachments) as $visa_attach)
                                <a class="btn btn-success btn-file" href="{{Storage::temporaryUrl('assets/upload/packages/'.$visa_attach, now()->addMinutes(5))}}"  target="_blank">
                                    View Attachment
                                </a>
                                    <span>|</span>
                                @endforeach
                                @else
                                N/A
                                @endif

                            </td>

                                <td><span class="badge badge-round-secondary">{{count($package_assign->where('package_id',$res->id))}}</span></td>

                                <td>

                                    <a class="text-success mr-2" href="{{route('view_riders',$res->id)}}" target="_blank"><i class="text-20 i-Full-View-Window"></i></a>

                                </td>
                                <td>
                                    @if(isset($res->amendment) && $res->amendment=='0' )

                                    <span class="badge badge-pill badge-success">Yes</span>
                                    @else
                                    <span class="badge badge-pill badge-danger">No</span>

                                    @endif
                                </td>

                                <td>
                                <button
                                class="btn btn-info btn-sm btn-file" onclick="offertLetterStartProcess({{$res->id}})" type="button">
                                        Ammend
                                </button>
                                </td>
                                <td>
                                    <span class="badge badge-round-secondary"> {{isset($res->amendment_times)?$res->amendment_times:"0"}}
                                    </span>
                                </td>
                                <td>
                                    {{isset($res->user_ammend->name)?$res->user_ammend->name:"N/A"}}
                                </td>
                                <td>

                                <button class="btn btn-success btn-s  btn-icon m-1"  data-toggle="modal"
                                data-target=".bd-example-modal-lg2" onclick="startVisa2({{$res->id}})"
                                 type="button">
                                Activate
                               </button>
                                </td>



                        </tr>
                    @endforeach


                    </tbody>
                </table>
