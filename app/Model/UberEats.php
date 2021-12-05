<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class UberEats extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable, SoftDeletes;
    public $table = "uber_eats_payment";
    protected $fillable=['driver_u_uid','trip_u_uid','first_name','last_name','amount','timestamp','item_type','description','disclaimer'];
}
