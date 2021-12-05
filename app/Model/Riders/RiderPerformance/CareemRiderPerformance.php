<?php

namespace App\Model\Riders\RiderPerformance;

use App\Model\Passport\Passport;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class CareemRiderPerformance extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable, SoftDeletes;
    protected $fillable = [
        'rider_platform_code',
        'passport_id',
        'start_date',
        'end_date',
        'uploaded_file_path',
        'limocompany',
        'cct',
        'trips',
        'earnings',
        'available_hours',
        'average_rating',
        'acceptance_rate',
        'completed_trips',
        'cash_collected'
    ];
    public function passport()
    {
        return $this->belongsTo(Passport::class, 'passport_id');
    }
}
