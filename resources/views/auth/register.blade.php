@extends('layouts.main')

@section('content')
    
    <div class="vh-100 d-flex justify-content-center align-items-center">
        <div class="card p-4 shadow-lg bg-opacity-75"
            style="background-color: rgba(255,255,255,0.75); max-width: 400px; width: 100%;">
            <form method="POST" action="{{ route('register.process') }}">
                @csrf
                {{-- Register --}}
                {{-- Name, UserName, Contact, Email, Password --}}
                <div class="mb-3">
                    <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" placeholder="Enter your name" name="name">
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">User Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" placeholder="Enter your username" name="username">
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Contact <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" placeholder="Enter your contact" name="contact">
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" placeholder="Enter your email" name="email">
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Password <span class="text-danger">*</span></label>
                    <input type="password" class="form-control" placeholder="Enter your password" name="password"">
                </div>
                <button class="btn btn-success w-100" type="submit">Register</button>
            </form>
            <div>
                <p class="mt-3">Already have an account? <a href="{{ route('login') }}">Login</a></p>
            </div>

            <div class="mt-3">
                <a href="" class="btn btn-light border w-100 d-flex align-items-center justify-content-center">
                    <img src="https://img.icons8.com/color/16/000000/google-logo.png" class="me-2">Sign up with Google
                </a>
            </div>
        </div>
    </div>

@endsection
