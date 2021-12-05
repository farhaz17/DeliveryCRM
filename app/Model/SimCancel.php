<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SimCancel extends Model
{
    //

    public function sim_detail(){
        return $this->belongsTo(Telecome::class,'sim_id','id');
    }
}
