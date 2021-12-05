<?php

namespace App\Model\Master;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class SubCategory extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;
    public function subcate_two(){
        return $this->hasMany(SubCategory::class,'sub_category');
    }

    public function subcate_one(){
        return $this->belongsTo(SubCategory::class,'sub_category');
    }

    public function main_cat(){
        return $this->belongsTo(Category::class,'main_category','id');
    }


}
