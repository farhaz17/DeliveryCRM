<?php

namespace App\Http\Controllers;

use App\Bike;
use App\Model\InvParts;
use App\Model\ManageRepair;
use App\Model\Parts;
use App\Model\RepairUsedParts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RepairUsedPartsController extends Controller
{

    // function __construct()
    // {
    //     $this->middleware('role_or_permission:Admin|user-manage-riders', ['only' => ['index','edit','update']]);
    //     $this->middleware('role_or_permission:Admin', ['only' => ['store']]);
    //     $this->middleware('role_or_permission:Admin|user-delete-rider', ['only' => ['destroy']]);




    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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
        try{

//            $current_quantity_single_parts = $this->getQuantityForSinglePart($request->input('part_id'));

            $available_single_parts=$this->getAvailableParts($request->input('part_id'));

            $requested_quantity = $request->input('quantity');
//            dd($available_single_parts);

            foreach ($available_single_parts as $part_item) {
                $quantity_balance=$part_item->quantity_balance;
                $inv_id=$part_item->id;
                $part_price=$part_item->price;
            }

            if($quantity_balance >= $request->input('quantity')){


                $obj = InvParts::find($inv_id);
                $obj->quantity_balance=$quantity_balance - $requested_quantity;
                $obj->save();

//                foreach ($available_single_parts as $part_item) {
//
//                    if($requested_quantity <= $part_item->quantity_balance){
//                        $obj = InvParts::find($part_item->id);
//                        $obj->quantity_balance=($part_item->quantity_balance)-$requested_quantity;
//                        $obj->save();
//                        break;
//                    }
//                    else{
//                        $requested_quantity=$requested_quantity-($part_item->quantity_balance);
//                        $obj = InvParts::find($part_item->id);
//                        $obj->quantity_balance=0;
//                        $obj->save();
//                        continue;
//                    }
//                }

                $jobDetail = ManageRepair::find($request->input('job_id'))->company;


                $obj=new RepairUsedParts();
                $obj->repair_job_id=$request->input('job_id');
                $obj->part_id=$request->input('part_id');
                $obj->quantity=$request->input('quantity');

                if($jobDetail == 0){
                    $obj->amount=$request->input('quantity')*$part_price;
                    $obj->part_price=$part_price;
                }
                else{
                    $obj->amount=$request->input('quantity')*$part_price*1.3;
                    $obj->part_price=$part_price*1.3;
                }

                $obj->save();

                $message = [
                    'message' => 'Parts Added Successfully',
                    'alert-type' => 'success'

                ];
            }
            else{
                $message = [
                    'message' => 'Parts are not sufficient enough',
                    'alert-type' => 'warning'

                ];
            }

            return back()->with($message);

        }
        catch (\Illuminate\Database\QueryException $e){
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return back()->with($message);
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
        $repairJob_id=$id;
        $parts = Parts::all();
        $manage_repairs=ManageRepair::all();
        $manage_repair_parts=$this->getPartDataByJobId($repairJob_id);
        $bikes=Bike::all();
        return view('admin-panel.pages.manage_repair',compact('parts','repairJob_id','manage_repairs','bikes','manage_repair_parts'));

    }

    // public function add_repair_detail($id){
    //     $repair_job_detail=$id;
    //     $parts=Parts::all();
    //     $manage_repair_parts=$this->getPartDataByJobId($repairJob_id);


    // }





    public function manage_repair_parts_add(Request $request){
        $id=$request->id;
        $repairJob_id=$id;
        $parts = Parts::all();
        $manage_repairs=ManageRepair::all();
        $manage_repair_parts=$this->getPartDataByJobId($repairJob_id);
        $bikes=Bike::all();

    $view = view("admin-panel.maintenance.repair.repair_ajax_files.manage_repair_ajax_parts",compact('manage_repair_data','manage_repairs','bikes','parts','manage_repair_parts'))->render();
    return response()->json(['html'=>$view]);
}


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $repairJob_id=$this->getJobIdFromPartId($id);
//        dd($repairJob_id);
        $manage_repair_part_data=RepairUsedParts::find($id);
        $manage_repair_parts=$this->getPartDataByJobId($repairJob_id->repair_job_id);
        $parts = Parts::all();
        $manage_repairs=ManageRepair::all();
        $bikes=Bike::all();
        return view('admin-panel.pages.manage_repair',compact('parts','repairJob_id','manage_repairs','bikes','manage_repair_part_data','manage_repair_parts'));
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
        try {

            $available_single_parts=$this->getAvailableParts($request->input('part_id'));

            $requested_quantity = $request->input('quantity');



            $usedPartDetail = RepairUsedParts::find($id);
            $usedPartQuantity=$usedPartDetail->quantity;
//            dd($usedPartQuantity);
            $additionalQuantity=$requested_quantity - $usedPartQuantity;

            foreach ($available_single_parts as $part_item) {
                $quantity_balance=$part_item->quantity_balance;
                $inv_id=$part_item->id;
                $part_price=$part_item->price;
            }

            if ($quantity_balance >= $additionalQuantity ){
                $obj = InvParts::find($inv_id);
                $obj->quantity_balance=$quantity_balance-$additionalQuantity;
                $obj->save();

                $jobDetail = ManageRepair::find($request->input('job_id'))->company;

                $obj = RepairUsedParts::find($id);
                $obj->repair_job_id=$request->input('job_id');
                $obj->part_id=$request->input('part_id');
                $obj->quantity=$request->input('quantity');
                if($jobDetail == 0){
                    $obj->amount=$request->input('quantity')*$part_price;
                    $obj->part_price=$part_price;
                }
                else{
                    $obj->amount=$request->input('quantity')*$part_price*1.3;
                    $obj->part_price=$part_price*1.3;
                }
                $obj->save();

                $message = [
                    'message' => 'Repair Part Updated',
                    'alert-type' => 'success'

                ];
            }
//            else if($additionalQuantity < 0){
//                $obj = InvParts::find($available_single_parts->id);
//                $obj->quantity_balance=($available_single_parts->quantity_balance)-$additionalQuantity;
//                $obj->save();
//            }
            else{
                $message = [
                    'message' => 'Parts are not sufficient enough',
                    'alert-type' => 'warning'

                ];
            }

            return back()->with($message);

        } catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return back()->with($message);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $deletedItem = RepairUsedParts::find($id);
            $deletedQuantity = $deletedItem->quantity;
            $deletedPart_id = $deletedItem->part_id;

            $available_single_parts=$this->getAvailableParts($deletedPart_id);

            foreach ($available_single_parts as $part_item) {
                $quantity_balance=$part_item->quantity_balance;
            }



            $obj = RepairUsedParts::find($id);
            $obj->delete();

            $obj = InvParts::find($deletedPart_id);
            $obj->quantity_balance=$quantity_balance+$deletedQuantity;
            $obj->save();

            $message = [
                'message' => 'Part Deleted Successfully',
                'alert-type' => 'success'

            ];
            return redirect()->route('manage_repair')->with($message);
        } catch (\Illuminate\Database\QueryException $e) {
            $message = [
                'message' => 'Error Occured',
                'alert-type' => 'error'
            ];
            return redirect()->route('manage_repair')->with($message);
        }
    }

    public function getPartDataByJobId($job_id){
        $assigned_parts = RepairUsedParts::select('*')
            ->where('repair_job_id', $job_id)
            ->with('part')
            ->get();
        return $assigned_parts;
    }

    public function getJobIdFromPartId($id){
        $job_id = DB::table('repair_used_parts')->where('id', $id)->get(['repair_job_id'])->first();
        return $job_id;
    }

    public function getQuantityForSinglePart($part_number_id){
        $quantity_bal_for_single_part = DB::table('inv_parts')->where('parts_id', $part_number_id)->get(['quantity_balance'])->sum('quantity_balance');
        return $quantity_bal_for_single_part;
    }

    public function getAvailableParts($part_number_id){
        $query = DB::table('inv_parts')->where('parts_id', $part_number_id)->get();
        return $query;
    }

    public function getEmptyInventoryParts($part_number_id){
        $query = DB::table('inv_parts')->where('parts_id', $part_number_id)->where('quantity_balance','=',0)->orderBy('id', 'DESC')->get();
        return $query;
    }
}
