<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Punch extends Model
{
    protected $fillable = [
        'emp_id',
        'time_in',
        'lunch_out',
        'lunch_in',
        'time_out'
    ];
}
