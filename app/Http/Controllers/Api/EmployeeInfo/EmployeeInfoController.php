<?php

namespace App\Http\Controllers\Api\EmployeeInfo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Assign\AssignPlateform;
use App\Model\Emirates_id_cards;
use App\Model\Guest\Career;
use App\Model\Offer_letter\Offer_letter;
use App\Model\Passport\Passport;
use App\Model\PlatformCode\PlatformCode;
use App\Model\UserCodes\UserCodes;

class EmployeeInfoController extends Controller
{
    //

    public function get_employee_info($keyword){


        //search with emiates_id, zdsid, ppuid, rider_id and
        //required information full_name, visa company, rider_id emirates_id and zds and ppuid and


        $active_riders  = AssignPlateform::where('status','=','1')->pluck('passport_id')->toArray();

         $emirates_id_detail = Emirates_id_cards::where('card_no','=',$keyword)->whereIn('passport_id',$active_riders)->first();



         if($emirates_id_detail != null){ //emirates id


            $offer_letter = Offer_letter::where('passport_id',$emirates_id_detail->passport_id)->first();

            $passport_detail =  $emirates_id_detail->passport;

            $four_pl_name =  null;

            if($passport_detail->career_id!="0"){
                $career_detail = Career::find($passport_detail->career_id);
                if($career_detail != null){
                    if($career_detail->employee_type=="2"){
                        if(isset($career_detail->vendor_fourpl_detail)){
                        $four_pl_name = isset($career_detail->vendor_fourpl_detail->vendor) ? $career_detail->vendor_fourpl_detail->vendor->name: '';
                            $is_working = $career_detail->vendor_fourpl_detail;

                        }else{
                        $four_pl_name = "N/A";
                        }


                         $visa_type =  $is_working->cancel_status=="1" ? "Company" : "Four PL";


                    }
                }else{
                    $visa_type = "Company";
                }
            }else{
                $visa_type = "Company";
            }



                    $platform_name = "";
                    $platform_id = "";
                    if(!$passport_detail->platform_assign->isEmpty()) {
                         $ab = $passport_detail->platform_assign->where('checkout','is',null)->first();
                        $platform_name = isset($ab->plateformdetail->name)? $ab->plateformdetail->name : 'N/A';
                        $platform_id = isset($ab->plateformdetail->id)? $ab->plateformdetail->id : '';
                    }else{
                        $platform_name = null;
                    }

                  $paltform_code  =  PlatformCode::where('platform_id','=',$platform_id)
                                                ->where('passport_id',$passport_detail->id)
                                                ->first();




            $company= isset($offer_letter->companies->name)?$offer_letter->companies->name:null;


            $gamer = array(
                'emirates_id_no' => isset($emirates_id_detail) ? $emirates_id_detail->card_no : null,
                'full_name' =>  isset($passport_detail) ? $passport_detail->personal_info->full_name : null,
                'company_name' => isset($company) ?  $company : $four_pl_name,
                'visa_type' => $visa_type,
                'platform_name' => $platform_name,
                'rider_id' => isset($paltform_code) ? $paltform_code->platform_code : null,
                'zds_code' =>  isset($passport_detail->rider_zds_code) ? $passport_detail->rider_zds_code->zds_code : null,
                'ppuid' => $passport_detail->pp_uid
            );

                return response()->json($gamer, 200, [], JSON_NUMERIC_CHECK);
                exit;
         }

           $zds_code_detail = UserCodes::where('zds_code','=',$keyword)->whereIn('passport_id',$active_riders)->first();

         if($zds_code_detail != null){ //zds code


            $offer_letter = Offer_letter::where('passport_id',$zds_code_detail->passport_id)->first();


            $emirates_id_detail = Emirates_id_cards::where('passport_id','=',$zds_code_detail->passport_id)->first();

            $passport_detail =  $zds_code_detail->passport;

            $four_pl_name =  null;

            if($passport_detail->career_id!="0"){
                $career_detail = Career::find($passport_detail->career_id);
                if($career_detail != null){
                    if($career_detail->employee_type=="2"){
                        if(isset($career_detail->vendor_fourpl_detail)){
                        $four_pl_name = isset($career_detail->vendor_fourpl_detail->vendor) ? $career_detail->vendor_fourpl_detail->vendor->name: '';
                            $is_working = $career_detail->vendor_fourpl_detail;

                        }else{
                        $four_pl_name = "N/A";
                        }


                         $visa_type =  $is_working->cancel_status=="1" ? "Company" : "Four PL";


                    }
                }else{
                    $visa_type = "Company";
                }
            }else{
                $visa_type = "Company";
            }



                    $platform_name = "";
                    $platform_id = "";
                    if(!$passport_detail->platform_assign->isEmpty()) {
                         $ab = $passport_detail->platform_assign->where('checkout','is',null)->first();
                        $platform_name = isset($ab->plateformdetail->name)? $ab->plateformdetail->name : 'N/A';
                        $platform_id = isset($ab->plateformdetail->id)? $ab->plateformdetail->id : '';
                    }else{
                        $platform_name = null;
                    }

                  $paltform_code  =  PlatformCode::where('platform_id','=',$platform_id)
                                                ->where('passport_id',$passport_detail->id)
                                                ->first();




            $company= isset($offer_letter->companies->name)?$offer_letter->companies->name:null;


            $gamer = array(
                'emirates_id_no' => isset($emirates_id_detail) ? $emirates_id_detail->card_no : null,
                'full_name' =>  isset($passport_detail) ? $passport_detail->personal_info->full_name : null,
                'company_name' => isset($company) ?  $company : $four_pl_name,
                'visa_type' => $visa_type,
                'platform_name' => $platform_name,
                'rider_id' => isset($paltform_code) ? $paltform_code->platform_code : null,
                'zds_code' =>  isset($passport_detail->rider_zds_code) ? $passport_detail->rider_zds_code->zds_code : null,
                'ppuid' => $passport_detail->pp_uid
            );

                return response()->json($gamer, 200, [], JSON_NUMERIC_CHECK);
                exit;
         }


         $passport_detail_search = Passport::where('pp_uid','=',$keyword)->whereIn('id',$active_riders)->first();

         if($passport_detail_search != null){ //ppuid search


            $offer_letter = Offer_letter::where('passport_id',$passport_detail_search->id)->first();



            $emirates_id_detail = Emirates_id_cards::where('passport_id','=',$passport_detail_search->id)->first();


            $passport_detail =  $passport_detail_search;



            $four_pl_name =  null;
            if($passport_detail->career_id!="0"){
                $career_detail = Career::find($passport_detail->career_id);
                if($career_detail != null){
                    if($career_detail->employee_type=="2"){
                        if(isset($career_detail->vendor_fourpl_detail)){
                        $four_pl_name = isset($career_detail->vendor_fourpl_detail->vendor) ? $career_detail->vendor_fourpl_detail->vendor->name: '';
                            $is_working = $career_detail->vendor_fourpl_detail;

                        }else{
                        $four_pl_name = "N/A";
                        }


                         $visa_type =  $is_working->cancel_status=="1" ? "Company" : "Four PL";


                    }
                }else{
                    $visa_type = "Company";
                }
            }else{
                $visa_type = "Company";
            }



                    $platform_name = "";
                    $platform_id = "";
                    if(!$passport_detail->platform_assign->isEmpty()) {
                         $ab = $passport_detail->platform_assign->where('checkout','is',null)->first();
                        $platform_name = isset($ab->plateformdetail->name)? $ab->plateformdetail->name : 'N/A';
                        $platform_id = isset($ab->plateformdetail->id)? $ab->plateformdetail->id : '';
                    }else{
                        $platform_name = null;
                    }

                  $paltform_code  =  PlatformCode::where('platform_id','=',$platform_id)
                                                ->where('passport_id',$passport_detail->id)
                                                ->first();




            $company= isset($offer_letter->companies->name)?$offer_letter->companies->name:null;


            $gamer = array(
                'emirates_id_no' => isset($emirates_id_detail) ? $emirates_id_detail->card_no : null,
                'full_name' =>  isset($passport_detail) ? $passport_detail->personal_info->full_name : null,
                'company_name' => isset($company) ?  $company : $four_pl_name,
                'visa_type' => $visa_type,
                'platform_name' => $platform_name,
                'rider_id' => isset($paltform_code) ? $paltform_code->platform_code : null,
                'zds_code' =>  isset($passport_detail->rider_zds_code) ? $passport_detail->rider_zds_code->zds_code : null,
                'ppuid' => $passport_detail->pp_uid
            );

                return response()->json($gamer, 200, [], JSON_NUMERIC_CHECK);
                exit;
         }





         $paltform_code_detail  =  PlatformCode::where('platform_code','=',$keyword)->whereIn('passport_id',$active_riders)->first();


         if($paltform_code_detail != null){ //rider id search


            $offer_letter = Offer_letter::where('passport_id',$paltform_code_detail->passport_id)->first();


            $emirates_id_detail = Emirates_id_cards::where('passport_id','=',$paltform_code_detail->passport_id)->first();

            $passport_detail =  $paltform_code_detail->passport;

            $four_pl_name =  null;

            if($passport_detail->career_id!="0"){
                $career_detail = Career::find($passport_detail->career_id);
                if($career_detail != null){
                    if($career_detail->employee_type=="2"){
                        if(isset($career_detail->vendor_fourpl_detail)){
                        $four_pl_name = isset($career_detail->vendor_fourpl_detail->vendor) ? $career_detail->vendor_fourpl_detail->vendor->name: '';
                            $is_working = $career_detail->vendor_fourpl_detail;

                        }else{
                        $four_pl_name = "N/A";
                        }


                         $visa_type =  $is_working->cancel_status=="1" ? "Company" : "Four PL";


                    }
                }else{
                    $visa_type = "Company";
                }
            }else{
                $visa_type = "Company";
            }



                    $platform_name = "";
                    $platform_id = "";
                    if(!$passport_detail->platform_assign->isEmpty()) {
                         $ab = $passport_detail->platform_assign->where('checkout','is',null)->first();
                        $platform_name = isset($ab->plateformdetail->name)? $ab->plateformdetail->name : 'N/A';
                        $platform_id = isset($ab->plateformdetail->id)? $ab->plateformdetail->id : '';
                    }else{
                        $platform_name = null;
                    }

                  $paltform_code  =  PlatformCode::where('platform_id','=',$platform_id)
                                                ->where('passport_id',$passport_detail->id)
                                                ->first();




            $company= isset($offer_letter->companies->name)?$offer_letter->companies->name:null;


            $gamer = array(
                'emirates_id_no' => isset($emirates_id_detail) ?$emirates_id_detail->card_no : null,
                'full_name' =>  isset($passport_detail) ? $passport_detail->personal_info->full_name : null,
                'company_name' => isset($company) ?  $company : $four_pl_name,
                'visa_type' => $visa_type,
                'platform_name' => $platform_name,
                'rider_id' => isset($paltform_code) ? $paltform_code->platform_code : null,
                'zds_code' =>  isset($passport_detail->rider_zds_code) ? $passport_detail->rider_zds_code->zds_code : null,
                'ppuid' => $passport_detail->pp_uid
            );

                return response()->json($gamer, 200, [], JSON_NUMERIC_CHECK);
                exit;
         }


         return response()->json(['data'=>'not found'], 200, [], JSON_NUMERIC_CHECK);
         exit;





    }
}
