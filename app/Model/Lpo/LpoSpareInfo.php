<?php

namespace App\Model\Lpo;

use App\Model\Parts;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class LpoSpareInfo extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    protected $guarded = [];

    public function model() {
        return $this->belongsTo(Parts::class, 'parts_id');
    }
}
