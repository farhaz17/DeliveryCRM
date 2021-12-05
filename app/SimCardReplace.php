<?php

namespace App;

use App\Model\Telecome;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class SimCardReplace extends Model  implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    public function sim()
    {
        return $this->belongsTo(Telecome::class, 'sim_id');
    }
}
