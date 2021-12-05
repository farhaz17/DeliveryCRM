<?php

namespace App\Model\VendorRegistration;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class VendorRegistration extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    //

    public $table = "vendor_registrations";
    protected $fillable=['passport_id','name','passport_no','driving_license','driving_attachment','status','credit_amount'];


}
