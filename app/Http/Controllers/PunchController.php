<?php

namespace App\Http\Controllers;

use App\Http\Requests\PunchRequest;
use App\Models\Punch;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Enums\PunchType;

class PunchController extends Controller
{
    public function index() {
        return Inertia::render('ess/TimePunch');
    }

    public function store(PunchRequest $request) {
//        Get punch type [COMPLETED]
//        Once punch type is determined, create row for user time punches [COMPLETED]
//        After row is created, update user status [COMPLETED]
        $punchType = PunchType::checkPunchType(Route::currentRouteName());
        $validated = $request->validated();
        $validated['emp_id'] = Auth::user()->emp_id;
        $validated[$punchType] = Carbon::now();

        Punch::create($validated);
        User::where('emp_id', Auth::user()->emp_id)->first()->update([
            'punch_type' => $punchType,
        ]);
    }
}
