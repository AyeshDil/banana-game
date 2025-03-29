<?php

namespace App\Http\Controllers;

use App\Models\Score;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    
    public function index() 
    {
        // Max score    
        $maxScore = Score::where('user_id', auth()->user()->id)->max('score');

        return view('dashboard.index', compact('maxScore'));
    }

}
