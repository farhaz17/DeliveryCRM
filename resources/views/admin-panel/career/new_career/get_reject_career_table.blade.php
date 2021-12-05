@foreach($careers as $career)
    <tr id="row-{{ $career->id }}">
        <td>
            <label class="checkbox checkbox-outline-primary text-10">
                <input type="checkbox"  data-email="{{ $career->email }}" name="checkbox_array[]" class="company_checkbox" value="{{ $career->id }}"><span></span><span class="checkmark"></span>
            </label>
        </td>
        <td id="name-{{ $career->id }}">{{ $career->name  }}</td>
        <td  id="email-{{ $career->id }}">{{ $career->email  }}</td>
        <td id="phone-{{ $career->id }}" >{{ $career->phone  }}</td>
        <td id="whatsapp-{{ $career->id }}" >{{ $career->whatsapp }}</td>

        <td>
            @if (isset($career->follow_up_status))
                @if ($career->follow_up_status == "1")
                    Interested
                @elseif ($career->follow_up_status == "2")
                    Call Me Tomorrow
                @elseif ($career->follow_up_status == "3")
                    No Response
                @elseif ($career->follow_up_status == "4")
                    Not Interested
                @elseif ($career->follow_up_status == "0")
                    Not Verified
                @endif
            @endif
        </td>

        {{-- <td>{{ isset($career->follow_status->name) ? $career->follow_status->name : 'Not Verified' }}</td> --}}
        <?php  $created_at = explode(" ", $career->created_at);?>

        <td id="created_at-{{ $career->id }}" >{{ $created_at[0] }}</td>
        <td>{{ isset($source_type_array[$career->source_type]) ? $source_type_array[$career->source_type] : 'N/A' }}</td>
        <?php $promotion_type = $from_sources->where('id','=',$career->promotion_type)->first() ?>
        <td>{{ (!empty($promotion_type)) ? $promotion_type->name : 'N/A' }}</td>
        <td>
            <a class="text-primary mr-2 view_cls" id="{{ $career->id  }}" href="javascript:void(0)"><i class="nav-icon i-eye font-weight-bold"></i></a>
            |

            @if(isset($career->passport_ppuid))
            @if($career->cancel_status=="1")
            <h4 class="badge badge-danger">PPUID Cancelled</h4>
            @else
            <a class="text-success mr-2 change_status_cls"  data-status="{{ $career->past_status }}" id="{{ "change_status-".$career->id }}" href="javascript:void(0)"><i class="nav-icon i-Gear-2 font-weight-bold"></i></a>
            @endif
                @else
                <a class="text-success mr-2 change_status_cls"  data-status="{{ $career->past_status }}" id="{{ "change_status-".$career->id }}" href="javascript:void(0)"><i class="nav-icon i-Gear-2 font-weight-bold"></i></a>
            @endif


        </td>
    </tr>
@endforeach
