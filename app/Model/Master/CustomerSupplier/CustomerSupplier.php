<?php

namespace App\Model\Master\CustomerSupplier;

use App\Model\Cities;
use App\Model\Master\Company\Traffic;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerSupplier extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable, SoftDeletes;
    protected $fillable = ['contact_name'];

    /**
     * Get the state that owns the CustomerSupplier
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function state()
    {
        return $this->belongsTo(Cities::class, 'state_id');
    }

    public function traffic_of_customer_suppliers()
    {
        return $this->hasMany(Traffic::class, 'company_id')->whereTrafficFor(3);
    }
}
