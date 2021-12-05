<?php

namespace App\Model\BoxInstall;

use App\Model\Platform;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class BoxBatch extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public function platform(){
        return $this->belongsTo(Platform::class,'platform_id');
    }
}
