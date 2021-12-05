<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class BikeCencel extends Model  implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    public $table = "bike_cencels";
    protected $fillable=['bike_id','plate_no','date_and_time'];

    public function chassis_number()
    {
        return $this->belongsTo(BikeDetail::class,'bike_id');
    }
}
