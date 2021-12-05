<style>
    .comment-box:hover{
        background: #dee2e6 !important
    }
</style>
<div class="card row"style="height: 550px;overflow-y: scroll;">
    <div class="card card-profile-1 col-12" style="overflow: overlay;">
        <div class="chat-content-wrap sidebar-content" data-sidebar-content="chat">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true" class="float-right text-danger p-2">×</span>
            </button>
            <div class="card-body text-left p-2">
                <div class="avatar box-shadow-2 mb-3" style="width: 60px; height:60px">
                    <img src="{{ asset($defaulter_rider_comments->passport->profile->image ?? '/assets/images/user_avatar.jpg') }}" alt="">
                </div>
                <h5 class="m-0 text-center"><span id="full_name"></span></h5>
                <p class="m-0 border-bottom text-center">
                    <b>Passport No: </b><span id="pp_uid">{{ $defaulter_rider_comments->passport->pp_uid }}</span> |
                    <b>Phone: </b>
                    <span id="sim_card">
                        {{ $defaulter_rider_comments->passport->sim_assign->where('status',1)->first()->telecome->account_number ??  "No Sim Assigned"  }}
                    </span> |
                    <b>Current Plateform:  </b>
                    <span id="current_plate_form">
                        {{ $defaulter_rider_comments->passport->assign_platforms_check() != null ? $defaulter_rider_comments->passport->assign_platforms_check()->plateformdetail->name : "Not Assigned" }}
                    </span> |
                    <b>Default level: </b>
                    <span id="pp_uid">{!! get_defaulter_rider_level($defaulter_rider_comments->defaulter_level) !!}</span>
                </p>
            </div>
            <div class="card-body text-left p-2">
                <h5 class="text-center">Rider Defaulter Details</h5>
                <strong>{{ $defaulter_rider_comments->subject ?? "" }}</strong>
                        {!! $defaulter_rider_comments->defaulter_details !!}
            </div>
            <div class="row">
                <div class="col-12 text-center">
                    @if($defaulter_rider_comments->attachments)
                    <b>Attachments: </b>
                        @forelse(json_decode($defaulter_rider_comments->attachments) as $attachment)
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
        </div>
        <div class="pt-3">
            <form class="inputForm row" action="{{ route('defaulter_rider_comments') }}" method="POST" id="commentForm">
                @csrf
                <input type="hidden" name="defaulter_rider_id" value="{{ $defaulter_rider_comments->id }}">
                <div class="form-group col-11 pr-1">
                    <textarea class="form-control form-control-sm" id="comment" placeholder="Type your comment" name="comment" cols="30" rows="2" required></textarea>
                </div>
                <div class="form-group col-1 text-right mb-3 pl-0">
                    <button class="btn btn-block btn-danger h-100" type="submit">
                        <i class="i-Paper-Plane text-30"></i>
                    </button>
                </div>
            </form>
        </div>
        <div
            class="chat-content perfect-scrollbar ps--active-y mt-2 border"
            data-suppress-scroll-x="true"
            {{-- style="overflow-x: hidden !important;overflow-y: scroll !important;height: 370px; padding:10px" --}}
        >
        <p class="p-2 m-0">Comments ( {{$defaulter_rider_comments->comments->count()}} )</p>
            @foreach ($defaulter_rider_comments->comments as $comment)
                @if( auth()->id() == $comment->commenter_id)
                <div class="d-flex mb-2 user border p-2 comment-box" style="">
                    <div class="mr-2">
                        <img class="avatar-sm rounded-circle" src="{{ asset( $defaulter_rider_comments->creator->passport->profile->image ?? '/assets/images/user_avatar.jpg') }}" alt="alt">
                        <p class="text-center m-0">{{ $comment->commenter->name ?? "" }}</p>
                    </div>
                    <div class="message flex-grow-1">
                        <p class="m-0">{{ $comment->comment ?? "" }}</p>
                        <small class="text-small text-muted">{{ $comment->created_at->diffForHumans() ?? "" }}</small>
                    </div>
                </div>
                @else
                <div class="d-flex mb-2 border p-2 comment-box">
                    <div class="message flex-grow-1 text-right">
                        <p class="m-0">{{ $comment->comment ?? "" }}</p>
                        <span class="text-small text-muted">{{ $comment->created_at->diffForHumans() ?? "" }}</span>
                    </div>
                    <div class="ml-2">
                        <img class="avatar-sm rounded-circle" src="{{ asset( $defaulter_rider_comments->creator->passport->profile->image ?? '/assets/images/user_avatar.jpg') }}" alt="alt">
                        <p class="text-center m-0">{{ $comment->commenter->name ?? "" }}</p>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    </div>
</div>
<script>
    $('#commentForm').on('submit', function(e){
        e.preventDefault();
        var data = $(this).serialize();
        var url = $(this).attr("action");
        $.ajax({
            url, data, method:"POST",
            success: function(response){
                setTimeout(() => {
                    tostr_display(response['alert-type'],response['message'])
                    $('#DefaulterRiderCommentModal').empty()
                    $('#DefaulterRiderCommentModal').append(response.html)
                 }, 2000);
            }
        }).then({

        });
    });
</script>

<script>
    function tostr_display(type,message){
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
