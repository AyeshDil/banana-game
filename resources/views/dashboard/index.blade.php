@extends('layouts.main')

@section('content')
    
    <div class="vh-100 d-flex justify-content-center align-items-center">
        <div class="card p-4 shadow-lg bg-opacity-75 w-75 h-75"
            style="background-color: rgba(255,255,255,0.75);">
            
            <!-- Top Bar -->
            <div class="w-100 d-flex justify-content-end align-items-center p-3 gap-4">
                <div class="badge bg-light text-dark p-2">Max Score: 2,250</div>
                <img src="{{ asset('assets/images/demo-profile-pic.jpg') }}" alt="Profile" class="rounded-circle" width="40" height="40">
            </div>

            <!-- Main Menu -->
            <div class="d-flex justify-content-center align-items-center h-100">
                <div class="p-4 text-center w-50 h-50 align-items-center justify-content-center" >
                    <a href="#" class="btn btn-lg btn-success w-75 mb-3">New Game</a>
                    <a href="#" class="btn btn-lg btn-info w-75 mb-3">Profile</a>
                    <a href="#" class="btn btn-lg btn-warning w-75 mb-3">Leaderboard</a>
                    <a href="#" class="btn btn-lg btn-danger w-75">Logout</a>
                </div>
            </div>

            <!-- Mute/Unmute Button -->
            <div class="position-absolute bottom-0 end-0 p-3">
                <button class="btn btn-light border" id="mute-button"><iconify-icon icon="solar:music-notes-outline" noobserver></iconify-icon></button>
            </div>

        </div>
    </div>

@endsection

@section('page-scripts')
    <script>
        document.getElementById('mute-button').addEventListener('click', function() {
            let btn = this;
            btn.innerHTML = btn.innerHTML === '<iconify-icon icon="solar:music-notes-outline" noobserver=""></iconify-icon>' 
                ? '<iconify-icon icon="solar:muted-outline" noobserver=""></iconify-icon>' 
                : '<iconify-icon icon="solar:music-notes-outline" noobserver=""></iconify-icon>';
        });
    </script>
@endsection
