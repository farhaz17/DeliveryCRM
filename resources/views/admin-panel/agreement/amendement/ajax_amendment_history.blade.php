
<a   href="{{ route('agreement_complete_pdf',$agreement_id) }}" target="_blank"  class="btn btn-primary btn-icon m-1 cls_btn "><span class="ul-btn__icon"><i class="i-Receipt-3"></i></span><span class="ul-btn__text"> Agreement</span></a>
@if(count($amendments)>0)
<div class="hr_cls"><hr></div>
<?php $counter =1;  ?>
@foreach($amendments as  $amd)
<a href="{{ route('amendment_complete_pdf',$amd->id) }}" target="_blank" class="btn btn-dark btn-icon m-1 cls_btn "><span class="ul-btn__icon"><i class="i-Receipt-4"></i></span><span class="ul-btn__text"> {{ $counter }} Amendment</span></a>
<?php $counter = $counter+1;  ?>
@endforeach
@endif
