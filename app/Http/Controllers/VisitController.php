<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visit;

class VisitController extends Controller
{
    public function index()
    {
        $totalVisits = Visit::count();
        $visitsToday = Visit::whereDate('created_at', today())->count();

        return view('visits', compact('totalVisits', 'visitsToday'));
    }
}
