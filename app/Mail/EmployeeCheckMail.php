<?php

namespace App\Mail;

use App\Models\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmployeeCheckMail extends Mailable
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
        $monday_hours = $this->report->monday_hours;
        
        return $this
        ->subject("Hours Report for {$this->report->driver->name}" )
        ->replyTo("hr@omcglobal.co.uk")
        ->markdown('emails.employee-check');
    }
}
