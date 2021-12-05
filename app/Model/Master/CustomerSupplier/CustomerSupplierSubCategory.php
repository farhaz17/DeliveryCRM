<?php

namespace App\Model\Master\CustomerSupplier;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\Master\CustomerSupplier\CustomerSupplierCategory;

class CustomerSupplierSubCategory extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable, SoftDeletes;
    protected $fillable = ['name'];

    /**
     * Get the parent_category that owns the CustomerSupplierSubCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent_category()
    {
        return $this->belongsTo(CustomerSupplierCategory::class, 'customer_supplier_category_id');
    }
}
