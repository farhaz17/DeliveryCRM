<ul class="nav nav-tabs" id="myTab" role="tablist" style="margin-top: 10px;">
    <li class="nav-item">
        <a class="nav-link" id="AllDCRidersTab" data-toggle="tab" href="#AllDCRiders" role="tab" aria-controls="AllDCRiders" aria-selected="false">All DC Riders ( {{ $all_dc_riders->count() ?? 0 }} )
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" id="MissingIDRidersTab" data-toggle="tab" href="#MissingIDRiders" role="tab" aria-controls="MissingIDRiders" aria-selected="true">Missing ID Riders( {{ $id_missing_riders->count() ?? 0}} )
        </a>
    </li>
</ul>
<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade" id="AllDCRiders" role="tabpanel" aria-labelledby="AllDCRidersTab">
        <div class="table-responsive">
            <table class="table table-sm table-hover text-11" id="AllDCRidersTable">
                <thead>
                    <tr>
                        <th>SL</th>
                        <th>ppuid</th>
                        <th>Name</th>
                        <th class="filtering_column">Platform Name</th>
                        <th class="filtering_column">RiderID</th>
                        <th class="">Update ID</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($all_dc_riders as $rider)
                    @php $platform = $rider->passport->get_the_rider_id_by_platform($rider->platform_id) @endphp
                    <tr>
                        <td>{{ $rider->rider_passport_id }}</td>
                        <td>{{ $rider->passport->pp_uid ?? "" }}</td>
                        <td>{{ $rider->passport->personal_info->full_name ?? "" }}</td>
                        <td>{{ $rider->platform->name ?? "" }}</td>
                        <td id="current_paltform_code{{$rider->rider_passport_id}}">
                            @if($platform)
                                {{ $platform->platform_code }}
                            @else
                                {{ "Missing ID" }}
                            @endif
                        </td>
                        <td>
                            @if($platform)
                            <button type="button" class="btn btn-link btn-sm rider_code_update_button"
                            id="rider_code_update_button_id{{ $rider->rider_passport_id }}"
                            data-platform_code_id="{{ $platform->id }}"
                            data-platform_code="{{ $platform->platform_code }}"
                            data-platform_name="{{ $rider->platform->name ?? "" }}"
                            data-platform_id="{{ $rider->platform->id ?? "" }}"
                            data-rider_passport_id="{{ $rider->rider_passport_id }}"
                            data-toggle="modal"
                            data-target="#RiderCodeUpdateModel">
                            {{-- Update --}}
                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit text-20"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                            </button>

                            @else
                                {{ "Missing ID" }}
                            @endif
                        </td>

                    </tr>
                    @empty

                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="tab-pane show active" id="MissingIDRiders" role="tabpanel" aria-labelledby="MissingIDRidersTab">
        <div class="table-responsive">
            <form action="{{ route('add_rider_id_to_talabat_dc') }}" method="post">
                @csrf
                <table class="table table-sm table-hover text-11" id="MissingIDRidersTable">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>PPUID</th>
                            <th>Name</th>
                            <th class="filtering_column" >Platform Name</th>
                            <th class="text-center">Add Talabat RiderID Below</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($id_missing_riders as $rider)
                        <tr>
                            <td>{{ $rider->rider_passport_id }}</td>
                            <td>{{ $rider->passport->pp_uid ?? "" }}</td>
                            <td>{{ $rider->passport->personal_info->full_name ?? "" }}</td>
                            <td>{{ $rider->platform->name ?? "" }}</td>
                            <td>
                                <div class="row row-xs">
                                    <div class="col-md-12">
                                        <input type="text" name="platform_code[]"class="form-control form-control-sm platform_code" placeholder="Enter Rider ID">
                                        <input type="hidden" name="passport_id[]" value="{{ $rider->rider_passport_id }}">
                                        <input type="hidden" name="platform_id[]" value="{{ $rider->platform_id ?? "" }}">
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty

                        @endforelse

                    </tbody>
                </table>
                @if($id_missing_riders->count() > 0)
                        <button class="btn btn-info btn-sm btn-block" type="submit">Add missing RiderId</button>
                @endif
            </form>
        </div>
    </div>
