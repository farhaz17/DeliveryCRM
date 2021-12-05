<?php

namespace App\Model;

use App\Model\CareemFollowUp;
use App\Model\Passport\Passport;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Careem extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public $table = "careem";
    //
    protected $fillable=['payment_id',
        'driver_id',
        'total_driver_base_cost',
        'total_driver_other_cost',
        'total_driver_payment',
        'document_number',
        'start_date',
        'end_date',
        'passport_id',
        ];

    public function passport()
    {
        return $this->belongsTo(Passport::class,'passport_id');
    }

    public function follow_ups()
    {
        return $this->hasMany(CareemFollowUp::class, 'careem_upload_id');
    }
}



