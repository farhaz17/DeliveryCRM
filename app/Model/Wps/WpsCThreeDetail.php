<?php

namespace App\Model\Wps;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class WpsCThreeDetail extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    use SoftDeletes;

    protected $guarded = [];
    protected $dates = ['expiry'];

    public function active()
    {
        return $this->morphMany(WpsPaymentDetail::class, 'wps_payment');
    }
}
