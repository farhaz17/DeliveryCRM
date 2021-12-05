<?php

namespace App\Model\Seeder;

use App\Model\Agreement;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class PersonStatus extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    //

    public function agreement(){
        return $this->belongsTo(Agreement::class);
    }


}
