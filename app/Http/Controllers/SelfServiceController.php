<?php

namespace App\Http\Controllers;

use App\Models\Punch;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class SelfServiceController extends Controller
{
    public function index()
    {
        return Inertia::render('Dashboard', [
            'punches' => Punch::where('emp_id', Auth::user()->emp_id)->get()
        ]);
    }
}
