<?php

namespace App\Http\Controllers\RiderOrderDetail;

use App\Model\Platform;
use App\Model\UnassignedOrders;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UnassigndOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $unassigned_orders = UnassignedOrders::orderby('id','desc')->get();

        $total_orders = UnassignedOrders::sum('no_of_orders');
        $rider_total = UnassignedOrders::groupby('passport_id')->get();

        $rider_total = count($rider_total);

        $plaforms = Platform::all();


        return  view('admin-panel.unassigned_order.index',compact('plaforms','rider_total','unassigned_orders','total_orders'));
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
        //
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

    public function unassigned_order_filter_ajax(Request $request){

        if($request->ajax()){


            $start_date = $request->start_date;


            if(!empty($start_date)){

                $start_date = Carbon::parse($request->start_date)->startOfDay();
                $end_date = Carbon::parse($request->end_date)->endOfDay();
                $platform_id = $request->platform_id;


                $unassigned_orders = UnassignedOrders::where('platform_id','=',$platform_id)
                    ->whereDate('order_date', '>=', $start_date)
                    ->whereDate('order_date', '<=', $end_date)
                    ->orderby('id','desc')->get();

            }else{


                $unassigned_orders = UnassignedOrders::orderby('id','desc')->get();
            }


            $view = view("admin-panel.unassigned_order.fileter_ajax", compact('unassigned_orders'))->render();

            return response()->json(['html' => $view]);
        }

    }

    public function unassigned_main_digit_ajax(Request $request){


        if($request->ajax()){

            $start_date = $request->start_date;


            if($start_date!=""){

                $start_date = Carbon::parse($request->start_date)->startOfDay();
                $end_date = Carbon::parse($request->end_date)->endOfDay();
                $platform_id = $request->platform;

                $total_orders = UnassignedOrders::where('platform_id','=',$platform_id)
                    ->whereDate('order_date', '>=', $start_date)
                    ->whereDate('order_date', '<=', $end_date)
                    ->sum('no_of_orders');

                $rider_total = UnassignedOrders::where('platform_id','=',$platform_id)
                    ->whereDate('order_date', '>=', $start_date)
                    ->whereDate('order_date', '<=', $end_date)
                    ->groupby('passport_id')->get();

                $rider_total = count($rider_total);

            }else{

                $total_orders = UnassignedOrders::sum('no_of_orders');
                $rider_total = UnassignedOrders::groupby('passport_id')->get();
                $rider_total = count($rider_total);



            }





            $array_to_send = array(
                'total_amount' => isset($total_orders) ? $total_orders : 0,
                'total_rider' => isset($rider_total) ? $rider_total : 0,
            );

            echo json_encode($array_to_send);
            exit;


        }



    }

    public function destroy($id)
    {
        //
    }
}
