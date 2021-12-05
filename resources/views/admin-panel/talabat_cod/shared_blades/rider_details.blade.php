<div class="row">
    {{-- @dd($rider_details->zone) --}}
    <table class="table">
        <tr>
            <td class="text-center">
                <b>Rider Info</b>
                <p class="m-0 text-11">
                    <span id="rider_name">
                        {{ $rider_details != null ? ucFirst($rider_details->passport->personal_info->full_name) : "NA" }}
                    </span><br>
                    <b>RiderID:</b>
                    <span id="rider_id">
                        {{ $rider_details->platform_code ?? "NA" }}
                    </span> |
                    <b>PPUID:</b>
                    <span id="rider_pp_uid">
                        {{ $rider_details->passport->pp_uid ?? "NA" }}
                    </span> |
                    <b>Passport No:</b>
                    <span id="rider_passport_no">
                        {{ $rider_details != null ? ucFirst($rider_details->passport->passport_no) : "NA" }}
                    </span>
                </p>
            </td>
        </tr>
    </table>
</div>
