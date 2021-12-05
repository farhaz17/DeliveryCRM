<?php

namespace App\Model\Master\Company;

use App\Model\BikeDetail;
use App\Model\Passport\Passport;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Model\Master\CustomerSupplier\CustomerSupplier;

class Traffic extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public function company()
    {
        return $this->belongsTo('App\Model\Seeder\Company', 'company_id');
    }

    public function passport_info()
    {
        return $this->belongsTo(Passport::class, 'company_id');
    }

    public function customer_supplier_info()
    {
        return $this->belongsTo(CustomerSupplier::class, 'company_id');
    }

    public function state()
    {
        return $this->belongsTo('App\Model\Cities','state_id');
    }

    public function bikes()
    {
        return $this->hasMany(BikeDetail::class, 'traffic_file');
    }
}
