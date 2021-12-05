<div class="responsive">
    <table class="table table-sm table-hover table-striped text-11  table-responsive" id="allPassportInfoTable">
        <thead>
            <tr>
                <th>SL</th>
                @if(request('name'))
                    {{-- $passport->with('passport_to_lock.receiving_user'); --}}
                    <th>Name</th>
                @endif
                @if(request('passport_no'))
                    {{-- no relation is needed --}}
                    <th>Passport No</th>
                @endif
                @if(request('passport_handler'))
                    {{-- $passport->with([
                        'passport_to_lock.receiving_user',
                    ]); --}}
                    <th class="filtering_column">Passport Handler</th>
                @endif
                @if(request('zds_code'))
                    {{-- $passport->with('zds_code'); --}}
                    <th>ZDS</th>
                @endif
                @if(request('ppuid'))
                    {{-- $passport->with('ppuid'); --}}
                    <th>PPUID</th>
                @endif
                @if(request('personal_phone'))
                    {{-- $passport->with('personal_phone'); --}}
                    <th>Personal Phone</th>
                @endif
                @if(request('personal_email'))
                    {{-- $passport->with('personal_email'); --}}
                    <th>Personal Email</th>
                @endif
                @if(request('company_phone'))
                    {{-- $passport->with('company_phone'); --}}
                    <th>Company Phone</th>
                @endif
                @if(request('sim_checkin_date'))
                    {{-- $passport->with('sim_checkin_date'); --}}
                    <th>Sim Checkin Date</th>
                @endif
                @if(request('sim_card_changed'))
                    {{-- $passport->with('sim_card_changed'); --}}
                    <th class="filtering_column">SimCard Changed</th>
                @endif
                @if(request('emirates_id'))
                    {{-- $passport->with('emirates_id'); --}}
                    <th>EmiratesId</th>
                @endif
                @if(request('platform_name'))
                    {{-- $passport->with('platform_name'); --}}
                    <th>Platform</th>
                @endif
                @if(request('platform_changed'))
                    {{-- $passport->with('platform_changed'); --}}
                    <th class="filtering_column">Platform Changed</th>
                @endif
                @if(request('platform_codes'))
                    {{-- $passport->with('platform_codes'); --}}
                    <th>Platform Codes</th>
                @endif
                @if(request('platform_city'))
                    {{-- $passport->with('platform_city'); --}}
                    <th>Platform City</th>
                @endif
                @if(request('current_dc'))
                    {{-- $passport->with('current_dc'); --}}
                    <th class="filtering_column">Current dc</th>
                @endif
                @if(request('bike_plate_no'))
                    {{-- $passport->with('bike_plate_no'); --}}
                    <th>Bike Plate No</th>
                @endif
                @if(request('bike_last_checkin_date'))
                    {{-- $passport->with('bike_last_checkin_date'); --}}
                    <th>Bike CheckIn date</th>
                @endif
                @if(request('bike_changed'))
                    <th class="filtering_column">Bike Changed</th>
                @endif
                @if(request('temporary_bike'))
                    {{-- $passport->with('bike_replacement.temporary_plate_number'); --}}
                    <th>Temporary Bike</th>
                @endif
                @if(request('driving_license'))
                    <th>Driving Licence</th>
                @endif
                @if(request('driving_license_city'))
                    <th>Driving Licence City</th>
                @endif
                @if(request('current_cod'))
                    <th class="filtering_column">Current cod</th>
                @endif
                {{-- <th>fine</th>
                <th>salik</th>
                <th>imponding</th>
                <th>advance</th> --}}
                @if(request('visa_status'))
                    <th class="filtering_column">Visa Status</th>
                @endif
                @if(request('visa_profession'))
                    <th class="filtering_column">Visa Profession</th>
                @endif
                @if(request('visa_company'))
                    <th class="filtering_column">Visa company</th>
                @endif
                @if(request('passport_ticket_count'))
                    <th>Tickets</th>
                @endif
                @if(request('assign_category'))
                    <th class="filtering_column">Assign Category</th>
                @endif
                @if(request('common_status'))
                    <th>Common Status</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($passports as $passport)
                <tr>
                    <td>{{ $passport->id }}</td>
                    @if(request('name'))
                        {{-- $passport->with(request('name')); --}}
                        <td>{{ $passport->personal_info->full_name ?? "" }}</td>
                    @endif
                    @if(request('passport_no') || request('renew_passport_number'))
                        {{-- no relation is needed --}}
                        <td>
                            @if(request('passport_no'))
                                {{ $passport->passport_no ?? "" }}
                            @endif
                            @if(request('renew_passport_number'))
                                {{ $passport->renew_pass ? $passport->renew_pass->renew_passport_number ?? '' : '' }}
                            @endif
                        </td>
                    @endif
                    @if(request('passport_handler'))
                        {{-- $passport->with([
                            'passport_to_lock.receiving_user',
                        ]); --}}
                        <td>
                            @if($passport->passport_locker_count)
                                {{ "In locker" }}
                            @elseif ($passport->passport_with_rider_count)
                                {{ "with rider" }}
                            @elseif ($passport->passport_to_lock_count)
                                {{ "with " . $passport->passport_to_lock->receiving_user->name }}
                            @else
                                {{ "No record" }}
                            @endif
                        </td>
                    @endif
                    @if(request('zds_code'))
                        {{-- $passport->with(request('zds_code')); --}}
                        <td>{{ $passport->zds_code->zds_code ?? ''}}</td>
                    @endif
                    @if(request('ppuid'))
                        {{-- $passport->with(request('ppuid')); --}}
                        <td>{{ $passport->pp_uid ?? ''}}</td>
                    @endif
                    @if(request('personal_phone'))
                        {{-- $passport->with(request('personal_phone')); --}}
                        <td>{{ $passport->personal_info->personal_mob ?? ''}}</td>
                    @endif
                    @if(request('personal_email'))
                        {{-- $passport->with(request('personal_email')); --}}
                        <td>{{ $passport->personal_info->personal_email ?? ''}}</td>
                    @endif
                    @if(request('company_phone'))
                        {{-- $passport->with(request('company_phone')); --}}
                        <td>{{ $passport->sim_assign->where('status', 1)->first()->sim ?? 'No record'}}</td>
                    @endif
                    @if(request('sim_checkin_date'))
                        {{-- $passport->with(request('sim_checkin_date')); --}}
                        <td>{{ $passport->sim_assign->where('status', 1)->first() ? dateToRead($passport->sim_assign->where('status', 1)->first()->checkin) : 'No record'}}</td>
                    @endif
                    @if(request('sim_card_changed'))
                        {{-- $passport->with(request('sim_card_changed')); --}}
                        <td>{{ $passport->sim_assign_count }}</td>
                    @endif
                    @if(request('emirates_id'))
                        <td>{{ $passport->emirates_id->card_no ?? ''}}</td>
                    @endif
                    @if(request('platform_name'))
                        {{-- $passport->with(request('platform_name')); --}}
                        <td>{{ $passport->assign_to_dcs->where('status', 1)->first()->platform->name ?? "No record" }}</td>
                    @endif
                    @if(request('platform_changed'))
                        {{-- $passport->with(request('platform_changed')); --}}
                        <td>{{ $passport->assign_to_dcs->count() }} </td>
                    @endif
                    @if(request('platform_codes'))
                        {{-- $passport->with(request('platform_codes')); --}}
                        <td>
                            @if (!$passport->check_platform_code_exist->isEmpty())
                                @php $p_code = $passport->check_platform_code_exist->where('platform_id','4'); @endphp
                                @foreach($p_code as $p_codes)
                                    {{ isset($p_codes) ? $p_codes->platform_code : '' }}<br>
                                @endforeach
                            @endif
                        </td>
                    @endif
                    @if(request('platform_city'))
                        {{-- $passport->with(request('platform_city')); --}}
                        <td>{{ $passport->assign_to_dcs->where('status', 1)->first()->platform->city_name->name ?? "" }}
                    @endif
                    @if(request('current_dc'))
                        {{-- $passport->with(request('current_dc')); --}}
                        <td>
                            @if(!$passport->assign_to_dcs->isEmpty())
                                {{ $passport->assign_to_dcs->where('status', 1)->first()->user_detail->name ?? "No record" }}
                            @else
                                {{ "No record" }}
                            @endif
                        </td>
                    @endif
                    @if(request('bike_plate_no'))
                        {{-- $passport->with(request('bike_plate_no')); --}}
                        <td>
                            @if (!$passport->bike_assign->isEmpty())
                                @foreach($passport->bike_assign->where('status', 1) as $bike)
                                    {{$bike->bike_plate_number->plate_no}}
                                @endforeach
                            @else
                                No record
                            @endif
                        </td>
                    @endif
                    @if(request('bike_last_checkin_date'))
                        {{-- $passport->with('assign_to_dcs'); --}}
                        <td>
                            @if(!$passport->assign_to_dcs->isEmpty())
                                {{ $passport->assign_to_dcs->where('status', 1)->first()->checkin ?? "No record" }}
                            @else
                                {{ "No record" }}
                            @endif
                        </td>
                    @endif
                    @if(request('bike_changed'))
                        <td>{{ $passport->bike_assign_count }}</td>
                    @endif
                    @if(request('temporary_bike'))
                        {{-- $passport->with(request('bike_replacement.temporary_plate_number')); --}}
                        <td>
                            {{
                                isset($passport->bike_replacement->temporary_plate_number)
                                ? $passport->bike_replacement->temporary_plate_number->plate_no
                                : 'No record'
                            }}
                        </td>
                    @endif
                    @if(request('driving_license'))
                        <td>{{ isset($passport->driving_license) ? $passport->driving_license->license_number : "No record"}}</td>
                    @endif
                    @if(request('driving_license_city'))
                        <td>
                            @if(isset($passport->driving_license))
                                @if(is_numeric($passport->driving_license->place_issue))
                                    {{ $passport->driving_license->city->name ?? "No record" }}
                                @else
                                    {{ $passport->driving_license->place_issue ?? "No record" }}
                                @endif
                            @else
                                {{ "No record" }}
                            @endif
                        </td>
                    @endif
                    @if(request('current_cod'))
                        <td>
                            @forelse ($passport->current_cods->where('balance' , '>', 0) as $cod)
                                {{ $cod['balance'] }}
                            @empty
                                {{ "No record" }}
                            @endforelse

                        </td>
                    @endif
                    {{-- <td>fine</td>
                    <td>salik</td>
                    <td>imponding</td>
                    <td>advance</td> --}}
                    @if(request('visa_status'))
                        <td>
                            @if($passport->career)
                                @if($passport->career->visa_status == 1)
                                    {{ "Visit" }}
                                @elseif($passport->career->visa_status == 2)
                                    {{ "Cancel" }}
                                @elseif($passport->career->visa_status == 3)
                                    {{ "Own" }}
                                @else
                                    {{ "No Record" }}
                                @endif
                            @endif
                        </td>
                    @endif
                    @if(request('visa_profession'))
                        <td>
                            @if(isset($passport->offer->designation))
                                {{ $passport->offer->designation->name ?? "No record" }}
                            @else
                                {{ "No record" }}
                            @endif
                        </td>
                    @endif
                    @if(request('visa_company'))
                        <td>
                            @if(isset($passport->offer->companies))
                                {{ $passport->offer->companies->name ?? "No record" }}
                            @else
                                {{ "No record" }}
                            @endif
                        </td>
                    @endif
                    @if(request('passport_ticket_count'))
                        <td>
                            {{ $passport->profile ? $passport->profile->passport_ticket_count : 'No record' }}
                        </td>
                    @endif
                    @if(request('assign_category'))
                        <td>
                        {{ $passport->category_assign->first()->main_cate->name ?? "" }}
                        >>
                        {{-- <i class="i-Arrow-Right-2"></i> --}}
                        {{ $passport->category_assign->first()->sub_cate1->name ?? "" }}
                        >>
                        {{-- <i class="i-Arrow-Right-2"></i> --}}
                        {{ $passport->category_assign->first()->sub_cate2->name ?? "" }}
                    </td>
                    @endif
                    @if(request('common_status'))
                        <td>
                            @php
                                 $common_status_id = $passport->active_inactive_category_assign_histories->first()->common_status_id ?? 0
                            @endphp
                            {{ config('common_statuses')->where('id', $common_status_id)->first()['name'] ?? "No record" }}
                            <a class="text-success mr-2 history_btn" data-passport_id={{$passport->id}} href="javascript:void(0)">
                                {{-- <i class="nav-icon i-Checkout-Basket font-weight-bold"></i> --}}
                                History
                            </a>
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<script>
    $(document).ready(function () {
    'use-strict',
        $('#allPassportInfoTable').DataTable({
            initComplete: function () {
                let filtering_columns = []
                $(this).children('thead').children('tr').children('th.filtering_column').each(function(i, v){
                    filtering_columns.push(v.cellIndex)
                });
                this.api().columns(filtering_columns).every( function () {
                    var column = this;
                    var select = $(`<select class='form-control form-control-sm'><option value="">All</option></select>`)
                        .appendTo( $(column.header()) )
                        .on( 'change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );
                            column
                                .search( val ? '^'+val+'$' : '', true, false )
                                .draw();
                        } );

                    column.data().unique().sort().each( function ( d, j ) {
                        select.append( '<option value="'+d+'">'+d+'</option>' )
                    } );
                } );
            },
            "aaSorting": [[0, 'asc']],
            "pageLength": 10,
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    title: '',
                    text: '<img src="{{asset('assets/images/icons/excel.png')}}" width=10px;>',
                    exportOptions: {
                        modifier: {
                            page : 'all',
                        }
                    }
                },
            ],
        });
    });
    // for redraw table
    $(document).ready(function () {
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            var currentTab = $(e.target).attr('href');
            $(currentTab +"Table").DataTable().columns.adjust().draw();
        });
    });
</script>
