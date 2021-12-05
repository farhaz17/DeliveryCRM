<?php

namespace App\Model\Lpo;

use App\Model\Lpo\LpoMaster;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Model\Master\Vehicle\VehicleModel;

class LpoVehicleInfo extends Model  implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    protected $guarded = [];
    public function model() {
        return $this->belongsTo(VehicleModel::class, 'model_id');
    }

    public function lpo() {
        return $this->belongsTo(LpoMaster::class, 'lpo_id');
    }
}
