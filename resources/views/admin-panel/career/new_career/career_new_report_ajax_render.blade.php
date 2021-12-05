@if($tab=="only_pass")

    @foreach($referals as $career)
        @if(!isset($career->passport_detail))
            <tr>
                <td id="name-{{ $career->id }}">{{ $career->name  }}</td>
                <td  id="email-{{ $career->id }}">{{ $career->email  }}</td>
                <td id="phone-{{ $career->id }}" >{{ $career->phone  }}</td>
                <td id="whatsapp-{{ $career->id }}" >{{ $career->whatsapp }}</td>
                <td>{{ isset($career->follow_status->name) ? $career->follow_status->name : 'Not Verified' }}</td>
                <td id="created_at-{{ $career->created_at->toDateString()}}" >{{ $career->created_at->toDateString() }}</td>
                <td>{{ isset($source_type_array[$career->source_type]) ? $source_type_array[$career->source_type] : 'N/A' }}</td>
                <?php $promotion_type = $from_sources->where('id','=',$career->promotion_type)->first() ?>
                <td>{{ (!empty($promotion_type)) ? $promotion_type->name : 'N/A' }}</td>
                <td>
                    @if($tab=="only_pass")
                        <a class="text-secondary mr-2 enter_passport" id="{{ $career->id }}" href="javascript:void(0)"><i class="nav-icon i-Diploma-2 font-weight-bold"></i></a>
                    @endif
                    <a class="text-primary mr-2 view_cls" id="{{ $career->id  }}" href="javascript:void(0)"><i class="nav-icon i-eye font-weight-bold"></i></a>
                </td>

            </tr>
        @endif
    @endforeach

@else

    @foreach($referals as $career)

        <tr>
            <td id="name-{{ $career->id }}">{{ $career->name  }}</td>
            <td  id="email-{{ $career->id }}">{{ $career->email  }}</td>
            <td id="phone-{{ $career->id }}" >{{ $career->phone  }}</td>
            <td id="whatsapp-{{ $career->id }}" >{{ $career->whatsapp }}</td>
            <td>{{ isset($career->follow_status->name) ? $career->follow_status->name : 'Not Verified' }}</td>
            <td id="created_at-{{ $career->created_at->toDateString()}}" >{{ $career->created_at->toDateString() }}</td>
            <td>{{ isset($source_type_array[$career->source_type]) ? $source_type_array[$career->source_type] : 'N/A' }}</td>
            <?php $promotion_type = $from_sources->where('id','=',$career->promotion_type)->first() ?>
            <td>{{ (!empty($promotion_type)) ? $promotion_type->name : 'N/A' }}</td>
            <td>
                <a class="text-primary mr-2 view_cls" id="{{ $career->id  }}" href="javascript:void(0)"><i class="nav-icon i-eye font-weight-bold"></i></a>
            </td>

        </tr>
    @endforeach

@endif
