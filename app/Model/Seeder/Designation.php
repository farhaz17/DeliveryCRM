<?php

namespace App\Model\Seeder;

use App\Model\Agreement;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Designation extends Model  implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    //
    public $table = "designations";
    protected $fillable = ['name','status'];

    public function agreement(){
        return $this->belongsTo(Agreement::class);
    }
}