</div>
<!-- Modal for Rider Code update -->
<div class="modal fade" id="RiderCodeUpdateModel" tabindex="-1" role="dialog" aria-labelledby="RiderCodeUpdateModelTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <form action="{{ route('rider_code_update') }}" id="" method="POST" id="RiderCodeUpdateForm">
            @csrf
            @method('put')
            <div class="modal-header">
            <h5 class="modal-title" id="RiderCodeUpdateModalLongTitle">Update Rider Code</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="current_platform_code">Current Platform Code</label>
                    <input type="text" placeholder="Enter new Platform Code" id="current_platform_code" class="form-control form-control-sm" readonly/>
                </div>

                <div class="form-group">
                    <label for="platform_code">New Platform Code</label>
                    <input type="text" placeholder="Enter new Platform Code" id="platform_code" name="platform_code" class="form-control form-control-sm" required/>
                </div>

                <div class="form-group">
                    <label for="platform_code_id"></label>
                    <input type="hidden"  name="platform_code_id" id="platform_code_id" class="form-control form-control-sm"/>
                </div>

                <div class="form-group">
                    <label for="platform_id"></label>
                    <input type="hidden"  name="platform_id" id="platform_id" class="form-control form-control-sm"/>
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary btn-sm" id="RiderCodeUpdatebutton" data-toggle="modal"
            data-target="#RiderCodeUpdateModel">Update platform code</button>
            </div>
        </form>
    </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        'use-strict',
        $('#AllDCRidersTable, #MissingIDRidersTable').DataTable( {
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
            "aaSorting": [[0, 'desc']],
            "pageLength": 10,
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    title: 'DC Riders',
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
</script>
<script>
    $('#RiderCodeUpdatebutton').click(function(){
        let current_platform_code = $("#current_platform_code").val();
        let platform_code_id = $("#platform_code_id").val();
        let platform_id = $("#platform_id").val();
        let platform_code = $("#platform_code").val();
        let _token = "{{ csrf_token() }}";
        let _method  = 'put';
        let rider_passport_id = $(this).attr('data-rider_passport_id')
        $.ajax({
            url: "{{ route('rider_code_update') }}",
            type:"POST",
            data:{ current_platform_code, platform_code_id , platform_id, platform_code, _token, _method },
            success:function(response){
                if(response.updated_row){
                    $('#current_paltform_code'+response.updated_row.passport_id).empty()
                    $('#current_paltform_code'+response.updated_row.passport_id).text(response.updated_row.platform_code)
                    $("#platform_code").val('');
                    $("#current_platform_code").val('');
                    $("#current_platform_code").val(response.updated_row.platform_code);
                    $('#rider_code_update_button_id' + response.updated_row.passport_id ).attr('data-platform_code',response.updated_row.platform_code)
                }
                tostr_display(response['alert-type'], response['message'])
            },
        });
    });

    function tostr_display(type, message){
        switch(type){
            case 'info':
                toastr.info(message, "Information!", { timeOut:10000 , progressBar : true});
                break;
            case 'warning':
                toastr.warning(message, "Warning!", { timeOut:10000 , progressBar : true});
                break;
            case 'success':
                toastr.success(message, "Success!", { timeOut:10000 , progressBar : true});
                break;
            case 'error':
                toastr.error(message, "Failed!", { timeOut:10000 , progressBar : true});
                break;
        }
    }
</script>
<script>
    $('.rider_code_update_button').click(function(){
        $('#current_platform_code').val($(this).attr('data-platform_code'))
        $('#platform_code_id').val($(this).attr('data-platform_code_id'))
        $('#platform_id').val($(this).attr('data-platform_id'))
    });
</script>


<script>
    // Add remove loading class on body element depending on Ajax request status
    $(document).on({
        ajaxStart: function(){
            $("body").addClass("loading");
        },
        ajaxStop: function(){
            $("body").removeClass("loading");
        }
    });
</script>

