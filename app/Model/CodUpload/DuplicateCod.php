<?php

namespace App\Model\CodUpload;

use App\Model\Platform;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class DuplicateCod extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    protected $fillable=['order_id',
        'order_date',
        'city',
        'rider_id',
        'agency',
        'amount',
        'platform_id'];

    public function platform()
    {
        return $this->belongsTo(Platform::class,'platform_id');
    }
}
