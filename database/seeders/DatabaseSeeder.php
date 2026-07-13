<?php

namespace Database\Seeders;

use App\Models\Punch;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
            'password' => bcrypt('password')
        ]);

        $users = User::all();
        $user = $users->find(1);

        Punch::create([
            'emp_id' => $user->emp_id,
            'time_in' => '2026-07-12 07:30:00',
            'lunch_out' => '2026-07-12 12:30:00',
            'lunch_in' => '2026-07-12 13:30:00',
            'time_out' => '2026-07-12 16:30:00'
        ]);
    }
}
