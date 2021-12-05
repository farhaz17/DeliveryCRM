<?php

namespace App\Mail;

use App\Model\Job\JobsApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class JobMailReject extends Mailable
{
    use Queueable, SerializesModels;
    public $obj;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(JobsApplication $obj)
    {
        $this->obj=$obj;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $viewName='admin-panel.emails.job_reject';
        return $this->from('info@zonemsp.com','Your Job Aknowledgment')
            ->view($viewName)
            ->subject('You Job Application Has Been Proceeded');
    }
}
