<?php

namespace App\Mail;

use App\Models\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Validation\Rules\Exists;

class PaidMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $report;

    public function __construct(Report $report)
    {
        $this->report = $report;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject("You have been paid - OMC Global")
            ->replyTo("hr@omcglobal.co.uk")
            ->from("hr@omcglobal.co.uk")
            ->markdown('emails.paid')
            ->attachFromStorage($this->report->paylsip);

    }
}
