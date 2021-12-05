<?php

namespace App\Http\Controllers\FuelRider;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Model\RiderFuel\RiderFuel;
use App\Http\Controllers\Controller;
use App\Model\AssingToDc\AssignToDc;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FuelRiderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    function __construct()
    {
        $this->middleware('role_or_permission:Admin|Rider-fuel|DC_roll', ['only' => ['index','store','destroy','edit','update','get_rider_fuel_list']]);
    }

    public function index()
    {

        $start_date = $request->start_date ?? Carbon::now()->subMonth(1)->startOfMonth()->format('Y-m-d');
        $end_date = $request->end_date ?? Carbon::now()->format('Y-m-d');

        $rider_fuel_pending = RiderFuel::where(function($query){
            if(auth()->user()->hasRole(['Admin'])){
                return true;
            }elseif(auth()->user()->hasRole(['manager_dc'])){
                $query->whereIn('passport_id', AssignToDc::whereIn('platform_id', auth()->user()->user_platform_id)->whereStatus(1)->pluck('rider_passport_id')->toArray());
            }elseif(auth()->user()->hasRole(['DC_roll'])){
                $query->whereIn('passport_id', AssignToDc::whereUserId(auth()->Id())->whereStatus(1)->pluck('rider_passport_id')->toArray());
            }else{
                return false;
            }
        })
        ->whereBetween('created_at', [$start_date, $end_date])
        ->whereStatus(0)
        ->with(['platform', 'passport','passport.rider_zds_code','passport.personal_info'])
        ->latest()
        // ->limit(60)
        ->get();
        $rider_fuel_approve = RiderFuel::where(function($query){
            if(auth()->user()->hasRole(['Admin'])){
                return true;
            }elseif(auth()->user()->hasRole(['manager_dc'])){
                $query->whereIn('passport_id', AssignToDc::whereIn('platform_id', auth()->user()->user_platform_id)->whereStatus(1)->pluck('rider_passport_id')->toArray());
            }elseif(auth()->user()->hasRole(['DC_roll'])){
                $query->whereIn('passport_id', AssignToDc::whereUserId(auth()->Id())->whereStatus(1)->pluck('rider_passport_id')->toArray());
            }else{
                return false;
            }
        })
        ->whereBetween('created_at', [$start_date, $end_date])
        ->whereStatus(1)->count();
        $rider_fuel_reject = RiderFuel::where(function($query){
            if(auth()->user()->hasRole(['Admin'])){
                return true;
            }elseif(auth()->user()->hasRole(['manager_dc'])){
                $query->whereIn('passport_id', AssignToDc::whereIn('platform_id', auth()->user()->user_platform_id)->whereStatus(1)->pluck('rider_passport_id')->toArray());
            }elseif(auth()->user()->hasRole(['DC_roll'])){
                $query->whereIn('passport_id', AssignToDc::whereUserId(auth()->Id())
                ->whereStatus(1)->pluck('rider_passport_id')->toArray());
            }else{
                return false;
            }
        })
        ->whereBetween('created_at', [$start_date, $end_date])
        ->whereStatus(2)->count();
        // $userData = Auth::user();
        // $platform_array = $userData->user_platform_id;
        // if($userData->hasRole(['Admin'])){
        //     $rider_fuel_pending = RiderFuel::where('status','=','0')->orderby('id','desc')->get();
        //     $rider_fuel_approve = RiderFuel::where('status','=','1')->orderby('id','desc')->get();
        //     $rider_fuel_reject = RiderFuel::where('status','=','2')->orderby('id','desc')->get();
        // }else{
        //     $dc_rider_passport_ids  = AssignToDc::where('user_id','=',$userData->id)->where('status','=','1')->pluck('rider_passport_id')->toArray();
        //     $rider_fuel_pending = RiderFuel::where('status','=','0')->whereIn('passport_id',$dc_rider_passport_ids)->orderby('id','desc')->get();
        //     $rider_fuel_approve = RiderFuel::where('status','=','1')->whereIn('passport_id',$dc_rider_passport_ids)->orderby('id','desc')->get();
        //     $rider_fuel_reject = RiderFuel::where('status','=','2')->whereIn('passport_id',$dc_rider_passport_ids)->orderby('id','desc')->get();
        // }
    return view('admin-panel.fuel_rider.index',compact('rider_fuel_pending','rider_fuel_approve','rider_fuel_reject', 'start_date', 'end_date'));

    }

    public function get_rider_fuel_list(Request $request)
    {
        $userData = Auth::user();
        $platform_array = $userData->user_platform_id;
        $status = request('status');
        $date = Carbon::now()->startOfMonth();
        $start_date = $request->start_date ?? Carbon::now()->startOfMonth();
        $end_date = $request->end_date ?? Carbon::now();

        $rider_fuel = RiderFuel::where(function($query){
                if(auth()->user()->hasRole(['Admin'])){
                    return true;
                }elseif(auth()->user()->hasRole(['manager_dc'])){
                    $query->whereIn('passport_id', AssignToDc::whereIn('platform_id', auth()->user()->user_platform_id)->whereStatus(1)->pluck('rider_passport_id')->toArray());
                }elseif(auth()->user()->hasRole(['DC_roll'])){
                    $query->whereIn('passport_id', AssignToDc::whereUserId(auth()->Id())->whereStatus(1)->pluck('rider_passport_id')->toArray());
                }else{
                    return false;
                }
            })
            ->where('status','=',$status)
            // ->limit(60)
            ->whereBetween('created_at', [$start_date, $end_date])
            ->orderby('id','desc')->get();

        // if($userData->hasRole(['Admin'])){
        //     if($request->start_date == '' && $request->end_date == '') {
        //         $rider_fuel = RiderFuel::where('status','=',$status)->where('created_at','>=',$date)->orderby('id','desc')->get();
        //     }else {
        //         $rider_fuel = RiderFuel::where('status','=',$status)->where('created_at','>=',$request->start_date)->where('created_at','<=',$request->end_date)->orderby('id','desc')->get();
        //     }
        // }else{
        //     $dc_rider_passport_ids  = AssignToDc::where('user_id','=',$userData->id)->where('status','=','1')->pluck('rider_passport_id')->toArray();
        //     if($request->start_date == '' && $request->end_date == '') {
        //         $rider_fuel = RiderFuel::where('status','=',$status)->whereIn('passport_id',$dc_rider_passport_ids)->where('created_at','>=',$date)->orderby('id','desc')->get();
        //     }else {
        //         $rider_fuel = RiderFuel::where('status','=',$status)->whereIn('passport_id',$dc_rider_passport_ids)->where('created_at','>=',$request->start_date)->where('created_at','<=',$request->end_date)->orderby('id','desc')->get();
        //     }
        // }
        // return $rider_fuel;
        $view = view('admin-panel.fuel_rider.latest_fuel_rider_list', compact('rider_fuel','status'))->render();
        return response(['html' => $view,'status'=> $status, "total" => $rider_fuel->count()]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();

        try {
            $validator = Validator::make($request->all(), [
                'status' => 'required',
                'remarks' => 'required_if:status,2'
            ],
            $messages = [
                'remarks.required_if' => 'Please select Rejection reason',
            ]
        );
            if ($validator->fails()){
                $validate = $validator->errors();
                $message = [
                    'message' => $validate->first(),
                    'alert-type' => 'error',
                    'error' => 'df'
                ];
                return response()->json($message, 422);
            }
            $id = $request->id;

            $user_id = Auth::user()->id;
            $rider_fuel = RiderFuel::find($id);
            $rider_fuel->status = $request->status;
            $rider_fuel->action_by = $user_id;
            $rider_fuel->remarks = $request->status == 2 ?  $request->remarks : null;
            $rider_fuel->update();
            $message = [
                'message' => "Status Updated Successfully",
                'alert-type' => 'success',
                'error' => 'df'
            ];
            return response()->json($message, 200);
            // return redirect()->back()->with($message);
        }catch(\Illuminate\Database\QueryException $e){
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return response()->json($message, 500);
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
