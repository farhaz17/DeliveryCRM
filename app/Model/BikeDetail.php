<?php

namespace App\Model;

use App\Model\Assign\AssignBike;
use App\Model\Salik\SalikOperation;
use App\Model\BoxInstall\FoodPermit;
use App\Model\Assign\AssignPlateform;
use App\Model\Master\Company\Traffic;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use App\Model\BoxInstall\BoxInstallation;
use App\Model\Master\Vehicle\VehicleMake;
use App\Model\Master\Vehicle\VehicleYear;
use App\Model\BikesTracking\BikesTracking;
use App\Model\Master\Vehicle\VehicleModel;
use App\Model\Master\Vehicle\VehicleCategory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\BikeReplacement\BikeReplacement;
use App\Model\Master\Vehicle\VehicleInsurance;
use App\Model\Master\Vehicle\VehiclePlateCode;
use App\Model\Master\Vehicle\VehicleSubCategory;

class BikeDetail extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    public function generateTags(): array
    {
        return ['Bike', 'RTA', 'Bike Update', 'RTA Update'];
    }
    // protected $auditInclude = ['plate_no','plate_code','model'];
    public $table = "bike_details";
    protected $fillable=['plate_no','plate_code','model','make_year', 'chassis_no','mortgaged_by','insurance_co','expiry_date','issue_date','traffic_file','category_type',
    'engine_no','seat','color','status','insurance_issue_date','insurance_expiry_date', 'vehicle_mortgage_no','make_id','vehicle_sub_category_id','insurance_no','attachment_reg_front','attachment_reg_back','attachment_insurance'];


    public function bike_history()
    {
        return $this->belongsTo(BikeDetailHistory::class,'id','bike_id');
    }

    public function bike_cancel()
    {
        return $this->belongsTo(BikeCencel::class,'id','bike_id');
    }
    public function traffic()
    {
        return $this->belongsTo(Traffic::class,'traffic_file');
    }


    public function tracking()
    {
        return $this->hasMany(BikesTracking::class,'bike_id','id');
    }

    public function assign_bike(){
        return $this->hasMany(AssignBike::class,'bike','id');
    }

    public function get_bikes(){
        return $this->AssignBike()->where('status','=','1')->first();
    }



    public function get_current_bike(){
        return $this->hasOne(AssignBike::class,'bike','id')->where('status','=', 1);
    }

    public function get_temporaray_bike(){
        return $this->hasOne(BikeReplacement::class,'new_bike_id','id')->where('status','=', 1);
    }

    public function bike_tracking()
    {
        return $this->belongsTo(BikesTracking::class,'id','bike_id');
    }

    public function model_info()
    {
        return $this->belongsTo(VehicleModel::class, 'model');
    }

    public function make()
    {
        return $this->belongsTo(VehicleMake::class);
    }

    public function year()
    {
        return $this->belongsTo(VehicleYear::class, 'make_year');
    }

    public function plate_code()
    {
        return $this->belongsTo(VehiclePlateCode::class);
    }
    public function plate_info()
    {
        return $this->belongsTo(VehiclePlateCode::class);
    }

    public function insurance()
    {
        return $this->belongsTo(VehicleInsurance::class);
    }

    public function category()
    {
        return $this->belongsTo(VehicleCategory::class, 'category_type');
    }

    public function sub_category()
    {
        return $this->belongsTo(VehicleSubCategory::class, 'vehicle_sub_category_id');
    }
    public function insurances()
    {
        return $this->belongsTo(VehicleInsurance::class,'insurance_co','id');
    }
    public function current_box()
    {
        return $this->hasOne(BoxInstallation::class,'bike_id','id')->where('status',6)->select(['id','bike_id','status','platform','box_image']);
    }
    public function food_permit()
    {
        return $this->hasOne(FoodPermit::class,'bike_id','id')->where('status',3);
    }

    public function salik_tag()
    {
        return $this->hasOne(SalikOperation::class,'bike_id','id')->where('status',1);
    }
}
