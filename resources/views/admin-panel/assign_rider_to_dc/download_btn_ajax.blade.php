<div class="col-6 mb-2">
    <div class="card card-icon bg-secondary">
        <a href="{{ route("assign_dc_rider_download",0) }}" id="download_btn_rider_assigned_dc" class="card-body text-center p-2 text-white text-white">
            <span class="item-name font-weight-bold">All Download</span>
        </a>
    </div>
</div>

@foreach($manager_users as $dc)
    <div class="col-6 mb-2">
        <div class="card card-icon bg-secondary">
            <a href="{{ route("assign_dc_rider_download", $dc->user_detail->id) }}" id="download_btn_rider_assigned_dc" class="card-body text-center p-2 text-white text-white">
                <span class="item-name font-weight-bold">{{ $dc->user_detail->name }} Download</span>
            </a>
        </div>
    </div>
@endforeach
