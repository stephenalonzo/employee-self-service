<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Timesheet extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'emp_id',
        'time_in',
        'lunch_out',
        'lunch_in',
        'time_out',
        'punch_uuid'
    ];
}
