<?php

namespace App\Imports;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Model\PlatformCode\PlatformCode;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\WithStartRow;
use App\Model\Riders\RiderPerformance\TalabatRiderPerformance;

class TalabatRiderPerformanceImport implements ToModel, WithStartRow
{
    use Importable, SkipsErrors;
    private  $start_date;
    private  $end_date;
    private  $uploaded_file_path;
    public function __construct($start_date, $end_date, $uploaded_file_path){
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->uploaded_file_path = $uploaded_file_path;
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $platform = PlatformCode::with('passport.personal_info')->whereIn('platform_id', [15,34,41])->wherePlatformCode($row[0])->first();
        return new TalabatRiderPerformance([
            'rider_platform_code' => $platform->platform_code, // Platform_code 0 => "Rider Id"
            'passport_id' => $platform->passport_id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'uploaded_file_path' => $this->uploaded_file_path,
            // 'rider_name', 1 => "Rider Name" // we dont need this column
            'tenure' => $row[2] ?? 0, // 2 => "Tenure"
            'batch_number' => $row[3] ?? 0, // 3 => "Batch Number"
            'contract_end_at' => Carbon::parse($row[4])->format('Y-m-d h:m:s'), // 4 => "Contract End At"
            'contract' => $row[5], // 5 => "Contract"
            'contract_start_at' => Carbon::parse($row[6])->format('Y-m-d h:m:s'), // 6 => "Contract Start At"
            'zone_name' => $row[7] ?? 'NA', // 7 => "Zone Name"
            'country_code' => $row[8] ?? 0, // Country Code
            'shift_count' => $row[9] ?? 0, // 9 => "Shift Count"
            'no_shows' => $row[11] ?? 0, // 11 => "No Shows"
            'no_show_percentage' => $row[12] ?? 0, // 12 => "%No Show"
            'late_login_grater_than_five' => $row[13] ?? 0, // 13 => "Late Login >5"
            'late_login_greater_than_five_percentage' => $row[14] ?? 0, //14 => "% Late Login>5"
            'completed_orders' => $row[15] ?? 0, //15 => "Completed Orders"
            'cancelled_orders' => $row[16] ?? 0, //16 => "Cancelled Orders
            'completed_deliveries' => $row[17] ?? 0, // 17 => "Completed Deliveries"
            'cancelations_divided_by_ten_orders' => $row[18] ?? 0, //18 => "Cancelations/ 10 Orders"
            'utr' => $row[19] ?? 0, // 19 => "UTR"
            'total_working_hours' => $row[20] ?? 0, // 20 => "Total Working Hours"
            'total_break_hours' => $row[21] ?? 0, // 21 => "Total Break Hours"
            'attendence_percentage'  => $row[22] ?? 0, // 22 => "% Attendence"
            'breaks_percentage' => $row[23] ?? 0, // 23 => "% Breaks"
            'notification_count' => $row[24] ?? 0, // 24 => "Notification Count"
            'acceptance_count' => $row[25] ?? 0, // 25 => "Acceptance Count"
            'worked_days' => $row[10] ?? 0, // Worked Days
            'acceptance_rate' => $row[26] ?? 0, // 26 => "Acceptance Rate"
            'completion__rate__percentage' => $row[27] ?? 0, // New column added
        ]);
    }

    public function startRow(): int
    {
        return 2;
    }
}
