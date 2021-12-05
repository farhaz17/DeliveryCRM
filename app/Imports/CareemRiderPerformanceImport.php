<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use App\Model\PlatformCode\PlatformCode;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\WithStartRow;
use App\Model\Riders\RiderPerformance\CareemRiderPerformance;

class CareemRiderPerformanceImport implements ToModel, WithStartRow
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
        $platform = PlatformCode::with('passport.personal_info')->wherePlatformCode($row[2])->whereIn('platform_id', [1,32])->first();
        return new CareemRiderPerformance([
            'rider_platform_code' => $platform->platform_code, // Platform_code 2 => captainid
            'passport_id' => $platform->passport_id,
            'start_date' => $this->start_date, // day
            'end_date' => $this->end_date,
            'uploaded_file_path' => $this->uploaded_file_path,

            'limocompany' => $row[1] , // limocompany
            'cct' => $row[3] , // CCT
            'trips' => $row[4] , // Trips
            'earnings' => $row[5] , // Earnings
            'available_hours' => $row[6] , // AvailableHours
            'average_rating' => $row[7] , // AverageRating
            'acceptance_rate' => $row[8] , // AcceptanceRate
            'completed_trips' => $row[9] , // completed_trips
            'cash_collected' => $row[10] , // cashcollected

        ]);
    }

    public function startRow(): int
    {
        return 2;
    }
}
