<?php

namespace App\Model\Master\Company;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Salik extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable; 
    public function company()
    {
        return $this->belongsTo('App\Model\Seeder\Company');
    }
    public function state()
    {
        return $this->belongsTo('App\Model\Cities','state_id');
    }
}
