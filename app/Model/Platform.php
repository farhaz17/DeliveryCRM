<?php

namespace App\Model;

use Carbon\Carbon;
use App\Model\Cods\Cods;
use App\Http\Middleware\Cod;
use App\Model\AssingToDc\AssignToDc;
use App\Model\Assign\AssignPlateform;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Platform extends Model  implements Auditable
{ 
    use \OwenIt\Auditing\Auditable;

    public  function  platforms_ab(){
        return $this->hasMany(Platform::class);
    }

    public function assign_platforms(){
        return $this->hasMany(AssignPlateform::class,'plateform');
    }

    public function total_check_in(){
        return $this->assign_platforms()->where('status','=','1')->count();
    }



    public function total_check_in_today(){
        $today_date  = date("Y-m-d");

        $now_time = Carbon::parse($today_date)->startOfDay();
        $end_time = Carbon::parse($today_date)->endOfDay();

        return $this->assign_platforms()->whereDate('created_at', '>=', $now_time)
                                            ->whereDate('created_at', '<=', $end_time)
                                            ->where('status','=','1')->count();
    }

    public function total_check_out_today(){

        $today_date  = date("Y-m-d");

        $now_time = Carbon::parse($today_date)->startOfDay();
        $end_time = Carbon::parse($today_date)->endOfDay();
        return $this->assign_platforms()->whereDate('updated_at', '>=', $now_time)
                                        ->whereDate('updated_at', '<=', $end_time)
                                        ->where('status','=','0')->count();
    }

    public function assign_platforms2(){
       return $this->assign_platforms()->where('status','=','1');
    }

    public function city_name(){
        return $this->belongsTo(Cities::class,'city_id');
    }

    public function platform_cod_detail(){
        return $this->hasMany(Cods::class,'platform_id','id');
    }



    public function get_total_approve_cod(){
          return $this->platform_cod_detail()->where('status','=','1')->sum('amount');
    }





//    public function get_distinct_passport(){
//       return $this->assign_platforms()->pluck('passport_id')->get();
//    }
}
