<ul class="nav nav-tabs containter" id="dropdwonTab1">
    <li class="nav-item"><a  class="nav-link active show tab-btn btn-info text-white ml-2 mr-2  mt-1" style="padding:4px" id="started-tab" data-toggle="tab" href="#started" aria-controls="started" aria-expanded="true">Started {{count($started)}}</a></li>
    <li class="nav-item"><a class="nav-link tab-btn btn-info text-white ml-2 mr-2  mt-1" style="padding:4px" id="in_process-tab" data-toggle="tab" href="#in_process" aria-controls="in_process" aria-expanded="false">In Process {{count($in_process)}}</a></li>
    <li class="nav-item"><a class="nav-link tab-btn btn-info text-white ml-2 mr-2  mt-1" style="padding:4px" id="completed-tab" data-toggle="tab" href="#completed" aria-controls="completed" aria-expanded="false">Completed {{count($complete)}}</a></li>
</ul>
<div class="tab-content px-1 pt-1 " id="dropdwonTabContent1">
    <div class="tab-pane active show" id="started" role="tabpanel" aria-labelledby="started-tab" aria-expanded="true">
        <h5><span class="badge badge-primary m-2 font-weight-bold">Started</span></h5>
        <table class="table table-striped" width='100%' id="datatable-1-{{$company_id}}">
            <thead class="table-dark">
            <tr class="t-row">
                <th>#</th>
                <th>Name</th>
                <th>Passport No</th>
                <th>PPUID</th>
            </tr>
            </thead>
            <tbody>
                <?php $counter=1?>
                @foreach ($started as $row)
                <tr>
                    <td>{{$counter}}</td>
                    <td>{{$row->passport->personal_info->full_name}}</td>
                    <td>{{$row->passport->passport_no}}</td>
                    <td>{{$row->passport->pp_uid}}</td>
                </tr>
                    <?php $counter++?>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="tab-pane" id="in_process" role="tabpanel" aria-labelledby="in_process-tab" aria-expanded="false">
        <h5><span class="badge badge-primary m-2 font-weight-bold">In Process</span></h5>

        <table class="table table-striped"  width='100%' id="datatable-2-{{$company_id}}">
            <thead class="table-dark">
            <tr class="t-row">
                <th>#</th>
                <th>Name</th>
                <th>Passport No</th>
                <th>PPUID</th>

            </tr>
            </thead>
            <tbody>
                <?php $counter=1?>
                @foreach ($in_process as $row)

                <tr>
                    <td>{{$counter}}</td>
                    <td>{{$row->passport->personal_info->full_name}}</td>
                    <td>{{$row->passport->passport_no}}</td>
                    <td>{{$row->passport->pp_uid}}</td>

                </tr>
                    <?php $counter++?>

                @endforeach
            </tbody>
        </table>
    </div>

    {{---------------------- status change starts--------------- --}}
    <div class="tab-pane" id="completed" role="tabpanel" aria-labelledby="completed-tab" aria-expanded="false">
        <h5><span class="badge badge-primary m-2 font-weight-bold">Complete</span></h5>
        <table class="table table-striped" width='100%' id="datatable-3-{{$company_id}}">
            <thead class="table-dark">
            <tr class="t-row">
                <th>#</th>
                <th>Name</th>
                <th>Passport No</th>
                <th>PPUID</th>
            </tr>
            </thead>
            <tbody>
                <?php $counter=1?>
                @foreach ($complete as $row)
                <tr>
                    <td>{{$counter}}</td>
                    <td>{{$row->passport->personal_info->full_name}}</td>
                    <td>{{$row->passport->passport_no}}</td>
                    <td>{{$row->passport->pp_uid}}</td>
                </tr>
                    <?php $counter++?>
                @endforeach
            </tbody>
        </table>
    </div>


            {{---------------------- status change ends--------------- --}}



</div>


