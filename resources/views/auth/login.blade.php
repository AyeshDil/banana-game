@extends('layouts.main')

@section('content')


        <div class="vh-100 d-flex justify-content-center align-items-center">


        <div class="card p-4 shadow-lg bg-opacity-75"
            style="background-color: rgba(255,255,255,0.75); max-width: 400px; width: 100%;">
            <div class=" d-flex justify-content-center align-items-center mb-3">
                <img src="{{ asset('assets/images/banana-game.png') }}" alt="Profile" class="rounded-circle text-center" width="200" height="200">
            </div>
            <form method="POST" action="{{ route('login.process') }}">
                @csrf
                <div class="mb-3">
                    <input type="email" class="form-control" placeholder="Enter your email or username" name="email"
                        required>
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" placeholder="Enter your password" name="password" required>
                </div>
                <button class="btn btn-success w-100" type="submit">Login</button>

                <p class="mt-3">Don't have an account? <a href="{{ route('register') }}">Register</a></p>

                <a href="{{ route('google.redirect') }}" class="btn btn-light border w-100 d-flex align-items-center justify-content-center">
                    <img src="https://img.icons8.com/color/16/000000/google-logo.png" class="me-2">Sign in with Google
                </a>
            </form>
        </div>
    </div>

@endsection
