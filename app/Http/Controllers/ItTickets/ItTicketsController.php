<?php

namespace App\Http\Controllers\ItTickets;

use App\Mail\TicketMail;
use App\Model\FcmToken;
use App\Model\It_tickets\It_tickets;
use App\Model\Notification;
use App\Model\Ticket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ItTicketsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $it_tickets=It_tickets::get();

        return view('admin-panel.it_tickets.it_tickets',compact('it_tickets'));
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
        if (!file_exists('../public/assets/upload/it_tickets/')) {
            mkdir('../public/assets/upload/it_tickets/', 0777, true);
        }

        $ext = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
        $file_name = time() . "_" . $request->date . '.' . $ext;

        move_uploaded_file($_FILES["img"]["tmp_name"], '../public/assets/upload/it_tickets/' . $file_name);
        $file_path = '/assets/upload/it_tickets/' . $file_name;

        //-------
        if (!file_exists('../public/assets/upload/it_tickets/')) {
            mkdir('../public/assets/upload/it_tickets/', 0777, true);
        }

        $ext2 = pathinfo($_FILES['file_name']['name'], PATHINFO_EXTENSION);
        $file_name2 = time() . "_" . $request->date . '.' . $ext2;

        move_uploaded_file($_FILES["file_name"]["tmp_name"], '../public/assets/upload/it_tickets/' . $file_name2);
        $file_path2 = 'assets/upload/it_tickets/' . $file_name2;




        $obj = new It_tickets();
        $obj->user_id = $request->input('user_id');
        $obj->message = $request->input('message');
        $obj->img = $file_path;
        $obj->file = $file_path2;
        $obj->status = '0';
//        dd($obj);
//        $obj->save();
        $obj->save();
        $message = [
            'message' => 'IT Ticket Generated Successfully',
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


    public function it_ticket_start(Request $request, $id)
    {

        try {

            $obj = It_tickets::find($id);
            $obj->remarks=$request->input('remarks');
            $obj->status = 1;
            $obj->save();

            $message = [
                'message' => 'IT Ticket Started Successfully',
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



    public function it_ticket_not_doing(Request $request, $id)
    {

        try {

            $obj = It_tickets::find($id);
            $obj->remarks=$request->input('remarks');
            $obj->status = 2;
            $obj->save();

            $message = [
                'message' => 'IT Ticket Moved to "Not Doing" Successfully',
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



    public function it_tickete_complete(Request $request, $id)
    {

        try {

            $obj = It_tickets::find($id);
            $obj->remarks=$request->input('remarks');
            $obj->status = 3;
            $obj->save();

            $message = [
                'message' => 'IT Ticket Moved to "Complete" Successfully',
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


    public function it_ticket_new(Request $request, $id)
    {

        try {

            $obj = It_tickets::find($id);
            $obj->remarks=$request->input('remarks');
            $obj->status = 0;
            $obj->save();

            $message = [
                'message' => 'IT Ticket Moved to "New" Successfully',
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

}
