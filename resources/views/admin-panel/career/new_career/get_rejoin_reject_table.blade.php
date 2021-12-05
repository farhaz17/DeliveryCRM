@foreach($wait_list as $career)
<tr id="row-{{ $career->id }}">
    <td>
        <label class="checkbox checkbox-outline-primary text-10">
            <input type="checkbox"  data-email="{{ $career->id }}" name="checkbox_array[]" class="company_checkbox" value="{{ $career->id }}"><span></span><span class="checkmark"></span>
        </label>
    </td>
    <td id="name-{{ $career->id }}">{{ $career->passport_detail->personal_info->full_name  }}</td>
    <td  id="email-{{ $career->id }}">{{ $career->passport_detail->personal_info->personal_email  }}</td>
    <td id="phone-{{ $career->id }}" >{{ $career->passport_detail->personal_info->inter_phone  }}</td>
    <td id="whatsapp-{{ $career->id }}" >{{ $career->passport_detail->personal_info->personal_mob }}</td>



    {{-- <td>{{ isset($career->follow_status->name) ? $career->follow_status->name : 'Not Verified' }}</td> --}}
    <?php  $created_at = explode(" ", $career->created_at);?>

    <td id="created_at-{{ $career->id }}" >{{ $created_at[0] }}</td>
    <td>
        <a class="text-primary mr-2 view_cls_rejoin" id="{{ $career->id  }}" href="javascript:void(0)"><i class="nav-icon i-eye font-weight-bold"></i></a>
        |

        @if(isset($career->passport_ppuid))
                    @if($career->cancel_status=="1")
                    <h4 class="badge badge-danger">PPUID Cancelled</h4>
                    @else
                    <a class="text-success mr-2 change_status_cls_rejoin"  data-status="{{ $career->past_status }}" id="{{ "change_status-".$career->id }}" href="javascript:void(0)"><i class="nav-icon i-Gear-2 font-weight-bold"></i></a>
                    @endif
         @else
         <a class="text-success mr-2 change_status_cls_rejoin"  data-status="{{ $career->past_status }}" id="{{ "change_status-".$career->id }}" href="javascript:void(0)"><i class="nav-icon i-Gear-2 font-weight-bold"></i></a>
         @endif


    </td>
</tr>
@endforeach
