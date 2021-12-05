<?php
$color = "";
if($type=="absent_order"){
    $color = "#ed6a07";
}elseif($type=="not_implement_order"){
    $color =  "#ff2a47";
}elseif($type=="rider_on_leave"){
    $color =   "#8b0000";
}
?>

@foreach($assign_to_dc as $user)
    <tr style="background-color: {{ $color }}">
        <td style="color: #ffffff;">{{ $user->passport->personal_info->full_name }}</td>
        <td style="color: #ffffff;">{{ isset($user->passport->rider_zds_code->zds_code) ? $user->passport->rider_zds_code->zds_code : 'N/A' }}</td>
        <td style="color: #ffffff;" >{{ $user->passport->passport_no }}</td>
        <td style="color: #ffffff;" >{{ $user->platform->name }}</td>
        <td style="color: #ffffff;" >{{ $user->user_detail->name }}</td>
        <td style="color: #ffffff;">{{ $user->created_at }}</td>
        <td ><a  style="color: #ffffff;" href="{{ route('profile.index') }}?passport_id={{ $user->passport->passport_no }}" target="_blank">see profile</a></td>
    </tr>
@endforeach
