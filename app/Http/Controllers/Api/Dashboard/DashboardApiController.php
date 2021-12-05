<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Bike;
use App\Model\Agreement\Agreement;
use App\Model\ArBalance\ArBalance;
use App\Model\ArBalance\ArBalanceSheet;
use App\Model\Assign\AssignBike;
use App\Model\Assign\AssignPlateform;
use App\Model\Assign\AssignSim;
use App\Model\BikeDetail;
use App\Model\Cods\Cods;
use App\Model\CodUpload\CodUpload;
use App\Model\DrivingLicense\DrivingLicense;
use App\Model\ElectronicApproval\ElectronicPreApproval;
use App\Model\Emirates_id_cards;
use App\Model\Passport\Passport;
use App\Model\Platform;
use App\Model\PlatformCode\PlatformCode;
use App\Model\RiderOrderDetail\RiderOrderDetail;
use App\Model\RiderProfile;
use App\Model\Telecome;
use App\Model\Ticket;
use http\Client\Curl\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Offer_letter\Offer_letter;
use App\Model\Seeder\Company;
use Mockery\Generator\StringManipulation\Pass\Pass;
use App\Model\Assign\OfficeSimAssign;
use App\Model\CodPrevious\CodPrevious;


class DashboardApiController extends Controller
{
    //
    public function get_dashboard()
    {


        $elec_pre_app=ElectronicPreApproval::all();
        $sims=Telecome::all();
        $bikes=BikeDetail::all();
        $agreement=Agreement::all();
        $platform=Platform::all();

        $total_received = Cods::where('status','=','1')->sum('cods.amount');

        $gamer = array(
            'total_employee' => count($elec_pre_app),
            'total_sim' => count($sims),
            'total_bikes' => count($bikes),
            'total_agreement' => count($agreement),
            'total_platform'=>count($platform),
            'total_received_cod' => $total_received

        );


        return response()->json(['data'=>$gamer], 200, [], JSON_NUMERIC_CHECK);
    }

    public function get_cod_all_counts(){

        $total_received = Cods::where('status','=','1')->sum('cods.amount');


        $toal_cod = CodUpload::sum('cod_uploads.amount');
        $total_cod_previous = CodPrevious::sum('cod_previouses.amount');

        $g_total_cod = $total_cod_previous+$toal_cod;

        $total_remain =$g_total_cod-$total_received;


        $total_cash_received = Cods::where('type','=','0')->where('status','=','1')->sum('cods.amount');
        $total_bank_received = Cods::where('type','=','1')->where('status','=','1')->sum('cods.amount');





        $array_game = array(
             'total_received',
             'total_remain',
             'total_cash_received',
             'total_bank_received',
        );


        $count  = $count =1;

        foreach($array_game as $ab){

            $amount = 0;
            $name = "";
            if($ab=="total_received"){
                $amount =number_format($total_received,2);
                $name = "total received cod";
            }elseif($ab=="total_remain"){
                $amount = number_format($total_remain,2);
                $name = "total remaining cod";
            }elseif($ab=="total_cash_received"){
                $amount = number_format($total_cash_received,2);
                $name = "total cash received cod";
            }elseif($ab=="total_bank_received"){
                $amount = number_format($total_bank_received,2);
                $name = "total bank received cod";
            }

            $gamer = array(
                'id' => $count,
                'name' => $name,
                'total' => $amount
            );
            $com_array[] = $gamer;
            $count  = $count+1;
        }

//        dd($array_game);

//        foreach($compnay as $row){
//            $gamer = array(
//
//                'id' => $row->id,
//                'name' => $row->name,
//                'total' => count($offer_letter->where('company',$row->id)),
//
//            );
//            $com_array[] = $gamer;
//        }

//
//        $gamer = array(
//            'total_received' => number_format($total_received,2),
//            'total_remain' => number_format($total_remain,2),
//            'total_cash_received' => number_format($total_cash_received,2),
//            'total_bank_received' => number_format($total_bank_received,2),
//        );

        return response()->json(['data'=>$com_array], 200, [], JSON_NUMERIC_CHECK);
    }

    public function get_cod_all_counts_by_platform($id){

            $platforms = Platform::all();

            $array_to_send = array();

            if($id=="1"){
                foreach($platforms  as $plt){
//                    dd($plt->platform_cod_detail);
                    $gamer = array(
                        'id' => $plt->id,
                        'name' => $plt->name,
                        'total' => $plt->get_total_approve_cod() ? number_format($plt->get_total_approve_cod(),2)  : 'N/A',
                    );
                    $array_to_send [] = $gamer;
                }
            }elseif($id=="2"){

                  foreach($platforms  as $plt){

                      $toal_cod = CodUpload::where('platform_id','=',$plt->id)->sum('cod_uploads.amount');

                      $rider_id = CodUpload::where('platform_id','=',$plt->id)->pluck('rider_id');
                      $passport_ids = PlatformCode::whereIn('platform_code',$rider_id)->pluck('passport_id');

                      $total_cod_previous = CodPrevious::whereIn('passport_id',$passport_ids)->sum('cod_previouses.amount');

                      $g_total_cod = $total_cod_previous+$toal_cod;


                      $total_received = Cods::where('status','=',1)->where('platform_id','=',$plt->id)->sum('amount');

                      $total_remain =$g_total_cod-$total_received;

                      $gamer = array(
                          'id' => $plt->id,
                          'name' => $plt->name,
                          'total' => $total_remain ? number_format($total_remain,2)  : '0',
                      );
                      $array_to_send [] = $gamer;
                  }

            }elseif($id=="3"){



                foreach($platforms  as $plt){

                    $total_cash_received = Cods::where('platform_id','=',$plt->id)->where('type','=','0')->where('status','=','1')->sum('cods.amount');

                    $gamer = array(
                        'id' => $plt->id,
                        'name' => $plt->name,
                        'total' => $total_cash_received ? number_format($total_cash_received,2)  : 'N/A',
                    );
                    $array_to_send [] = $gamer;
                }


            }elseif($id=="4"){

                foreach($platforms  as $plt){

                    $total_bank_received = Cods::where('platform_id','=',$plt->id)->where('type','=','1')->where('status','=','1')->sum('cods.amount');
                    $gamer = array(
                        'id' => $plt->id,
                        'name' => $plt->name,
                        'total' => $total_bank_received ? number_format($total_bank_received,2)  : 'N/A',
                    );
                    $array_to_send [] = $gamer;
                }

            }

        return response()->json(['data'=>$array_to_send], 200, [], JSON_NUMERIC_CHECK);

    }


    public function get_company(){


        //id
        //name/
        //total
        $compnay= Company::where('type','1')->get();
        $offer_letter=Offer_letter::all();
        $com_array = array();
         foreach($compnay as $row){
            $gamer = array(

                'id' => $row->id,
                'name' => $row->name,
                'total' => count($offer_letter->where('company',$row->id)),

            );
            $com_array[] = $gamer;
         }

         return response()->json(['data'=>$com_array], 200, [], JSON_NUMERIC_CHECK);
    }

