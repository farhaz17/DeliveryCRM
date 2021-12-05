<?php

namespace App\Model\Passport;

//use App\Model\Types;
use App\Model\Types;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class PassportAdditional extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public $table = "passport_additionals";
    protected $fillable = ['nation_id', 'additional_name','additional_name_field','type_id','placeholder'];

    public function type()
    {
        return $this->belongsTo(Types::class,'type_id');
    }

    public function additional_value()
    {
        return $this->belongsTo(Passport_add_values::class,'id');
    }

}
