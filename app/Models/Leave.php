<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    protected $fillable = [
        'emp_name',
        'emp_id',
        'emp_department',
        'leave_type',
        'leave_start',
        'leave_end',
        'leave_reason',
        'leave_uuid'
    ];
}
