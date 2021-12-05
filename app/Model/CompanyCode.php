<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class CompanyCode extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public $table = "company_codes";

    protected $fillable = [
        'passport_id',
        'company_code'
    ];

    public function passport()
    {
        return $this->belongsTo(\App\Model\Passport\Passport::class,'passport_id');
    }
}
