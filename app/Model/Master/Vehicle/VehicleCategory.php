<?php

namespace App\Model\Master\Vehicle;

use App\Model\BikeDetail;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\Master\Vehicle\VehicleSubCategory;

class VehicleCategory extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable, SoftDeletes;
    protected $fillable = ['name'];
    public function bikes()
    {
        return $this->hasMany(BikeDetail::class,'category_type');
    }

    public function sub_categories()
    {
        return $this->hasMany(VehicleSubCategory::class,'vehicle_category_id');
    }
}
