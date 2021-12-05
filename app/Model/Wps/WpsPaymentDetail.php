<?php

namespace App\Model\Wps;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class WpsPaymentDetail extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    protected $guarded = [];

    public function wps_payment()
    {
        return $this->morphTo();
    }

    public function c_three_details()
    {
        return $this->hasMany(WpsCThreeDetail::class, 'passport_id', 'passport_id');
    }

    public function lulu_card_details()
    {
        return $this->hasMany(WpsLuluCardDetail::class, 'passport_id', 'passport_id');
    }

    public function bank_details()
    {
        return $this->hasMany(WpsBankDetails::class, 'passport_id', 'passport_id');
    }
}