    //get the company categories
    public function get_company_category($id)
    {
//        $user =\App\User::whereIn('user_group_id','4')->get();
//        $offer=Offer_letter::where('company',$id)->get();
        $rider = array(
            'id' => $id,
            'name' => 'Rider',
            'total' => '100',

        );
        $office=array(
            'id'=>$id,
            'name'=>'Office Staff',
            'total'=>'100',
        );
        $service=array(
            'id'=>$id,
            'name'=>'Service',
            'total'=>'100',
        );
        $garage=array(
            'id'=>$id,
            'name'=>'Garage',
            'total'=>'100',
        );
        $freelancer=array(
            'id'=>$id,
            'name'=>'Freelancer',
            'total'=>'100',
        );
        return response()->json(['rider'=>$rider,'office'=>$office,'service'=>$service,'garage'=>$garage,'freelancer'=>$freelancer], 200, [], JSON_NUMERIC_CHECK);




    }

    //get the passport company id
    public function get_the_passport($id){

        // $pass=Passport::where('id',$id)->limit(15)->get();

        $offer=Offer_letter::where('company',$id)->limit(15)->get();
         $pass_array = array();

         foreach($offer as $pass){
            $gamer = array(
                'id' => $pass->company,
                'zds_code' => $pass->passport->zds_code->zds_code,
                'passport' => $pass->passport->passport_no,
                'passport_id'=> $pass->passport->id,
                'ppuid' => $pass->passport->pp_uid,
                'name' => $pass->passport->personal_info->full_name,

               );
               $pass_array[] = $gamer;
         }



         return response()->json(['data' => $pass_array], 200, [], JSON_NUMERIC_CHECK);

    }


