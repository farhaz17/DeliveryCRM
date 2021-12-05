<?php

namespace App\Model\Lpo;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Model\Master\CustomerSupplier\CustomerSupplier;

class LpoMaster extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public function supplier() {
        return $this->belongsTo(CustomerSupplier::class);
    }

    public function contract() {
        return $this->belongsTo(LpoContract::class);
    }

    public function inventory_model()
    {
        return $this->hasMany(LpoInventoryModel::class, 'lpo_id');
    }
}
