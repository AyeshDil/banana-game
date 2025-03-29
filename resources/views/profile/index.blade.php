@extends('layouts.main')

@section('content')

<!-- Back Button -->
<div class="position-absolute top-0 start-0 p-3">
    <button class="btn btn-light border rounded-circle" onclick="history.back()">
        <iconify-icon icon="solar:arrow-left-line-duotone"></iconify-icon>
    </button>
</div>

<!-- Max Score & Profile -->
<div class="position-absolute top-0 end-0 p-3 d-flex align-items-center gap-2">
    <div class="badge bg-light text-dark px-3 py-2">Max Score: 2 250</div>
    <img src="{{ asset('assets/images/demo-profile-pic.jpg') }}" class="rounded-circle" width="40" height="40" alt="Profile">
</div>

<!-- Profile Form & History -->
<div class="container vh-100 d-flex align-items-center justify-content-center">
    <div class="row w-100">

        <!-- Profile Form -->
        <div class="col-md-6 mb-4">
            <div class="card p-4 shadow-lg bg-opacity-75" style="background-color: rgba(255,255,255,0.75);">

                <h5 class="fw-bold mb-4">Profile</h5>
                @if (session('success'))
                    <div class="alert alert-success d-flex align-items-center justify-content-between" role="alert" id="success-alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('profile.update', Auth::user()->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" value="{{ Auth::user()->name }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">User Name</label>
                        <input type="text" class="form-control" name="username" value="{{ Auth::user()->username }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" value="{{ Auth::user()->email }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" placeholder="Enter your new password">
                    </div>

                    <button type="submit" class="btn btn-success w-100 mt-2">Save</button>

                </form>

            </div>
        </div>

        <!-- History -->
        <div class="col-md-6 mb-4">
            <div class="card p-4 shadow-lg bg-opacity-75" style="background-color: rgba(255,255,255,0.75);">
                <h5 class="fw-bold mb-4 text-center">My History</h5>

                <ul class="list-group">
                    @foreach ($scoreHistory as $history)
                        <li class="list-group-item d-flex justify-content-between bg-secondary bg-opacity-25">
                            {{ $history->created_at }} 
                            <strong>
                                {{ $history->score }}
                            </strong>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

    </div>
</div>

<!-- Music Button -->
<div class="position-absolute bottom-0 end-0 p-3">
    <button class="btn btn-light border rounded-circle">
        <iconify-icon icon="solar:music-notes-outline"></iconify-icon>
    </button>
</div>

@endsection
