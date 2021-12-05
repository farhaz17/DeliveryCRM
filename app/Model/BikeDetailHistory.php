<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class BikeDetailHistory extends Model  implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    public $table = "bike_detail_histories";
    protected $fillable=['bike_id','plate_no'];
    public function chassis_number()
    {
        return $this->belongsTo(BikeDetail::class,'bike_id');
    }
}
