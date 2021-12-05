<ul class="nav nav-tabs" id="myTab2" role="tablist">
    <li class="nav-item"><a class="nav-link active show" id="with-basic-tab" data-toggle="tab" href="#withBasic" role="tab" aria-controls="withBasic" aria-selected="true">With NOC</a></li>
    <li class="nav-item"><a class="nav-link" id="without-basic-tab" data-toggle="tab" href="#withoutBasic" role="tab" aria-controls="withoutBasic" aria-selected="false">Without NOC</a></li>
</ul>


<div class="tab-content" id="myTabContent2">

    <div class="tab-pane fade active show" id="withBasic" role="tabpanel" aria-labelledby="with-basic-tab">


    <table class="display table table-striped table-bordered table-sm text-10" id="datatable-6" width="100%">
    <thead>
    <tr>

        <th scope="col">&nbsp</th>
        <th scope="col">Name</th>
        <th scope="col">Passport No</th>
        <th scope="col">PPUID</th>
        <th scope="col">Fine State/Days Remaining</th>
        <th scope="col">Action</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $row)
    {{-- @if($row['visa_status']=='1') --}}
        <tr>
            <td class="details-control">
                <button class="btn btn-success btn-icon rounded-circle m-1 gone" style="font-size: 16px" id="go-{{ $row['passport_id'] }}"  type="button">
                    <span class="ul-btn__icon"><i class="i-Add" id="ico-{{ $row['passport_id'] }}"></i></span>
                </button>
               </td>

            <td>
                {{$row['name']}}
                <div id='nested_table-{{$row['passport_id']}}'  style="display: none; margin-top:5px; margin-bottom:5px" >

                </div>
            </td>
            <td> {{$row['pass_no']}}</td>
            <td> {{$row['pp_uid']}}</td>
            <td> {{$row['fine_start']}}</td>
            <td>
                @if($row['career_id']!='N/A')
                <button class="btn btn-success btn-s  btn-icon m-1" style="font-size: 12px" data-toggle="modal"
                 data-target=".bd-example-modal-lg3" onclick="startVisa3({{$row['career_id']}})" id="start-{{ $row['career_id'] }}"
                  type="button">
                  Start
                </button>
                @else
                <button class="btn btn-success btn-s  btn-icon m-1" style="font-size: 12px" data-toggle="modal"
                 data-target=".bd-example-modal-lg4" onclick="startVisa4({{$row['passport_id']}})" id="start-{{ $row['passport_id'] }}"
                  type="button">
                  Start
                </button>
                @endif
            </td>
        </tr>
        {{-- @endif --}}
    @endforeach



    </tbody>
</table>
    </div>


    <div class="tab-pane fade" id="withoutBasic" role="tabpanel" aria-labelledby="without-basic-tab">
        <div class="without_div"></div>
    </div>



</div>




