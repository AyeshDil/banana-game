<?php

namespace App\Http\Controllers;

use App\Models\Score;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class GameController extends Controller
{
    public function selectMode()
    {
        return view('game.select-mode');
    }

    public function game(String $mode)
    {

        $playGround = [
            'marksPerQuestion' => 10,
            'timer' => 30
        ];

        if($mode == 'easy') {

            $playGround['marksPerQuestion'] = 10;
            $playGround['timer'] = 30;

        } elseif($mode == 'medium') {

            $playGround['marksPerQuestion'] = 20;
            $playGround['timer'] = 20;

        } elseif($mode == 'hard') {

            $playGround['marksPerQuestion'] = 30;
            $playGround['timer'] = 10;
        }

        return view('game.index', compact('playGround'));
    }

    public function addScore(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'score' => 'required|integer|min:0',
        ]);

        // Update score
        Score::create([
            'user_id' => auth()->user()->id,
            'score' => $request->score
        ]);


        return response()->json([
            'message' => 'Score added successfully',
            'score' => Session::get('score')
        ], 200);
    }

}
