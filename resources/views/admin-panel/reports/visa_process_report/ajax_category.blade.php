<ul class="nav nav-tabs mt-4 containter" id="dropdwonTab1">
    <li class="nav-item"><a  class="nav-link active show tab-btn btn-info   text-white ml-2 mr-2 mt-1" style="padding:4px" id="first-tab" data-toggle="tab" href="#first" aria-controls="first" aria-expanded="true">PRE APPROVAL FOR WORK PERMIT ({{count($pre_app_for_work_per)}})</a></li>
    <li class="nav-item"><a class="nav-link tab-btn btn-info text-white ml-2 mr-2  mt-1" style="padding:4px" id="second-tab" data-toggle="tab" href="#second" aria-controls="second" aria-expanded="false"> NEW ELECTRONIC WORK PERMIT ({{count($new_contract_work_per)}}) </a></li>
    <li class="nav-item"><a class="nav-link tab-btn btn-info text-white ml-2 mr-2  mt-1" style="padding:4px" id="third-tab" data-toggle="tab" href="#third" aria-controls="third" aria-expanded="false">NEW ELECTRONIC WORK PERMIT UNDER CANCELLATION ({{count($new_elec_work_permit_under_cancel)}})</a></li>
    <li class="nav-item"><a class="nav-link tab-btn btn-info text-white ml-2 mr-2  mt-1" style="padding:4px" id="fourth-tab" data-toggle="tab" href="#fourth" aria-controls="fourth" aria-expanded="false">ELECTRONIC WORK PERMIT FOR PART TIME ({{count($elec_work_per_for_part_time)}})</a></li>
    <li class="nav-item"><a class="nav-link tab-btn btn-info text-white ml-2 mr-2  mt-1" style="padding:4px" id="fifth-tab" data-toggle="tab" href="#fifth" aria-controls="fifth" aria-expanded="false">NATIONAL AND GCC ELECTRONIC WORK PERMIT ({{count($national_gcc)}})</a></li>
    <li class="nav-item"><a class="nav-link tab-btn btn-info text-white ml-2 mr-2  mt-1" style="padding:4px" id="sixth-tab" data-toggle="tab" href="#sixth" aria-controls="sixth" aria-expanded="false">RENEWAL ELECTRONIC WORK PERMIT ({{count($renew_elec_work_after)}})</a></li>
    <li class="nav-item"><a class="nav-link tab-btn btn-info text-white ml-2 mr-2  mt-1" style="padding:4px" id="seventh-tab" data-toggle="tab" href="#seventh" aria-controls="seventh" aria-expanded="false">RENEWAL NATIONAL AND GCC ELECTRONIC WORK PERMIT ({{count($renew_elec_work_per_if_emr)}})</a></li>
    <li class="nav-item"><a class="nav-link tab-btn btn-info text-white ml-2 mr-2  mt-1" style="padding:4px" id="ninth-tab" data-toggle="tab" href="#ninth" aria-controls="ninth" aria-expanded="false"> RENEWAL  WORK PERMIT UNDER CANCELLATION ({{count($renewal_work_permit_under_cancel)}})</a></li>

</ul>

<div class="tab-content px-1 pt-1" id="dropdwonTabContent1">

    <div class="tab-pane active show" id="first" role="tabpanel" aria-labelledby="first-tab" aria-expanded="true">
        <h5><span class="badge badge-primary m-2 font-weight-bold">PRE APPROVAL FOR WORK PERMIT</span></h5>

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
                @foreach ($pre_app_for_work_per as $row)

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

<div class="tab-pane" id="second" role="tabpanel" aria-labelledby="second-tab" aria-expanded="false">
<h5><span class="badge badge-primary m-2 font-weight-bold"> NEW ELECTRONIC WORK PERMIT</span></h5>

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
    @foreach ($new_contract_work_per as $row)

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
<div class="tab-pane" id="third" role="tabpanel" aria-labelledby="third-tab" aria-expanded="false">
<h5><span class="badge badge-primary m-2 font-weight-bold">NEW ELECTRONIC WORK PERMIT UNDER CANCELLATION</span></h5>
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
    @foreach ($new_elec_work_permit_under_cancel as $row)

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

<div class="tab-pane" id="fourth" role="tabpanel" aria-labelledby="fourth-tab" aria-expanded="false">
    <h5><span class="badge badge-primary m-2 font-weight-bold">ELECTRONIC WORK PERMIT FOR PART TIME</span></h5>
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
            @foreach ($elec_work_per_for_part_time as $row)

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

{{---------------------- status change ends--------------- --}}

<div class="tab-pane" id="fifth" role="tabpanel" aria-labelledby="fifth-tab" aria-expanded="false">
<h5><span class="badge badge-primary m-2 font-weight-bold">NATIONAL AND GCC ELECTRONIC WORK PERMIT</span></h5>
<table class="table table-striped" width='100%' id="datatable-4-{{$company_id}}">
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
@foreach ($national_gcc as $row)

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

{{---------------------- status change ends--------------- --}}

<div class="tab-pane" id="sixth" role="tabpanel" aria-labelledby="sixth-tab" aria-expanded="false">
<h5><span class="badge badge-primary m-2 font-weight-bold">RENEWAL ELECTRONIC WORK PERMIT</span></h5>
<table class="table table-striped" width='100%' id="datatable-5-{{$company_id}}">
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
@foreach ($renew_elec_work_after as $row)

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
{{---------------------- status change ends--------------- --}}

<div class="tab-pane" id="seventh" role="tabpanel" aria-labelledby="seventh-tab" aria-expanded="false">
<h5><span class="badge badge-primary m-2 font-weight-bold">RENEWAL NATIONAL AND GCC ELECTRONIC WORK PERMIT</span></h5>
<table class="table table-striped" width='100%' id="datatable-6-{{$company_id}}">
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
@foreach ($renew_elec_work_per_if_emr as $row)

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

{{---------------------- status change ends--------------- --}}

{{---------------------- status change ends--------------- --}}

<div class="tab-pane" id="ninth" role="tabpanel" aria-labelledby="ninth-tab" aria-expanded="false">
<h5><span class="badge badge-primary m-2 font-weight-bold">RENEWAL  WORK PERMIT UNDER CANCELLATION</span></h5>
<table class="table table-striped" width='100%' id="datatable-7-{{$company_id}}">
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
@foreach ($renewal_work_permit_under_cancel as $row)

<tr>
<td>{{$counter}}</td>
<tr>
    <td>{{$counter}}</td>
    <td>{{$row['name']}}</td>
    <td>{{$row['passport_no']}}</td>
    <td>{{$row['ppuid']}}</td>

</tr>

</tr>
<?php $counter++?>

@endforeach
</tbody>
</table>
</div>
{{---------------------- status change ends--------------- --}}

















</div>
