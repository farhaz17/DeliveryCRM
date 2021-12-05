<?php

namespace App\Model\BikeHandling;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class UploadHandlingAgreement extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
}
