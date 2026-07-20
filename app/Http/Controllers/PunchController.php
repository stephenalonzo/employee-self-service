<?php

namespace App\Http\Controllers;

use App\Http\Requests\PunchRequest;
use App\Models\Punch;
use App\Models\Timesheet;
use App\Services\PunchService;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Inertia\Inertia;
use App\Enums\PunchType;
use App\Services\TimesheetService;

class PunchController extends Controller
{
    public function __construct(public PunchService $punchService) {}

    public function index()
    {
        return Inertia::render('ess/TimePunch');
    }

    public function store(PunchRequest $request)
    {
        $users = User::where('emp_id', Auth::user()->emp_id)->first()->get();

        $validated = $request->validated();

        foreach ($users as $user) {
            $this->punchService->handlePunches($validated, $user);
        }
    }
}
