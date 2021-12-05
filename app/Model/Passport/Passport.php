<?php

namespace App\Model\Passport;

use App\User;
use Carbon\Carbon;
use App\Model\Platform;
use App\Model\BikeDetail;
use App\Model\CompanyCode;
use App\Model\Nationality;
use App\Model\AgreedAmount;
use App\Model\Guest\Career;
use App\Model\RiderProfile;
use App\Model\LabourCardType;
use App\Model\Assign\AssignSim;
use App\Model\Assign\AssignBike;
use App\Model\Emirates_id_cards;
use App\Model\Agreement\Agreement;
use App\Model\Assign\AssignReport;
use App\Model\Career\RejoinCareer;
use App\Model\UserCodes\UserCodes;
use App\Model\LabourCardTypeAssign;
use App\Model\VisaProcess\FitUnfit;
use App\Model\AssingToDc\AssignToDc;
use App\Model\Master\CategoryAssign;
use App\Model\VisaProcess\EntryDate;
use App\Model\VisaProcess\Medical24;
use App\Model\VisaProcess\Medical48;
use App\Model\Assign\AssignPlateform;
use App\Model\Master\Company\Traffic;
use App\Model\VisaProcess\LabourCard;
use App\Model\VisaProcess\MedicalVIP;
use App\Model\VisaProcess\VisaPasted;
use App\Model\CodPrevious\CodPrevious;
use App\Model\PpuidCancel\PpuidCancel;
use App\Model\ReserveBike\ReserveBike;
use App\Model\VisaProcess\StatusChange;
use App\Model\VisaProcess\TawjeehClass;
use App\Model\VisaProcess\VisaStamping;
use Illuminate\Database\Eloquent\Model;
use App\Model\Offer_letter\Offer_letter;
use App\Model\PlatformCode\PlatformCode;
use App\Model\VisaProcess\CurrentStatus;
use App\Model\VisaProcess\MedicalNormal;
use App\Model\VisaProcess\UniqueEmailId;
use OwenIt\Auditing\Contracts\Auditable;
use App\Model\Attendance\RiderAttendance;
use App\Model\Passport\PassportWithRider;
use App\Model\VisaProcess\VisaAttachment;
use App\Model\LogAfterPpuid\LogAfterPpuid;
use App\Model\OnBoardStatus\OnBoardStatus;
use App\Model\VisaProcess\EmiratesIdApply;
use App\Model\VisaProcess\WaitingForZajeel;
use App\Model\DrivingLicense\DrivingLicense;
use App\Model\SimReplacement\SimReplacement;
use App\Model\VisaProcess\EntryPrintOutside;
use App\Model\VisaProcess\RenewAgreedAmount;
use App\Model\VisaProcess\WaitingForApproval;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Model\BikeReplacement\BikeReplacement;
use App\Model\Passport\passport_addtional_info;
use App\Model\VisaProcess\NewContractAppTyping;
use App\Model\RiderOrderDetail\RiderOrderDetail;
use App\Model\VisaProcess\EmiratesIdFingerPrint;
use App\Model\VisaProcess\NewContractSubmission;
use App\Model\VisaProcess\UniqueEmailIdHandover;
use App\Model\Master\ActiveInactiveCategoryAssign;
use App\Model\Offer_letter\Offer_letter_submission;
use App\Model\PassportAttachment\PassportAttachment;
use App\Model\Riders\DefaulterRiders\DefaulterRider;
use App\Model\DcRequestForCheckin\DcRequestForCheckin;
use App\Model\ElectronicApproval\ElectronicPreApproval;
use phpDocumentor\Reflection\DocBlock\Tags\TagWithType;
use App\Model\Master\ActiveInactiveCategoryAssignHistory;
use App\Model\ElectronicApproval\ElectronicPreApprovalPayment;

class Passport extends Model  implements Auditable
{
    use \OwenIt\Auditing\Auditable, SoftDeletes;
    public $table = "passports";
    protected $fillable = ['nation_id', 'country_code','passport_no','sur_name','given_names','father_name','dob','place_birth','place_issue','date_issue','date_expiry','passport_pic','citizenship_no','personal_address','permanant_address','booklet_number','tracking_number','name_of_mother','next_of_kin','relationship','middle_name','attachment_name','attachment_id','status','career_id','employee_category','visa_status','visa_status_visit','visa_status_cancel','visa_status_own','exit_date'];

    public function nation()
    {
        return $this->belongsTo(Nationality::class,'nation_id');
    }
    public function offer()
    {
        return $this->hasOne(Offer_letter::class,'passport_id','id');
    }

    public function after_ppuid_status(){
        return $this->hasMany(LogAfterPpuid::class,'passport_id');
    }
    public function traffics(){
        return $this->hasMany(Traffic::class,'company_id');
    }

