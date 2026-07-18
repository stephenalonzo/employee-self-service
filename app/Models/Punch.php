<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Punch extends Model
{
    protected $fillable = [
        'emp_id',
        'punch_type',
        'punch_uuid',
    ];
}
