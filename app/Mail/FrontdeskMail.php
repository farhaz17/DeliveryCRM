<?php

namespace App\Mail;

use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class FrontdeskMail extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(Request $request)
    {
        if(!empty($request->attachment)) {
            $file = $request->attachment;
            $this->attach($file->getRealPath(), array(
                'as' => $file->getClientOriginalName(),
                'mime' => $file->getMimeType())
            );
        }
        return $this->from(env('MAIL_FROM_ADDRESS', 'info@zonemsp.com'))
        ->view('admin-panel.emails.career_frontdesk')
        ->subject( $request->subject ?? "Career Information Update");

    }
}
