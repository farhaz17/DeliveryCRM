<?php

namespace App\Model\PpuidCancel;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class CancelCateogryPpuid extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public function childrenCategories()
    {
    return $this->hasMany(CancelCateogryPpuid::class,'parent_id','id');
    // ->with('categories');
    }


}
