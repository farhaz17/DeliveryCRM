<?php

namespace App\Http\Controllers\VehicleReport;

use App\Model\BikeDetail;
use App\Model\Lpo\SalikTag;
use Illuminate\Http\Request;
use App\Model\Salik\SalikOperation;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SalikTagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $installed = SalikOperation::where('status',1)->pluck('bike_id')->toArray();
        $bikes = BikeDetail::whereNotIn('id',$installed)->get(['id','plate_no','chassis_no','engine_no']);
        $saliks = SalikTag::where('status',0)->get();
        $installs = SalikOperation::where('status',1)->get();
        return view('admin-panel.salik_tag.salik_tag',compact('bikes','saliks','installs'));
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
        $validator = Validator::make($request->all(),[
            'bike_id' => 'required',
            'salik_tag' => 'required',
            'date' => 'required',
        ]);
        if($validator->fails()){
            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error',
            ];
            return redirect()->back()->with($message);
        }

        $obj = new SalikOperation();
        $obj->bike_id = $request->bike_id;
        $obj->salik_id = $request->salik_tag;
        $obj->checkin = $request->date;
        $obj->user_id = Auth::user()->id;
        $obj->status = 1;
        $obj->type = 1;
        $obj->save();

        $abc = SalikTag::find($request->salik_tag);
        $abc->status = 1;
        $abc->save();

        $message = [
            'message' => 'Salik Added Successfully',
            'alert-type' => 'success'
        ];
        return redirect()->back()->with($message);
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
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'bike_id' => 'required',
            'remove_replace' => 'required',
            'date' => 'required',
            'saliks' => 'required_if:remove_replace,3',
        ]);
        if($validator->fails()){
            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error',
            ];
            return redirect()->back()->with($message);
        }

        if($request->remove_replace == 2)
        {
            $obj = SalikOperation::find($request->bike_id);

            $abc = SalikTag::find($obj->salik_id);
            $abc->status = 0;
            $abc->save();

            $obj->type = $request->remove_replace;
            $obj->checkout = $request->date;
            $obj->remark = $request->remark;
            $obj->status = 2;
            $obj->save();

            $message = [
                'message' => 'Salik Removed Successfully',
                'alert-type' => 'success'
            ];
            return redirect()->back()->with($message);
        }
        elseif($request->remove_replace == 3)
        {
            $obj = SalikOperation::find($request->bike_id);

            $abc = SalikTag::find($obj->salik_id);
            $abc->status = 0;
            $abc->save();

            $obj->type = $request->remove_replace;
            $obj->checkout = $request->date;
            $obj->new_shuffled_salik_id = $request->saliks;
            $obj->remark = $request->remark;
            $obj->status = 2;
            $obj->save();

            $new_salik = SalikTag::find($request->saliks);
            $new_salik->status = 1;
            $new_salik->save();

            $new_tag = new SalikOperation();
            $new_tag->bike_id = $request->new_bike_id;
            $new_tag->salik_id = $request->saliks;
            $new_tag->checkin = $request->date;
            $new_tag->user_id = Auth::user()->id;
            $new_tag->status = 1;
            $new_tag->type = 1;
            $new_tag->save();

            $message = [
                'message' => 'Salik Replaced Successfully',
                'alert-type' => 'success'
            ];
            return redirect()->back()->with($message);
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
        //
    }
}