    public  function get_dashboard_search( Request $request){

        $search_text = $request->get('query');
        $rider_profile=RiderProfile::all();
        $passport_data =Passport::select('passports.passport_no','passports.id','passports.pp_uid','passport_additional_info.full_name','user_codes.zds_code','offer_letters.company')
            ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
            ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
            ->join('offer_letters', 'offer_letters.passport_id', '=', 'passports.id')
            ->where("passports.passport_no","LIKE","%{$request->input('query')}%")
            ->where("offer_letters.company","LIKE","%{$request->input('id')}%")
            ->get();

        if (count($passport_data)=='0')
        {
            $puid_data =Passport::select('passports.pp_uid','passports.id','passports.passport_no','passport_additional_info.full_name','user_codes.zds_code','offer_letters.company')
                ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                ->join('offer_letters', 'offer_letters.passport_id', '=', 'passports.id')
                ->where("passports.pp_uid","LIKE","%{$request->input('query')}%")
                ->where("offer_letters.company","LIKE","%{$request->input('id')}%")
                ->get();
            if (count($puid_data)=='0')
            {
                $full_data =Passport::select('passport_additional_info.full_name','passports.id','passports.passport_no','passports.pp_uid','user_codes.zds_code','offer_letters.company')
                    ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                    ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                    ->join('offer_letters', 'offer_letters.passport_id', '=', 'passports.id')
                    ->where("passport_additional_info.full_name","LIKE","%{$request->input('query')}%")
                    ->where("offer_letters.company","LIKE","%{$request->input('id')}%")
                    ->get();
                if (count($full_data)=='0')
                {
                    $zds_data =Passport::select('user_codes.zds_code','passports.id','passport_additional_info.full_name','passports.passport_no','passports.pp_uid','offer_letters.company')
                        ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                        ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                        ->join('offer_letters', 'offer_letters.passport_id', '=', 'passports.id')
                        ->where("user_codes.zds_code","LIKE","%{$request->input('query')}%")
                        ->where("offer_letters.company","LIKE","%{$request->input('id')}%")
                        ->get();
                    if (count($zds_data)=='0')
                    {
                        $mobile_data =Passport::select('passport_additional_info.personal_mob','passports.id','user_codes.zds_code','passport_additional_info.full_name','passports.passport_no','passports.pp_uid','offer_letters.company')
                            ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                            ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                            ->join('offer_letters', 'offer_letters.passport_id', '=', 'passports.id')
                            ->where("passport_additional_info.personal_mob","LIKE","%{$request->input('query')}%")
                            ->where("offer_letters.company","LIKE","%{$request->input('id')}%")
                            ->get();

                        if (count($mobile_data)=='0')
                        {
//                            $drive_lin_data =Passport::select('driving_licenses.license_number','user_codes.zds_code','passport_additional_info.full_name','passports.passport_no','passports.pp_uid')
//                                ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
//                                ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
//                                ->join('driving_licenses', 'driving_licenses.passport_id', '=', 'passports.id')
//                                ->where("driving_licenses.license_number","LIKE","%{$request->input('query')}%")
//                                ->get();
//                            $platform=$request->input('query');
//                            $plaform_code_id=PlatformCode::where('platform_code',$platform)->first();

                            $platform_code =Passport::select('platform_codes.platform_code','passports.id','user_codes.zds_code','passport_additional_info.full_name','passports.passport_no','passports.pp_uid','offer_letters.company')
                                ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                                ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                                ->join('platform_codes', 'platform_codes.passport_id', '=', 'passports.id')
                                ->join('offer_letters', 'offer_letters.passport_id', '=', 'passports.id')
                                ->where("platform_codes.platform_code","LIKE","%{$request->input('query')}%")
                                ->where("offer_letters.company","LIKE","%{$request->input('id')}%")
                                ->get();

                            if (count($platform_code)=='0') {


                                $emirates_code = Passport::select('emirates_id_cards.card_no','passports.id', 'user_codes.zds_code', 'passport_additional_info.full_name', 'passports.passport_no', 'passports.pp_uid','offer_letters.company')
                                    ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                                    ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                                    ->join('emirates_id_cards', 'emirates_id_cards.passport_id', '=', 'passports.id')
                                    ->join('offer_letters', 'offer_letters.passport_id', '=', 'passports.id')
                                    ->where("emirates_id_cards.card_no", "LIKE", "%{$request->input('query')}%")
                                    ->where("offer_letters.company","LIKE","%{$request->input('id')}%")
                                    ->get();



                                if (count($emirates_code) == '0') {
                                    $drive_lin_data = Passport::select('driving_licenses.license_number','passports.id', 'user_codes.zds_code', 'passport_additional_info.full_name', 'passports.passport_no', 'passports.pp_uid','offer_letters.company')
                                        ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                                        ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                                        ->join('driving_licenses', 'driving_licenses.passport_id', '=', 'passports.id')
                                        ->join('offer_letters', 'offer_letters.passport_id', '=', 'passports.id')
                                        ->where("driving_licenses.license_number", "LIKE", "%{$request->input('query')}%")
                                        ->where("offer_letters.company","LIKE","%{$request->input('id')}%")
                                        ->get();

                                    if (count($drive_lin_data) == '0') {

                                        $labour_card_data = Passport::select('electronic_pre_approval.labour_card_no','passports.id', 'user_codes.zds_code', 'passport_additional_info.full_name', 'passports.passport_no', 'passports.pp_uid','offer_letters.company')
                                            ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                                            ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                                            ->join('electronic_pre_approval', 'electronic_pre_approval.passport_id', '=', 'passports.id')
                                            ->join('offer_letters', 'offer_letters.passport_id', '=', 'passports.id')
                                            ->where("electronic_pre_approval.labour_card_no", "LIKE", "%{$request->input('query')}%")
                                            ->where("offer_letters.company","LIKE","%{$request->input('id')}%")
                                            ->get();


                                        if( count($labour_card_data)=='0') {
                                            $visa_number = Passport::select('entry_print_inside_outside.visa_number', 'passports.id','user_codes.zds_code', 'passport_additional_info.full_name', 'passports.passport_no', 'passports.pp_uid','offer_letters.company')
                                                ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                                                ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                                                ->join('offer_letters', 'offer_letters.passport_id', '=', 'passports.id')
                                                ->join('entry_print_inside_outside', 'entry_print_inside_outside.passport_id', '=', 'passports.id')
                                                ->where("entry_print_inside_outside.visa_number", "LIKE", "%{$request->input('query')}%")
                                                ->where("offer_letters.company","LIKE","%{$request->input('id')}%")
                                                ->get();

                                            if (count($visa_number) == '0') {

                                                $platno = $request->input('query');
                                                $bike_id = BikeDetail::where('plate_no', $platno)->first();
                                                if (!empty($bike_id)) {
                                                    $plat_data = Passport::select('assign_bikes.bike', 'user_codes.zds_code', 'passports.id', 'passport_additional_info.full_name', 'passports.passport_no', 'passports.pp_uid','offer_letters.company')
                                                        ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                                                        ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                                                        ->join('assign_bikes', 'assign_bikes.passport_id', '=', 'passports.id')
                                                        ->join('offer_letters', 'offer_letters.passport_id', '=', 'passports.id')
                                                        ->where("assign_bikes.bike", "LIKE", "%{$bike_id->id}%")
                                                        ->where("offer_letters.company","LIKE","%{$request->input('id')}%")
                                                        ->where("assign_bikes.status", "1")
                                                        ->get();
                                                    //platnumber response
                                                    $pass_array = array();
                                                    foreach ($plat_data as $pass) {
                                                        $image=RiderProfile::where('passport_id',$pass->id)->first();
                                                        $gamer = array(
                                                            'name' => $bike_id->plate_no,
                                                            'zds_code' => $pass->zds_code,
                                                            'passport' => $pass->passport_no,
                                                            'passport_id' => $pass->id,
                                                            'ppuid' => $pass->pp_uid,
                                                            'full_name' => $pass->full_name,
                                                            'image' => isset($image->image)?$image->image:"",
                                                            'type' => '5',
                                                        );
                                                        $pass_array[] = $gamer;

                                                        return response()->json(['data' => $pass_array], 200, [], JSON_NUMERIC_CHECK);

                                                    }
                                                }
                                            }

                                            //visa number search
                                            $pass_array = array();
                                            foreach ($visa_number as $pass) {
                                                $image=RiderProfile::where('passport_id',$pass->id)->first();
                                                $gamer = array(
                                                    'name' => $pass->visa_number,
                                                    'zds_code' => $pass->zds_code,
                                                    'passport' => $pass->passport_no,
                                                    'passport_id' => $pass->id,
                                                    'ppuid' => $pass->pp_uid,
                                                    'full_name' => $pass->full_name,
                                                    'image' => isset($image->image)?$image->image:"",
                                                    'type' => '10',
                                                );
                                                $pass_array[] = $gamer;
                                                return response()->json(['data'=>$pass_array], 200, [], JSON_NUMERIC_CHECK);
                                            }



                                        }


                                        $pass_array = array();
                                        foreach ($labour_card_data as $pass) {
                                            $image=RiderProfile::where('passport_id',$pass->id)->first();
                                            $gamer = array(
                                                'name' => $pass->labour_card_no,
                                                'zds_code' => $pass->zds_code,
                                                'passport' => $pass->passport_no,
                                                'passport_id' => $pass->id,
                                                'ppuid' => $pass->pp_uid,
                                                'full_name' => $pass->full_name,
                                                'image' => isset($image->image)?$image->image:"",
                                                'type' => '9',
                                            );
                                            $pass_array[] = $gamer;
                                            return response()->json(['data'=>$pass_array], 200, [], JSON_NUMERIC_CHECK);
                                        }



                                    }

                                    //platnumber response
                                    $pass_array = array();
                                    foreach ($drive_lin_data as $pass) {
                                        $image=RiderProfile::where('passport_id',$pass->id)->first();
                                        $gamer = array(
                                            'name' => (string)$pass->license_number,
                                            'zds_code' => $pass->zds_code,
                                            'passport' => $pass->passport_no,
                                            'passport_id' => $pass->id,
                                            'ppuid' => $pass->pp_uid,
                                            'full_name' => $pass->full_name,
                                            'image' => isset($image->image)?$image->image:"",
                                            'type' => '8',
                                        );
                                        $pass_array[] = $gamer;

                                        return response()->json(['data'=>$pass_array], 200, [], JSON_NUMERIC_CHECK);
                                    }
                                }


                                //emirates ID response
                                $pass_array = array();
                                foreach ($emirates_code as $pass) {
                                    $image=RiderProfile::where('passport_id',$pass->id)->first();
                                    $gamer = array(


                                        'name' => $pass->card_no,
                                        'zds_code' => $pass->zds_code,
                                        'passport' => $pass->passport_no,
                                        'passport_id' => $pass->id,
                                        'ppuid' => $pass->pp_uid,
                                        'full_name' => $pass->full_name,
                                        'image' => isset($image->image)?$image->image:"",
                                        'type' => '7',
                                    );
                                    $pass_array[] = $gamer;

                                }
                                return response()->json(['data'=>$pass_array], 200, [], JSON_NUMERIC_CHECK);
                            }

                            //platform code  response

                            $pass_array=array();
                            foreach ($platform_code as $pass){
                                $image=RiderProfile::where('passport_id',$pass->id)->first();
                                $gamer = array(
                                    'name' => $pass->platform_code,
                                    'zds_code' => $pass->zds_code,
                                    'passport' => $pass->passport_no,
                                    'passport_id' => $pass->id,
                                    'ppuid' => $pass->pp_uid,
                                    'full_name' => $pass->full_name,
                                    'image' => isset($image->image)?$image->image:"",
                                    'type'=>'6',
                                );
                                $pass_array[]= $gamer;
                            }

                            return response()->json(['data'=>$pass_array], 200, [], JSON_NUMERIC_CHECK);
                        }
                        //mobile number response
                        $pass_array=array();
                        foreach ($mobile_data as $pass){
                            $image=RiderProfile::where('passport_id',$pass->id)->first();
                            $gamer = array(
                                'name' => $pass->personal_mob,
                                'zds_code' => $pass->zds_code,
                                'passport' => $pass->passport_no,
                                'passport_id' => $pass->id,
                                'ppuid' => $pass->pp_uid,
                                'full_name' => $pass->full_name,
                                'image' => isset($image->image)?$image->image:"",
                                'type'=>'5',
                            );
                            $pass_array[]= $gamer;
                        }
                        return response()->json(['data'=>$pass_array], 200, [], JSON_NUMERIC_CHECK);
                    }

//zds code response
                    $pass_array=array();
                    foreach ($zds_data as $pass){
                        $image=RiderProfile::where('passport_id',$pass->id)->first();
                        $gamer = array(
                            'name' => $pass->zds_code,
                            'passport' => $pass->passport_no,
                            'passport_id' => $pass->id,
                            'ppuid' => $pass->pp_uid,
                            'full_name' => $pass->full_name,
                            'image' => isset($image->image)?$image->image:"",
                            'type'=>'3',
                        );
                        $pass_array[]= $gamer;
                    }
                    return response()->json(['data'=>$pass_array], 200, [], JSON_NUMERIC_CHECK);

                }

                //full name response
                $pass_array=array();
                foreach ($full_data as $pass){
                    $image=RiderProfile::where('passport_id',$pass->id)->first();
                    $gamer = array(
                        'name' => $pass->full_name,
                        'passport' => $pass->passport_no,
                        'passport_id' => $pass->id,
                        'ppuid' => $pass->pp_uid,
                        'zds_code' => $pass->zds_code,
                        'image' => isset($image->image)?$image->image:"",
                        'type'=>'2',
                    );
                    $pass_array[]= $gamer;
                }
                return response()->json(['data'=>$pass_array], 200, [], JSON_NUMERIC_CHECK);

            }
            //ppuid response

            $pass_array=array();
            foreach ($puid_data as $pass){
                $image=RiderProfile::where('passport_id',$pass->id)->first();
                $gamer = array(
                    'name' => $pass->pp_uid,
                    'passport' => $pass->passport_no,
                    'passport_id' => $pass->id,
                    'full_name' => $pass->full_name,
                    'zds_code' => $pass->zds_code,
                    'image' => isset($image->image)?$image->image:"",
                    'type'=>'1',
                );
                $pass_array[]= $gamer;
            }
            return response()->json(['data'=>$pass_array], 200, [], JSON_NUMERIC_CHECK);
        }


//passport number response
        $pass_array=array();
        foreach ($passport_data as $pass){
            $image=RiderProfile::where('passport_id',$pass->id)->first();
            $gamer = array(
                'name' => $pass->passport_no,
                'passport_id' => $pass->passport_id,
                'ppuid' => $pass->pp_uid,
                'full_name' => $pass->full_name,
                'zds_code' => $pass->zds_code,
                'image' => isset($image->image)?$image->image:"",
                'type'=>'0',
            );
            $pass_array[]= $gamer;
        }
        return response()->json(['data'=>$pass_array], 200, [], JSON_NUMERIC_CHECK);

    }


