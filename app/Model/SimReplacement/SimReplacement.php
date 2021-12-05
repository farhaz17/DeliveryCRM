<?php

namespace App\Model\SimReplacement;

use App\Model\Platform;
use App\Model\Telecome;
use App\Model\Passport\Passport;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class SimReplacement extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    //

    public function passport()
    {
        return $this->belongsTo(Passport::class,'passport_id');
    }

    public function temporary_plate_number()
    {
        return $this->belongsTo(Telecome::class,'new_sim_id');
    }

    public function permanent_plate_number()
    {
        return $this->belongsTo(Telecome::class,'replace_sim_id');
    }

    public function plateformdetail()
    {
        return $this->belongsTo(Platform::class,'plateform');
    }
}
