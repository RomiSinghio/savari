<?php

namespace App\Models;


use App\Models\Report;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Driver extends Model
{
    use HasFactory;
    protected $table = 'driver';
    protected $guarded = [];
    
}
