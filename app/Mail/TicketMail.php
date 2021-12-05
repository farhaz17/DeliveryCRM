<?php

namespace App\Mail;

use App\Model\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TicketMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $ticket;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Ticket $ticket)
    {
        $this->ticket=$ticket;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $viewName='admin-panel.emails.ticket_email';
        return $this->from('info@zonemsp.com','Ticket Query')
            ->view($viewName)
            ->subject('Ticket Query Update');
    }
}
