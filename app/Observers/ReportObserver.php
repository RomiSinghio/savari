<?php

namespace App\Observers;

use App\Models\Report;
use App\Mail\EmployeeCheckMail;
use App\Mail\PaidMail;
use Illuminate\Support\Facades\Mail;

class ReportObserver
{
    /**
     * Handle the Report "created" event.
     *
     * @param  \App\Models\Report  $report
     * @return void
     */
    public function created(Report $report)
    {
        if ($report->status == 3) { // Employee check
            Mail::to($report->driver->email)->send(new EmployeeCheckMail($report));
        }

        if ($report->status == 5) { // Paid
            Mail::to($report->driver->email)->send(new PaidMail($report));
        }
    }

    /**
     * Handle the Report "updated" event.
     *
     * @param  \App\Models\Report  $report
     * @return void
     */
    public function updated(Report $report)
    {
        if ($report->status == 3) { // Employee check
            Mail::to($report->driver->email)->send(new EmployeeCheckMail($report));
        }
    //   if ($report->status == 5)  { // Paid
     //       Mail::to($report->driver->email)->send(new PaidMail($report));
//}
    }

    /**
     * Handle the Report "deleted" event.
     *
     * @param  \App\Models\Report  $report
     * @return void
     */
    public function deleted(Report $report)
    {
        //
    }

    /**
     * Handle the Report "restored" event.
     *
     * @param  \App\Models\Report  $report
     * @return void
     */
    public function restored(Report $report)
    {
        //
    }

    /**
     * Handle the Report "force deleted" event.
     *
     * @param  \App\Models\Report  $report
     * @return void
     */
    public function forceDeleted(Report $report)
    {
        //
    }

}
