<?php

namespace App\Http\Controllers\Api\TicketProblem;

use App\Model\Departments;
use App\Model\TicketProblem\TicketProblem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TicketProblemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $data = TicketProblem::get();

//         $array_to_send = array();
//
//        $array_to_send [] = array('name','=','please select department');
//
//        foreach ($data as $ab){
//
//            $array_to_send [] =  array('name','=',$ab->name);
//        }


        return response()->json(['data' => $data], 200, [], JSON_NUMERIC_CHECK);
    }

    public function get_ticket_issue($id){

        $data = Departments::where('ticket_problem_id','=',$id)->where('status','=','0')->get();
        return response()->json(['data' => $data], 200, [], JSON_NUMERIC_CHECK);

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
    public function destroy($id)
    {
        //
    }
}
