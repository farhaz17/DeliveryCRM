<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Manage_bike_purchase extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    protected $fillable = ['part_number', 'invoice_number','part_name','part_des','part_qty','part_qty_balance','amount','vat','date_created'];


    public function part()
    {
        return $this->belongsTo(Parts::class,'part_number');
    }
}
