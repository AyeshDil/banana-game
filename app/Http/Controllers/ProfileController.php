<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Score;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index() 
    {
        $scoreHistory = Score::where('user_id', auth()->user()->id)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('profile.index', compact('scoreHistory'));
    }

    public function update(Request $request, User $user)
    {

        $validatedData = $request->validate([
            'name' => 'required',
            'username' => 'required',
            'password' => 'nullable',
        ]);

        $user->name = $validatedData['name'];
        $user->username = $validatedData['username'];

        if ($validatedData['password']) {
            $user->password = Hash::make($validatedData['password']);
        }

        $user->save();

        return redirect()->route('profile')->with('success', 'Profile updated successfully.');
    }
}
