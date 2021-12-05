<?php $total_first_priority_24 = 0; ?>
<?php $total_first_priority_48 = 0; ?>
<?php $total_first_priority_72 = 0; ?>
<?php $total_first_priority_less_24 = 0; ?>

@foreach($first_priority as $career)

    <tr>
        <th scope="row">{{ $career->id }}</th>
        <td>{{ $career->name  }}</td>
        <td>{{ $career->email  }}</td>
        <td>{{ $career->phone  }}</td>
        <td>{{ $career->whatsapp }}</td>
        <td>{{  $career->follow_status ? $career->follow_status->name : 'Not Verified' }}</td>
        <?php $promotion_type = $from_sources->where('id','=',$career->promotion_type)->first() ?>
        <td>{{ (!empty($promotion_type)) ? $promotion_type->name : 'N/A' }}</td>
        <?php  $created_at = explode(" ", $career->created_at);?>
        <td>{{ $created_at[0] }}</td>
        <td>{{ isset($source_type_array[$career->source_type]) ? $source_type_array[$career->source_type] : 'N/A' }}</td>
        <td>
            <a class="text-warning mr-2 view_cls" id="{{ $career->id  }}" href="javascript:void(0)"><i class="nav-icon i-eye font-weight-bold"></i></a>
                        <a class="text-warning mr-2 edit_cls" id="{{ $career->id  }}" href="javascript:void(0)"><i class="nav-icon i-Pen-5 font-weight-bold"></i></a>
            <a class="text-warning mr-2 remarks_history_cls" id="{{ $career->id  }}" href="javascript:void(0)"><i class="nav-icon i-Sand-watch-2 font-weight-bold"></i></a>
            @if($user_status=="2")

                <a class="text-secondary mr-2 enter_passport" id="{{ $career->id  }}" href="javascript:void(0)"><i class="nav-icon i-Diploma-2 font-weight-bold"></i></a>
            @endif
        </td>
    </tr>



@endforeach
