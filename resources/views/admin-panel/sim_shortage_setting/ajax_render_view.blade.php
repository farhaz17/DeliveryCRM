
<h5 class="modal-title" id="verifyModalContent_title2">Sim Shortage Status</h5>
<label class="switch">
    <input id="{{$setting->id}}" value="1"  class="status stats_sim_shortage"  type="checkbox"  @if($setting->status==1) checked @else unchecked @endif>
    <span class="slider round"></span>
</label>
