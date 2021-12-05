<?php

namespace App\Http\Controllers\Followup;

use App\Mail\CareerMail;
use App\Model\CareerStatusHistory\CareerStatusHistory;
use App\Model\Guest\Career;
use App\Model\Referal\Referal;
use App\Model\Seeder\Followup_statuses;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class FollowupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $today_date = date("Y-m-d");

        $bike_replacements = array();
        $first_priority =  Career::select('careers.*')
              ->where('created_at', '<', $today_date)
            ->where('applicant_status','!=','2')
            ->where('applicant_status','!=','1')
            ->where('created_at', '<', $today_date)
            ->orderBy('careers.id','asc')
            ->get();

        $source_types = collect([
            (object) [
                'name' => 'Tiktok',
                'id' => '1'
            ],
            (object) [
                'name' => 'Facebook',
                'id' => '2'
            ],
            (object) [
                'name' => 'Youtube',
                'id' => '3'
            ],
            (object) [
                'name' => 'Website',
                'id' => '4'
            ],
            (object) [
                'name' => 'Instagram',
                'id' => '5'
            ],
            (object) [
                'name' => 'Friend',
                'id' => '6'
            ],
            (object) [
                'name' => 'Other',
                'id' => '7'
            ],
            (object) [
                'name' => 'Radio',
                'id' => '8'
            ],
            (object) [
                'name' => 'Restaurant',
                'id' => '9'
            ]
        ]);

         $follow_up_statuses = Followup_statuses::all();

         $source_type_array = array('','App','On Call','Walkin Candidate','Website','Social Media','International');

        return  view('admin-panel.follow_up.index',compact('source_type_array','first_priority','source_types','follow_up_statuses'));
    }

    public function follow_up_candidate(){


        $today_date = date("Y-m-d");

        $user_id = Auth::user()->id;

        $bike_replacements = array();
        $first_priority =  Career::select('careers.*')
            ->where('created_at', '<', $today_date)
            ->where('applicant_status','!=','2')
            ->where('applicant_status','!=','1')
            ->where('user_id','=',$user_id)
            ->orderBy('careers.id','asc')
            ->get();

        $source_types = collect([
            (object) [
                'name' => 'Tiktok',
                'id' => '1'
            ],
            (object) [
                'name' => 'Facebook',
                'id' => '2'
            ],
            (object) [
                'name' => 'Youtube',
                'id' => '3'
            ],
            (object) [
                'name' => 'Website',
                'id' => '4'
            ],
            (object) [
                'name' => 'Instagram',
                'id' => '5'
            ],
            (object) [
                'name' => 'Friend',
                'id' => '6'
            ],
            (object) [
                'name' => 'Other',
                'id' => '7'
            ],
            (object) [
                'name' => 'Radio',
                'id' => '8'
            ],
            (object) [
                'name' => 'Restaurant',
                'id' => '9'
            ]
        ]);

        $follow_up_statuses = Followup_statuses::all();

        $source_type_array = array('','App','On Call','Walkin Candidate','Website','Social Media','International');

        return  view('admin-panel.follow_up.follow_up_candidate',compact('follow_up_statuses','source_type_array','first_priority','source_types','follow_up_statuses'));

    }


    public function follow_up_dashboard()
    {
        $user_id = Auth::user()->id;
        $total_query_received = Career::where('user_id','=',$user_id)->count();



        return view('admin-panel.follow_up.follow_up_dashboard',compact('total_query_received'));
    }


    public function ajax_filter_report_follow_up(Request  $request){

        $today_date = date("Y-m-d");


        if($request->ajax()){

            $promotion_type = $request->option;

            if($promotion_type=="7"){

                $first_priority =  Career::select('careers.*')
                    ->where('created_at', '<', $today_date)
                    ->where('promotion_type','=',$promotion_type)
                    ->where('applicant_status','!=','2')
                    ->where('applicant_status','!=','1')
                    ->orwhereNull('promotion_type')
                    ->orderBy('careers.id','asc')
                    ->get();

            }elseif($promotion_type=="0"){
                $first_priority =  Career::select('careers.*')
                    ->where('created_at', '<', $today_date)
                    ->where('applicant_status','!=','2')
                    ->where('applicant_status','!=','1')
                    ->orderBy('careers.id','asc')
                    ->get();
            }else{
                $first_priority =  Career::select('careers.*')
                    ->where('created_at', '<', $today_date)
                    ->where('promotion_type','=',$promotion_type)
                    ->where('applicant_status','!=','2')
                    ->where('applicant_status','!=','1')
                    ->orderBy('careers.id','asc')
                    ->get();
            }




            $source_types = collect([
                (object) [
                    'name' => 'Tiktok',
                    'id' => '1'
                ],
                (object) [
                    'name' => 'Facebook',
                    'id' => '2'
                ],
                (object) [
                    'name' => 'Youtube',
                    'id' => '3'
                ],
                (object) [
                    'name' => 'Website',
                    'id' => '4'
                ],
                (object) [
                    'name' => 'Instagram',
                    'id' => '5'
                ],
                (object) [
                    'name' => 'Friend',
                    'id' => '6'
                ],
                (object) [
                    'name' => 'Other',
                    'id' => '7'
                ],
                (object) [
                    'name' => 'Radio',
                    'id' => '8'
                ],
                (object) [
                    'name' => 'Restaurant',
                    'id' => '7'
                ]

            ]);
            $source_type_array = array('','App','On Call','Walkin Candidate','Website','Social Media','International');


            if(!empty($request->color)){
                    $color = $request->color;
                    $view = view('admin-panel.follow_up.ajax_color_block_filter',compact('first_priority','source_types','color','source_type_array'))->render();
            }else{
                    $view = view('admin-panel.follow_up.follow_up_report_render',compact('first_priority','source_types','source_type_array'))->render();
            }


            return response()->json(['html'=>$view]);

        }

    }

    public function get_color_block_count_ajax_candidate(Request $request){

        $promotion_type = $request->option;
        $today_date = date("Y-m-d");

        $user_id = Auth::user()->id;


        if($promotion_type=="0"){
            $first_priority =  Career::select('careers.*')
                ->where('created_at', '<', $today_date)
                ->where('user_id',$user_id)
                ->where('applicant_status','!=','2')
                ->where('applicant_status','!=','1')
                ->orderBy('careers.id','asc')
                ->get();
        }else{
            $first_priority =  Career::select('careers.*')
                ->where('created_at', '<', $today_date)
                ->where('applicant_status','=',$promotion_type)
                ->where('user_id','=',$user_id)
                ->where('applicant_status','!=','2')
                ->where('applicant_status','!=','1')
                ->orderBy('careers.id','asc')
                ->get();
        }

        $total_first_priority_24 = 0;
        $total_first_priority_48 = 0;
        $total_first_priority_72 = 0;
        $total_first_priority_less_24 = 0;

        foreach ($first_priority as $career) {

            $from = \Carbon\Carbon::parse($career->updated_at);
            $to = \Carbon\Carbon::now();
            $hours_spend = $to->diffInHours($from);

            if ($hours_spend < 24) {
                $total_first_priority_less_24 = $total_first_priority_less_24 + 1;
            }elseif($hours_spend >= 24 && $hours_spend < 48) {
                $total_first_priority_24 = $total_first_priority_24 + 1;
            }elseif($hours_spend >= 48 && $hours_spend <= 72) {
                $total_first_priority_48 = $total_first_priority_48 + 1;
            }elseif($hours_spend > 72) {
                $total_first_priority_72 = $total_first_priority_72 + 1;
            }
        }

        $gamer = array(
            'orange' => $total_first_priority_24,
            'pink' => $total_first_priority_48,
            'red' => $total_first_priority_72,
            'white' => $total_first_priority_less_24,
        );

        return $gamer;
    }


    public function ajax_filter_report_follow_up_candidate(Request  $request){

        $today_date = date("Y-m-d");

        $user_id = Auth::user()->id;
        if($request->ajax()){

            $promotion_type = $request->option;
            if($promotion_type=="0"){
                $first_priority =  Career::select('careers.*')
                    ->where('created_at', '<', $today_date)
                    ->where('applicant_status','!=','2')
                    ->where('applicant_status','!=','1')
                    ->where('user_id', '=', $user_id)
                    ->orderBy('careers.id','asc')
                    ->get();
            }else{
                $first_priority =  Career::select('careers.*')
                    ->where('created_at', '<', $today_date)
                    ->where('applicant_status','=',$promotion_type)
                    ->where('applicant_status','!=','2')
                    ->where('applicant_status','!=','1')
                    ->where('user_id', '=', $user_id)
                    ->orderBy('careers.id','asc')
                    ->get();
                dd($first_priority);
            }




            $source_types = collect([
                (object) [
                    'name' => 'Tiktok',
                    'id' => '1'
                ],
                (object) [
                    'name' => 'Facebook',
                    'id' => '2'
                ],
                (object) [
                    'name' => 'Youtube',
                    'id' => '3'
                ],
                (object) [
                    'name' => 'Website',
                    'id' => '4'
                ],
                (object) [
                    'name' => 'Instagram',
                    'id' => '5'
                ],
                (object) [
                    'name' => 'Friend',
                    'id' => '6'
                ],
                (object) [
                    'name' => 'Other',
                    'id' => '7'
                ],
                (object) [
                    'name' => 'Radio',
                    'id' => '8'
                ],
                (object) [
                    'name' => 'Restaurant',
                    'id' => '7'
                ]

            ]);
            $source_type_array = array('','App','On Call','Walkin Candidate','Website','Social Media','International');


            if(!empty($request->color)){
                $color = $request->color;
                $view = view('admin-panel.follow_up.ajax_color_block_filter',compact('first_priority','source_types','color','source_type_array'))->render();
            }else{
                $view = view('admin-panel.follow_up.follow_up_report_render',compact('first_priority','source_types','source_type_array'))->render();
            }


            return response()->json(['html'=>$view]);

        }

    }


    public function get_color_block_count_ajax(Request $request){

        $promotion_type = $request->option;
        $today_date = date("Y-m-d");

        if($promotion_type=="7"){

            $first_priority =  Career::select('careers.*')
                ->where('created_at', '<', $today_date)
                ->where('promotion_type','=',$promotion_type)
                ->where('applicant_status','!=','2')
                ->where('applicant_status','!=','1')
                ->orwhereNull('promotion_type')
                ->orderBy('careers.id','asc')
                ->get();

        }elseif($promotion_type=="0"){
            $first_priority =  Career::select('careers.*')
                ->where('created_at', '<', $today_date)
                ->where('applicant_status','!=','2')
                ->where('applicant_status','!=','1')
                ->orderBy('careers.id','asc')
                ->get();
        }else{
            $first_priority =  Career::select('careers.*')
                ->where('created_at', '<', $today_date)
                ->where('promotion_type','=',$promotion_type)
                ->where('applicant_status','!=','2')
                ->where('applicant_status','!=','1')
                ->orderBy('careers.id','asc')
                ->get();
        }

        $total_first_priority_24 = 0;
        $total_first_priority_48 = 0;
        $total_first_priority_72 = 0;
        $total_first_priority_less_24 = 0;

        foreach ($first_priority as $career) {

            $from = \Carbon\Carbon::parse($career->updated_at);
            $to = \Carbon\Carbon::now();
            $hours_spend = $to->diffInHours($from);

            if ($hours_spend < 24) {
                $total_first_priority_less_24 = $total_first_priority_less_24 + 1;
            }elseif($hours_spend >= 24 && $hours_spend < 48) {
                $total_first_priority_24 = $total_first_priority_24 + 1;
            }elseif($hours_spend >= 48 && $hours_spend <= 72) {
                $total_first_priority_48 = $total_first_priority_48 + 1;
            }elseif($hours_spend > 72) {
                $total_first_priority_72 = $total_first_priority_72 + 1;
            }
        }

        $gamer = array(
            'orange' => $total_first_priority_24,
            'pink' => $total_first_priority_48,
            'red' => $total_first_priority_72,
            'white' => $total_first_priority_less_24,
        );

        return $gamer;
    }

    public function get_career_history(Request $request){

        if($request->ajax()){
            $career_id = $request->career_id;
            $histories = CareerStatusHistory::where('career_id','=',$career_id)->orderby('id','desc')->get();

            $view = view('admin-panel.follow_up.career_history_render',compact('histories'))->render();
            return response()->json(['html'=>$view]);

        }


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


            try {
                $validator = Validator::make($request->all(), [
                    'status' => 'required',
                    'remarks' => 'required',
                    'company_remarks' => 'required',
                ]);
                if ($validator->fails()) {
                    $validate = $validator->errors();
                    $message_error = "";
                    foreach ($validate->all() as $error) {
                        $message_error .= $error;
                    }
                    $message = [
                        'message' => $message_error,
                        'alert-type' => 'error',
                        'error' => $validate->first()
                    ];
                    return redirect()->back()->with($message);
                }
                $id = $request->id;
                $remarks = $request->remarks;
                $status = $request->status;
                $career = Career::find($id);

                if(empty($career->passport_no)){
                    $message = [
                        'message' => 'please enter passport number before change the status',
                        'alert-type' => 'error'
                    ];
                    return redirect()->back()->with($message);
                }

//                if(empty($career->email)){
//                    $message = [
//                        'message' => 'please enter email before change the status',
//                        'alert-type' => 'error'
//                    ];
//                    return redirect()->back()->with($message);
//                }


//                $career->applicant_status = $status;
//                $career->remarks = $remarks;
//                $career->company_remarks = $request->company_remarks;
//                $career->update();

                $careers = new CareerStatusHistory();
                $careers->remarks=$request->input('remarks');
                $careers->company_remarks=$request->input('company_remarks');
                $careers->career_id = $id;
                $careers->status = $status;
                $careers->user_id = Auth::user()->id;
                $careers->save();

//
//                $career_history = new CareerStatusHistory();
//                $career_history->career_id = $id;
//                $career_history->status = $status;
//                $career_history->remarks = $remarks;
//                $career_history->company_remarks = $request->company_remarks;
//                $career_history->user_id = auth()->user()->id;
//                $career_history->save();
//                $application_status = "";
//                if ($request->status == "0") {
//                    $application_status = "Not Verified";
//                } elseif ($request->status == "1") {
//                    $application_status = "Rejected";
//                } elseif ($request->status == "2") {
//                    $application_status = "Document Pending";
////                              $passport_number=trim($request->input('passport_no'));
//
//                    Referal::where('career_id','=',$id)
//                        ->update(['status'=>'1']);
//
//
//                } elseif ($request->status == "3") {
//                    $application_status = "Short Listed";
//                } elseif ($request->status == "4") {
//                    $application_status = "Selected";
//                } elseif ($request->status == "5") {
//                    $application_status = "Wait List";
//                }
//                $career_array = array(
//                    'status' => $application_status,
//                    'remarks' => $remarks,
//                );
//                Mail::to([$career->email])->send(new CareerMail($career_array));

                $message = [
                    'message' => 'Status has been updated Successfully',
                    'alert-type' => 'success'
                ];

                return redirect()->back()->with($message);

            } catch (\Illuminate\Database\QueryException $e) {
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