    public function on_board_details(){
        return $this->hasMany(OnBoardStatus::class,'passport_id','id');
    }

    public function on_board_details_check(){
        return $this->on_board_details()
            ->where('assign_platform','=','1')
            ->where('interview_status','=','1')
            ->where('on_board','=','1')->first();

    }
    public function assign_to_dcs()
    {
        return $this->hasMany(AssignToDc::class, 'rider_passport_id')->latest();
    }
    public function active_inactive_category_assign_histories()
    {
        return $this->hasMany(ActiveInactiveCategoryAssignHistory::class, 'passport_id')->latest();
    }

    public function get_current_dc(){
            return $this->assign_to_dcs()->where('status','=','1')->first();
    }

    public function offer_letter_submission()
    {
        return $this->hasOne(Offer_letter_submission::class,'passport_id','id');
    }

    public function elect_pre_approval()
    {
        return $this->hasOne(ElectronicPreApproval::class,'passport_id','id');
    }

    public function elect_pre_approval_payment()
    {
        return $this->hasOne(ElectronicPreApprovalPayment::class,'passport_id','id');
    }

    public function print_visa_inside_outside()
    {
        return $this->hasOne(EntryPrintOutside::class,'passport_id','id');
    }

    public function status_change()
    {
        return $this->hasOne(StatusChange::class,'passport_id','id');
    }

    public function entry_date()
    {
        return $this->hasOne(EntryDate::class,'passport_id','id');
    }

    public function medical_twnenty_four()
    {
        return $this->hasOne(Medical24::class,'passport_id','id');
    }

    public function medical_fourty_eight()
    {
        return $this->hasOne(Medical48::class,'passport_id','id');
    }

    public function medical_vip()
    {
        return $this->hasOne(MedicalVIP::class,'passport_id','id');
    }

    public function medical_normal()
    {
        return $this->hasOne(MedicalNormal::class,'passport_id','id');
    }

    public function fit_unfit()
    {
        return $this->hasOne(FitUnfit::class,'passport_id','id');
    }

    public function emitres_id_apply()
    {
        return $this->hasOne(EmiratesIdApply::class,'passport_id','id');
    }

    public function reserve_bike()
    {
        return $this->hasOne(ReserveBike::class,'passport_id','id');
    }

    public function finger_print()
    {
        return $this->hasOne(EmiratesIdFingerPrint::class,'passport_id','id');
    }
    public function tawjeeh_class()
    {
        return $this->hasOne(TawjeehClass::class,'passport_id','id');
    }
    public function visa_approval()
    {
        return $this->hasOne(WaitingForApproval::class,'passport_id','id');
    }
    public function zajeel()
    {
        return $this->hasOne(WaitingForZajeel::class,'passport_id','id');
    }

    public function contract_typing()
    {
        return $this->hasOne(NewContractAppTyping::class,'passport_id','id');
    }

    public function new_contract_submission()
    {
        return $this->hasOne(NewContractSubmission::class,'passport_id','id');
    }

    public function labour_card_print()
    {
        return $this->hasOne(LabourCard::class,'passport_id','id');
    }

    public function visa_stamping()
    {
        return $this->hasOne(VisaStamping::class,'passport_id','id');
    }

    public function previous_balance()
    {
        return $this->hasOne(CodPrevious::class,'passport_id','id');
    }

    public function visa_pasted()
    {
        return $this->hasOne(VisaPasted::class,'passport_id','id');
    }

    public function emirates_id_handover()
    {
        return $this->hasOne(UniqueEmailIdHandover::class,'passport_id','id');
    }

    public function emirated_id_received()
    {
        return $this->hasOne(UniqueEmailId::class,'passport_id','id');
    }

    public function attachment_type(){
        return $this->belongsTo(AttachmentTypes::class,'attachment_name');
    }



    public function agreement(){
        return $this->hasOne(Agreement::class);
    }
    public function userCodes(){
        return $this->hasMany(UserCodes::class, 'passport_id', 'id');
    }

    public function platform_codes(){
        return $this->hasMany(PlatformCode::class, 'passport_id', 'id');
    }
    public function get_the_rider_id_by_platform($platform_id){
        return $this->hasMany(PlatformCode::class, 'passport_id', 'id')->where('platform_id','=',$platform_id)->first();
    }


    public function personal_info(){
        return $this->belongsTo(passport_addtional_info::class, 'id','passport_id');
    }

    public function personal_info_ticket(){
        return $this->belongsTo(passport_addtional_info::class, 'id','passport_id')->select(['passport_id', 'full_name']);
    }

    public function company_code()
    {
        return $this->hasOne(CompanyCode::class,'passport_id','id');
    }
    public function labour_card_type()
    {
        return $this->hasOne(LabourCardType::class,'passport_id','id');
    }
    public function profile()
    {
        return $this->hasOne(RiderProfile::class,'passport_id','id');
    }
    public function card_type()
    {
        return $this->hasOne(LabourCardTypeAssign::class,'passport_id','id');
    }


