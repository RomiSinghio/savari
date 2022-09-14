@component('mail::message')
Hi {{ $report->driver->name }},
<br>
Please check below your hours that you worked.
<br> <br>
# Employee Hour Check
 <br>
For reference: 
<br>
Standard = Normal Working Hours (£14 Weekday / £15 Weekend) <br>
Bonus = Non sociable hours / 22:00 - 04:00 (£15 Weekday / £16 Weekend) <br>
Fixed = Jobs paid in fixed amounts <br>
Overtime = If you have worked over 39 hours in a week you will be paid an additional £1 per hour. <br>

<br><br>
Monday Standard: {{ $report->monday_hours  }} hours
<br>
Monday Bonus: {{ $report->monday_bonus  }} hours 
<br>
Monday Fixed: £{{ $report->monday_fixed }}
<br><br>
Tuesday Standard: {{ $report->tuesday_hours }} hours
<br>
Tuesday Bonus: {{ $report->tuesday_bonus }} hours
<br>
Tuesday Fixed: £{{ $report->tuesday_fixed }}
<br><br>
Wednesday Standard: {{ $report->wednesday_hours }} hours
<br>
Wednesday Bonus: {{ $report->wednesday_bonus }} hours
<br>
Wednesday Fixed: £{{ $report->wednesday_fixed }}
<br><br>
Thursday Standard: {{ $report->thursday_hours }} hours
<br>
Thursday Bonus: {{ $report->thursday_bonus }} hours
<br>
Thursday Fixed: £{{ $report->thursday_fixed }}
<br><br>
Friday Standard: {{ $report->friday_hours }} hours
<br>
Friday Bonus: {{ $report->friday_bonus }} hours
<br>
Friday Fixed: £{{ $report->friday_fixed }}
<br><br>
Saturday Standard: {{ $report->saturday_hours }} hours
<br>
Saturday Bonus: {{ $report->saturday_bonus }} hours
<br>
Saturday Fixed: £{{ $report->saturday_fixed }}
<br><br>
Sunday Standard: {{ $report->sunday_hours }} hours
<br>
Sunday Bonus: {{ $report->sunday_bonus }} hours
<br>
Sunday Fixed: £{{ $report->sunday_fixed }}
<br><br>

Food Allowance: £{{ $report->food_allowance }}
<br>
Fuel Allowance: £{{ $report->fuel_allowance }}
<br>

Notes: {{ $report->notes }}
<br><br>
Standard Hours: {{ $report->standard_hours }} hours
<br>
Overtime Hours: {{ $report->overtime }} hours
<br>
<br>
Total Hours: {{ $report->total_hours }} hours
<br>
Gross Pay: £{{ $report->gross_pay }}
<br>
<br>
<h3> Deductions / Expenses are calculated after tax so it is not calculated into the gross pay </h3>
<br>
Deductions: £{{ $report->deductions }} 
<br>
Expenses: £{{ $report->expenses }}

@component('mail::button', ['url' => 'https://forms.monday.com/forms/ae570e29b06416a22b887bf9fe76ccea?r=use1'])
Report Missing Hours
@endcomponent

Thanks,<br>
OMC Global
@endcomponent
