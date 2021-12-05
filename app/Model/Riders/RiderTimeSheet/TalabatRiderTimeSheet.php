<?php

namespace App\Model\Riders\RiderTimeSheet;

use App\Model\Cities;
use App\Model\Passport\Passport;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class TalabatRiderTimeSheet extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    protected $fillable = [
        'start_date',
        'end_date',
        'uploaded_file_path',
        'platform_code', // Logistics Riders Rider ID
        'passport_id', // Rider Name
        'contact', // Contract Name
        'city_id', // City
        'orders', // Orders
        'deliveries', // Deliveries
        'rider_ppd', // Rider PPD
        'three_p_l_ppd', // 3PL PPD
        'distance', // Distance
        'rider_delivery_pay', // Rider Delivery Pay
        'rider_distance_pay', // Rider Distance Pay
        'fp_delivery_pay', // FP Delivery Pay
        'total_delivery_pay', // Total Delivery Pay
        'monthly_incentive', // Monthly Incentive
        'booster', // Booster
        'new_hire_benefit', // New Hire Benefit
    ];

    public function passport()
    {
        return $this->belongsTo(Passport::class, 'passport_id');
    }
    public function city()
    {
        return $this->belongsTo(Cities::class, 'passport_id');
    }
}
