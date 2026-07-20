<?php

namespace App\Services;

use App\Models\Punch;
use App\Models\Timesheet;

class TimesheetService
{
    public function automateTimesheet($user): void
    {
        $timeIn = Punch::where('emp_id', $user->emp_id)->where('punch_uuid', $user->punch_uuid)->where('punch_type', 'time_in')->first();
        $lunchOut = Punch::where('emp_id', $user->emp_id)->where('punch_uuid', $user->punch_uuid)->where('punch_type', 'lunch_out')->first();
        $lunchIn = Punch::where('emp_id', $user->emp_id)->where('punch_uuid', $user->punch_uuid)->where('punch_type', 'lunch_in')->first();
        $timeOut = Punch::where('emp_id', $user->emp_id)->where('punch_uuid', $user->punch_uuid)->where('punch_type', 'time_out')->first();

        Timesheet::create([
            'emp_id' => $user->emp_id,
            'time_in' => $timeIn->created_at,
            'lunch_out' => $lunchOut->created_at,
            'lunch_in' => $lunchIn->created_at,
            'time_out' => $timeOut->created_at,
            'punch_uuid' => $user->punch_uuid
        ]);
    }
}
