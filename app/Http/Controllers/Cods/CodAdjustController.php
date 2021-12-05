<?php

namespace App\Http\Controllers\Cods;

use DataTables;
use App\Model\Platform;
use App\Model\Cods\Cods;
use Illuminate\Http\Request;
use App\Model\CodUpload\CodUpload;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Model\PlatformCode\PlatformCode;
use Illuminate\Support\Facades\Validator;
use App\Model\CodAdjustRequest\CodAdjustRequest;


class CodAdjustController extends Controller
{



    function __construct()
    {
        $this->middleware('role_or_permission:Admin|Cod|deliveroo_cod', ['only' => ['index','edit','update']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {

            if ($request->pending) {

                if (!empty($request->from_date)) {
                    $start_date = $request->from_date." 00:00:01";
                    $end_date = $request->end_date." 23:59:00";

                    $data = CodAdjustRequest::where('status', '=', '1')->where('platform_id','=',$request->platform)->whereBetween('created_at', [$start_date, $end_date])->get();
                } else {
                    $data = CodAdjustRequest::where('status', '=', '1')->orderby('id','desc')->get();
                }

                return Datatables::of($data)
                    ->editColumn('status', '<h4 class="badge badge-primary">Pending</h4>')
                    ->addColumn('name', function (CodAdjustRequest $cod) {
                        return $cod->passport->personal_info->full_name;
                    })
                    ->addColumn('created_date', function (CodAdjustRequest $cod) {
                        $date_ab = explode(" ",$cod->created_at);
                        return $date_ab[0];
                    })
                    ->editColumn('amount',function(CodAdjustRequest $cod){


                        return $cod->amount.' <span class="badge badge-success">AED</span>';

                    })
                    ->editColumn('message',function(CodAdjustRequest $cod){
                        $id = $cod->id;
                        $mg = '<a href="javascript:void(0)" id="'.$id.'"  class="badge badge-primary msg_dipslay">click to read</a>';
                        return $mg;
                    })
                    ->editColumn('images', function (CodAdjustRequest $cod) {

                        if (!empty($cod->images)) {
                        $image = json_decode($cod->images);

                        $ab_image = "";
                        $other_image_html = "";
                        $abs = 1;


                        $url = url($image[0]);
                        $ab = '​<a href="'.$url.'" target="_blank" >See Image</a><br>';

                        if(isset($image[1])){
                            $url = url($image[1]);
                            $ab .= '​<a href="'.$url.'" target="_blank"  >See Image</a><br>';
                        }
                        if(isset($image[2])){
                            $url = url($image[2]);
                            $ab .= '​<a href="'.$url.'" target="_blank"  class=" ">See Image</a><br>';
                        }

                        return $ab;
                    }else {
                        $ab = '<span class="badge badge-info">No Image</span>';
                        return $ab;
                    }
                    })

                    ->addColumn('action', function (CodAdjustRequest $cod) {
                        $html_ab = "";
                        $html_ab = '<a class="text-success mr-2 edit_cls" id = "'.$cod->id.'" href = "javascript:void(0)" ><i class="nav-icon i-Pen-2 font-weight-bold" ></i ></a >';
                        return  $html_ab;
                    })->rawColumns(['status', 'action','images','amount','message'])
                    ->make(true);
            }elseif($request->approved) {

                if (!empty($request->from_date)) {

                    $start_date = $request->from_date." 00:00:01";
                    $end_date = $request->end_date." 23:59:00";
                    $data = CodAdjustRequest::where('status', '=', '2')->where('platform_id','=',$request->platform)->whereBetween('created_at', [$start_date, $end_date])->orderby('id','desc')->get();
                    // dd($data);

                } else {
                    $data = CodAdjustRequest::where('status', '=', '2')->orderby('id','desc')->get();
                }

                return Datatables::of($data)
                ->editColumn('action',function(CodAdjustRequest $cod){

                    $html_ab = "";

                    $html_ab = '<a class="text-danger mr-2 delete_cls" id = "'.$cod->id.'" href = "javascript:void(0)" ><i class="nav-icon i-Close-Window font-weight-bold" ></i ></a>';

                return  $html_ab;

                })
                    ->addColumn('created_date', function (CodAdjustRequest $cod) {
                        $date_ab = explode(" ",$cod->created_at);
                        return $date_ab[0];
                    })
                    ->editColumn('amount',function(CodAdjustRequest $cod){


                        return $cod->amount.' <span class="badge badge-success">AED</span>';

                    })
                    ->editColumn('images', function (CodAdjustRequest $cod) {
                        if (!empty($cod->images)) {
                        $image = json_decode($cod->images);

                        $image = json_decode($cod->images);

                        $url = Storage::temporaryUrl($image[0], now()->addMinutes(5));
                        $ab = '​<a href="'.$url.'" target="_blank" >See Image</a><br>';

                        if(isset($image[1])){
                            $url = Storage::temporaryUrl($image[1], now()->addMinutes(5));
                            $ab .= '​<a href="'.$url.'" target="_blank"  >See Image</a><br>';
                        }
                        if(isset($image[2])){
                            $url = Storage::temporaryUrl($image[2], now()->addMinutes(5));
                            $ab .= '​<a href="'.$url.'" target="_blank"  class=" ">See Image</a><br>';
                        }

                        return $ab;
                    }
                    else {
                        $ab = '<span class="badge badge-info">No Image</span>';
                        return $ab;
                    }
                    })
                    ->editColumn('message',function(CodAdjustRequest $cod){
                        $id = $cod->id;
                        $mg = '<a href="javascript:void(0)" id="'.$id.'"  class="badge badge-primary msg_dipslay">click to read</a>';
                        return $mg;
                    })
                    ->addColumn('name', function (CodAdjustRequest $cod) {
                        return $cod->passport->personal_info->full_name;
                    })
                    ->addColumn('approved_by', function (CodAdjustRequest $cod) {

            $name  = isset($cod->verify_by->name) ? $cod->verify_by->name : 'N/A';

                        $html_ab = '<h4 class="badge badge-primary">'.$name.'</h4>';

                        return  $html_ab;
                    })->rawColumns(['action', 'approved_by','images','message','amount'])
                    ->make(true);


            }elseif($request->rejected){

                $start_date = $request->from_date." 00:00:01";
                $end_date = $request->end_date." 23:59:00";

                if (!empty($request->from_date)) {
                    $data = CodAdjustRequest::where('status', '=', '3')->where('platform_id','=',$request->platform)->whereBetween('created_at', [$start_date,  $end_date])->get();
                } else {
                    $data = CodAdjustRequest::where('status', '=', '3')->orderby('id','desc')->get();
                }

                return Datatables::of($data)
                    ->editColumn('status', '<h4 class="badge badge-danger">Rejected</h4>')
                    ->addColumn('name', function (CodAdjustRequest $cod) {
                        return $cod->passport->personal_info->full_name;
                    })
                    ->addColumn('created_date', function (CodAdjustRequest $cod) {
                        $date_ab = explode(" ",$cod->created_at);
                        return $date_ab[0];
                    })
                    ->editColumn('amount',function(CodAdjustRequest $cod){

                        return $cod->amount.' <span class="badge badge-success">AED</span>';

                    })
                    ->editColumn('images', function (CodAdjustRequest $cod) {
                        if (!empty($cod->images)) {

                        $image = json_decode($cod->images);

                        $image = json_decode($cod->images);

                        $image = json_decode($cod->images);

                        $url = url($image[0]);
                        $ab = '​<a href="'.$url.'" target="_blank" >See Image</a><br>';

                        if(isset($image[1])){
                            $url = url($image[1]);
                            $ab .= '​<a href="'.$url.'" target="_blank"  >See Image</a><br>';
                        }
                        if(isset($image[2])){
                            $url = url($image[2]);
                            $ab .= '​<a href="'.$url.'" target="_blank"  class=" ">See Image</a><br>';
                        }

                        return $ab;
                    }
                    else {
                        $ab = '<span class="badge badge-info">No Image</span>';
                        return $ab;
                    }
                    })
                    ->editColumn('message',function(CodAdjustRequest $cod){
                        $id = $cod->id;
                        $mg = '<a href="javascript:void(0)" id="'.$id.'"  class="badge badge-primary msg_dipslay">click to read</a>';
                        return $mg;
                    })
                    ->addColumn('rejected_by', function (CodAdjustRequest $cod) {
                        $name  = isset($cod->verify_by->name) ? $cod->verify_by->name : 'N/A';
                        $html_ab = '<h4 class="badge badge-primary">'.$name.'</h4>';
                        return  $html_ab;
                    })->rawColumns(['status', 'rejected_by','images','message','amount'])
                    ->make(true);
            }
        }

//        $pending = CodAdjustRequest::where('status', '=', '1')->orderby('id','desc')->get();
//        $approved = CodAdjustRequest::where('status', '=', '2')->orderby('id','desc')->get();
//        $rejected = CodAdjustRequest::where('status', '=', '3')->orderby('id','desc')->get();

        if(in_array(1, Auth::user()->user_group_id)){
            $platforms = Platform::all();
        }else{
            $platforms = Platform::whereIn('id',Auth::user()->user_platform_id)->get();
        }

   return view('admin-panel.cods.adjust_cod.index',compact('platforms'));

    }
    public function cod_adjust_amt_delete(Request $request){
        // return $request->all();
        $id=  $request->id;
        $cod = CodAdjustRequest::find($id);
        $cod->delete();

        $message = [
            'message' => 'Deleted Successfully!!',
            'alert-type' => 'success',

        ];
        return redirect()->back()->with($message);
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

        try {
            $validator = Validator::make($request->all(), [
                'status' => 'required',
                'id' => 'required',
            ]);
            if ($validator->fails()) {
                $validate = $validator->errors();
                return $validate->first();
            }

            $cod_req = CodAdjustRequest::find($request->id);
            $cod_req->status = $request->status;
            $cod_req->verify_by = Auth::user()->id;
            $cod_req->update();

//            $cod_upload= CodUpload::where('order_id','=',$cod_req->order_id)->first();
//            $cod_upload->status =  $request->status;
//            $cod_upload->update();

            return  "success";

        }catch (\Illuminate\Database\QueryException $e){

            return "Error Occured";

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

    public function ajax_total_cod_adjust_approve(Request $request){

        $start_date = $request->start_date." 00:00:01";
        $end_date = $request->end_date." 23:59:00";
        $data = CodAdjustRequest::where('status', '=', '2')->where('platform_id','=',$request->platform)->whereBetween('created_at', [$start_date, $end_date])->get();
        return $data;
    }

    public function ajax_total_cod_adjust_reject(Request $request){

        $data = CodAdjustRequest::where('status', '=', '3')->where('platform_id','=',$request->platform)->whereBetween('created_at', [$request->start_date, $request->end_date])->get();
        return $data;
    }

    public function ajax_total_cod_adjust_pend(Request $request){

        $data = CodAdjustRequest::where('status', '=', '1')->where('platform_id','=',$request->platform)->whereBetween('created_at', [$request->start_date, $request->end_date])->get();
        return $data;
    }

    public function add_cod_adjust(){

        $rider_ids = PlatformCode::where('platform_id','=','4')->get();
        return view('admin-panel.cods.adjust_cod.add_cod_adjust',compact('rider_ids'));
    }

    public function cod_adjust_save(Request $request){

        $abc = new CodAdjustRequest();
        $abc->passport_id = $request->zds_code;
        $abc->order_id = $request->order_id;
        $abc->order_date = $request->date;
        $abc->amount = $request->amount;
        if($request->message){
        $abc->message = $request->message;}
        // $abc->verify_by = Auth::user()->id;
        $abc->platform_id = 4;
        $abc->status = 2;

        $images = [];
        if($request->hasFile('image')){
            foreach($request->image as $key => $image){
                if (!file_exists('../public/assets/upload/cods/adjustment/'.$key.'/')) {
                    mkdir('../public/assets/upload/cods/adjustment/'.$key.'/', 0777, true);
                }
                    $ext = pathinfo($_FILES['image']['name'][$key], PATHINFO_EXTENSION);
                    $file_name = time() . "_" . $request->date . '.' . $ext;
                    // move_uploaded_file($_FILES["image"]["tmp_name"][$key], '../public/assets/upload/cods/adjustment/'.$key.'/' . $file_name);
                    $file_path = 'assets/upload/cods/adjustment/'.$key.'/'. $file_name;
                    Storage::disk('s3')->put($file_path, file_get_contents($image));
                    $abc->images ? file_exists($abc->images) ? unlink($abc->images) : "" : "";
                    $images[] = $file_path;
                    // $abc->image = $file_path;
                }
        }
        if($request->image){
        $abc->images = json_encode($images);}
        $abc->save();

        $message = [
            'message' => 'Added Successfully!',
            'alert-type' => 'success',
        ];
        return redirect()->back()->with($message);
    }
}
