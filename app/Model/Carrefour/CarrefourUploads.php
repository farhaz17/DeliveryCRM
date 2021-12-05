<?php

namespace App\Model\Carrefour;

use App\Model\Passport\Passport;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Model\Carrefour\CarrefourFollowUp;

class CarrefourUploads extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    protected $fillable=[
        'rider_id',
        'amount',
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
        return $this->hasMany(CarrefourFollowUp::class, 'carrefour_upload_id');
    }
}
