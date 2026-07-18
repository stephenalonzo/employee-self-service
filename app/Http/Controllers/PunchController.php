<?php

namespace App\Http\Controllers;

use App\Http\Requests\PunchRequest;
use App\Models\Punch;
use App\Models\Timesheet;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Inertia\Inertia;
use App\Enums\PunchType;

class PunchController extends Controller
{
    public function index()
    {
        return Inertia::render('ess/TimePunch');
    }

    public function store(PunchRequest $request)
    {
        $validated = $request->validated();

        $users = User::where('emp_id', Auth::user()->emp_id)->first()->get();

        $validated['emp_id'] = Auth::user()->emp_id;

        foreach ($users as $user) {
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

            // When the user punches for time, generate a UUID.
            // The UUID will be the identifier for the punches.
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
            } else {
                User::where('emp_id', Auth::user()->emp_id)->first()->update([
                    'punch_type' => $validated['punch_type'],
                    'punch_uuid' => $validated['punch_uuid'],
                ]);
            }


        }
    }
}
