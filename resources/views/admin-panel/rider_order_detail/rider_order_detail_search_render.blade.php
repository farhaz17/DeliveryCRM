@foreach($data as $rider_detail)

<tr>
    <td>
        {{ isset($rider_detail->passport->personal_info->full_name) ? $rider_detail->passport->personal_info->full_name : 'N/A' }}
    </td>
    <td>
        {{ isset($rider_detail->passport->zds_code->zds_code)? $rider_detail->passport->zds_code->zds_code:"N/A" }}
    </td>
    <td>
        {{ isset($rider_detail->passport->rider_id->platform_code)?$rider_detail->passport->rider_id->platform_code:"N/A" }}
    </td>
    <td>
        {{ isset($rider_detail->platform->name) ? $rider_detail->platform->name : 'N/A' }}
    </td>
    <td>
        {{ isset($rider_detail->start_date_time) ? $rider_detail->start_date_time : 'N/A' }}
    </td>
    <td>
        {{ isset($rider_detail->end_date_time) ? $rider_detail->end_date_time : 'N/A' }}
    </td>
    <td>
        {{ isset($rider_detail->total_order) ? $rider_detail->total_order : 'N/A' }}
    </td>

    <td>
        <?php $image_url =  ltrim($rider_detail->image, $rider_detail->image[0]); ?>

            <a href="{{Storage::temporaryUrl($image_url, now()->addMinutes(5))}}" target="_blank"class="badge badge-primary ">see image</a>

    </td>
    <td>
        {{ $rider_detail->created_at }}
    </td>

</tr>

@endforeach
