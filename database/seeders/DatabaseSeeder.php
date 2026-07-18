<?php

namespace Database\Seeders;

use App\Models\Punch;
use App\Models\Timesheet;
use App\Models\User;
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
        User::create([
            'name' => 'Stephen Alonzo',
            'emp_id' => 2973,
            'email' => 'hello@stephenaalonzo.com',
            'password' => bcrypt('password'),
            'punch_uuid' => Str::uuid()
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
    }
}
