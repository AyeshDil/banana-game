<?php

namespace App\Http\Controllers;

use App\Models\Score;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LeaderBoardController extends Controller
{
    public function index() {

        // Select the top 10 players for today with total score today
        $todayTopPlayers = Score::select('user_id', DB::raw('SUM(score) as score'))
            ->whereDate('created_at', date('Y-m-d'))
            ->groupBy('user_id')
            ->orderBy('score', 'desc')
            ->limit(10)
            ->get();

        // Select the top 10 players for this week with total score
        $thisWeekTopPlayers = Score::select('user_id', DB::raw('SUM(score) as score'))
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->groupBy('user_id')
            ->orderBy('score', 'desc')
            ->limit(10)
            ->get();

        return view('leaderboard.index', compact('todayTopPlayers', 'thisWeekTopPlayers'));
    }
}
