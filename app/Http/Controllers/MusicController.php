<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MusicController extends Controller
{
    
    public function muteAndUnmute(Request $request)
    {
        session(['is_muted' => $request->input('muted')]);
        return response()->json(['status' => 'ok']);
    }
}
