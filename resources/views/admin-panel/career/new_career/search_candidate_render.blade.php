@if(isset($careers))
@foreach($careers as $career)
    <tr id="row-{{ $career->id }}" @if(isset($career->refer_by)) style="background-color: #43b343;" @endif>
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
        {{-- <td>{{ isset($career->follow_up_status) ? $career->follow_up_status : 'Not Verified' }}</td> --}}
        <?php  $created_at = explode(" ", $career->created_at);?>

        <td id="created_at-{{ $career->id }}" >{{ $career->updated_at->todateString() }}</td>
        <td>{{ isset($source_type_array[$career->source_type]) ? $source_type_array[$career->source_type] : 'N/A' }}</td>
        <?php $promotion_type = $from_sources->where('id','=',$career->promotion_type)->first() ?>
        <td>{{ (!empty($promotion_type)) ? $promotion_type->name : 'N/A' }}</td>

    </tr>
@endforeach
    @endif