    public function offerLetter()
    {
        return $this->hasMany(Offer_letter::class,'passport_id','id');
    }

    public function attach()
    {
        return $this->belongsTo(PassportAttachment::class,'attachment_id');
    }



    public  function  zds_code(){

        return $this->belongsTo(UserCodes::class,'id','passport_id');
    }

    public  function  get_platform_code(){

        return $this->hasOne(UserCodes::class,'passport_id');
    }

    public  function  rider_zds_code(){

        return $this->hasOne(UserCodes::class);
    }

    public  function platform(){

        return $this->belongsTo(AssignPlateform::class,'id','passport_id');
    }



    public  function sim(){

        return $this->belongsTo(AssignSim::class,'id');
    }
    public  function bike(){

        return $this->belongsTo(AssignBike::class,'id');
    }



    public  function platform_assign(){
        return $this->hasMany(AssignPlateform::class,'passport_id','id');
    }

    public function check_platform_code_exist(){
        return $this->hasMany(PlatformCode::class,'passport_id','id');
     }

     public function get_current_platfom_code($plataform_id){
        return $this->check_platform_code_exist()->where('platform_id','=',$plataform_id)->first();
     }

    public function check_platform_code_exist_by_platform($platform_id){
        return $this->check_platform_code_exist()->where('platform_id','=',$platform_id)->first();
    }

    public function assign_platforms_check(){
        return $this->platform_assign()->where('status','=','1')->first();
    }
    //get last checkout platform

    public function assign_platforms_checkin(){
        return $this->platform_assign()->where('status','=','1')->first();
    }

    public function assign_platforms_checkout(){
        return $this->platform_assign()->where('status','=','0')
            ->orderBy('checkout','asc')
            ->limit('1')
            ->first();
    }

    public function last_assign_platforms_checkout(){
        return $this->platform_assign()->where('status','=','0')
            ->orderBy('id','desc')
            ->limit('1')
            ->first();
    }



    public  function sim_assign(){
        return $this->hasMany(AssignSim::class,'passport_id','id')->with('telecome');
    }

    public  function sim_checkin(){
        return $this->sim_assign()->where('status','=','1')->first();
    }

    public  function bike_assign(){
        return $this->hasMany(AssignBike::class,'passport_id','id');
    }
    public  function bike_assign_assign_report(){
        return $this->hasMany(AssignBike::class,'passport_id','id')->with('bike_plate_number');
    }

    public  function bike_checkin(){
        return $this->bike_assign()->where('status','=','1')->first();
    }


    public function assign_sim_check(){
        return $this->sim_assign()->where('status','=','1')->first();
    }

    public function assign_bike_check(){
        return $this->bike_assign()->where('status','=','1')->first();
    }

    public function bike_replacement(){
        return $this->hasOne(BikeReplacement::class);
    }
    public function rider_bike_replacement(){
        return $this->hasOne(BikeReplacement::class)->select(['passport_id', 'new_bike_id','replace_checkin']);
    }

    //temporary bike
    public function temporary_bike_replacement(){
        return $this->hasMany(BikeReplacement::class);
    }

    //temporary sim
    public function temporary_sim_replacement(){
        return $this->hasMany(SimReplacement::class);
    }

    public  function emirates_id(){
        return $this->hasOne(Emirates_id_cards::class);
    }

    public  function driving_license(){
        return $this->hasOne(DrivingLicense::class);
    }

    public  function verified(){
        return $this->belongsTo(AssignReport::class,'id','passport_id');
    }

    public  function  renew_pass(){
        return $this->belongsTo(RenewPassport::class,'id','passport_id');
    }
    public  function wrong_pass(){
        return $this->belongsTo(CorrectPassport::class,'id','passport_id');
    }


    public function rider_id()
    {
        return $this->belongsTo(PlatformCode::class,'id');
    }
    public function rider_platform()
    {
        return $this->belongsTo(AssignPlateform::class,'id','passport_id');

    }
    public function agreement2(){
        return $this->belongsTo(Agreement::class,'id','passport_id');
    }

    public function profile_img()
    {
        return $this->belongsTo(RiderProfile::class,'id','passport_id');
    }

    public  function driving_license2(){

        return $this->belongsTo(DrivingLicense::class,'id','passport_id');
    }

    public function dc_detail()
    {
        return $this->hasOne(AssignToDc::class,'rider_passport_id','id');
    }
    public function rider_dc_detail()
    {
        return $this->hasOne(AssignToDc::class,'rider_passport_id','id')->select(['rider_passport_id', 'user_id'])->where('status','1');
    }
    public function ppuid_cancel()
    {
        return $this->hasOne(PpuidCancel::class,'passport_id','id');
    }

