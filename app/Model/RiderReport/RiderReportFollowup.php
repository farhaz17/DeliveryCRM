<?php

namespace App\Model\RiderReport;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class RiderReportFollowup extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
}