    public  function get_dashboard_detail_test($id)
    {
        $passport=Passport::where('id',$id)->first();
        $bike_number=AssignBike::where('passport_id',$id)->where('status','1')->first();
        $sim_number=AssignSim::where('passport_id',$id)->where('status','1')->first();
        $platform=AssignPlateform::where('passport_id',$id)->where('status','1')->first();
        $rider_orders=RiderOrderDetail::where('passport_id',$id)->get();



        //cod outstading balance

        $riderProfile = RiderProfile::where('passport_id', '=', $id)->first();
        $remain_amount = 0;
        $total_pending_amount = 0;
        $total_paid_amount = 0;

        if (isset($riderProfile->passport->platform_codes)) {
            $check_in_platform = null;
            $check_in_platform = $riderProfile->passport->platform_assign->where('status', '=', '1')->pluck(['plateform'])->first();
            $rider_id = $riderProfile->passport->platform_codes->where('platform_id', '=', $check_in_platform)->pluck(['platform_code'])->first();

            $amount = CodUpload::where('rider_id', '=', $rider_id)
                ->where('platform_id', '=', $check_in_platform)
                ->where(function ($query) {
                    $query->where('status', '=', 1)
                        ->orwhere('status', '=', 0)
                        ->orwhere('status', '=', 3);
                })
                ->selectRaw('sum(amount) as total')->first();
            $paid_amount = Cods::where('passport_id', $id)->where('platform_id', '=', $check_in_platform)->where('status', '1')->selectRaw('sum(amount) as total')->first();

            if (!empty($amount)) {
                $total_pending_amount = $amount->total;
            }
            if (!empty($paid_amount)) {
                $total_paid_amount = $paid_amount->total;
            }

        }
        $remain_amount = number_format((float)$total_pending_amount - $total_paid_amount, 2, '.', '');


        //cod outstading balance


        $pass_array=array();
        $gamer = array(
            'passport_id' => isset($passport->passport_id)?$passport->passport_id:null,
            'passport_no' => isset($passport->passport_no)?$passport->passport_no:null,
            'name' => isset($passport->personal_info->full_name)?$passport->personal_info->full_name:null,
            'email' => isset($passport->personal_info->personal_email)?$passport->personal_info->personal_email:null,
            'profile_image' => isset($passport->profile->image)?$passport->profile->image:null,
            'zds_code' => isset($passport->zds_code->zds_code)?$passport->zds_code->zds_code:null,
            'ppuid' => isset($passport->pp_uid)?$passport->pp_uid:null,
            'bike_number' => isset($bike_number->bike_plate_number->plate_no)?$bike_number->bike_plate_number->plate_no:null,
            'bike_checkin' => isset($bike_number->checkin)?$bike_number->checkin:null,
            'sim' => isset($sim_number->telecome->account_number)?$bike_number->telecome->account_number:null,
            'sim_checkin' => isset($sim_number->checkin)?$sim_number->checkin:null,
            'platform' => isset($platform->plateformdetail->name)?$platform->plateformdetail->name:null,
            'platform_checkin' => isset($platform->checkin)?$platform->checkin:null,
            'passport_expiry' => isset($passport->date_expiry)?$passport->date_expiry:null,
            'emirates_id' => isset($passport->emirates_id->card_no)?$passport->emirates_id->card_no:null,
            'eid_expire_date' => isset($emirates_id->emirates_id->expire_date)?$emirates_id->emirates_id->expire_date:null,
            'driving_license' => isset($passport->driving_license->license_number)?$passport->driving_license->license_number:null,
            'driving_license_expiry' => isset($passport->driving_license->expire_date)?$passport->driving_license->expire_date:null,
            'platform_code' => isset($passport->rider_id->platform_code)?$passport->rider_id->platform_code:null,
            'visa_number' => isset($passport->print_visa_inside_outside->visa_number)?$passport->print_visa_inside_outside->visa_number:null,
            'labour_card_no' => isset($passport->elect_pre_approval->labour_card_no)?$passport->elect_pre_approval->labour_card_no:null,
            'rider_orders_total' => isset($rider_orders)?count($rider_orders):null,
            'total_earning' => isset($rider_orders)?$rider_orders->sum('amount'):null,
            'outstading_balance' => isset($remain_amount)?$remain_amount:null,
            'driving_license_attach' => isset($passport->driving_license->image)?$passport->driving_license->image:null,
            'emirates_id_attach' => isset($passport->emirates_id->card_front_pic)?$passport->emirates_id->card_front_pic:null,
            'passport_attach' => isset($passport->passport_pic)?$passport->passport_pic:null,





//    emirates id
//    passport


        );
        $pass_array[]= $gamer;

        return response()->json($gamer, 200, [], JSON_NUMERIC_CHECK);

    }


