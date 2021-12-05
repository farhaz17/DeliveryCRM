<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ActiveInactiveSubCategory extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public function subcate_two(){
        return $this->hasMany(ActiveInactiveSubCategory::class,'sub_category');
    }

    public function subcate_one(){
        return $this->belongsTo(ActiveInactiveSubCategory::class,'sub_category');
    }

    public function main_cat(){
        return $this->belongsTo(ActiveInactiveCategoryMain::class,'main_category','id');
    }
}
