<?php

namespace App\Model\Master\Vehicle;

use App\Model\BikeDetail;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class VehiclePlateCode extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable, SoftDeletes;
    protected $fillable = ['plate_code'];
    
    /**
     * Get all of the bikes for the VehicleModel
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bikes()
    {
        return $this->hasMany(BikeDetail::class,'plate_code');
    }
}
