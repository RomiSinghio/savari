@component('mail::message')
# Employee Hour Check

Please check below your hours that you worked.
<br><br>
Monday: {{ $report->monday_hours  }} hours
<br>
Monday: £{{ $report->monday_fixed }} fixed
<br><br>
Tuesday: {{ $report->tuesday_hours }} hours
<br>
Tuesday: £{{ $report->tuesday_fixed }} fixed
<br><br>
Wednesday: {{ $report->wednesday_hours }} hours
<br>
Wednesday: £{{ $report->wednesday_fixed }} fixed
<br><br>
Thursday: {{ $report->thursday_hours }} hours
<br>
Thursday: £{{ $report->thursday_fixed }} fixed
<br><br>
Friday: {{ $report->friday_hours }} hours
<br>
Friday: £{{ $report->friday_fixed }} fixed
<br><br>
Saturday: {{ $report->saturday_hours }} hours
<br>
Saturday: £{{ $report->saturday_fixed }} fixed
<br><br>
Sunday: {{ $report->sunday_hours }} hours
<br>
Sunday: £{{ $report->sunday_fixed }} fixed
<br><br>

Food Allowance: £{{ $report->food_allowance }}
<br>
Fuel Allowance: £{{ $report->fuel_allowance }}

<br>

Notes: {{ $report->notes }}
<br><br>
Total Hours: {{ $report->total_hours }} hours
<br>
Gross Pay: £{{ $report->gross_pay }}

@component('mail::button', ['url' => 'https://forms.monday.com/forms/ae570e29b06416a22b887bf9fe76ccea?r=use1'])
Report Missing Hours
@endcomponent

Thanks,<br>
OMC GLobal
@endcomponent
