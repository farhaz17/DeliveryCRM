<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvParts extends Model  implements Auditable
{ 
    use SoftDeletes, \OwenIt\Auditing\Auditable;
    protected $fillable=['parts_id','quantity','quantity_balance','price'];

    public function part()
    {
        return $this->belongsTo(Parts::class,'parts_id');
    }
}