    public  function get_dashboard_detail($id)
    {

        $passport=Passport::where('id',$id)->first();
        $bike_number=AssignBike::where('passport_id',$id)->where('status','1')->first();
        $sim_number=AssignSim::where('passport_id',$id)->where('status','1')->first();
        $platform=AssignPlateform::where('passport_id',$id)->where('status','1')->first();
        $rider_orders=RiderOrderDetail::where('passport_id',$id)->get();




         $rider_profile = RiderProfile::where('passport_id','=',$id)->first();

        $ar_current_balance = 0;

         if(!empty($passport->zds_code->zds_code)) {
             $bal_detail = ArBalanceSheet::where('zds_code', $passport->zds_code->zds_code)->get();
             $first_balance = ArBalance::where('zds_code', $passport->zds_code->zds_code)->first();
             $ar_current_balance = isset($first_balance->balance) ? $first_balance->balance : 0;
             foreach ($bal_detail as $ar_res){
                     if($ar_res->status == '0') {
                         $ar_current_balance = $ar_current_balance+$ar_res->balance;
                     }else {
                         $ar_current_balance = $ar_current_balance-$ar_res->balance;
                     }
              }
         }

         $total_ticket = 0;

         if(!empty($rider_profile)){
             $total_ticket =  Ticket::where('user_id','=',$rider_profile->user_id)->count();
         }



        //cod outstading balance

        $riderProfile = RiderProfile::where('passport_id', '=', $id)->first();
        $remain_amount = 0;
        $total_pending_amount = 0;
        $total_paid_amount = 0;

        if (isset($riderProfile->passport->platform_codes)) {
            $check_in_platform = null;
            $check_in_platform = $riderProfile->passport->platform_assign->where('status', '=', '1')->pluck(['plateform'])->first();
            $rider_id = $riderProfile->passport->platform_codes->where('platform_id', '=', $check_in_platform)->pluck(['platform_code'])->first();

            $amount = CodUpload::where('rider_id', '=', $rider_id)
                ->where('platform_id', '=', $check_in_platform)
                ->where(function ($query) {
                    $query->where('status', '=', 1)
                        ->orwhere('status', '=', 0)
                        ->orwhere('status', '=', 3);
                })
                ->selectRaw('sum(amount) as total')->first();
            $paid_amount = Cods::where('passport_id', $id)->where('platform_id', '=', $check_in_platform)->where('status', '1')->selectRaw('sum(amount) as total')->first();

            if (!empty($amount)) {
                $total_pending_amount = $amount->total;
            }
            if (!empty($paid_amount)) {
                $total_paid_amount = $paid_amount->total;
            }

        }
        $remain_amount = number_format((float)$total_pending_amount - $total_paid_amount, 2, '.', '');

        $pass_array=array();
        $gamer = array(

            'passport_id' => $passport->id,
            'name' => isset($passport->personal_info->full_name)?$passport->personal_info->full_name:"N/A",
            'personal_phone' => isset($passport->personal_info->personal_mob)?$passport->personal_info->personal_mob:"N/A",
            'email' => isset($passport->personal_info->personal_email)?$passport->personal_info->personal_email:"N/A",
            'profile_image' => isset($passport->profile->image)?$passport->profile->image:"N/A",
            'zds_code' => isset($passport->zds_code->zds_code)?$passport->zds_code->zds_code:"N/A",
            'ppuid' => isset($passport->pp_uid)?$passport->pp_uid:"N/A",
            'passport_image' => isset($passport->passport_pic)?$passport->passport_pic:"N/A",
            'bike_number' => isset($bike_number->bike_plate_number->plate_no)?$bike_number->bike_plate_number->plate_no:"N/A",
            'bike_checkin' => isset($bike_number->checkin)?$bike_number->checkin:"N/A",
            'sim' => isset($sim_number->telecome->account_number)?$sim_number->telecome->account_number:"N/A",
            'sim_checkin' => isset($sim_number->checkin)?$sim_number->checkin:"N/A",
            'platform' => isset($platform->plateformdetail->name)?$platform->plateformdetail->name:"N/A",
            'platform_sim' => isset($platform->checkin)?$platform->checkin:"N/A",
            'passport_expiry' => isset($passport->date_expiry)?$passport->date_expiry:"N/A",
            'emirates_id' => isset($passport->emirates_id->card_no)?$passport->emirates_id->card_no:"N/A",
            'eid_expire_date' => isset($emirates_id->emirates_id->expire_date)?$emirates_id->emirates_id->expire_date:"N/A",
            'driving_license' => isset($passport->driving_license->license_number)?$passport->driving_license->license_number:"N/A",
            'driving_license_expiry' => isset($passport->driving_license->expire_date)?$passport->driving_license->expire_date:"N/A",
            'platform_code' => isset($passport->rider_id->platform_code)?$passport->rider_id->platform_code:"N/A",
            'visa_number' => isset($passport->print_visa_inside_outside->visa_number)?$passport->print_visa_inside_outside->visa_number:"N/A",
            'labour_card_no' => isset($passport->elect_pre_approval->labour_card_no)?$passport->elect_pre_approval->labour_card_no:"N/A",
            'rider_orders_total' => isset($rider_orders)?count($rider_orders):"N/A",
            'total_ticket' => $total_ticket,
            'ar_balance' => $ar_current_balance,
            'passport_no' => isset($passport->passport_no)?$passport->passport_no:null,
            'platform_checkin' => isset($platform->checkin)?$platform->checkin:null,
            'total_earning' => isset($rider_orders)?$rider_orders->sum('amount'):null,
            'outstading_balance' => isset($remain_amount)?$remain_amount:null,
            'driving_license_attach' => isset($passport->driving_license->image)?$passport->driving_license->image:null,
            'emirates_id_attach' => isset($passport->emirates_id->card_front_pic)?$passport->emirates_id->card_front_pic:null,
            'passport_attach' => isset($passport->passport_pic)?$passport->passport_pic:null,


        );
        $pass_array[]= $gamer;

        return response()->json($gamer, 200, [], JSON_NUMERIC_CHECK);

    }

