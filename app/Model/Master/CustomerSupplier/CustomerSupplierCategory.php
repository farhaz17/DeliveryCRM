<?php

namespace App\Model\Master\CustomerSupplier;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerSupplierCategory extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable, SoftDeletes;
    protected $fillable = ['name'];
    public function sub_categories()
    {
        return $this->hasMany(CustomerSupplierSubCategory::class);
    }
}
