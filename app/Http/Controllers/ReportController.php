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
                ->where("status", "!=", 5)
                ->orderBy('created_at', 'desc')
                ->get()->map(function ($report) {
                    $status = array();
                    $status[1] = "New";
                    $status[2] = "Needs Approval";
                    $status[3] = "Employee Check";
                    $status[4] = "Ready for Payroll";
                    $status[6] = "Payroll Done";
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
                        'week_no' => $report->week_no,
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
                        'actual_pay' => $report->actual_pay,

                    ];
                }),
            'weeks' => $this->weeks(),
            'current_week' => 1
        ]);
    }


    public function filter($week_no)
    {
        return Inertia::render('Reports/ReportsIndex', [
            'reports' => Report::with('driver')
                ->orderBy('created_at', 'desc')
                ->where('week_no', $week_no)
                ->get()->map(function ($report) {
                    $status = array();
                    $status[1] = "New";
                    $status[2] = "Needs Approval";
                    $status[3] = "Employee Check";
                    $status[4] = "Ready for Payroll";
                    $status[6] = "Payroll Done";
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
                        'week_no' => $report->week_no,
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
                        'actual_pay' => $report->actual_pay,

                    ];
                }),
            'weeks' => $this->weeks(),
            'current_week' => $week_no
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
            'weeks' => $this->weeks(),
            'current_week' => date("W"),
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
        if ($request->hasFile('payslip')) {


            $extension = $request->file('payslip')->extension();
            $path = Storage::disk('spaces')->put('payslips', $request->file('payslip'), $request->file('payslip'), time() . '.' . $extension);
            $payslip = $path;
        } else {
            $payslip = null;
        }
        $gross_pay_bonus='no';
        if($request->has('gross_pay_bonus')){
            $gross_pay_bonus=$request->input('gross_pay_bonus');
        }
        Report::create([
            'driver_id' => $request->input('driver_id'),
            'status' => $request->input('status'),
            'week_no' => $request->input('week_no'),
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
            'actual_pay' => $request->input('actual_pay'),
            'payslip' => $payslip,
            'gross_pay_bonus' => $gross_pay_bonus,

        ]);


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
        $file = $report->payslip;
        if ($file != null) {
            $file_name = Storage::url($file);
        }




        return Inertia::render('Reports/ReportEdit', [
            'drivers' => Driver::pluck('name', 'id', 'contract_hours'),
            'report' => $report,
            'payslip' => $file_name,
            'weeks' => $this->weeks(),
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
            $payslip = $request->file('payslip')->store('payslips');
        }
        if ($report->payslip != '') {
            $report->status = 6;
            $report->save();
        }
        $gross_pay_bonus='no';
        if($request->has('gross_pay_bonus')){
            $gross_pay_bonus=$request->input('gross_pay_bonus');
        }

        $report->update([
            'driver_id' => $request->input('driver_id'),
            'status' => $request->input('status') ?? null,
            'week_no' => $request->input('week_no'),
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
            'actual_pay' => $request->input('actual_pay'),
            'payslip' => $payslip,
            'gross_pay_bonus' => $gross_pay_bonus,
        ]);
        return Redirect::route('reports');
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

    public function weeks()
    {
        $weeks = array();
        for ($i = 1; $i <= 52; $i++) {
            $weeks[$i] = "Week " . $i;
        }
        return $weeks;
    }
}