    public function get_dashboard_bike_search(Request $request){

        // $bikes = BikeDetail::where('plate_no','LIKE','%'.$request->bike_search.'%')
        // ->orwhere('chassis_no','LIKE','%'.$request->bike_search.'%')
        // ->get();


        $search_val=$request->search_value;
        if($search_val=='1'){
            //used bikes
            $bikes = BikeDetail::where('plate_no','LIKE','%'.$request->bike_search.'%')
            ->orwhere('chassis_no','LIKE','%'.$request->bike_search.'%')
            ->where('status','1')
            ->get();

        }
        else if($search_val=='2'){
            //free bikes

            $bikes = BikeDetail::where('plate_no','LIKE','%'.$request->bike_search.'%')
            ->orwhere('chassis_no','LIKE','%'.$request->bike_search.'%')
            ->where('status','0')
            ->get();

        }
        else if($search_val=='3'){
         //compnay bikes
         $bikes = BikeDetail::where('plate_no','LIKE','%'.$request->bike_search.'%')
         ->orwhere('chassis_no','LIKE','%'.$request->bike_search.'%')
         ->where('category_type','1')
         ->get();
     }
     else if($search_val=='4'){
         //lease bikes

         $bikes = BikeDetail::where('plate_no','LIKE','%'.$request->bike_search.'%')
         ->orwhere('chassis_no','LIKE','%'.$request->bike_search.'%')
         ->where('category_type','0')
         ->get();

     }
     else if($search_val=='5'){
         //lease bikes

         $bikes = BikeDetail::where('plate_no','LIKE','%'.$request->bike_search.'%')
         ->orwhere('chassis_no','LIKE','%'.$request->bike_search.'%')
         ->where('plate_code','!=','Motorcycle 1')
         ->get();

     }
     else if($search_val=='6'){
        $bikes = BikeDetail::where('plate_no','LIKE','%'.$request->bike_search.'%')
        ->orwhere('chassis_no','LIKE','%'.$request->bike_search.'%')
        ->where('plate_code','!=','Motorcycle 1')
        ->get();
     }
        return response()->json(['data'=>$bikes], 200, [], JSON_NUMERIC_CHECK);
    }

    public function get_the_bike($id){



        $bike = BikeDetail::where('id','=',$id)->first();

        $array_to_send = array();

        $gamer = array(
            'plate_no' => $bike->plate_no,
            'model' => $bike->model,
            'make_year' => $bike->make_year,
            'chassis_no' => $bike->chassis_no,
            'insurance_co' => $bike->insurance_co,
            'expiry_date' => $bike->expiry_date,
            'issue_date' => $bike->issue_date,
            'traffic_file' => $bike->traffic_file,
        );
        // $array_to_send [] = $gamer;
        foreach($bike->assign_bike as $bk){

            $gamer_now = array(
                'username' => $bk->passport->personal_info->full_name,
                'checkin' => $bk->checkin,
                'checkout' => $bk->checkout,
                'remarks' => $bk->remarks,
                'status' => $bk->status,
            );

            $array_to_send [] = $gamer_now;
        }
        return response()->json(['data'=>$array_to_send,'bike_detail'=>$gamer], 200, [], JSON_NUMERIC_CHECK);

    }

    public function get_bikes_category(){
        $used_bikes= BikeDetail::where('status','1')->count();
        $free_bikes=BikeDetail::where('status','0')->count();
        $company=BikeDetail::where('category_type','1')->count();
        $lease=BikeDetail::where('category_type','0')->count();
        $cars=BikeDetail::where('plate_code','!=','Motorcycle 1')->count();
        return response()->json(['used_bikes'=>$used_bikes,'free_bikes'=>$free_bikes,'company_bikes'=>$company,'lease_bikes'=>$lease,'cars'=>$cars,'platform'=>$used_bikes], 200, [], JSON_NUMERIC_CHECK);
    }
    //1used
    //2 free
    //3 companu
    //4 lease
    //5 cars
    //6 platform
    public function get_bikes_detail($id)
    {

      $search_val=$id;
       if($search_val=='1'){
           //used bikes
        $bikes= BikeDetail::where('status','1')->limit('15')->get();
       }
       else if($search_val=='2'){
           //free bikes
        $bikes= BikeDetail::where('status','0')->limit('15')->get();
       }
       else if($search_val=='3'){
        //compnay bikes
     $bikes= BikeDetail::where('category_type','1')->limit('15')->get();
    }
    else if($search_val=='4'){
        //lease bikes
     $bikes= BikeDetail::where('category_type','0')->limit('15')->get();
    }
    else if($search_val=='5'){
        //lease bikes
     $bikes=BikeDetail::where('plate_code','!=','Motorcycle 1')->limit('15')->get();
    }
    else if($search_val=='6'){
    $bikes=BikeDetail::where('plate_code','!=','Motorcycle 1')->limit('15')->get();
    }


    foreach($bikes as $bike){

        $gamer = array(
            'id' => $bike->id,
            'plate_no' => $bike->plate_no,
            'model' => $bike->model,
            'make_year' => $bike->make_year,
            'chassis_no' => $bike->chassis_no,
            'insurance_co' => $bike->insurance_co,
            'expiry_date' => $bike->expiry_date,
            'issue_date' => $bike->issue_date,
            'traffic_file' => $bike->traffic_file,
        );

        $array_to_send [] = $gamer;
    }
    return response()->json(['data'=>$array_to_send], 200, [], JSON_NUMERIC_CHECK);
}


////passport_id

//plate no
//check-in date-
//checin- time
//checkin-date
//chechout-time
//total_hours
public function get_bike_histories($id){

    $array_to_send = array();
    $bikes = AssignBike::where('passport_id','=',$id)->orderby('status','desc')->get();

    if(!empty($bikes)){
        foreach($bikes as $bike){
            $time = explode(" ",$bike->checkin);
            $checkout_dt = null;
            if(!empty($bike->checkout)){
                $checkout_dt = explode(" ",$bike->checkout);
            }

            $duration = null;
            if(!empty($bike->checkin) && !empty($bike->checkout)){

                $diff = abs(strtotime($bike->checkout) - strtotime($bike->checkin));
                $years   = floor($diff / (365*60*60*24));
                $months  = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));

                $days    = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                $hours   = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)/ (60*60));
                $minuts  = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60);

                $duration = $days." days"." ".$hours." hrs"." ".$minuts." min";

            }

            $gamer = array(
                'bike' =>  $bike->bike_plate_number->plate_no,
                'checkin_date' => $time[0],
                'checkin_time' =>  $time[1],
                'checkout_date' =>  !empty($checkout_dt) ? $checkout_dt[0] : "Active",
                'checkout_time' =>   !empty($checkout_dt) ? $checkout_dt[1] : "Active",
                'duration' => !empty($duration) ?  $duration : "You are using this Bike",
                'status' => $bike->status,
            );
            $array_to_send [] = $gamer;
        }
    }

    return response()->json(['data' => $array_to_send], 200, [], JSON_NUMERIC_CHECK);
}
public function get_sim_histories($id){
    $array_to_send = array();

    $sims = AssignSim::where('passport_id','=',$id)->orderby('status','desc')->get();

    if(!empty($sims)){
        foreach($sims as $sim){

            $time = explode(" ",$sim->checkin);
            $checkout_dt = null;
            if(!empty($sim->checkout)){
                $checkout_dt =    explode(" ",$sim->checkout);
            }

            $duration = null;

            if(!empty($sim->checkin) && !empty($sim->checkout)){

                $diff = abs(strtotime($sim->checkout) - strtotime($sim->checkin));
                $years   = floor($diff / (365*60*60*24));
                $months  = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));

                $days    = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                $hours   = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)/ (60*60));
                $minuts  = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60);

                $duration = $days." days"." ".$hours." hrs"." ".$minuts." min";

            }

            $gamer = array(
                'sim' =>  $sim->telecome->account_number,
                'checkin_date' => $time[0],
                'checkin_time' =>  $time[1],
                'checkout_date' =>  !empty($checkout_dt) ? $checkout_dt[0] : "Active",
                'checkout_time' =>   !empty($checkout_dt) ? $checkout_dt[1] : "Active",
                'duration' => !empty($duration) ?  $duration : "You are using this Sim",
                'status' => $sim->status,
            );
            $array_to_send [] = $gamer;
        }
    }

    return response()->json(['data' => $array_to_send], 200, [], JSON_NUMERIC_CHECK);

}


