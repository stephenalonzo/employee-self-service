<?php

namespace App\Services;

use App\Models\Punch;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PunchService
{
    public function __construct(public TimesheetService $timesheetService){}

    public function handlePunches($validated, $user):void
    {
        $validated['emp_id'] = Auth::user()->emp_id;

        switch ($user->punch_type) {
            case null:
                $validated['punch_type'] = 'time_in';
                break;
            case 'time_in':
                $validated['punch_type'] = 'lunch_out';
                break;
            case 'lunch_out':
                $validated['punch_type'] = 'lunch_in';
                break;
            case 'lunch_in':
                $validated['punch_type'] = 'time_out';
                break;
            case 'time_out':
                $validated['punch_type'] = null;
                break;
        }

        if (is_null($user->punch_uuid)) {
            $validated['punch_uuid'] = Str::uuid();
        } else {
            $validated['punch_uuid'] = $user->punch_uuid;
        }

        Punch::create($validated);

        if ($validated['punch_type'] == 'time_out') {
            User::where('emp_id', Auth::user()->emp_id)->first()->update([
                'punch_type' => null,
                'punch_uuid' => null,
            ]);

            $this->timesheetService->automateTimesheet($user);
        } else {
            User::where('emp_id', Auth::user()->emp_id)->first()->update([
                'punch_type' => $validated['punch_type'],
                'punch_uuid' => $validated['punch_uuid'],
            ]);
        }
    }
}
