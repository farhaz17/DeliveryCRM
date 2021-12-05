<?php

namespace App\Model\Riders\RiderPerformance;

use DateTimeInterface;
use App\Model\Passport\Passport;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class TalabatRiderPerformance extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable, SoftDeletes;
    protected $fillable = [
        'uploaded_file_path',
        'passport_id',
        'start_date',
        'end_date',
        'rider_platform_code', // Platform_code
        // 'rider_name', // we dont need this column
        'tenure',
        'batch_number',
        'contract_end_at',
        'contract',
        'contract_start_at',
        'zone_name',
        'country_code',
        'shift_count',
        'worked_days',
        'no_shows',
        'no_show_percentage',
        'late_login_grater_than_five',
        'late_login_greater_than_five_percentage',
        'completed_orders',
        'cancelled_orders',
        'completed_deliveries',
        'cancelations_divided_by_ten_orders',
        'utr',
        'total_working_hours',
        'total_break_hours',
        'attendence_percentage',
        'breaks_percentage',
        'notification_count',
        'acceptance_count',
        'acceptance_rate',
        'completion__rate__percentage'
    ];
    // getter and setter starts here
    // public function getNoShowPercentageAttribute($value)
    // {
    //     return $value*100;
    // }
    // public function setNoShowPercentageAttribute($value)
    // {
    //     return $value/100;
    // }
    // public function getLateLoginGreaterThenFivePercentageAttribute($value)
    // {
    //     return $value*100;
    // }
    // public function setLateLoginGreaterThenFivePercentageAttribute($value)
    // {
    //     return $value/100;
    // }
    // public function getAttendencePercentageAttribute($value)
    // {
    //     return $value*100;
    // }
    // public function setAttendencePercentageAttribute($value)
    // {
    //     return $value/100;
    // }
    // public function getBreaksPercentageAttribute($value)
    // {
    //     return $value*100;
    // }
    // public function setBreaksPercentageAttribute($value)
    // {
    //     return $value/100;
    // }
    // public function getCompletionRatePercentageAttribute($value)
    // {
    //     return $value*100;
    // }
    // public function setCompletionRatePercentageAttribute($value)
    // {
    //     return $value/100;
    // }
    // public function getPickUpGpsErrorPercentageAttribute($value)
    // {
    //     return $value*100;
    // }
    // public function setPickUpGpsErrorPercentageAttribute($value)
    // {
    //     return $value/100;
    // }
    // public function getDropOffGpsErrorPercentageAttribute($value)
    // {
    //     return $value*100;
    // }
    // public function setDropOffGpsErrorPercentageAttribute($value)
    // {
    //     return $value/100;
    // }
    // public function getCancelationsDividedByTenOrdersAttribute($value)
    // {
    //     return $value*10;
    // }
    // public function setCancelationsDividedByTenOrdersAttribute($value)
    // {
    //     return $value/10;
    // }

    // getter and setter ends here

    // relations starts here
    public function passport()
    {
        return $this->belongsTo(Passport::class, 'passport_id');
    }

    // relation ends here
}
