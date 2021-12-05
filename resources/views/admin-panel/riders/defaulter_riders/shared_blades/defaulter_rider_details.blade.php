
<div class="card card-profile-1 col-12">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true" class="float-right text-danger p-2">×</span>
    </button>
    <div class="card-body text-left p-2">
        <div class="avatar box-shadow-2 mb-3" style="width: 120px; height:120px">
            <img src="{{ asset($defaulter_rider_details->passport->profile->image ?? '/assets/images/user_avatar.jpg') }}" alt=""></div>
            <h5 class="m-0 text-center"><span id="full_name"></span></h5>
        <br/>
        <p class="m-0 border-bottom text-center">
            <b>Passport No: </b><span id="pp_uid">{{ $defaulter_rider_details->passport->pp_uid ?? '' }}</span> |
            <b>Phone:  </b> <span id="sim_card">
                {{ isset($defaulter_rider_details->passport->sim_assign) ?  $defaulter_rider_details->passport->sim_assign->where('status',1)->first()->telecome->account_number ??  "No Sim Assigned" : '' }}
            </span> |
            <b>Current Plateform:  </b> <span id="current_plate_form">
                {{ isset($defaulter_rider_details->passport->sim_assign) ?  $defaulter_rider_details->passport->assign_platforms_check() != null ? $defaulter_rider_details->passport->assign_platforms_check()->plateformdetail->name : "Not Assigned"  : ""}}
            </span> |
            <b>Default level: </b><span id="pp_uid">{!! get_defaulter_rider_level($defaulter_rider_details->defaulter_level) !!}</span>
        </p>
    </div>
    <div class="card-body text-left p-2">
        <h5 class="text-center">Rider Defaulter Details</h5>
        <strong>{{ $defaulter_rider_details->subject ?? "" }}</strong>
        {!! $defaulter_rider_details->defaulter_details !!}
    </div>
    <div class="row">
        <div class="col-12 text-center">
            @if($defaulter_rider_details->attachments)
            <b>Attachments: </b>
                @forelse(json_decode($defaulter_rider_details->attachments) as $attachment)
                    <a href="{{ Storage::temporaryUrl($attachment, now()->addMinutes(5)) }}"
                        target="_blank">{{ ++$loop->index }}
                        <i class="fa fa-paperclip"></i>
                    </a>
                @empty
                NA
                @endforelse
            @endif
        </div>
    </div>
    {{-- <div class="col-12 card">
        <div class="card-title">Comments</div>
        <div class="chat-content perfect-scrollbar ps ps--active-y mt-2" data-suppress-scroll-x="true">
            @foreach ($defaulter_rider_details->comments as $comment)
                @if( auth()->id() == $comment->commenter_id)
                <div class="d-flex mb-2 user">
                    <div class="mr-2">
                        <img class="avatar-sm rounded-circle" src="{{ asset( $defaulter_rider_details->creator->passport->profile->image ?? '/assets/images/user_avatar.jpg') }}" alt="alt">
                        <p class="text-center">{{ $comment->commenter->name ?? "" }}</p>
                    </div>
                    <div class="message flex-grow-1">
                        <p class="m-0">{{ $comment->comment ?? "" }}</p>
                        <small class="text-small text-muted">{{ $comment->created_at->diffForHumans() ?? "" }}</small>
                    </div>
                </div>
                @else
                <div class="d-flex mb-2">
                    <div class="message flex-grow-1 text-right">
                        <p class="m-0">{{ $comment->comment ?? "" }}</p>
                        <span class="text-small text-muted">{{ $comment->created_at->diffForHumans() ?? "" }}</span>
                    </div>
                    <div class="ml-2">
                        <img class="avatar-sm rounded-circle" src="{{ asset( $defaulter_rider_details->creator->passport->profile->image ?? '/assets/images/user_avatar.jpg') }}" alt="alt">
                        <p class="text-center">{{ $comment->commenter->name ?? "" }}</p>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    </div> --}}
</div>
