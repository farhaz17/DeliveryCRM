<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Nationality extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    protected $fillable=['name'];

    public function nat()
    {
//        return $this->hasOne(\App\Model\Passport\Passport::class,'nation_id','id');
    }
}
