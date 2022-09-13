<?php

namespace App\Http\Controllers;

use Exception;
use Inertia\Inertia;
use App\Models\Driver;
use App\Models\Report;
use Illuminate\Http\Request;
use App\Mail\EmployeeCheckMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\StoreReportRequest;
use App\Http\Requests\UpdateReportRequest;

class ReportController extends Controller
{




    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Reports/ReportsIndex', [
            'reports' => Report::with('driver')
                ->orderBy('created_at', 'desc')
                ->get()->map(function ($report) {
                    $status = array();
                    $status[1] = "New";
                    $status[2] = "Needs Approval";
                    $status[3] = "Employee Check";
                    $status[4] = "Ready for Payroll";
                    $status[5] = "Paid";
                    $report_status = $status[$report->status];
                    // $report->status

                    $type = array();
                    $type[1] = "Employeed";
                    $type[2] = "Self Employeed";
                    $driver_type = $type[$report->driver->type];
                    return [
                        'id' => $report->id,
                        'name' => $report->driver->name ?? 'no name',
                        'type'  =>  $driver_type,
                        'status' => $report_status,
                        'monday_hours' => $report->monday_hours,
                        'tuesday_hours' => $report->tuesday_hours,
                        'wednesday_hours' => $report->wednesday_hours,
                        'thursday_hours' => $report->thursday_hours,
                        'friday_hours' => $report->friday_hours,
                        'saturday_hours' => $report->saturday_hours,
                        'sunday_hours' => $report->sunday_hours,
                        'total_hours' => $report->total_hours,
                        'monday_fixed' => $report->monday_fixed,
                        'tuesday_fixed' => $report->tuesday_fixed,
                        'wednesday_fixed' => $report->wednesday_fixed,
                        'thursday_fixed' => $report->thursday_fixed,
                        'friday_fixed' => $report->friday_fixed,
                        'saturday_fixed' => $report->saturday_fixed,
                        'sunday_fixed' => $report->sunday_fixed,
                        'food_allowance' => $report->food_allowance,
                        'fuel_allowance' => $report->fuel_allowance,
                        'deductions' => $report->deductions,
                        'expenses' => $report->expenses,
                        'notes' => $report->notes,
                        'payslip' => $report->payslip,
                        'net_pay' => $report->net_pay,
                        'overtime' => $report->overtime,
                        'gross_pay' => $report->gross_pay,

                    ];
                })
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Reports/ReportCreate', [
            'drivers' => Driver::pluck('name', 'id'),
        ]);
    }

    /**4
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreReportRequest  $request
     * @return \Illuminate\Http\Response
     */


    public function store(Request $request)
    {
        $attachments = array();
        $payslip = $request->payslip;
        if ($request->file('payslip')) {
            $payslip = $request->file('payslip')->store('payslips', 'public');
            $attachments[] = array(
                "storage/" . $payslip, "application/pdf", "driver_report.pdf"
            );
        }
        Report::create([
            'driver_id' => $request->input('driver_id'),
            'status' => $request->input('status'),
            'monday_hours' => $request->input('monday_hours'),
            'tuesday_hours' => $request->input('tuesday_hours'),
            'wednesday_hours' => $request->input('wednesday_hours'),
            'thursday_hours' => $request->input('thursday_hours'),
            'friday_hours' => $request->input('friday_hours'),
            'saturday_hours' => $request->input('saturday_hours'),
            'sunday_hours' => $request->input('sunday_hours'),
            'total_hours' => $request->input('total_hours'),
            'monday_fixed' => $request->input('monday_fixed'),
            'tuesday_fixed' => $request->input('tuesday_fixed'),
            'wednesday_fixed' => $request->input('wednesday_fixed'),
            'thursday_fixed' => $request->input('thursday_fixed'),
            'friday_fixed' => $request->input('friday_fixed'),
            'saturday_fixed' => $request->input('saturday_fixed'),
            'sunday_fixed' => $request->input('sunday_fixed'),
            'monday_bonus' => $request->input('monday_bonus'),
            'tuesday_bonus' => $request->input('tuesday_bonus'),
            'wednesday_bonus' => $request->input('wednesday_bonus'),
            'thursday_bonus' => $request->input('thursday_bonus'),
            'friday_bonus' => $request->input('friday_bonus'),
            'saturday_bonus' => $request->input('saturday_bonus'),
            'sunday_bonus' => $request->input('sunday_bonus'),
            'food_allowance' => $request->input('food_allowance'),
            'fuel_allowance' => $request->input('fuel_allowance'),
            'deductions' => $request->input('deductions'),
            'expenses' => $request->input('expenses'),
            'notes' => $request->input('notes'),
            'net_pay' => $request->input('net_pay'),
            'overtime' => $request->input('overtime'),
            'standard_hours' => $request->input('standard_hours'),
            'gross_pay' => $request->input('gross_pay'),
            'payslip' => $payslip,

        ]);

        $this->after_save($request->input('driver_id'), $attachments,$request->input('status'));
        return Redirect::route('reports');
    }




    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function show(Report $report)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function edit(Report $report)
    {
        $file_name = "";
        $file = "public/" . $report->payslip;
        if (Storage::exists($file) && $report->payslip != '') {
            $file_name = Storage::url($file);
        }
        return Inertia::render('Reports/ReportEdit', [
            'drivers' => Driver::pluck('name', 'id'),
            'report' => $report,
            'payslip' => $file_name,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateReportRequest  $request
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Report $report)
    {
        $payslip = $report->payslip;
        $attachments = array();

        if ($request->file('payslip')) {
            Storage::delete('public/' . $report->payslip);
            $payslip = $request->file('payslip')->store('payslips', 'public');
            $attachments[] = array(
                "storage/" . $payslip, "application/pdf", "driver_report.pdf"
            );
        }
        $report->update([
            'driver_id' => $request->input('driver_id'),
            'status' => $request->input('status') ?? null,
            'monday_hours' => $request->input('monday_hours'),
            'tuesday_hours' => $request->input('tuesday_hours'),
            'wednesday_hours' => $request->input('wednesday_hours'),
            'thursday_hours' => $request->input('thursday_hours'),
            'friday_hours' => $request->input('friday_hours'),
            'saturday_hours' => $request->input('saturday_hours'),
            'sunday_hours' => $request->input('sunday_hours'),
            'total_hours' => $request->input('total_hours'),
            'monday_fixed' => $request->input('monday_fixed'),
            'tuesday_fixed' => $request->input('tuesday_fixed'),
            'wednesday_fixed' => $request->input('wednesday_fixed'),
            'thursday_fixed' => $request->input('thursday_fixed'),
            'friday_fixed' => $request->input('friday_fixed'),
            'saturday_fixed' => $request->input('saturday_fixed'),
            'sunday_fixed' => $request->input('sunday_fixed'),
            'monday_bonus' => $request->input('monday_bonus'),
            'tuesday_bonus' => $request->input('tuesday_bonus'),
            'wednesday_bonus' => $request->input('wednesday_bonus'),
            'thursday_bonus' => $request->input('thursday_bonus'),
            'friday_bonus' => $request->input('friday_bonus'),
            'saturday_bonus' => $request->input('saturday_bonus'),
            'sunday_bonus' => $request->input('sunday_bonus'),
            'food_allowance' => $request->input('food_allowance'),
            'fuel_allowance' => $request->input('fuel_allowance'),
            'deductions' => $request->input('deductions'),
            'expenses' => $request->input('expenses'),
            'notes' => $request->input('notes'),
            'net_pay' => $request->input('net_pay'),
            'standard_hours' => $request->input('standard_hours'),
            'overtime' => $request->input('overtime'),
            'gross_pay' => $request->input('gross_pay'),
            'payslip' => $payslip,
        ]);
        $this->after_save($request->input('driver_id'), $attachments,$request->input('status'));
        return Redirect::route('reports');
    }
    public function after_save($driver_id, $attachments = array(),$status=0)
    {
        $row = Driver::where('id', $driver_id)->first();
        if (count($attachments)>0 && ($status==5 || $status==3) && $row->email != '') {
            $to = $row->email;
            $subject = "";
            $text = "";

            if($status==3){
                $subject = "OMC Global - Earnings Report";
                $text.="
                <p>Please find below your earnings report for last week.</p>
                <h4>Monday Standard Hours</h4> 
                ";
            }
            if($status==5){
                $subject = "OMC Global - You have been paid";
                $text.="
                <h1>You have been paid!</h1>
                <br>
                <p>Please find attached your payslip</p>
                <h4>Monday Standard Hours</h4>
                
                ";
            }
            $this->global_email($to, $subject, $text, '', $attachments);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function destroy(Report $report)
    {
        //
    }


    public function global_email($to, $subject, $text, $username = '', $attachments = array())
    {
        if ($to == '') {
            return false;
        }
        $sendgridkey = config('services.sendgrid.api_key');
        $username = config('services.sendgrid.username');
        $email = new \SendGrid\Mail\Mail();
        $email->setFrom("hr@omcglobal.co.uk", "OMC Global");
        $email->setSubject($subject);
        $email->addTo($to, $username);
        $email->addContent(
            "text/html",
            $text
        );

        foreach ($attachments as $at) {
            $file_encoded = base64_encode(file_get_contents($at[0]));
            $email->addAttachment(
                $file_encoded,
                $at[1],
                $at[2],
                "attachment"
            );
        }
        $sendgrid = new \SendGrid(($sendgridkey));
        try {
            if ($sendgrid->send($email)) {

             //   echo  1;
              //  exit;
            }
        } catch (Exception $e) {
          //  echo 'Caught exception: ' . $e->getMessage() . "\n";
        }
    }
}
