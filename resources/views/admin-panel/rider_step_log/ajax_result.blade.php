<style>
    .font_size{
        font-size: 15px;
    }
  .table th{
        padding: 2px;
        font-size: 12px;
        font-weight: 300;
    }
    .remarks{
        font-weight:800;
    }
     .table td{
        padding: 2px;
        font-size: 12px;
    }
    .history_table th{
        font-weight:800 !important;
    }
</style>
<div class="card user-profile o-hidden mb-4">
    <div class="user-info">
        <img class="profile-picture avatar-lg mb-2" src="{{ $passport->profile ?  $passport->profile->user->image  : asset('assets/images/user_avatar.jpg') }}" alt="No image">
        <p class="m-0 text-24">{{ $passport->personal_info->full_name }}</p>
    </div>
</div>
<div  class="row" >
    <div class="col-md-6">
        <h5 class=" text-success font-weight-bold">Log After PPUID Created</h5>
        @if(count($passport->after_ppuid_status)>0)
            @foreach($passport->after_ppuid_status as $log)
                <p class="font_size" ><i class="i i-Yes font-weight-bold text-success font_size"></i> {{ $log->log_status->name }}</p>
            @endforeach
        @endif
        @foreach($not_found_log as $not_log)
            <p class="font_size" ><i class="i i-Close-Window font-weight-bold text-danger font_size"></i> {{ $not_log->name }}</p>
        @endforeach
    </div>
    <div class="col-md-6">
        <h5 class=" text-success font-weight-bold">Before PPUID Created Log</h5>
        <div class="table-responsive modal_table">
            <table class="table table-bordered table-striped " id="table_history">
                <thead>
                <tr class="history_table">
                    <th>Status</th>
                    <th>Remarks For Rider</th>
                    <th>Remarks For Company</th>
                    <th>Created At</th>
                    <th>Remarks By</th>
                </tr>
                </thead>
                <tbody>
                @foreach($histories as $career)
                    <tr>
                        @if($career->status_after_shortlist=="1")
                        <td>{{ isset($career->status_after_shortlist_detail->name) ? $career->status_after_shortlist_detail->name : 'N/A'  }}</td>
                        @else
                         <td>{{ isset($career->follow_status->name) ? $career->follow_status->name : 'N/A'  }}</td>
                        @endif
                        <td>{{ $career->remarks  }}</td>
                        <td>{{ $career->company_remarks  }}</td>
                        <td>{{ $career->created_at }}</td>
                        <td>{{ isset($career->user_id) ?  $career->user->name : 'By Default abcd' }} </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
