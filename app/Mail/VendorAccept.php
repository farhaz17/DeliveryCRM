<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Model\Master\FourPl;

class VendorAccept extends Mailable
{
    use Queueable, SerializesModels;
    public $fourpl;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(FourPl $fourpl)
    {
        $this->fourpl=$fourpl;
      
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $viewName='admin-panel.emails.mail_to_vendor';
        return $this->from('info@zonemsp.com','Zone APP - Your Vendor Code is')
            ->view($viewName)
            ->subject('Your Vendor Code is Following');
    }
}
