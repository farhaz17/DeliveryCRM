<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CareerMail extends Mailable
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
        $viewName='admin-panel.emails.career_status';
        return $this->from('info@zonemsp.com','Career')
            ->view($viewName)
            ->subject('Career Status Update');
    }
}