public  function get_platform_histories($id)
{




$array_to_send = array();

$platforms = AssignPlateform::where('passport_id','=',$id)->orderby('status','desc')->get();

if(!empty($platforms)){
    foreach($platforms as $plt){

        $time = explode(" ",$plt->checkin);
        $checkout_dt = null;
        if(!empty($plt->checkout)){
            $checkout_dt =    explode(" ",$plt->checkout);
        }

        $duration = null;

        if(!empty($plt->checkin) && !empty($plt->checkout)){

            $diff = abs(strtotime($plt->checkout) - strtotime($plt->checkin));
            $years   = floor($diff / (365*60*60*24));
            $months  = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));

            $days    = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
            $hours   = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)/ (60*60));
            $minuts  = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60);

            $duration = $days." days"." ".$hours." hrs"." ".$minuts." min";

        }
        // $row->passport->assign_platforms_check() ? $row->passport->assign_platforms_check()->plateformdetail->name:"N/A"

        $gamer = array(
            'platform' =>  $plt->plateformdetail->name,
            'checkin_date' => $time[0],
            'checkin_time' =>  $time[1],
            'checkout_date' =>  !empty($checkout_dt) ? $checkout_dt[0] : "Active",
            'checkout_time' =>   !empty($checkout_dt) ? $checkout_dt[1] : "Active",
            'duration' => !empty($duration) ?  $duration : "You are in this Platform",
            'status' => $plt->status,
        );
        $array_to_send [] = $gamer;
    }
}

return response()->json(['data' => $array_to_send], 200, [], JSON_NUMERIC_CHECK);
}

public function get_sims_category(){



    $used_sims= Telecome::where('status','1')->count();
    $free_sims=Telecome::where('status','0')->count();
    $rider_sims=AssignSim::where('assigned_to','1')->count();
    $office_sim=OfficeSimAssign::where('assigned_to','2')->count();
    $admin_sim=OfficeSimAssign::where('assigned_to','3')->count();
    $workshop_sim=OfficeSimAssign::where('assigned_to','4')->count();
    $home_sim=OfficeSimAssign::where('assigned_to','5')->count();
    return response()->json(['used_sims'=>$used_sims,'free_sims'=>$free_sims,'rider_sims'=>$rider_sims,'office_sim'=>$office_sim,'admin_sim'=>$admin_sim,'workshop_sim'=>$workshop_sim,'home_sim'=>$home_sim], 200, [], JSON_NUMERIC_CHECK);
}

