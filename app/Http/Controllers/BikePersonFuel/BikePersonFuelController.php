<?php

namespace App\Http\Controllers\BikePersonFuel;

use App\Model\Assign\AssignBike;
use App\Model\Bike_person_fuels;
use App\Model\BikeDetail;
use App\Model\BikeReplacement\BikeReplacement;
use App\Model\Passport\Passport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class BikePersonFuelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $bike_persons = Bike_person_fuels::where('status','=','1')->get();

       $type_array  = ['','Bike','Person'];

        return  view('admin-panel.bikeperson_fuel.index',compact('type_array','bike_persons'));
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $bike_persons = Bike_person_fuels::where('status','=','0')->pluck('passport_id')->toArray();

          $passports = Passport::whereNotIn('id',$bike_persons)->get();

            $bike_replacements = BikeReplacement::where('type','=','1')->where('status','=','1')->pluck('replace_bike_id')->toArray();

           $bikes = BikeDetail::where('status','=','1')->whereNotIn('id',$bike_replacements)->get();

        return view('admin-panel.bikeperson_fuel.create',compact('passports','bikes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'user_passport_id' => 'required',
                'search_type' => 'required'
            ]);

            if ($validator->fails()) {
                $validate = $validator->errors();
                $message_error = "";
                $message = [
                    'message' => $validate->first(),
                    'alert-type' => 'error',
                    'error' => $validate->first()
                ];
                return redirect()->back()->with($message);
            }
            $passport_id =  $request->user_passport_id;


         $isbike_already = Bike_person_fuels::where('passport_id','=',$passport_id)->where('status','=','1')->first();
         if($isbike_already != null){

             $message = [
                 'message' => "This user already assigned for fuel.!",
                 'alert-type' => 'error',
                 'error' => ''
             ];
             return redirect()->back()->with($message);

         }


            if($request->search_type=="2"){
                if($this->get_current_bike_id($passport_id)=="nothing"){

                    $message = [
                        'message' => "This user don't have any vehicle",
                        'alert-type' => 'error',
                        'error' => ''
                    ];
                    return redirect()->back()->with($message);
                }else{
                    $current_bike_detail = $this->get_current_bike_id($passport_id);

                    $bike_person_fuel = new  Bike_person_fuels();
                    $bike_person_fuel->type = $request->search_type;
                    $bike_person_fuel->status = "1";
                    $bike_person_fuel->bike_id = $current_bike_detail['bike_id'];
                    $bike_person_fuel->bike_type_from = $current_bike_detail['bike_type_from'];
                    $bike_person_fuel->primary_id_from = $current_bike_detail['primary_id_from'];
                    $bike_person_fuel->passport_id = $passport_id;
                    $bike_person_fuel->save();

                    $message = [
                        'message' => 'User Assigned For Fuel Successfully',
                        'alert-type' => 'success',
                    ];
                    return redirect()->back()->with($message);
                }

            }else{


                $validator = Validator::make($request->all(), [
                    'user_passport_id' => 'required',
                    'search_type' => 'required',
                    'bike_id' => 'required'
                ]);
                if ($validator->fails()) {
                    $validate = $validator->errors();
                    $message_error = "";
                    $message = [
                        'message' => $validate->first(),
                        'alert-type' => 'error',
                        'error' => $validate->first()
                    ];
                    return redirect()->back()->with($message);
                }

                $bike_id = $request->bike_id;

                $current_bike_detail = $this->get_current_bike_id($passport_id);

                if($this->current_bike_user($bike_id)=="nothing"){
                    $message = [
                        'message' => "This vehicle don't have any user assign",
                        'alert-type' => 'error',
                        'error' => ''
                    ];
                    return redirect()->back()->with($message);
                }


                $bike_person_fuel = new  Bike_person_fuels();
                $bike_person_fuel->type = $request->search_type;
                $bike_person_fuel->status = "1";
                $bike_person_fuel->bike_id = $current_bike_detail['bike_id'];
                $bike_person_fuel->bike_type_from = $current_bike_detail['bike_type_from'];
                $bike_person_fuel->primary_id_from = $current_bike_detail['primary_id_from'];
                $bike_person_fuel->passport_id = $passport_id;
                $bike_person_fuel->save();

                $message = [
                    'message' => 'Bike Assigned For Fuel Successfully',
                    'alert-type' => 'success',
                ];
                return redirect()->back()->with($message);



            } //else end here





        }
        catch (\Illuminate\Database\QueryException $e){
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($message);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    public function crown_job_checkout_bike(){

         $bike_person_fuel = Bike_person_fuels::where('status','=','1')->get();

         foreach ($bike_person_fuel as $bike){
             if($bike->bike_type_from=="1"){
                 $assign_bike = AssignBike::where('passport_id','=',$bike->passport_id)
                     ->where('bike','=',$bike->bike_id)
                     ->where('status','=','0')
                     ->orderby('id','desc')
                     ->first();

                 if($assign_bike!=null){
                     Bike_person_fuels::where('bike_id','=',$assign_bike)
                         ->where('status','=','1')
                         ->updat(['status' => '0','checkout'=> $assign_bike->checkout]);
                 }


             }else{

                 $replace_bike = BikeReplacement::where('passport_id','=',$bike->passport_id)
                     ->where('new_bike_id','=',$bike->bike_id)
                     ->where('status','=','0')
                     ->orderby('id','desc')
                     ->first();

                 if($replace_bike!=null){
                     Bike_person_fuels::where('bike_id','=',$replace_bike)
                         ->where('status','=','1')
                         ->updat(['status' => '0','checkout'=> $replace_bike->checkout]);
                 }


             }

         }

         return "success";

    }

    public function get_current_bike_user(Request $request){

        if($request->ajax()){
            $gamer = array(
                'name' => 'N/A'
            );

            $bike_id = $request->bike_id;
//            $bike_detail  = BikeDetail::where('id',$bike_id)->where('status','=','1')->first();

            $bike_replacement = BikeReplacement::where('new_bike_id','=',$bike_id)->where('status','=','1')->where('type','=','1')->first();

            if($bike_replacement !=  null){
                $passport_id = $bike_replacement->passport_id;

                 $passport = Passport::find($passport_id);

                $name = $passport->personal_info->full_name;
                $gamer = array(
                    'name' => $name,
                    'id' => $passport->id,
                    'platform_name' => isset($passport->assign_platforms_check()->plateformdetail->name) ? ($passport->assign_platforms_check()->plateformdetail->name) : '',
                    'platform_id' => isset($passport->assign_platforms_check()->plateformdetail->id) ? ($passport->assign_platforms_check()->plateformdetail->id) : '',

                );

            }else{
                $assign_bike = AssignBike::where('bike',$bike_id)->where('status','=','1')->first();

                if($assign_bike != null){
                    $passport = Passport::find($assign_bike->passport_id);
                    $name = $passport->personal_info->full_name;
                    $gamer = array(
                        'name' => $name,
                        'id' => $passport->id,
                        'platform_name' => isset($passport->assign_platforms_check()->plateformdetail->name) ? ($passport->assign_platforms_check()->plateformdetail->name) : '',
                        'platform_id' => isset($passport->assign_platforms_check()->plateformdetail->id) ? ($passport->assign_platforms_check()->plateformdetail->id) : '',

                    );


                }
            }

            echo json_encode($gamer);
            exit;


        }

    }

    public function get_current_bike_id($passport_id){

        $bike_replacement = BikeReplacement::where('passport_id','=',$passport_id)->where('status','=','1')->where('type','=','1')->first();

        if($bike_replacement !=  null){
            $passport_id = $bike_replacement->passport_id;

            $passport = Passport::find($passport_id);

            $array_to_send = array(
                'bike_id' => $bike_replacement->new_bike_id,
                'bike_type_from' => "2",
                'primary_id_from' => $bike_replacement->id,
            );

            return $array_to_send;


        }else{
            $assign_bike = AssignBike::where('passport_id','=',$passport_id)->where('status','=','1')->first();

            if($assign_bike != null){

                $array_to_send = array(
                    'bike_id' => $assign_bike->bike,
                    'bike_type_from' => "1",
                    'primary_id_from' => $assign_bike->id,

                );

                return $array_to_send;

            }

        }

        return  "nothing";
    }

    public function current_bike_user($bike_id){

            $bike_id = $bike_id;


            $bike_replacement = BikeReplacement::where('new_bike_id','=',$bike_id)->where('status','=','1')->where('type','=','1')->first();

            if($bike_replacement !=  null){
                $passport_id = $bike_replacement->passport_id;

                return $passport_id;

            }else{
                $assign_bike = AssignBike::where('bike',$bike_id)->where('status','=','1')->first();

                if($assign_bike != null){

                    return $assign_bike->passport_id;
                }
            }

           return "nothing";

    }

    public function autocomplete_passport_have_vehicle_only(Request $request){

          $bike_person_fuels = Bike_person_fuels::where('status','=','1')->pluck('passport_id')->toArray();

          $assign_bike_array = AssignBike::where('status','=','1')->whereNotIn('passport_id',$bike_person_fuels)->pluck('passport_id')->toArray();

        $passport_data =Passport::select('passports.passport_no','passports.pp_uid','passport_additional_info.full_name','user_codes.zds_code')
            ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
            ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
            ->where("passports.passport_no","LIKE","%{$request->input('query')}%")
            ->whereIn('passports.id',$assign_bike_array)
            ->get();

        if (count($passport_data)=='0')
        {
            // return "pp";
            $puid_data =Passport::select('passports.pp_uid','passports.passport_no')
                ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                ->where("passports.pp_uid","LIKE","%{$request->input('query')}%")
                ->whereIn('passports.id',$assign_bike_array)
                ->get();
            if (count($puid_data)=='0')
            {
                $full_data =Passport::select('passport_additional_info.full_name','passports.passport_no','passports.pp_uid','user_codes.zds_code')
                    ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                    ->join('user_codes', 'user_codes.passport_id', '=', 'passports.id')
                    ->whereIn('passports.id',$assign_bike_array)
                    ->where("passport_additional_info.full_name","LIKE","%{$request->input('query')}%")
                    ->get();
                if (count($full_data)=='0')
                {
                    $zds_data =Passport::select('user_codes.zds_code','passport_additional_info.full_name','passports.passport_no','passports.pp_uid')
                        ->join('passport_additional_info', 'passport_additional_info.passport_id', '=', 'passports.id')
                        ->whereIn('passports.id',$assign_bike_array)
                        ->where("user_codes.zds_code","LIKE","%{$request->input('query')}%")
                        ->get();

                    //zds code response
                    $pass_array=array();
                    foreach ($zds_data as $pass){
                        $gamer = array(
                            'name' => isset($pass->zds_code) ? $pass->zds_code : '',
                            'passport' => $pass->passport_no,
                            'ppuid' => $pass->pp_uid,
                            'full_name' => $pass->full_name,
                            'type'=>'3',
                        );
                        $pass_array[]= $gamer;
                    }
                    return response()->json($pass_array);

                }

                //full name response
                $pass_array=array();
                foreach ($full_data as $pass){
                    $gamer = array(
                        'name' => $pass->full_name,
                        'passport' => $pass->passport_no,
                        'ppuid' => $pass->pp_uid,
                        'zds_code' => isset($pass->zds_code) ? $pass->zds_code : '',
                        'type'=>'2',
                    );
                    $pass_array[]= $gamer;
                }
                return response()->json($pass_array);

            }
            //ppuid response

            $pass_array=array();
            foreach ($puid_data as $pass){
                $gamer = array(
                    'name' => $pass->pp_uid,
                    'passport' => $pass->passport_no,
                    'full_name' => $pass->full_name,
                    'zds_code' =>isset($pass->zds_code) ? $pass->zds_code : '',
                    'type'=>'1',
                );
                $pass_array[]= $gamer;
            }
            return response()->json($pass_array);
        }


        //passport number response
        $pass_array=array();
        foreach ($passport_data as $pass){
            $gamer = array(
                'name' => $pass->passport_no,
                'ppuid' => $pass->pp_uid,
                'full_name' => $pass->full_name,
                'zds_code' =>isset($pass->zds_code) ? $pass->zds_code : '',
                'type'=>'0',
            );
            $pass_array[]= $gamer;
        }
        return response()->json($pass_array);

    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
