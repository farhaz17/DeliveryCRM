<?php

namespace App\Model\Guest;

use App\User;
use App\Model\Cities;
use App\Model\Platform;
use App\Model\Nationality;
use App\Model\Master\FourPl;
use App\Model\exprience_month;
use App\Model\Referal\Referal;
use App\Model\Guest\Experience;
use App\Model\Passport\Passport;
use App\Model\Career\waitlistfollowup;
use App\Model\Career\selected_followup;
use App\Model\Seeder\Followup_statuses;
use Illuminate\Database\Eloquent\Model;
use App\Model\Career\frontdesk_followup;
use OwenIt\Auditing\Contracts\Auditable;
use App\Model\OnBoardStatus\OnBoardStatus;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\CreateInterviews\CreateInterviews;
use App\Model\VendorRegistration\VendorRiderOnboard;
use App\Model\CareerStatusHistory\CareerStatusHistory;
use App\Model\Package\Package;

class Career extends Model  implements Auditable
{
    use \OwenIt\Auditing\Auditable, SoftDeletes;
    protected $table= "careers";
    // protected $with = ['user'];
    protected $fillable = [
        'name', 'email', 'phone','whatsapp','facebook','vehicle_type','experience','cv',
        'licence_status','licence_status_vehicle','licence_no','licence_issue','licence_expiry',
        'licence_attach','licence_city_id' ,'nationality','dob','passport_no','passport_expiry','passport_attach',
        'visa_status','visa_status_visit','visa_status_cancel','visa_status_own',
        'exit_date','company_visa','inout_transfer','platform_id','applicant_status',
        'remarks','company_remarks','hire_status','action_rider','traffic_file_no','licence_attach_back'
        ,'experience_month','refer_by','refer_type','cities','promotion_type','promotion_others',
        'belong_city_name','passport_status','pak_licence_status','source_type','user_id','social_media_id_name','have_passport'
        ,'employee_type','four_pl_name_id','waist_size','shirt_size','vendor_fourpl_pk_id','care_of','medical_type',
        'employee_status_id','physical_document','nic_expiry','referal_status_reward','referal_reward_amount'
        ,'new_taken_licence','licence_front_image','licence_back_image','past_status','career_bypass','pkg_id'
    ];

    protected $casts = [
        'platform_id' => 'int',
        'cities' => 'int',
    ];



    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function city()
    {
        return $this->belongsTo(Cities::class,'licence_city_id','id');

    }

    public function country_name(){
        return $this->belongsTo(Nationality::class,'nationality','id');
    }

    function getPlatformIdAttribute(){
        return json_decode($this->attributes['platform_id'],true);
    }
    function getCitiesAttribute(){
        return json_decode($this->attributes['cities'],true);
    }

    function fourpl_company_name(){
        return $this->belongsTo(FourPl::class,'four_pl_name_id','id');
    }

    function care_of_name(){
        return $this->belongsTo(Passport::class,'care_of','id');
    }


    public  function platform(){

            return $this->belongsTo(Platform::class,'platform_id');
    }


    public  function get_experience(){

        return $this->belongsTo(Experience::class,'experience','id');
    }

    public  function get_month_experience(){

        return $this->belongsTo(exprience_month::class,'experience_month','id');
    }


    public function career_history(){
        return $this->hasMany(CareerStatusHistory::class);
    }

    public function passport_detail(){

        return $this->belongsTo(Passport::class,'passport_no','passport_no');
    }

    public function passport_ppuid(){
        return $this->hasOne(Passport::class,'career_id','id');
    }

    public function refer_by_user(){

        return $this->belongsTo(Passport::class,'refer_by','id');
    }

    public function follow_status(){

        return $this->belongsTo(Followup_statuses::class,'applicant_status','id');
    }

    public function interviews()
    {
        return $this->hasMany(CreateInterviews::class);
    }

    public function on_boards()
    {
        return $this->hasMany(OnBoardStatus::class,'career_id','id');
    }

    public function check_on_board(){
        return $this->on_boards()->where('interview_status','=','1')
                                ->where('assign_platform','=','1')
                                ->where('assign_platform','=','1')->first();
     }

    public function training_pass()
    {
        return $this->on_boards()->where('is_training','=','1')->count();
    }

    public function training_fail()
    {
        return $this->on_boards()->where('is_training','>','1')->count();
    }


    public function interview_pass()
    {
        return $this->interviews()->where('interview_status','=','1')->count();
    }

    public function check_interview_or_not()
    {
        return $this->interviews()->where('interview_status','=','0')->first();
    }


    public function interview_failed()
    {
        return $this->interviews()->where('interview_status','=','2')->count();
    }

    public function follow_up_frontdesk(){

        return $this->belongsTo(frontdesk_followup::class,'follow_up_status');
    }

    public function follow_up_name(){

        return $this->belongsTo(waitlistfollowup::class,'follow_up_status');
    }

    public function follow_up_name_selected(){

        return $this->belongsTo(selected_followup::class,'follow_up_status');
    }

    public function vendor_fourpl_detail(){
        return $this->belongsTo(VendorRiderOnboard::class,'vendor_fourpl_pk_id');
    }

    public function referal_detail(){
       return $this->hasOne(Referal::class,'career_id');
    }

    public function pkg_detail(){
        return $this->belongsTo(Package::class,'pkg_id');
    }

}
