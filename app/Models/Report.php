<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }


    protected $status = array(
        '1' => 'New',
        '2' => 'Needs Approval',
        '3' => 'Employee Check',
        '4' => 'Ready for Payroll',
        '5' => 'Paid',
    );

    protected $casts = [
        'status' => 'integer',
    ];



}
