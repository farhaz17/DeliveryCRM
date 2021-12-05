<?php

namespace App\Http\Controllers\CodUpload;

use Calendar;
use DataTables;
use Carbon\Carbon;
use App\Model\Platform;
use App\Imports\CodUploads;
use App\Model\Vehicle_salik;
use Illuminate\Http\Request;
use App\Model\CodUpload\CodUpload;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Model\CodUpload\ExcelFilePath;
use Illuminate\Support\Facades\Storage;
use App\Model\PlatformCode\PlatformCode;
use Illuminate\Support\Facades\Validator;


class CodUploadController extends Controller
{
    /**
     * Display a listing of the resource.j
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $events = [];
        $data  = CodUpload::distinct()->Orderby('end_date','desc')->get(['start_date','end_date']);

        if($data->count()) {
            foreach ($data as $key => $value) {
                $events[] = Calendar::event(
                    'Sheet Uploaded',

                    true,
                    new \DateTime($value->start_date),
                    new \DateTime($value->end_date.' +1 day'),
                    null,
                    // Add color and link on event
                    [
                        'color' => '#f05050',
                        'contentHeight' => 100,
                    ]
                );
            }
        }
        $calendar = Calendar::addEvents($events);

        if(in_array(1, Auth::user()->user_group_id)){
            $platforms = Platform::all();
        }else{
            $platforms = Platform::whereIn('id',Auth::user()->user_platform_id)->get();
        }

        return view('admin-panel.cod_uploads.index',compact('calendar','platforms'));
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

    public function missing_rider_id(Request $request){

        if($request->ajax()) {
            if (!empty($request->from_date)) {
                $order_id = PlatformCode::pluck('platform_code')->toArray();
                $data = CodUpload::whereNotIn('rider_id',$order_id)->where('platform_id','=',$request->platform)->whereBetween('start_date', [$request->from_date, $request->end_date])->get();
            } else {
                $order_id = PlatformCode::pluck('platform_code')->toArray();
                $data = CodUpload::whereNotIn('rider_id',$order_id)->get();
            }

            return Datatables::of($data)
                ->addColumn('platform', function (CodUpload $cod) {
                    return $cod->platform->name;
                })
                ->make(true);
        }

        if(in_array(1, Auth::user()->user_group_id)){
            $platforms = Platform::all();
        }else{
            $platforms = Platform::whereIn('id',Auth::user()->user_platform_id)->get();
        }

    return view('admin-panel.cod_uploads.missing_rider_id',compact('platforms'));

    }

    public function uploaded_data(Request $request){

        if($request->ajax()) {

            if (!empty($request->from_date)) {

                if(!empty($request->type)){
                    $data = CodUpload::where('start_date','=',$request->from_date)->get();

                }
                else{

                    $data = CodUpload::where('platform_id','=',$request->platform)->whereBetween('start_date', [$request->from_date, $request->end_date])->whereBetween('end_date', [$request->from_date, $request->end_date])->get();
                }


            } else {
                $data = CodUpload::orderby('id','desc')->get();
            }

            return Datatables::of($data)
                ->addColumn('platform', function (CodUpload $cod) {
                    return $cod->platform->name;
                })
                ->addColumn('upload_date', function (CodUpload $cod) {
                    $date = explode(' ',$cod->created_at);
                    return $date[0];
                })
                ->addColumn('rider_name', function (CodUpload $cod) {
                    return $cod->rider_code->passport->personal_info->full_name;
                })
                ->make(true);
        }

        $dates_batch = CodUpload::distinct()->latest('end_date')->get(['start_date','end_date']);
        $total_amount = CodUpload::select(DB::raw('sum(amount) as total_amount'))->first();
        $total_rider = CodUpload::distinct()->get(['rider_id'])->count();

        if(in_array(1, Auth::user()->user_group_id)){
            $platforms = Platform::all();
        }else{
            $platforms = Platform::whereIn('id',Auth::user()->user_platform_id)->get();
        }



        return view('admin-panel.cod_uploads.uploaded_data',compact('platforms','dates_batch','total_amount','total_rider'));
    }

    public function get_cod_total_amount_ajax(Request $request){

        if($request->ajax()) {

            if($request->start_date!="ab"){

                $total_amount = CodUpload::select(DB::raw('sum(amount) as total_amount'))
                    ->where('platform_id','=',$request->platform)
                    ->where('start_date', '=', $request->start_date)->first();
                $total_rider = CodUpload::where('start_date', '=', $request->start_date)->where('platform_id','=',$request->platform)
                    ->count();
                $origina_file = ExcelFilePath::where('upload_start_date', '=', $request->start_date)->first();

                $array_to_send = array(
                    'total_amount' => isset($total_amount->total_amount) ? number_format($total_amount->total_amount, 2) : 0,
                    'total_rider' => isset($total_rider) ? $total_rider : 0,
                    'original_path' => isset($origina_file->file_path) ? Storage::temporaryUrl($origina_file->file_path, now()->addMinutes(5)) : '',
                );

                echo json_encode($array_to_send);
                exit;

            }else{

                $total_amount = CodUpload::select(DB::raw('sum(amount) as total_amount'))->first();
                $total_rider = CodUpload::distinct()->get(['rider_id'])->count();

                $origina_file = ExcelFilePath::where('upload_start_date', '=', $request->start_date)->first();
                $array_to_send = array(
                    'total_amount' => isset($total_amount->total_amount) ? number_format($total_amount->total_amount, 2) : 0,
                    'total_rider' => isset($total_rider) ? $total_rider : 0,
                    'original_path' => isset($origina_file->file_path) ? Storage::temporaryUrl($origina_file->file_path, now()->addMinutes(5)) : '',
                );
                echo json_encode($array_to_send);
                exit;

            }


        }

    }

    public function ajax_total_amount(Request $request){

        if($request->ajax()) {

            if($request->start_date!="ab"){

                $total_amount = CodUpload::select(DB::raw('sum(amount) as total_amount'))
                    ->where('platform_id','=',$request->platform)
                    ->whereBetween('start_date', [$request->start_date, $request->end_date])->whereBetween('end_date', [$request->start_date, $request->end_date])->first();
                $total_rider = CodUpload::whereBetween('start_date', [$request->start_date, $request->end_date])->whereBetween('end_date', [$request->start_date, $request->end_date])->where('platform_id','=',$request->platform)->distinct()->get(['rider_id'])
                    ->count();

                $array_to_send = array(
                    'total_amount' => isset($total_amount->total_amount) ? number_format($total_amount->total_amount, 2) : 0,
                    'total_rider' => isset($total_rider) ? $total_rider : 0,
                );

                echo json_encode($array_to_send);
                exit;

            }
        }

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->upload_or_delete == "delete"){
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $cod_exits = CodUpload::where('start_date', $start_date)->where('end_date', $end_date)->delete();
            if($cod_exits){
                $file_exists = ExcelFilePath::whereDate('upload_start_date', $request->start_date )->first();
                $file_exists->file_path ? Storage::disk('s3')->delete($file_exists->file_path) : "";
                $message = [
                    'message' => "Cod on between " . $start_date." and ".$end_date. " deleted successfully.",
                    'alert-type' => 'success'
                ];
                return redirect()->back()->with($message);
            }else{
                $message = [
                    'message' => "Cod not found on " . $start_date." to ".$end_date,
                    'alert-type' => 'error'
                ];
                return redirect()->back()->with($message);
            }

        }else{

        $validator = Validator::make($request->all(), [
            'select_file' => 'required|mimes:xls,xlsx',
            'start_date' => 'unique:cod_uploads,start_date',
            'end_date' => 'unique:cod_uploads,end_date',
        ]);
//        try{
        if ($validator->fails()) {
            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error'
            ];
            return redirect()->route('cod_uploads')->with($message);
        }else{

             $is_already = CodUpload::where('platform_id','=','4')->orderby('end_date','desc')->first();


             if($is_already != null){

                //  $latest_date = strtotime($is_already->end_date);
                //  $start_date = strtotime($request->start_date);
                //  $end_date = strtotime($request->end_date);

                //  if($latest_date >= $end_date || $latest_date >= $start_date){

                //      $message = [
                //          'message' => 'For this Date Range is Already Uploaded',
                //          'alert-type' => 'error'
                //      ];
                //      return redirect()->route('cod_uploads')->with($message);

                //  }
                $start_date = Carbon::parse($request->start_date)->startOfDay();
                $end_date = Carbon::parse($request->end_date)->endOfday();
                $already = CodUpload::where(function($upload)use($start_date){
                    $upload->whereDate('start_date', '<=', $start_date);
                    $upload->whereDate('end_date', '>=', $start_date);
                })->orWhere(function($upload)use($end_date){
                    $upload->whereDate('end_date', '>=', $end_date);
                    $upload->whereDate('start_date', '<=', $end_date);
                })->first();
                // $already = CodUpload::where('start_date',$request->start_date )->where('end_date',$request->end_date )->first();
                    if($already){
                        $message = [
                            'message' => 'For this Date Range is Already Uploaded',
                            'alert-type' => 'error'
                        ];
                        return redirect()->back()->with($message);
                    }
                }
                 $rows_to_be_updated = head(Excel::toArray(new \App\Imports\CodUploads('4',$request->start_date,$request->end_date), request()->file('select_file')));
                //  dd($rows_to_be_updated);
                unset($rows_to_be_updated[0]);
                    $missing_rider_ids = [];
                    foreach($rows_to_be_updated as $key => $row){

                        $riderid_exists  = PlatformCode::wherePlatformId(4)->wherePlatformCode($row[0])->first();

                        if(!$riderid_exists){
                            $missing_rider_ids[] = $row[0];
                        }
                    }
                    if(count($missing_rider_ids) > 0){
                        $message = [
                            'message' => "Excel Upload failed",
                            'alert-type' => 'error',
                            'missing_rider_ids' => implode(',' , $missing_rider_ids),
                        ];
                        return redirect()->back()->with($message);

                    }else{

                     Excel::import(new CodUploads('4',$request->start_date,$request->end_date), request()->file('select_file'));

                     if (!file_exists('../public/assets/upload/excel_file/deliveroo_cod')) {
                         mkdir('../public/assets/upload/excel_file/deliveroo_cod', 0777, true);
                     }

                     if(!empty($_FILES['select_file']['name'])) {
                         $ext = pathinfo($_FILES['select_file']['name'], PATHINFO_EXTENSION);
                         $file_name = time()."_" .$request->start_date.'.'.$ext;
                         $file_path_image = 'assets/upload/excel_file/deliveroo_cod/'.$file_name;
                         Storage::disk('s3')->put($file_path_image, file_get_contents($request->select_file));
                        //  move_uploaded_file($_FILES["select_file"]["tmp_name"], '../public/assets/upload/excel_file/'.$file_name);

                         $excel_path = new ExcelFilePath();
                         $excel_path->upload_start_date = $request->start_date;
                         $excel_path->file_path = $file_path_image;
                         $excel_path->save();

                     }


                     $message = [
                         'message' => 'Uploaded Successfully',
                         'alert-type' => 'success'
                     ];

                     return redirect()->route('cod_uploads')->with($message);
                    }

            //  else{




            //      Excel::import(new CodUploads('4',$request->start_date,$request->end_date), request()->file('select_file'));

            //      if (!file_exists('../public/assets/upload/excel_file')) {
            //          mkdir('../public/assets/upload/excel_file', 0777, true);
            //      }

            //      if(!empty($_FILES['select_file']['name'])) {
            //          $ext = pathinfo($_FILES['select_file']['name'], PATHINFO_EXTENSION);
            //          $file_name = time()."_" .$request->start_date.'.'.$ext;
            //          Storage::disk('s3')->put($file_name, file_get_contents($request->select_file));
            //         //  move_uploaded_file($_FILES["select_file"]["tmp_name"], '../public/assets/upload/excel_file/'.$file_name);
            //          $file_path_image = 'assets/upload/excel_file/'.$file_name;

            //          $excel_path = new ExcelFilePath();
            //          $excel_path->upload_start_date = $request->start_date;
            //          $excel_path->file_path = $file_path_image;
            //          $excel_path->save();
            //      }

            //      $message = [
            //          'message' => 'Uploaded Successfully',
            //          'alert-type' => 'success'
            //      ];
            //      return redirect()->route('cod_uploads')->with($message);
            //  }




        }
//        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
//            $failures = $e->failures();
//             $eror =$failures[0];
//            $final_error = $eror->errors();
//            dd($failures->failures());
//
//            $message = [
//                'message' => $final_error[0],
//                'alert-type' => 'error'
//            ];
//            return redirect()->route('cod_uploads')->with($message);
//
//
//
//        }
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

    public  function render_calender(Request $request){

        if($request->ajax()){
            $events = [];
            $data  = CodUpload::where('platform_id','=',$request->platform_id)->distinct()->Orderby('end_date','desc')->get(['start_date','end_date']);

            if($data->count()) {
                foreach ($data as $key => $value) {
                    $events[] = Calendar::event(
                        'Sheet Uploaded',
                        true,
                        new \DateTime($value->start_date),
                        new \DateTime($value->end_date.' +1 day'),
                        null,
                        // Add color and link on event
                        [
                            'color' => '#f05050',
                            'contentHeight' => 100,
                        ]
                    );
                }
            }
            $calendar = Calendar::addEvents($events);

            $html = view('admin-panel.cod_uploads.render_calender_ajax',compact('calendar'))->render();

            return $html;

        }
    }

    public function get_plaform_batch_dates(Request $request){

        if($request->ajax()){
            $dates_batch   = CodUpload::where('platform_id','=',$request->platform_id)->distinct()->Orderby('id','desc')->get(['start_date','end_date']);

            $html = view('admin-panel.cod_uploads.render_ajax_batch_dates',compact('dates_batch'))->render();
            return $html;

        }




    }

}
