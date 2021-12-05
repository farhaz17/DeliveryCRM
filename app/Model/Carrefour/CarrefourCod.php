<?php

namespace App\Model\Carrefour;

use App\Model\Passport\Passport;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class CarrefourCod extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable, SoftDeletes;
    protected $fillable=[
        'rider_id',
        'amount',
        'start_date',
        'end_date',
        'passport_id',
        'date',
        'time'
        ];

    public function passport()
    {
        return $this->belongsTo(Passport::class,'passport_id');
    }
}