    public function ppuid_cancel_history()
    {
        return $this->hasOne(PpuidCancel::class,'passport_id','id');
    }

    public function ppuid_cancel_current()
    {
        return $this->ppuid_cancel_history()->where('status','=','1')->first();
    }

    public function has_pending_request_for_checkin(){
        return $this->hasMany(DcRequestForCheckin::class,'rider_passport_id','id');
    }

    public function pending_request_for_checkin($passport_id){

        return $this->has_pending_request_for_checkin()
            ->where(function ($query)  {
                $query->where('request_status', '=', '0')
                    ->orwhere('request_status','=','1');
            })
            ->where('rider_passport_id','=',$passport_id)->first();
    }

    public function pending_request_for_checkin_second($passport_id){

        return $this->has_pending_request_for_checkin()
            ->where('request_status', '=', '0')
            ->where('rider_passport_id','=',$passport_id)->first();
    }


    public function career(){
        return $this->belongsTo(Career::class,'career_id');


    }

    public function agreed(){
        return $this->belongsTo(AgreedAmount::class,'id','passport_id');
    }

    public function total_checkin_request_rejected($passport_id){

        return $this->has_pending_request_for_checkin()
            ->where('request_status', '=', '2')
            ->where('rider_passport_id','=',$passport_id)->count();
    }

    public function total_checkin_request_accepted($passport_id){

        return $this->has_pending_request_for_checkin()
            ->where('request_status', '=', '1')
            ->where('rider_passport_id','=',$passport_id)->count();
    }

    public function passport_to_locker(){
        return $this->hasMany(PassportToLocker::class,'passport_id','id');
    }

    public function check_passport_hold(){
         return $this->passport_to_locker()->where('holds_passport','=','1')->first();
    }

    public function passport_locker(){
        return $this->hasMany(PassportLocker::class);
    }

    public function check_passport_locker(){
        return $this->passport_locker()->whereNotNull('deleted_at')->first();
    }

    public function passport_with_rider(){
        return $this->hasOne(PassportWithRider::class,'passport_id');
    }

    public function passport_in_locker(){
        return $this->hasOne(PassportLocker::class,'passport_id');
    }

    public function passport_to_lock(){
        return $this->hasOne(PassportToLocker::class,'passport_id')->where('holds_passport','=','1');
    }

    public function visa_process_status(){
        return $this->hasOne(CurrentStatus::class,'passport_id','id');
    }

    public function agree_amount(){
        return $this->hasOne(AgreedAmount::class,'passport_id','id');
    }

    public function reserved_bike_sim_check_history(){
        return $this->hasMany(ReserveBike::class,'passport_id','id');
    }

    public function check_bike_sim_reserved_or_not(){

        return $this->reserved_bike_sim_check_history()
                ->where('assign_status','=','0')
                ->where('sim_assign_status','=','0')
                ->orderBy('id','desc')->first();
    }

    public  function rider_sim_assign(){
        return $this->hasOne(AssignSim::class,'passport_id','id')->select(['passport_id', 'sim','checkin'])->where('status','=','1');
    }

    public function rider_attendance()
    {
        return $this->hasOne(RiderAttendance::class,'passport_id')->select(['passport_id', 'status'])->whereDate('created_at', '=', Carbon::today()->toDateString());
    }
    public function rider_orders(){
        return $this->hasOne(RiderOrderDetail::class, 'passport_id')->select(['passport_id', 'start_date_time'])->latest();
    }

    public function rejoin_career_detail(){

        return $this->hasMany(RejoinCareer::class,'passport_id','id');

    }

    public function check_rejoin_in_waitlist(){
        return  $this->rejoin_career_detail()->where('hire_status','!=','1')->first();
    }

    public function careem_plateform_code(){
        return $this->hasOne(PlatformCode::class, 'passport_id', 'id')->whereIn('platform_id',[1,32]);
    }
    public function carrefour_plateform_code(){
        return $this->hasOne(PlatformCode::class, 'passport_id', 'id')->where('platform_id','38');
    }

    public function renew_agreed(){
        return $this->belongsTo(RenewAgreedAmount::class,'id','passport_id');
    }

    public function defaulter_rider_details(){
        return $this->hasMany(DefaulterRider::class,'passport_id','id');
    }

    public function category_assign(){
        return $this->hasMany(CategoryAssign::class,'passport_id','id')->select('passport_id', 'id','main_category','sub_category1', 'sub_category2');
    }

    public function get_employee_type(){
        return $this->category_assign()->where('status','=','1')->first();
    }


    public function active_inactive_category_assigns(){
        return $this->hasMany(ActiveInactiveCategoryAssign::class,'passport_id','id');
    }


}
