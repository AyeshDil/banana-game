@extends('layouts.main')

@section('content')
    
    <div class="vh-100 d-flex justify-content-center align-items-center">
        <div class="card p-4 shadow-lg bg-opacity-75"
            style="background-color: rgba(255,255,255,0.75); max-width: 400px; width: 100%;">
            <h4>Enter OTP</h4>
            <p class="text-center mb-4">Please check your mobile, find the OTP, and enter it below to verify your account.</p>
            <form method="POST" action="{{ route('verify.process') }}">
                @csrf
                @method('POST')
                <input type="text" name="email" id="email" value="{{ $user->email }}" hidden>
                <div class="mb-3 d-flex justify-content-between">
                    <input type="text" class="form-control text-center me-2" maxlength="1" name="otp1" required>
                    <input type="text" class="form-control text-center me-2" maxlength="1" name="otp2" required>
                    <input type="text" class="form-control text-center me-2" maxlength="1" name="otp3" required>
                    <input type="text" class="form-control text-center" maxlength="1" name="otp4" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Verify OTP</button>
            </form>

        </div>
    </div>

@endsection
