<?php

namespace App\Http\Controllers;

use App\Http\Requests\LeaveRequest;
use App\Models\Leave;
use Inertia\Inertia;

class LeaveController extends Controller
{
    public function index()
    {
        return Inertia::render('ess/Timeoff');
    }

    public function store(LeaveRequest $request)
    {
        $validated = $request->validated();

        Leave::create($validated);
    }
}
