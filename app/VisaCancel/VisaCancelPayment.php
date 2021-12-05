<?php

namespace App\VisaCancel;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class VisaCancelPayment extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    //
}
