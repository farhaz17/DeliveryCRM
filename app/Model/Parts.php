<?php

namespace App\Model;


use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Parts extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable, SoftDeletes;

    protected $fillable=['part_name','part_number'];

    public function inv()
    {
        return $this->hasOne(InvParts::class,'parts_id','id');
    }
}
