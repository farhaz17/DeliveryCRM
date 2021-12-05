<div class="table-responsive">
    <table class="table table-stripped" id="datatable-2">
        <thead>
            <tr>
                <th scope="col">Reference #</th>
                <th scope="col">Applied For</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Phone</th>
                <th scope="col">Education</th>
                <th scope="col">Last Company</th>
                <th scope="col">CV</th>
                <th scope="col">Cover Letter</th>
                <th scope="col">Comments</th>
                <th scope="col">Questions</th>
                <th scope="col">References</th>
                <th scope="col">Applied Time</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($applicants as $row)
            <tr>
                <td>{{isset($row->jobs_created->refrence_no)?$row->jobs_created->refrence_no:"N/A"}}</td>
                <td>{{isset($row->jobs_created->job_title)?$row->jobs_created->job_title:"N/A"}}</td>
                <td>{{isset($row->first_name)?$row->first_name:"N/A"}} {{isset($row->last_name)?$row->last_name:""}}</td>
                <td>{{isset($row->email_address)?$row->email_address:"N/A"}}</td>
                <td>{{isset($row->phone_no)?$row->phone_no:"N/A"}}</td>
                <td>{{isset($row->education)?$row->education:"N/A"}}</td>
                <td>{{isset($row->last_company)?$row->last_company:"N/A"}}</td>

                <td>
                    @if (isset($row->cv))

                    <a class="btn btn-primary btn-file2 mb-4 text-white" href="{{Storage::temporaryUrl($row->cv, now()->addMinutes(5))}}"  target="_blank">
                        <strong style="color: #000000"> <i class="text-15 text-white  i-Download"></i></strong>
                    </a>
                    @endif
                </td>

                <td>
                    <button class="btn btn-info"
                    onclick="viewJobCoverLetter({{$row->id}})" type="button">
                    <i class="text-15  i-Mail-2"></i>
                    </button>
                </td>
                <td>
                    <button class="btn btn-warning"
                    onclick="viewJobComments({{$row->id}})" type="button">
                    <i class="text-15  i-Align-Justify-All

                    "></i>
                    </button>
                </td>

                <td>

                    <button class="btn btn-success"
                    onclick="viewJobQuestions({{$row->id}})" type="button">
                    <i class="text-15  i-Speach-Bubble-Asking"></i>
                    </button>

                </td>

                <td> <button class="btn btn-dark"
                    onclick="viewJobRef({{$row->id}})" type="button">
                    <i class="text-15  i-Business-Mens"></i>
                    </button>
                </td>
                <td>{{isset($row->created_at)?$row->created_at:"N/A"}}</td>


            </tr>
            @endforeach


        </tbody>
    </table>
</div>
