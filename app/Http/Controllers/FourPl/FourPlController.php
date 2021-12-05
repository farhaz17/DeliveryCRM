<?php

namespace App\Http\Controllers\FourPl;

use App\Model\Master\FourPl;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class FourPlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $fourpl=FourPl::where('status','1')->get();
        // $fourpl=FourPl::where('four_pl_type','=','1')->get();
        $fourpl_agent=FourPl::where('four_pl_type','=','2')->get();

        return view('admin-panel.four_pl.index',compact('fourpl','fourpl_agent'));
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
        $validator = Validator::make($request->all(), [
            'phone_number' => 'numeric',
            'four_pl_code' => 'numeric|unique:four_pls,four_pl_code',
            'pl_typle' => 'required',
            'email' => 'required|email|unique:four_pls,email',
        ]);
        if ($validator->fails()) {
            $validate = $validator->errors();
            $message = [
                'message' => $validate->first(),
                'alert-type' => 'error',
                'error' => $validate->first()
            ];
            return redirect()->back()->with($message);
        }

//        $group_id = 0;
//        if($request->pl_typle=="1"){
//            $group_id = 18;
//        }else{
//            $group_id = 19;
//        }

//        $user=new User();
//        $user->name = $request->input('name');
//        $user->email = $request->input('email');
//        $user->user_group_id = json_encode(["$group_id"]);
//        $user->password = bcrypt(trim($request->input('password')));
//        $user->save();


        $obj = new FourPl();
        $obj->name = $request->input('name');
        $obj->phone_no = $request->input('phone_number');
        $obj->four_pl_code = $request->input('four_pl_code');
        $obj->four_pl_type = $request->input('pl_typle');
        $obj->email = $request->input('email');
        $obj->save();
        $message = [
            'message' => 'Added Successfully',
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
      $fourpl_edit=FourPl::find($id);

      $fourpl=FourPl::where('status','1')->get();
        // $fourpl=FourPl::where('four_pl_type','=','1')->get();
        $fourpl_agent=FourPl::where('four_pl_type','=','2')->get();

        return view('admin-panel.four_pl.index',compact('fourpl','fourpl_agent','fourpl_edit'));

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
        $obj=FourPl::find($id);


        $obj->name = $request->input('name');
        $obj->phone_no = $request->input('phone_number');
        $obj->four_pl_code = $request->input('four_pl_code');
        $obj->four_pl_type = $request->input('pl_typle');
        $obj->email = $request->input('email');
        $obj->save();
        $message = [
            'message' => 'updated Successfully',
            'alert-type' => 'success'

        ];
        return redirect()->route('four_pl')->with($message);
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
