<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class TimePunchController extends Controller
{
    public function index()
    {
        return Inertia::render('ess/TimePunch');
    }
}
