<?php

namespace App\Model\Referal;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ReferralSetting extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
}
