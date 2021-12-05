<?php

namespace App\Mail;

use App\Model\Guest\Career;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RemarksMail extends Mailable
{
    use Queueable, SerializesModels;
    public $career = array();


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($career)
    {
        $this->career=$career;
    }



    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $viewName='admin-panel.emails.send_remarks';
        return $this->from('info@zonemsp.com','Zone APP - Remarks')
            ->view($viewName)
            ->subject('ZDS Remarks');
    }
}