public function get_sims_detail($id)
{
 $array_to_send = array();
 $array_to_assign = array();
  $search_val=$id;
   if($search_val=='1'){
       //used bikes
       $sims= Telecome::where('status','1')->limit(15)->get();

       foreach($sims as $sim){


        $gamer = array(
            'id' => $sim->id,
            'account_number' => $sim->account_number,
            'party_id' => $sim->party_id,
            'product_type' => $sim->product_type,
            'network' => $sim->network,

            // 'checkin' => $assinged_sim->checkin,
        );

        $array_to_send [] = $gamer;
    }
    return response()->json(['data'=>$array_to_send], 200, [], JSON_NUMERIC_CHECK);
   }
   else if($search_val=='2'){
       //free bikes
       $sims=Telecome::where('status','0')->limit(15)->get();
       foreach($sims as $sim){
        $gamer = array(
            'id' => $sim->id,
            'account_number' => $sim->account_number,
            'party_id' => $sim->party_id,
            'product_type' => $sim->product_type,
            'network' => $sim->network,

            // 'checkin' => $assinged_sim->checkin,
        );

        $array_to_send [] = $gamer;
    }
    return response()->json(['data'=>$array_to_send], 200, [], JSON_NUMERIC_CHECK);
   }
   else if($search_val=='3'){
    //compnay bikes
    $sims=AssignSim::where('assigned_to','1')->limit(15)->get();
    foreach($sims as $sim){
        // $assinged_sim=AssignSim::where('sim',$sim->id)->where('status','1')->first();
        // $name=$assinged_sim->passport->personal_info->full_name;


        $gamer = array(
            'id' => $sim->telecome->id,
            'account_number' => $sim->telecome->account_number,
            'party_id' => $sim->telecome->party_id,
            'product_type' => $sim->telecome->product_type,
            'network' => $sim->telecome->network,

        );

        $array_to_send [] = $gamer;
    }
    return response()->json(['data'=>$array_to_send], 200, [], JSON_NUMERIC_CHECK);
}



else if($search_val=='4'){
    $sims=OfficeSimAssign::where('assigned_to','2')->limit(15)->get();
    foreach($sims as $sim){

    $gamer = array(
        'id' => $sim->telecome->id,
        'account_number' => $sim->telecome->account_number,
        'party_id' => $sim->telecome->party_id,
        'product_type' => $sim->telecome->product_type,
        'network' => $sim->telecome->network,

    );
    $array_to_send [] = $gamer;
}
return response()->json(['data'=>$array_to_send], 200, [], JSON_NUMERIC_CHECK);

    }

    else if($search_val=='5'){
        $sims=OfficeSimAssign::where('assigned_to','3')->limit(15)->get();
        foreach($sims as $sim){

        $gamer = array(
            'id' => $sim->telecome->id,
            'account_number' => $sim->telecome->account_number,
            'party_id' => $sim->telecome->party_id,
            'product_type' => $sim->telecome->product_type,
            'network' => $sim->telecome->network,

        );
        $array_to_send [] = $gamer;
    }
    return response()->json(['data'=>$array_to_send], 200, [], JSON_NUMERIC_CHECK);
    }

    else if($search_val=='6'){
        $sims=OfficeSimAssign::where('assigned_to','4')->limit(15)->get();
        foreach($sims as $sim){

        $gamer = array(
            'id' => $sim->telecome->id,
            'account_number' => $sim->telecome->account_number,
            'party_id' => $sim->telecome->party_id,
            'product_type' => $sim->telecome->product_type,
            'network' => $sim->telecome->network,

        );
        $array_to_send [] = $gamer;
    }
    return response()->json(['data'=>$array_to_send], 200, [], JSON_NUMERIC_CHECK);
    }
    else if($search_val=='7'){
        $sims=OfficeSimAssign::where('assigned_to','5')->limit(15)->get();
        foreach($sims as $sim){

        $gamer = array(
            'id' => $sim->telecome->id,
            'account_number' => $sim->telecome->account_number,
            'party_id' => $sim->telecome->party_id,
            'product_type' => $sim->telecome->product_type,
            'network' => $sim->telecome->network,

        );
        $array_to_send [] = $gamer;
    }
    return response()->json(['data'=>$array_to_send], 200, [], JSON_NUMERIC_CHECK);
    }


}
//-----
public function get_dashboard_sim_search(Request $request){

    // $bikes = BikeDetail::where('plate_no','LIKE','%'.$request->bike_search.'%')
    // ->orwhere('chassis_no','LIKE','%'.$request->bike_search.'%')
    // ->get();
    //sim_search


    $search_val=$request->search_value;
    if($search_val=='1'){
        //used bikes
        $sim= Telecome::where('account_number','LIKE','%'.$request->sim_search.'%')
        ->where('status','1')
        ->get();
    }
    else if($search_val=='2'){
        //free sims
        $sim= Telecome::where('account_number','LIKE','%'.$request->sim_search.'%')
        ->where('status','0')
        ->get();
    }
    else if($search_val=='3'){
     //rider_sims
     $sim =Telecome::select('telecomes.account_number','telecomes.id','telecomes.party_id','telecomes.product_type','telecomes.network','assign_sims.sim',
     'assign_sims.assigned_to')
     ->join('assign_sims', 'assign_sims.sim', '=', 'telecomes.id')
     ->where("telecomes.account_number","LIKE","%{$request->sim_search}%")
     ->where("assign_sims.sim","=",'1')
     ->where("assign_sims.assigned_to","=",'1')
     ->get();
    //  $company=AssignSim::where('assigned_to','2')->count();
 }
 else if($search_val=='4'){
     //office_sim
     $sim =Telecome::select('telecomes.account_number','telecomes.id','telecomes.party_id','telecomes.product_type','telecomes.network','office_sim_assigns.sim_id',
     'office_sim_assigns.assigned_to','office_sim_assigns.status')
     ->join('office_sim_assigns', 'office_sim_assigns.sim_id', '=', 'telecomes.id')
     ->where("telecomes.account_number","LIKE","%{$request->sim_search}%")
     ->where("office_sim_assigns.status","=",'1')
     ->where("office_sim_assigns.assigned_to","=",'2')
     ->get();
 }

 else if($search_val=='5'){
    //admin_sim
    $sim =Telecome::select('telecomes.account_number','telecomes.id','telecomes.party_id','telecomes.product_type','telecomes.network','office_sim_assigns.sim_id',
    'office_sim_assigns.assigned_to','office_sim_assigns.status')
    ->join('office_sim_assigns', 'office_sim_assigns.sim_id', '=', 'telecomes.id')
    ->where("telecomes.account_number","LIKE","%{$request->sim_search}%")
    ->where("office_sim_assigns.status","=",'1')
    ->where("office_sim_assigns.assigned_to","=",'3')
    ->get();
}

else if($search_val=='6'){
    //admin_sim
    $sim =Telecome::select('telecomes.account_number','telecomes.id','telecomes.party_id','telecomes.product_type','telecomes.network','office_sim_assigns.sim_id',
    'office_sim_assigns.assigned_to','office_sim_assigns.status')
    ->join('office_sim_assigns', 'office_sim_assigns.sim_id', '=', 'telecomes.id')
    ->where("telecomes.account_number","LIKE","%{$request->sim_search}%")
    ->where("office_sim_assigns.status","=",'1')
    ->where("office_sim_assigns.assigned_to","=",'4')
    ->get();
}

else if($search_val=='7'){
    //admin_sim
    $sim =Telecome::select('telecomes.account_number','telecomes.id','telecomes.party_id','telecomes.product_type','telecomes.network','office_sim_assigns.sim_id',
    'office_sim_assigns.assigned_to','office_sim_assigns.status')
    ->join('office_sim_assigns', 'office_sim_assigns.sim_id', '=', 'telecomes.id')
    ->where("telecomes.account_number","LIKE","%{$request->sim_search}%")
    ->where("office_sim_assigns.status","=",'1')
    ->where("office_sim_assigns.assigned_to","=",'5')
    ->get();
}

    return response()->json(['data'=>$sim], 200, [], JSON_NUMERIC_CHECK);
}
public function get_the_sim($id){
    $sim = Telecome::where('id','=',$id)->first();
    $sim_assinged = AssignSim::where('sim','=',$id)->get();
    $array_to_send = array();
    $gamer = array(
    'id' => $sim->id,
    'account_number' => $sim->account_number,
    'party_id' => $sim->party_id,
    'product_type' => $sim->product_type,
    'network' => $sim->network,
    );
    // $array_to_send [] = $gamer;
    foreach($sim_assinged as $bk){
        $gamer_now = array(
            'username' => $bk->passport->personal_info->full_name,
            'checkin' => $bk->checkin,
            'checkout' => $bk->checkout,
            'remarks' => $bk->remarks,
            'status' => $bk->status,
        );

        $array_to_send [] = $gamer_now;
    }
    return response()->json(['data'=>$array_to_send,'sim_detail'=>$gamer], 200, [], JSON_NUMERIC_CHECK);
}
public function get_the_platform(){
    $platforms= Platform::all();
    $platform_assign=AssignPlateform::all();
    $platforms_array = array();
    foreach($platforms as   $row){
        $gamer = array(
            'id' => $row->id,
            'name' => $row->name,
            'total' => count($platform_assign->where('status','1')->where('plateform',$row->id)),
        );
        $platforms_array[] = $gamer;
    }

    return response()->json(['data'=>$platforms_array], 200, [], JSON_NUMERIC_CHECK);
}

public function get_platform_detail($id){

    $platform_assign=AssignPlateform::all();

        $rider_status = array(
            'id' => $id,
            'name' => 'Riders',
            'total' =>count($platform_assign->where('status','1')->where('plateform',$id)),
        );
        $tl_dc=array(
            'id'=>$id,
            'name'=>'TL & DC',
            'total'=>'0',
        );
    return response()->json(['rider_status'=>$rider_status,'tl_dc'=>$tl_dc], 200, [], JSON_NUMERIC_CHECK);

}

    public function get_rider_status($id){



        $active = array(
            'id' => $id,
            'name' => 'Active',
            'total' => '100',

        );
        $inactive=array(
            'id'=>$id,
            'name'=>'In Active',
            'total'=>'100',
        );
        return response()->json(['active'=>$active,'inactive'=>$inactive], 200, [], JSON_NUMERIC_CHECK);

    }





}
