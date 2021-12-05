<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ReturnPurchase extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    protected $fillable=['part_number','qty','invoice_no'];

    public function part()
    {
        return $this->belongsTo(Parts::class,'part_number');
    }
}
