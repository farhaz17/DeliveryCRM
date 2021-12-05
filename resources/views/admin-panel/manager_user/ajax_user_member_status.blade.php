@foreach($manager_user->manager_user_detail->manager_users as $ab)

<h5 class="modal-title" id="verifyModalContent_title2">{{ $ab->user_detail->name }}</h5>
<label class="switch">
    <input id="{{$ab->id}}" value="1"  class="status stats_user_manager"  type="checkbox"  @if($ab->status==1) checked @else unchecked @endif>
    <span class="slider round"></span>
</label>
    <br>
    <br>

@endforeach
