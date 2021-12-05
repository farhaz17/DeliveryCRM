<div class="card text-left">
    <div class="card-body">


        <h3 class="card-title mb-3 text-center text-white"> <a class="badge badge-info m-2">Job Detail</a></h3>

        <div class="table-responsive">
            <table class="table table-sm table-striped">

                <tbody>
                    <tr>
                        <th>Refrence #</th>
                        <td>
                            <a class="badge badge-success text-white">
                            {{$create_job_detail->refrence_no}}
                        </a>
                        </td>
                    </tr>

                    <tr>
                        <th>Company</th>
                        <td>
                            @if($create_job_detail->company=='100')
                            Confidential
                            @else
                            {{$create_job_detail->comp_detail->name}}
                            @endif

                        </td>
                    </tr>
                    <tr>
                        <th>Job Title</th>
                        <td>{{$create_job_detail->job_title}}</td>
                    </tr>

                    <tr>
                        <th>State</th>
                        <td>{{$create_job_detail->states_detail->name}}</td>
                    </tr>

                    <tr>
                        <th>Job Description</th>

                        <td>{!!  html_entity_decode($create_job_detail->job_description) !!}</td>
                    </tr>

                    <tr>
                        <th>Quualification</th>
                        <td>{{$create_job_detail->qualification}}</td>
                    </tr>

                    <tr>
                        <th>Experience</th>
                        <td>{{$create_job_detail->experience}}</td>
                    </tr>

                    <tr>
                        <th>Start Date</th>
                        <td>{{$create_job_detail->start_date}}</td>
                    </tr>


                    <tr>
                        <th>End Date</th>
                        <td>{{$create_job_detail->end_date}}</td>
                    </tr>

                    <tr>
                        <th>Activation Status</th>

                        <td>
                            @if($create_job_detail->status==1)
                            <span class="badge badge-success m-2">Active</span>
                            @else
                            <span class="badge badge-danger m-2"> Deactive</span>
                            @endif
                          </td>
                    </tr>


                    <tr>
                        <th>Job Created At</th>
                        <td>{{$create_job_detail->created_at}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>


