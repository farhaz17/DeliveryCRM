<div class="col-md-12 form-group mb-6">
    @foreach($company as $com)
        <label class="radio-outline-primary">
            <input type="radio" id="{{$com->id}}" class="companies" name="radio"><span>   &nbsp;{{$com->name}}</span>
        </label>
    @endforeach
</div>
<table class="table" id="datatable22" >
    <thead class="thead-dark">
    <tr>
        <th scope="col">Name3</th>
        <th scope="col">Passport Number</th>
        <th scope="col">ZDS Code</th>
        <th scope="col">PPUID</th>
        <th scope="col">Personal Number</th>
        <th scope="col">SIM Number</th>
        <th scope="col">Bike Plate Number</th>
        <th scope="col">Platform</th>
        <th scope="col">Emirates ID</th>
        <th scope="col">Driving License</th>
        <th scope="col">Labour Card No.</th>
        <th scope="col">Company</th>
        <th scope="col">Verifing Status</th>



    </tr>
    </thead>
    <tbody>
    @foreach($passport as $row)
        {{--        @if(isset($row->elect_pre_approval))--}}
        {{--            @if(isset($row->agreement2))--}}
        {{--                                @else--}}
        <tr>
            <td style="font-size: 13px; white-space: nowrap"> {{$row->personal_info->full_name}}</td>
            <td> {{isset($row->passport_no)?$row->passport_no:""}}</td>
            <td> {{isset($row->zds_code->zds_code)?$row->zds_code->zds_code:""}}</td>
            <td> {{ $row->pp_uid}}</td>
            <td style="font-size: 13px; white-space: nowrap"> {{ isset($row->personal_info->personal_mob)?$row->personal_info->personal_mob:"N/A"}}</td>
            @if (!$row->sim_assign->isEmpty())
                @foreach($row->sim_assign as $rw)
                    <td>{{$rw->telecome->account_number}}</td>
                @endforeach
            @else
                <td>N/A</td>
            @endif
            @if (!$row->bike_assign->isEmpty())
                @foreach($row->bike_assign as $rw)
                    <td>{{$rw->bike_plate_number->plate_no}}</td>
                @endforeach
            @else
                <td>N/A</td>
            @endif
            @if (!$row->platform_assign->isEmpty())
                @foreach($row->platform_assign as $rw)
                    {{--                                            <td>{{$rw->plateformdetail->name}}</td>--}}
                    <td>{{isset($rw->plateformdetail)?$rw->plateformdetail->name:"N/A"}}</td>
                @endforeach
            @else
                <td>N/A</td>
            @endif
            <td>{{isset($row->emirates_id)?$row->emirates_id->card_no:"N/A"}}</td>
            <td>{{isset($row->driving_license)?$row->driving_license->license_number:"N/A"}}</td>
            <td>{{isset($row->elect_pre_approval)?$row->elect_pre_approval->labour_card_no:"N/A"}}</td>
            <td>{{isset($row->offer)?$row->offer->companies->name:"N/A"}}</td>
            @if(isset($row->verified->verification_status))
                <td>Verified</td>
            @elseif(!isset($row->verified->verification_status))
                <td>Not Verified</td>
            @endif


        </tr>
        {{--        @endif--}}
        {{--        @endif--}}
    @endforeach


    </tbody>
</table>

<script>
    $(document).ready(function () {

        $('#datatable22').DataTable( {
            "aaSorting": [[0, 'desc']],
            "pageLength": 10,
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    title: 'Report',
                    text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=20px;>',
                    exportOptions: {
                        modifier: {
                            page : 'all'

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
    $(".companies").click(function () {
        var token = $("input[name='_token']").val();
        var id= $(this).attr('id');


        $.ajax({
            url: "{{ url('ajax_company') }}",
            method: 'POST',
            dataType: 'json',
            data: {_token: token,id:id},
            success: function (response) {
                $('.table2').empty();
                $('.table2').append(response.html);
            }});
    });
</script>
