<?php

namespace App\Model\RiderReport;

use App\User;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Model\RiderReport\RiderReportFollowup;

class RiderFollowUps extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public function followup()
    {
        return $this->belongsTo(RiderReportFollowup::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
