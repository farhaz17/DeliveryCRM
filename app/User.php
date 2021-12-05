<?php

namespace App;

use App\DcLimit\DcLimit;
use App\Model\AssingToDc\AssignToDc;
use App\Model\Attendance\RiderAttendance;
use App\Model\Departments;
use App\Model\MajorDepartment;
use App\Model\Manager_users;
use App\Model\Platform;
use App\Model\RiderOrderDetail\RiderOrderDetail;
use App\Model\RiderProfile;
use App\Model\UserGroups;
use App\Model\UserLiveStatus\UserLiveStatus;
use App\Model\VerificationForm;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Contracts\Auth\CanResetPassword;

use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable 
{
    use SoftDeletes;
    use HasApiTokens, Notifiable;
    use HasRoles;

    protected $table= "users";

    protected $fillable = [
        'name', 'email', 'password','user_group_id','otp','user_issue_dep_id','user_platform_id','major_department_ids'
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'user_group_id' => 'int',
        'major_department_ids' => 'int',
        'user_issue_dep_id' => 'int',
        'user_platform_id' => 'int',
    ];

    function getAttributeName($name){
        return ucFirst($name);
    }

    function getUserGroupIdAttribute(){
        return json_decode($this->attributes['user_group_id'],true);
    }
    function getUserIssueDepIdAttribute(){
        return json_decode($this->attributes['user_issue_dep_id'],true);
    }
    function getUserPlatformIdAttribute(){
        return json_decode($this->attributes['user_platform_id'],true);
    }

    function getMajorDepartmentIdsAttribute(){
        return json_decode($this->attributes['major_department_ids'],true);
    }

    public function userGroup()
    {
        return $this->belongsTo(UserGroups::class,'user_group_id');
    }
    public function userissuedepartment()
    {
        return $this->belongsTo(Departments::class,'user_issue_dep_id');
    }

    public function major_department()
    {
        return $this->belongsTo(MajorDepartment::class,'major_department_ids');
    }
    public function userPlatform()
    {
        return $this->belongsTo(Platform::class,'user_platform_id');
    }

    public function profile()
    {
        return $this->hasOne(RiderProfile::class,'user_id','id');
    }

    public function profile_ticket()
    {
        return $this->hasOne(RiderProfile::class,'user_id','id')->select(['user_id', 'passport_id']);
    }

    public function verify_from()
    {
        return $this->hasOne(VerificationForm::class,'user_id','id');
    }

    public function live_user_status(){
        return $this->hasOne(UserLiveStatus::class,'user_id');
    }

    public function get_dc_rirders(){
        return $this->hasMany(AssignToDc::class,'user_id');
    }

    public function  get_dc_riders_by_platform($id){
        return $this->get_dc_rirders()->where('platform_id','=',$id)->where('status','=','1')->get();
    }

    public function dc_limit_detail()
    {
        return $this->hasOne(DcLimit::class,'user_id');
    }

    public function dc_riders(){
        return $this->hasMany(AssignToDc::class,'user_id');
    }

    public function  dc_riders_count(){
        return $this->dc_riders()->where('status','=','1')->count();
    }

    public function  dc_riders_array_active(){
        return $this->dc_riders()->where('status','=','1')->pluck('rider_passport_id')->toArray();
    }

    public function dc_today_order(){

        $u_data = $this->dc_riders()->first();

        $user_id = isset($u_data->user_id) ? $u_data->user_id :0 ;

        $total_rider_array = AssignToDc::where('user_id','=',$user_id)->where('status','=',"1")->get()->pluck('rider_passport_id')->toArray();
        $today_date = date("Y-m-d");

        $last_day = date("Y-m-d", strtotime($today_date."-1 day"));

        $total_orders_today = RiderOrderDetail::whereIn('passport_id',$total_rider_array)->where('start_date_time','LIKE','%'.$last_day.'%')->sum('total_order');

        return $total_orders_today;

    }

    public function today_absent_rider_by_dc($total_rider_array){

        $today_date = date("Y-m-d");

        $today_attendence = RiderAttendance::whereIn('passport_id',$total_rider_array)->where('status','=','1')->where('created_at','LIKE','%'.$today_date.'%')->count();
        $today_leaves = RiderAttendance::whereIn('passport_id',$total_rider_array)->where('status','=','2')->where('created_at','LIKE','%'.$today_date.'%')->count();

        $total_rider_assigned = count($total_rider_array);

        $today_absent = $total_rider_assigned-($today_attendence+$today_leaves);

        return $today_absent;

    }

    public function manager_users(){
        return $this->hasMany(Manager_users::class,'manager_user_id','id');
    }

    public function member_user(){
        return $this->hasOne(Manager_users::class,'member_user_id','id');
    }




}
