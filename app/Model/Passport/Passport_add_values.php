<?php

namespace App\Model\Passport;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Passport_add_values extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public $table = "passport_add_values";
    protected $fillable = ['passport_id','additional_field_id', 'value'];


    public function additional_values()
    {
        return $this->belongsTo(Passport_add_values::class,'additional_field_id');
    }
}


