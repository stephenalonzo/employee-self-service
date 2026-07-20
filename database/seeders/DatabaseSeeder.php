<?php

namespace Database\Seeders;

use App\Models\Leave;
use App\Models\Punch;
use App\Models\Timesheet;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Employee Time Punch seeders
        User::create([
            'name' => 'Stephen Alonzo',
            'emp_id' => 2973,
            'email' => 'hello@stephenaalonzo.com',
            'password' => bcrypt('password'),
            'punch_uuid' => Str::uuid(),
            'annual_leave' => 164,
            'sick_leave' => 45
        ]);

        $users = User::all();
        $user = $users->find(1);

        Punch::create([
            'emp_id' => $user->emp_id,
            'punch_type' => 'time_in',
            'punch_uuid' => $user->punch_uuid,
        ]);

        Punch::create([
            'emp_id' => $user->emp_id,
            'punch_type' => 'lunch_out',
            'punch_uuid' => $user->punch_uuid,
        ]);

        Punch::create([
            'emp_id' => $user->emp_id,
            'punch_type' => 'lunch_in',
            'punch_uuid' => $user->punch_uuid,
        ]);

        Punch::create([
            'emp_id' => $user->emp_id,
            'punch_type' => 'time_out',
            'punch_uuid' => $user->punch_uuid,
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

        // Employee Time-off Seeders
        Leave::create([
            'emp_name' => $user->name,
            'emp_id' => $user->emp_id,
            'emp_department' => 'Department of Finance',
            'leave_type' => 'SL',
            'leave_start' => date('Y-m-d H:i:s', strtotime('2026-07-06')),
            'leave_end' => date('Y-m-d H:i:s', strtotime('2026-07-10')),
            'leave_reason' => 'I just want a break',
            'leave_uuid' => Str::uuid()
        ]);

        Leave::create([
            'emp_name' => $user->name,
            'emp_id' => $user->emp_id,
            'emp_department' => 'Department of Finance',
            'leave_type' => 'AL',
            'leave_start' => date('Y-m-d H:i:s', strtotime('2026-07-13')),
            'leave_end' => date('Y-m-d H:i:s', strtotime('2026-07-17')),
            'leave_reason' => 'I just want a break',
            'leave_uuid' => Str::uuid()
        ]);

        Leave::create([
            'emp_name' => $user->name,
            'emp_id' => $user->emp_id,
            'emp_department' => 'Department of Finance',
            'leave_type' => 'AL',
            'leave_start' => date('Y-m-d H:i:s', strtotime('2026-07-20')),
            'leave_end' => date('Y-m-d H:i:s', strtotime('2026-07-24')),
            'leave_reason' => 'I just want a break',
            'leave_uuid' => Str::uuid()
        ]);

        // Get employee leave data
        $empLeave = Leave::where('emp_id', $user->emp_id)->whereColumn('leave_end', '>', 'leave_start')->where('leave_end', '<', now())->latest()->get();

        foreach ($empLeave as $leave) {
            $start = Carbon::parse($leave->leave_start);
            $end = Carbon::parse($leave->leave_end);

            $calendarDays = $start->diffInDaysFiltered(function (Carbon $date) {
                return true;
            }, $end);

            if ($leave->leave_type == 'AL') {
                $newLeaveHours = $user->annual_leave - $calendarDays;
                User::where('emp_id', $user->emp_id)->first()->update([
                    'annual_leave' => $newLeaveHours
                ]);
            } else {
                $newLeaveHours = $user->sick_leave - $calendarDays;
                User::where('emp_id', $user->emp_id)->first()->update([
                    'sick_leave' => $newLeaveHours
                ]);
            }
        }
    }
}
