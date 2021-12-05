<?php $total_first_priority_24 = 0; ?>
<?php $total_first_priority_48 = 0; ?>
<?php $total_first_priority_72 = 0; ?>
<?php $total_first_priority_less_24 = 0; ?>

@foreach($first_priority as $career)

    <?php
    $from = \Carbon\Carbon::parse($career->updated_at);
    $to = \Carbon\Carbon::now();
    $hours_spend = $to->diffInHours($from);
    $color_code = "";
    $font_color = "";
    if($hours_spend < 24  && $color=="white"){
    $total_first_priority_less_24 = $total_first_priority_less_24+1;  ?>

    <tr style="background-color: {{ $color_code.";" }} color :{{ $font_color }} ">
        <th scope="row">{{ $career->id }}</th>
        <td>{{ $career->name  }}</td>
        <td>{{ $career->email  }}</td>
        <td>{{ $career->phone  }}</td>
        <td>{{ $career->whatsapp }}</td>
        <?php $application_status = ""; ?>
        <?php if($career->applicant_status=="0"){
            $application_status  = "Not Verified";
        }elseif($career->applicant_status=="1"){
            $application_status  = "Rejected";
        }elseif($career->applicant_status=="2"){
            $application_status  = "Document Pending";
        }elseif($career->applicant_status=="3"){
            $application_status  = "Short Listed";
        } ?>

        <td>{{ $application_status }}</td>
        <?php  $created_at = explode(" ", $career->created_at);?>
        <td>{{ $created_at[0] }}</td>
        <td>{{ isset($source_type_array[$career->source_type]) ? $source_type_array[$career->source_type] : 'N/A' }}</td>
        <td>
            <a class="text-primary mr-2 view_cls" id="{{ $career->id  }}" href="javascript:void(0)"><i class="nav-icon i-eye font-weight-bold"></i></a>
{{--            <a class="text-warning mr-2 edit_cls" id="{{ $career->id  }}" href="javascript:void(0)"><i class="nav-icon i-Pen-5 font-weight-bold"></i></a>--}}
            <a class="text-warning mr-2 remarks_history_cls" id="{{ $career->id  }}" href="javascript:void(0)"><i class="nav-icon i-Sand-watch-2 font-weight-bold"></i></a>
        </td>
    </tr>


    <?php }elseif($hours_spend >= 24 && $hours_spend < 48 && $color=="orange"){
    $color_code = "#ed6a07";
    $font_color = "black";
    $total_first_priority_24 = $total_first_priority_24+1; ?>

    <tr style="background-color: {{ $color_code.";" }} color :{{ $font_color }} ">
        <th scope="row">{{ $career->id }}</th>
        <td>{{ $career->name  }}</td>
        <td>{{ $career->email  }}</td>
        <td>{{ $career->phone  }}</td>
        <td>{{ $career->whatsapp }}</td>
        <?php $application_status = ""; ?>
        <?php if($career->applicant_status=="0"){
            $application_status  = "Not Verified";
        }elseif($career->applicant_status=="1"){
            $application_status  = "Rejected";
        }elseif($career->applicant_status=="2"){
            $application_status  = "Document Pending";
        }elseif($career->applicant_status=="3"){
            $application_status  = "Short Listed";
        } ?>

        <td>{{ $application_status }}</td>
        <?php  $created_at = explode(" ", $career->created_at);?>
        <td>{{ $created_at[0] }}</td>
        <td>{{ isset($source_type_array[$career->source_type]) ? $source_type_array[$career->source_type] : 'N/A' }}</td>
        <td>
            <a class="text-primary mr-2 view_cls" id="{{ $career->id  }}" href="javascript:void(0)"><i class="nav-icon i-eye font-weight-bold"></i></a>
{{--            <a class="text-warning mr-2 edit_cls" id="{{ $career->id  }}" href="javascript:void(0)"><i class="nav-icon i-Pen-5 font-weight-bold"></i></a>--}}
            <a class="text-warning mr-2 remarks_history_cls" id="{{ $career->id  }}" href="javascript:void(0)"><i class="nav-icon i-Sand-watch-2 font-weight-bold"></i></a>
        </td>
    </tr>


    <?php }elseif($hours_spend >= 48 && $hours_spend <= 72  && $color=="pink"){
    $color_code = "#ff2a47";
    $font_color = "black";
    $total_first_priority_48 = $total_first_priority_48+1; ?>

    <tr style="background-color: {{ $color_code.";" }} color :{{ $font_color }} ">
        <th scope="row">{{ $career->id }}</th>
        <td>{{ $career->name  }}</td>
        <td>{{ $career->email  }}</td>
        <td>{{ $career->phone  }}</td>
        <td>{{ $career->whatsapp }}</td>
        <?php $application_status = ""; ?>
        <?php if($career->applicant_status=="0"){
            $application_status  = "Not Verified";
        }elseif($career->applicant_status=="1"){
            $application_status  = "Rejected";
        }elseif($career->applicant_status=="2"){
            $application_status  = "Document Pending";
        }elseif($career->applicant_status=="3"){
            $application_status  = "Short Listed";
        } ?>

        <td>{{ $application_status }}</td>
        <?php  $created_at = explode(" ", $career->created_at);?>
        <td>{{ $created_at[0] }}</td>
        <td>{{ isset($source_type_array[$career->source_type]) ? $source_type_array[$career->source_type] : 'N/A' }}</td>
        <td>
            <a class="text-primary mr-2 view_cls" id="{{ $career->id  }}" href="javascript:void(0)"><i class="nav-icon i-eye font-weight-bold"></i></a>
{{--            <a class="text-warning mr-2 edit_cls" id="{{ $career->id  }}" href="javascript:void(0)"><i class="nav-icon i-Pen-5 font-weight-bold"></i></a>--}}
            <a class="text-warning mr-2 remarks_history_cls" id="{{ $career->id  }}" href="javascript:void(0)"><i class="nav-icon i-Sand-watch-2 font-weight-bold"></i></a>
        </td>
    </tr>


    <?php }else if($hours_spend > 72 && $color=="red"){
    $color_code = "#8b0000";
    $font_color = "white";
    $total_first_priority_72 = $total_first_priority_72+1; ?>

    <tr style="background-color: {{ $color_code.";" }} color :{{ $font_color }} ">
        <th scope="row">{{ $career->id }}</th>
        <td>{{ $career->name  }}</td>
        <td>{{ $career->email  }}</td>
        <td>{{ $career->phone  }}</td>
        <td>{{ $career->whatsapp }}</td>
        <?php $application_status = ""; ?>
        <?php if($career->applicant_status=="0"){
            $application_status  = "Not Verified";
        }elseif($career->applicant_status=="1"){
            $application_status  = "Rejected";
        }elseif($career->applicant_status=="2"){
            $application_status  = "Document Pending";
        }elseif($career->applicant_status=="3"){
            $application_status  = "Short Listed";
        } ?>

        <td>{{ $application_status }}</td>
        <?php  $created_at = explode(" ", $career->created_at);?>
        <td>{{ isset($source_type_array[$career->source_type]) ? $source_type_array[$career->source_type] : 'N/A' }}</td>
        <td>{{ $created_at[0] }}</td>
        <td>
            <a class="text-primary mr-2 view_cls" id="{{ $career->id  }}" href="javascript:void(0)"><i class="nav-icon i-eye font-weight-bold"></i></a>
{{--            <a class="text-warning mr-2 edit_cls" id="{{ $career->id  }}" href="javascript:void(0)"><i class="nav-icon i-Pen-5 font-weight-bold"></i></a>--}}
            <a class="text-warning mr-2 remarks_history_cls" id="{{ $career->id  }}" href="javascript:void(0)"><i class="nav-icon i-Sand-watch-2 font-weight-bold"></i></a>
        </td>
    </tr>


    <?php } ?>

@endforeach
