<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Bike_invoice extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    protected $fillable = ['image_path', 'upload_date','vendor_name','invoice_number'];
}
