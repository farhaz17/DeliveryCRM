<?php

namespace App\Http\Controllers\Price;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Parts;
use App\Model\Price\CurrentPrice;
use App\Model\Price\PriceHistory;

class CurrentPriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $parts=Parts::all();
        return view('admin-panel.price.current_price',compact('parts'));
    }
    public function price_view()
    {
        $current_price=CurrentPrice::all();
        $view = view("admin-panel.Price.price_ajax_files.get_current_prices",compact('current_price'))->render();
        return response()->json(['html' => $view]);
    }

    public function activate_deactivate(Request $request){



        $obj = CurrentPrice::find($request->id);
        $obj->status=$request->input('status');
        $obj->save();
        return json_encode(array('statusCode'=>200));


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

        $part_id = $request->input('parts_id');
        $price = $request->input('current_price');

        $current_price= CurrentPrice::where('part_id',$part_id)->first();

        if(!empty($current_price)){
            $status=$current_price->status;
            $id=$current_price->id;
            $hisotry_price=$current_price->price;
            $date_from=$current_price->created_at;

            if($status=='0'){
                return response()->json([
                    'code' => "101"
                ]);
            }
            else{

                $obj = CurrentPrice::find($id);

                $obj->price = $price;
                $obj->status = '0';// status 0 is active price
                $obj->save();

                $obj = new PriceHistory();
                $obj->part_id = $part_id;
        $obj->price = $hisotry_price;
        $obj->date_from = $date_from;
        $obj->date_to = date("Y/m/d");
        $obj->source = '0';// status 0 price add new
        $obj->added_by = auth()->user()->id;
        $obj->save();




                return response()->json([
                    'code' => "102"
                    ]);
            }
        }
        else{

        $obj = new CurrentPrice();
        $obj->part_id = $part_id;
        $obj->price = $price;
        $obj->status = '0';// status 0 is active price
        $obj->save();
        return response()->json([
            'code' => "100"
        ]);

    }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
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
        $current_price_edit=CurrentPrice::find($id);
        $parts=Parts::all();
        return view('admin-panel.price.current_price',compact('current_price_edit','parts'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        $id=$request->id;
        $price = $request->input('current_price');
        $obj = CurrentPrice::find($id);
        $obj->price = $price;
        $obj->save();



        return response()->json([
            'code' => "100"
            ]);
    }

    public function price_update(Request $request)
    {
        $current_price= CurrentPrice::where('id',$request->id)->first();
        $part_id=$current_price->part_id;
        $old_price=$current_price->price;
        $date_from=$current_price->created_at;
        $date_to=$current_price->created_at;



        $id=$request->id;
        $new_price = $request->input('current_price');
        $obj = CurrentPrice::find($id);
        $obj->price = $new_price;
        $obj->save();

        $obj = new PriceHistory();
        $obj->part_id = $part_id;
        $obj->price = $old_price;
        $obj->date_from = $date_from;
        $obj->date_to = date("Y/m/d");
        $obj->source = '1';// status 1 price was editted
        $obj->added_by = auth()->user()->id;
        $obj->save();


        return response()->json([
            'code' => "100"
            ]);
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

    public function price_history(){

        $price_history = PriceHistory::all();

        return view('admin-panel.price.price_history',compact('price_history'));

    }
}
