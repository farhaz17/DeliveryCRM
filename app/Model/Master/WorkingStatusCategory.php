<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class WorkingStatusCategory extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public function working_subcategories(){
        return $this->hasMany(WorkingStatusSubCategory::class,'main_category');
    }
}
