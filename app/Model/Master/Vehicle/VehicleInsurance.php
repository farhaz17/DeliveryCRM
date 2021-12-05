<?php

namespace App\Model\Master\Vehicle;

use App\Model\BikeDetail;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehicleInsurance extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable, SoftDeletes;
    protected $fillable = ['name'];
            /**
     * Get all of the bikes for the VehicleModel
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bikes()
    {
        return $this->hasMany(BikeDetail::class,'insurance_co');
    }

    
}
